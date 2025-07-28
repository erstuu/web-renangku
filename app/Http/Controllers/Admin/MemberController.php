<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MemberProfile;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'member')
            ->with(['memberProfile']);

        // Filter by membership status
        if ($request->filled('membership_status')) {
            $query->whereHas('memberProfile', function ($q) use ($request) {
                $q->where('membership_status', $request->membership_status);
            });
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('username', 'LIKE', "%{$search}%");
            });
        }

        $members = $query->orderBy('created_at', 'desc')->paginate(15);

        // Stats
        $totalMembers = User::where('role', 'member')->count();
        $activeMembers = User::where('role', 'member')
            ->whereHas('memberProfile', function ($q) {
                $q->where('membership_status', 'active');
            })->count();
        $pendingMembers = User::where('role', 'member')
            ->whereHas('memberProfile', function ($q) {
                $q->where('membership_status', 'pending');
            })->count();
        $suspendedMembers = User::where('role', 'member')
            ->whereHas('memberProfile', function ($q) {
                $q->where('membership_status', 'suspended');
            })->count();

        if ($request->ajax() || $request->get('ajax')) {
            $html = view('admin.members._index_list', compact('members'))->render();
            return response()->json(['html' => $html]);
        }

        return view('admin.members.index', compact(
            'members',
            'totalMembers',
            'activeMembers',
            'pendingMembers',
            'suspendedMembers'
        ));
    }

    public function create()
    {
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:6',
            // Profile fields
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'emergency_contact_name' => 'nullable|string|max:100',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'medical_notes' => 'nullable|string|max:500',
        ]);

        // Create user
        $member = User::create([
            'full_name' => $validated['full_name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'email_verified_at' => now(),
            'password' => bcrypt($validated['password']),
            'role' => 'member',
            'is_active' => true,
        ]);

        // Create member profile
        MemberProfile::create([
            'user_id' => $member->id,
            'phone' => $validated['phone'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'emergency_contact_name' => $validated['emergency_contact_name'] ?? null,
            'emergency_contact_phone' => $validated['emergency_contact_phone'] ?? null,
            'medical_notes' => $validated['medical_notes'] ?? null,
        ]);

        return redirect()->route('admin.members.index')
            ->with('success', "Member {$member->full_name} berhasil ditambahkan!");
    }

    public function edit($id)
    {
        $member = User::where('role', 'member')->findOrFail($id);
        $memberProfile = $member->memberProfile;

        return view('admin.members.edit', compact('member', 'memberProfile'));
    }

    public function update(Request $request, $id)
    {
        $member = User::where('role', 'member')->findOrFail($id);

        $validated = $request->validate([
            'full_name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username,' . $member->id,
            'email' => 'required|email|max:100|unique:users,email,' . $member->id,
            'password' => 'nullable|string|min:6',
            // Profile fields
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string|max:255',
            'membership_status' => 'nullable|in:active,inactive,pending,suspended',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'emergency_contact_name' => 'nullable|string|max:100',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'medical_notes' => 'nullable|string|max:500',
        ]);

        // Update user
        $member->full_name = $validated['full_name'];
        $member->username = $validated['username'];
        $member->email = $validated['email'];
        if (!empty($validated['password'])) {
            $member->password = bcrypt($validated['password']);
        }
        $member->save();

        // Update or create member profile
        $profileData = [
            'gender' => $validated['gender'] ?? null,
            'address' => $validated['address'] ?? null,
            'membership_status' => $validated['membership_status'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'emergency_contact_name' => $validated['emergency_contact_name'] ?? null,
            'emergency_contact_phone' => $validated['emergency_contact_phone'] ?? null,
            'medical_notes' => $validated['medical_notes'] ?? null,
        ];
        if ($member->memberProfile) {
            $member->memberProfile->update($profileData);
        } else {
            $profileData['user_id'] = $member->id;
            MemberProfile::create($profileData);
        }

        return redirect()->route('admin.members.show', $member->id)
            ->with('success', 'Data member berhasil diperbarui!');
    }

    public function show($id)
    {
        $member = User::where('role', 'member')
            ->with(['memberProfile', 'sessionRegistrations.trainingSession.coach'])
            ->findOrFail($id);

        // Get registration stats
        $totalRegistrations = $member->sessionRegistrations->count();
        $attendedSessions = $member->sessionRegistrations
            ->where('attendance_status', 'attended')->count();
        $paidRegistrations = $member->sessionRegistrations
            ->where('payment_status', 'paid')->count();

        return view('admin.members.show', compact(
            'member',
            'totalRegistrations',
            'attendedSessions',
            'paidRegistrations'
        ));
    }

    public function updateMembershipStatus(Request $request, $id)
    {
        $request->validate([
            'membership_status' => 'required|in:active,inactive,suspended,pending',
            'reason' => 'nullable|string|max:500'
        ]);

        $member = User::where('role', 'member')->findOrFail($id);

        if ($member->memberProfile) {
            $member->memberProfile->update([
                'membership_status' => $request->membership_status
            ]);
        }

        return redirect()->route('admin.members.index', $id)
            ->with('success', 'Status membership berhasil diperbarui!');
    }

    public function toggleStatus($id)
    {
        $member = User::where('role', 'member')->findOrFail($id);

        $member->update([
            'is_active' => !$member->is_active
        ]);

        $status = $member->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.members.index')
            ->with('success', "Member {$member->full_name} berhasil {$status}!");
    }

    public function destroy($id)
    {
        $member = User::where('role', 'member')->findOrFail($id);

        // Check if member has active registrations
        $activeRegistrations = $member->sessionRegistrations()
            ->whereHas('trainingSession', function ($q) {
                $q->where('start_time', '>', now());
            })->count();

        if ($activeRegistrations > 0) {
            return redirect()->route('admin.members.index')
                ->with('error', 'Tidak dapat menghapus member yang memiliki pendaftaran aktif!');
        }

        $memberName = $member->full_name;
        $member->delete();

        return redirect()->route('admin.members.index')
            ->with('success', "Member {$memberName} berhasil dihapus!");
    }
}
