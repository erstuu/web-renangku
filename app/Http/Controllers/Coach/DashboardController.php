<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\TrainingSession;
use App\Models\CoachProfile;
use App\Models\SessionRegistration;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Check if user is coach
        if ($user->role !== 'coach') {
            abort(403, 'Unauthorized access');
        }

        // Redirect ke setup profil jika belum lengkap
        if ($this->needsProfileCompletion($user)) {
            return redirect()->route('coach.profile.setup')
                ->with('warning', 'Silakan lengkapi profil Anda terlebih dahulu.');
        }

        // Jika masih pending approval
        if ($this->isPendingApproval($user)) {
            return view('coach.pending-approval', compact('user'));
        }

        // Jika sudah approved, tampilkan dashboard normal
        if ($this->isApproved($user)) {
            $coachProfile = CoachProfile::where('user_id', $user->id)->first();

            // Get dashboard statistics
            $activeSessionsCount = TrainingSession::where('coach_id', $user->id)
                ->where('is_active', true)
                ->where('end_time', '>=', now())
                ->count();

            $recentSessions = TrainingSession::where('coach_id', $user->id)
                ->where('start_time', '>=', now())
                ->orderBy('start_time')
                ->limit(5)
                ->with('sessionRegistrations')
                ->get();

            // Get unique members who have registered for this coach's sessions
            $totalMembers = SessionRegistration::whereHas('trainingSession', function ($query) use ($user) {
                $query->where('coach_id', $user->id);
            })
                ->distinct('user_id')
                ->count('user_id');

            // Get pending registrations count
            $pendingRegistrations = SessionRegistration::whereHas('trainingSession', function ($query) use ($user) {
                $query->where('coach_id', $user->id);
            })
                ->where('attendance_status', 'pending')
                ->count();

            // Calculate monthly earnings (current month)
            $monthlyEarnings = SessionRegistration::whereHas('trainingSession', function ($query) use ($user) {
                $query->where('coach_id', $user->id);
            })
                ->where('payment_status', 'paid')
                ->whereMonth('registered_at', now()->month)
                ->whereYear('registered_at', now()->year)
                ->join('training_sessions', 'session_registrations.training_session_id', '=', 'training_sessions.id')
                ->sum('training_sessions.price');

            // Get recent registrations
            $recentRegistrations = SessionRegistration::whereHas('trainingSession', function ($query) use ($user) {
                $query->where('coach_id', $user->id);
            })
                ->with(['trainingSession', 'member'])
                ->orderBy('registered_at', 'desc')
                ->limit(5)
                ->get();

            return view('coach.dashboard', compact(
                'user',
                'coachProfile',
                'recentSessions',
                'activeSessionsCount',
                'totalMembers',
                'pendingRegistrations',
                'monthlyEarnings',
                'recentRegistrations'
            ));
        }

        // Jika status tidak dikenal atau ditolak
        return view('coach.approval-rejected', compact('user'));
    }

    private function needsProfileCompletion($user)
    {
        if ($user->role === 'coach') {
            $coachProfile = CoachProfile::where('user_id', $user->id)->first();
            return !$coachProfile || !$this->isProfileComplete($coachProfile);
        }
        return false;
    }

    private function isPendingApproval($user)
    {
        return $user->role === 'coach' && $user->approval_status === 'pending';
    }

    private function isApproved($user)
    {
        return $user->approval_status === 'approved';
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
