<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\MemberProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the member's profile.
     */
    public function show()
    {
        /** @var User $user */
        $user = Auth::user();
        $memberProfile = $user->memberProfile;

        return view('member.profile.show', compact('user', 'memberProfile'));
    }

    /**
     * Show the form for editing the member's profile.
     */
    public function edit()
    {
        /** @var User $user */
        $user = Auth::user();
        $memberProfile = $user->memberProfile;

        return view('member.profile.edit', compact('user', 'memberProfile'));
    }
    /**
     * Update the member's profile.
     */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'string', 'max:20'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'gender' => ['required', 'in:male,female'],
            'address' => ['nullable', 'string', 'max:500'],
            'emergency_contact_name' => ['required', 'string', 'max:255'],
            'emergency_contact_phone' => ['required', 'string', 'max:20'],
            'emergency_contact_relationship' => ['required', 'string', 'max:100'],
            'medical_conditions' => ['nullable', 'string', 'max:1000'],
            'swimming_experience' => ['required', 'in:beginner,intermediate,advanced'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ], [
            'full_name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh user lain.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'date_of_birth.required' => 'Tanggal lahir wajib diisi.',
            'date_of_birth.before' => 'Tanggal lahir harus sebelum hari ini.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'emergency_contact_name.required' => 'Nama kontak darurat wajib diisi.',
            'emergency_contact_phone.required' => 'Nomor kontak darurat wajib diisi.',
            'emergency_contact_relationship.required' => 'Hubungan kontak darurat wajib diisi.',
            'swimming_experience.required' => 'Pengalaman renang wajib dipilih.',
            'profile_photo.image' => 'File harus berupa gambar.',
            'profile_photo.mimes' => 'Gambar harus berformat: jpeg, png, jpg, gif.',
            'profile_photo.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        try {
            // Update user data using User model
            User::where('id', $user->id)->update([
                'full_name' => $request->full_name,
                'email' => $request->email,
            ]);

            // Handle profile photo upload
            $profilePhotoPath = null;
            if ($request->hasFile('profile_photo')) {
                // Delete old profile photo if exists
                $existingProfile = MemberProfile::where('user_id', $user->id)->first();
                if ($existingProfile && $existingProfile->profile_photo) {
                    Storage::disk('public')->delete($existingProfile->profile_photo);
                }

                $profilePhotoPath = $request->file('profile_photo')->store('profile-photos', 'public');
            }

            // Update or create member profile
            $profileData = [
                'user_id' => $user->id,
                'phone' => $request->phone,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'address' => $request->address,
                'emergency_contact_name' => $request->emergency_contact_name,
                'emergency_contact_phone' => $request->emergency_contact_phone,
                'emergency_contact_relationship' => $request->emergency_contact_relationship,
                'medical_conditions' => $request->medical_conditions,
                'swimming_experience' => $request->swimming_experience,
            ];

            // Add profile photo path if uploaded
            if ($profilePhotoPath) {
                $profileData['profile_photo'] = $profilePhotoPath;
            }

            // Use updateOrCreate to handle both update and create
            MemberProfile::updateOrCreate(
                ['user_id' => $user->id],
                $profileData
            );
            return redirect()->route('member.profile.show')
                ->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Member profile update error: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'trace' => $e->getTraceAsString()
            ]);
            return back()
                ->withErrors(['error' => 'Terjadi kesalahan saat memperbarui profil. Silakan coba lagi.'])
                ->withInput();
        }
    }
}
