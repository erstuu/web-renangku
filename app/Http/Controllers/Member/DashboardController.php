<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\TrainingSession;
use App\Models\SessionRegistration;
use App\Models\MemberProfile;
use App\Models\Announcement;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Check if user is member
        if ($user->role !== 'member') {
            abort(403, 'Unauthorized access');
        }

        $memberProfile = $user->memberProfile;

        // Get available training sessions (active and future) from active coaches only
        $availableSessions = TrainingSession::where('is_active', true)
            ->where('start_time', '>=', now())
            ->whereHas('coach', function ($query) {
                $query->where('is_active', true);
            })
            ->with(['coach', 'sessionRegistrations'])
            ->orderBy('start_time')
            ->limit(6)
            ->get();

        // Get member's registrations
        $myRegistrations = SessionRegistration::where('user_id', $user->id)
            ->with('trainingSession.coach')
            ->orderBy('registered_at', 'desc')
            ->limit(5)
            ->get();

        // Get upcoming sessions that member is registered for
        $upcomingSessions = SessionRegistration::where('user_id', $user->id)
            ->whereHas('trainingSession', function ($query) {
                $query->where('start_time', '>=', now());
            })
            ->where('attendance_status', 'attended')
            ->with('trainingSession.coach')
            ->orderBy('registered_at', 'desc')
            ->limit(3)
            ->get();

        // Get statistics
        $totalRegistrations = SessionRegistration::where('user_id', $user->id)->count();
        $completedSessions = SessionRegistration::where('user_id', $user->id)
            ->where('attendance_status', 'attended')
            ->count();
        $pendingRegistrations = SessionRegistration::where('user_id', $user->id)
            ->where('attendance_status', 'registered')
            ->count();

        // Get recent announcements
        $recentAnnouncements = Announcement::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        return view('member.dashboard', compact(
            'user',
            'memberProfile',
            'availableSessions',
            'myRegistrations',
            'upcomingSessions',
            'totalRegistrations',
            'completedSessions',
            'pendingRegistrations',
            'recentAnnouncements'
        ));
    }

    private function needsProfileCompletion($user)
    {
        if ($user->role === 'member') {
            $memberProfile = MemberProfile::where('user_id', $user->id)->first();
            return !$memberProfile || !$this->isProfileComplete($memberProfile);
        }
        return false;
    }

    private function isProfileComplete($memberProfile)
    {
        if (!$memberProfile) return false;

        return !empty($memberProfile->phone) &&
            !empty($memberProfile->emergency_contact_name) &&
            !empty($memberProfile->swimming_experience) &&
            !is_null($memberProfile->date_of_birth);
    }
}
