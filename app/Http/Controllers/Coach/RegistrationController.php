<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SessionRegistration;
use App\Models\TrainingSession;

class RegistrationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get all registrations for this coach's sessions
        $registrations = SessionRegistration::whereHas('trainingSession', function ($query) use ($user) {
            $query->where('coach_id', $user->id);
        })
            ->with(['trainingSession', 'member'])
            ->orderBy('registered_at', 'desc')
            ->paginate(15);

        // Get stats
        $pendingCount = SessionRegistration::whereHas('trainingSession', function ($query) use ($user) {
            $query->where('coach_id', $user->id);
        })
            ->where('attendance_status', 'pending')
            ->count();

        $approvedCount = SessionRegistration::whereHas('trainingSession', function ($query) use ($user) {
            $query->where('coach_id', $user->id);
        })
            ->where('attendance_status', 'confirmed')
            ->count();

        return view('coach.registrations.index', compact('registrations', 'pendingCount', 'approvedCount'));
    }

    public function approve(SessionRegistration $sessionRegistration)
    {
        // Ensure this registration is for the coach's session
        if ($sessionRegistration->trainingSession->coach_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $sessionRegistration->update([
            'attendance_status' => 'confirmed'
        ]);

        return redirect()->route('coach.registrations.index')
            ->with('success', 'Pendaftaran berhasil dikonfirmasi!');
    }

    public function reject(SessionRegistration $sessionRegistration)
    {
        // Ensure this registration is for the coach's session
        if ($sessionRegistration->trainingSession->coach_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $sessionRegistration->update([
            'attendance_status' => 'cancelled'
        ]);

        return redirect()->route('coach.registrations.index')
            ->with('success', 'Pendaftaran berhasil ditolak!');
    }
}
