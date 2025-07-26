<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CoachProfile;

class ProfileController extends Controller
{
    public function setup()
    {
        $user = Auth::user();

        // Check if user is coach
        if ($user->role !== 'coach') {
            abort(403, 'Unauthorized access');
        }

        $coachProfile = CoachProfile::where('user_id', $user->id)->first();

        return view('coach.profile-setup', compact('user', 'coachProfile'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Check if user is coach
        if ($user->role !== 'coach') {
            abort(403, 'Unauthorized access');
        }

        $validatedData = $request->validate([
            'specialization' => 'required|string|max:255',
            'bio' => 'required|string|min:50',
            'contact_info' => 'required|string|max:255',
            'certification' => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0|max:50',
            'hourly_rate' => 'nullable|numeric|min:0',
        ], [
            'specialization.required' => 'Spesialisasi harus diisi.',
            'bio.required' => 'Bio/Deskripsi harus diisi.',
            'bio.min' => 'Bio minimal 50 karakter.',
            'contact_info.required' => 'Informasi kontak harus diisi.',
            'certification.required' => 'Sertifikat harus diisi.',
            'experience_years.required' => 'Pengalaman (tahun) harus diisi.',
            'experience_years.integer' => 'Pengalaman harus berupa angka.',
            'experience_years.min' => 'Pengalaman minimal 0 tahun.',
            'experience_years.max' => 'Pengalaman maksimal 50 tahun.',
            'hourly_rate.numeric' => 'Tarif per jam harus berupa angka.',
            'hourly_rate.min' => 'Tarif per jam minimal 0.',
        ]);

        // Update coach profile
        $coachProfile = CoachProfile::where('user_id', $user->id)->first();
        if ($coachProfile) {
            $coachProfile->update($validatedData);
        } else {
            $validatedData['user_id'] = $user->id;
            $coachProfile = CoachProfile::create($validatedData);
        }

        // Update user status ke pending jika profil lengkap
        if ($this->isProfileComplete($coachProfile)) {
            DB::table('users')->where('id', $user->id)->update(['approval_status' => 'pending']);

            // Kirim notifikasi ke admin (akan implementasi nanti)
            $this->notifyAdminNewCoachApplication($user);

            return redirect()->route('coach.dashboard')
                ->with('success', 'Profil berhasil dilengkapi! Aplikasi Anda telah dikirim ke admin untuk disetujui.');
        }

        return back()->with('warning', 'Profil belum lengkap. Pastikan semua field wajib telah diisi.');
    }

    public function edit()
    {
        $user = Auth::user();

        // Check if user is coach
        if ($user->role !== 'coach') {
            abort(403, 'Unauthorized access');
        }

        $coachProfile = CoachProfile::where('user_id', $user->id)->first();

        return view('coach.profile-edit', compact('user', 'coachProfile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Check if user is coach
        if ($user->role !== 'coach') {
            abort(403, 'Unauthorized access');
        }

        $validatedData = $request->validate([
            'specialization' => 'required|string|max:255',
            'bio' => 'required|string|min:50',
            'contact_info' => 'required|string|max:255',
            'certification' => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0|max:50',
            'hourly_rate' => 'nullable|numeric|min:0',
        ], [
            'specialization.required' => 'Spesialisasi harus diisi.',
            'bio.required' => 'Bio/Deskripsi harus diisi.',
            'bio.min' => 'Bio minimal 50 karakter.',
            'contact_info.required' => 'Informasi kontak harus diisi.',
            'certification.required' => 'Sertifikat harus diisi.',
            'experience_years.required' => 'Pengalaman (tahun) harus diisi.',
            'experience_years.integer' => 'Pengalaman harus berupa angka.',
            'experience_years.min' => 'Pengalaman minimal 0 tahun.',
            'experience_years.max' => 'Pengalaman maksimal 50 tahun.',
            'hourly_rate.numeric' => 'Tarif per jam harus berupa angka.',
            'hourly_rate.min' => 'Tarif per jam minimal 0.',
        ]);

        // Update coach profile
        $coachProfile = CoachProfile::where('user_id', $user->id)->first();
        if ($coachProfile) {
            $coachProfile->update($validatedData);
        }

        return redirect()->route('coach.dashboard')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    private function notifyAdminNewCoachApplication($user)
    {
        // TODO: Implementasi notifikasi ke admin
        // Bisa via email, database notification, atau real-time notification
        // Untuk sekarang skip dulu, akan implementasi di step selanjutnya
    }

    private function isProfileComplete($coachProfile)
    {
        if (!$coachProfile) return false;

        return !empty($coachProfile->specialization) &&
            !empty($coachProfile->bio) &&
            !empty($coachProfile->contact_info) &&
            !empty($coachProfile->certification) &&
            !is_null($coachProfile->experience_years);
    }
}
