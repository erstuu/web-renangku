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

        return view('admin.members.index', compact(
            'members',
            'totalMembers',
            'activeMembers',
            'pendingMembers',
            'suspendedMembers'
        ));
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

        return redirect()->route('admin.members.show', $id)
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
