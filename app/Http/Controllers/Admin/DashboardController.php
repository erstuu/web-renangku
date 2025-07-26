<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TrainingSession;
use App\Models\SessionRegistration;
use App\Models\DataChangeRequest;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $totalUsers = User::count();
        $totalCoaches = User::where('role', 'coach')->count();
        $totalMembers = User::where('role', 'member')->count();
        $pendingCoaches = User::where('role', 'coach')
            ->where('approval_status', 'pending')
            ->count();

        // Training sessions statistics
        $totalSessions = TrainingSession::count();
        $activeSessions = TrainingSession::where('is_active', true)->count();
        $todaySessions = TrainingSession::whereDate('start_time', today())->count();

        // Registration statistics
        $totalRegistrations = SessionRegistration::count();
        $paidRegistrations = SessionRegistration::where('payment_status', 'paid')->count();
        $todayRegistrations = SessionRegistration::whereDate('registered_at', today())->count();

        // Pending requests
        $pendingDataChangeRequests = DataChangeRequest::where('status', 'pending')->count();

        // Recent activities
        $recentRegistrations = SessionRegistration::with(['user', 'trainingSession'])
            ->orderBy('registered_at', 'desc')
            ->limit(5)
            ->get();

        $recentCoaches = User::where('role', 'coach')
            ->where('approval_status', 'pending')
            ->with('coachProfile')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        $recentDataChangeRequests = DataChangeRequest::with('user')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // Monthly registration chart data
        $monthlyRegistrations = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = SessionRegistration::whereYear('registered_at', $date->year)
                ->whereMonth('registered_at', $date->month)
                ->count();
            $monthlyRegistrations[] = [
                'month' => $date->format('M Y'),
                'count' => $count
            ];
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalCoaches',
            'totalMembers',
            'pendingCoaches',
            'totalSessions',
            'activeSessions',
            'todaySessions',
            'totalRegistrations',
            'paidRegistrations',
            'todayRegistrations',
            'pendingDataChangeRequests',
            'recentRegistrations',
            'recentCoaches',
            'recentDataChangeRequests',
            'monthlyRegistrations'
        ));
    }
}
