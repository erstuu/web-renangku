<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrainingSession;
use App\Models\User;

class TrainingSessionController extends Controller
{
    public function edit($id)
    {
        $session = TrainingSession::findOrFail($id);
        $coaches = User::where('role', 'coach')
            ->where('approval_status', 'approved')
            ->orderBy('full_name')
            ->get();
        return view('admin.training-sessions.edit', compact('session', 'coaches'));
    }

    public function update(Request $request, $id)
    {
        $session = TrainingSession::findOrFail($id);
        $validated = $request->validate([
            'session_name'   => 'required|string|max:255',
            'session_type'   => 'required|in:group,private,competition',
            'coach_id'       => 'required|exists:users,id',
            'location'       => 'required|string|max:255',
            'start_time'     => 'required|date',
            'end_time'       => 'required|date|after_or_equal:start_time',
            'max_capacity'   => 'required|integer|min:1',
            'price'          => 'required|numeric|min:0',
            'skill_level'    => 'required|in:all,beginner,intermediate,advanced',
            'is_active'      => 'required|boolean',
            'description'    => 'nullable|string',
        ]);

        $session->update($validated);

        return redirect()->route('admin.training-sessions.show', $session->id)
            ->with('success', 'Data sesi latihan berhasil diperbarui!');
    }
    public function index(Request $request)
    {
        $query = TrainingSession::with(['coach']);

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Filter by session type
        if ($request->filled('session_type')) {
            $query->where('session_type', $request->session_type);
        }

        // Filter by coach
        if ($request->filled('coach_id')) {
            $query->where('coach_id', $request->coach_id);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('session_name', 'LIKE', "%{$search}%")
                    ->orWhere('location', 'LIKE', "%{$search}%")
                    ->orWhereHas('coach', function ($sq) use ($search) {
                        $sq->where('full_name', 'LIKE', "%{$search}%");
                    });
            });
        }

        $sessions = $query->orderBy('start_time', 'desc')->paginate(15);

        // Get coaches for filter
        $coaches = User::where('role', 'coach')
            ->where('approval_status', 'approved')
            ->orderBy('full_name')
            ->get();

        // Stats
        $totalSessions = TrainingSession::count();
        $activeSessions = TrainingSession::where('is_active', true)->count();
        $todaySessions = TrainingSession::whereDate('start_time', today())->count();
        $upcomingSessions = TrainingSession::where('start_time', '>', now())->count();

        // AJAX response for live search/filter
        if ($request->ajax() || $request->wantsJson() || $request->input('ajax')) {
            $html = view('admin.training-sessions._index_list', ['sessions' => $sessions])->render();
            return response()->json(['html' => $html]);
        }

        return view('admin.training-sessions.index', compact(
            'sessions',
            'coaches',
            'totalSessions',
            'activeSessions',
            'todaySessions',
            'upcomingSessions'
        ));
    }

    public function show($id)
    {
        $session = TrainingSession::with([
            'coach.coachProfile',
            'sessionRegistrations.user'
        ])->findOrFail($id);

        // Get registration stats
        $totalRegistrations = $session->sessionRegistrations->count();
        $paidRegistrations = $session->sessionRegistrations
            ->where('payment_status', 'paid')->count();
        $attendedCount = $session->sessionRegistrations
            ->where('attendance_status', 'attended')->count();

        return view('admin.training-sessions.show', compact(
            'session',
            'totalRegistrations',
            'paidRegistrations',
            'attendedCount'
        ));
    }

    public function create()
    {
        $coaches = User::where('role', 'coach')
            ->where('approval_status', 'approved')
            ->orderBy('full_name')
            ->get();
        return view('admin.training-sessions.create', compact('coaches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'session_name'   => 'required|string|max:255',
            'session_type'   => 'required|in:group,private,competition',
            'coach_id'       => 'required|exists:users,id',
            'location'       => 'required|string|max:255',
            'start_time'     => 'required|date',
            'end_time'       => 'required|date|after_or_equal:start_time',
            'max_capacity'   => 'required|integer|min:1',
            'price'          => 'required|numeric|min:0',
            'skill_level'    => 'required|in:all,beginner,intermediate,advanced',
            'is_active'      => 'required|boolean',
            'description'    => 'nullable|string',
        ]);

        TrainingSession::create($validated);

        return redirect()->route('admin.training-sessions.index')
            ->with('success', 'Sesi latihan baru berhasil ditambahkan!');
    }

    public function toggleStatus($id)
    {
        $session = TrainingSession::findOrFail($id);

        $session->update([
            'is_active' => !$session->is_active
        ]);

        $status = $session->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.training-sessions.index')
            ->with('success', "Sesi latihan berhasil {$status}!");
    }

    public function destroy($id)
    {
        $session = TrainingSession::findOrFail($id);

        // Check if session has registrations
        $registrations = $session->sessionRegistrations()->count();

        if ($registrations > 0) {
            return redirect()->route('admin.training-sessions.index')
                ->with('error', 'Tidak dapat menghapus sesi yang memiliki pendaftaran!');
        }

        $sessionName = $session->session_name;
        $session->delete();

        return redirect()->route('admin.training-sessions.index')
            ->with('success', "Sesi latihan \"{$sessionName}\" berhasil dihapus!");
    }
}
