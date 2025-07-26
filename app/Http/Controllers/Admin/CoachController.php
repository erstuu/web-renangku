<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CoachProfile;
use Illuminate\Support\Facades\Auth;

class CoachController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'coach')
            ->with(['coachProfile']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('approval_status', $request->status);
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

        // Sort
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name':
                $query->orderBy('full_name', 'asc');
                break;
            default: // latest
                $query->orderBy('created_at', 'desc');
        }

        $coaches = $query->paginate(15);

        // Stats
        $totalCoaches = User::where('role', 'coach')->count();
        $activeCoaches = User::where('role', 'coach')->where('is_active', true)->count();
        $inactiveCoaches = User::where('role', 'coach')->where('is_active', false)->count();
        $pendingCount = User::where('role', 'coach')->where('approval_status', 'pending')->count();
        $approvedCount = User::where('role', 'coach')->where('approval_status', 'approved')->count();
        $rejectedCount = User::where('role', 'coach')->where('approval_status', 'rejected')->count();

        // Handle AJAX request
        if ($request->ajax() || $request->get('ajax')) {
            $html = view('admin.coaches._index_list', compact('coaches'))->render();
            return response()->json(['html' => $html]);
        }

        return view('admin.coaches.index', compact(
            'coaches',
            'totalCoaches',
            'activeCoaches',
            'inactiveCoaches',
            'pendingCount',
            'approvedCount',
            'rejectedCount'
        ));
    }

    public function pending(Request $request)
    {
        $query = User::where('role', 'coach')
            ->where('approval_status', 'pending')
            ->with(['coachProfile']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('username', 'LIKE', "%{$search}%");
            });
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name':
                $query->orderBy('full_name', 'asc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $pendingCoaches = $query->paginate(15);

        // Stats for dashboard
        $approvedCoaches = User::where('role', 'coach')->where('approval_status', 'approved')->count();
        $rejectedCoaches = User::where('role', 'coach')->where('approval_status', 'rejected')->count();

        // Handle AJAX request
        if ($request->ajax() || $request->get('ajax')) {
            $html = view('admin.coaches._pending_list', compact('pendingCoaches'))->render();
            return response()->json(['html' => $html]);
        }

        return view('admin.coaches.pending', compact(
            'pendingCoaches',
            'approvedCoaches',
            'rejectedCoaches'
        ));
    }

    public function show($id)
    {
        $coach = User::where('role', 'coach')
            ->with(['coachProfile', 'trainingSessions.registrations'])
            ->findOrFail($id);

        // Calculate statistics
        $totalParticipants = 0;
        $totalRatings = 0;
        $ratingCount = 0;

        foreach ($coach->trainingSessions as $session) {
            $totalParticipants += $session->registrations->count();

            // If you have rating system, calculate average rating here
            // For now, we'll use a placeholder
        }

        $averageRating = $ratingCount > 0 ? $totalRatings / $ratingCount : 0;

        return view('admin.coaches.show', compact('coach', 'totalParticipants', 'averageRating'));
    }

    public function approve($id)
    {
        $coach = User::where('role', 'coach')->findOrFail($id);

        $coach->update([
            'approval_status' => 'approved',
            'is_active' => true
        ]);

        // Update coach profile if needed
        if ($coach->coachProfile) {
            // You might want to activate coach profile or set some status
        }

        return redirect()->route('admin.coaches.index')
            ->with('success', "Coach {$coach->full_name} berhasil disetujui!");
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500'
        ]);

        $coach = User::where('role', 'coach')->findOrFail($id);

        $coach->update([
            'approval_status' => 'rejected',
            'is_active' => false
        ]);

        // You might want to store the rejection reason
        // Or send notification to the coach

        return redirect()->route('admin.coaches.index')
            ->with('success', "Coach {$coach->full_name} berhasil ditolak!");
    }

    public function destroy($id)
    {
        $coach = User::where('role', 'coach')->findOrFail($id);

        // Check if coach has active sessions
        $activeSessions = $coach->trainingSessions()->where('is_active', true)->count();

        if ($activeSessions > 0) {
            return redirect()->route('admin.coaches.index')
                ->with('error', 'Tidak dapat menghapus coach yang memiliki sesi aktif!');
        }

        $coachName = $coach->full_name;
        $coach->delete();

        return redirect()->route('admin.coaches.index')
            ->with('success', "Coach {$coachName} berhasil dihapus!");
    }

    public function toggleStatus($id)
    {
        $coach = User::where('role', 'coach')->findOrFail($id);

        $newStatus = !$coach->is_active;

        $coach->update([
            'is_active' => $newStatus
        ]);

        // If deactivating coach, also deactivate their future training sessions
        if (!$newStatus) {
            $coach->trainingSessions()
                ->where('start_time', '>=', now())
                ->update(['is_active' => false]);
        }

        $status = $coach->is_active ? 'diaktifkan' : 'dinonaktifkan';
        $message = "Coach {$coach->full_name} berhasil {$status}!";

        if (!$newStatus) {
            $message .= " Sesi latihan yang akan datang juga telah dinonaktifkan.";
        }

        return redirect()->route('admin.coaches.index')
            ->with('success', $message);
    }

    public function create()
    {
        return view('admin.coaches.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'specialization' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'contact_info' => 'required|string|max:255',
            'certification' => 'nullable|string',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'hourly_rate' => 'nullable|numeric|min:0',
        ]);

        // Create the user
        $user = User::create([
            'full_name' => $request->full_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'coach',
            'approval_status' => 'approved', // Admin creates already approved coaches
            'is_active' => true,
            'email_verified_at' => now(), // Admin-created coaches are auto-verified
        ]);

        // Create coach profile - now required because contact_info is mandatory
        CoachProfile::create([
            'user_id' => $user->id,
            'specialization' => $request->specialization,
            'bio' => $request->bio,
            'contact_info' => $request->contact_info,
            'certification' => $request->certification,
            'experience_years' => $request->experience_years,
            'hourly_rate' => $request->hourly_rate,
        ]);

        return redirect()->route('admin.coaches.index')
            ->with('success', "Coach {$user->full_name} berhasil ditambahkan!");
    }
}
