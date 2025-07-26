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

        // Get stats - only count paid registrations
        $registeredCount = SessionRegistration::whereHas('trainingSession', function ($query) use ($user) {
            $query->where('coach_id', $user->id);
        })
            ->where('attendance_status', 'registered')
            ->where('payment_status', 'paid') // Only count paid registrations
            ->count();

        $attendedCount = SessionRegistration::whereHas('trainingSession', function ($query) use ($user) {
            $query->where('coach_id', $user->id);
        })
            ->where('attendance_status', 'attended')
            ->where('payment_status', 'paid') // Only count paid registrations
            ->count();

        return view('coach.registrations.index', compact('registrations', 'registeredCount', 'attendedCount'));
    }

    public function approve(SessionRegistration $sessionRegistration)
    {
        // Ensure this registration is for the coach's session
        if ($sessionRegistration->trainingSession->coach_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        // Only allow approval if payment is completed
        if ($sessionRegistration->payment_status !== 'paid') {
            return redirect()->route('coach.registrations.index')
                ->with('error', 'Tidak dapat konfirmasi - pembayaran belum selesai.');
        }

        $sessionRegistration->update([
            'attendance_status' => 'attended'
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

        // If already paid, set payment status to refunded
        $updateData = ['attendance_status' => 'cancelled'];
        if ($sessionRegistration->payment_status === 'paid') {
            $updateData['payment_status'] = 'refunded';
        }

        $sessionRegistration->update($updateData);

        $message = $sessionRegistration->payment_status === 'refunded'
            ? 'Pendaftaran berhasil ditolak! Pembayaran akan dikembalikan.'
            : 'Pendaftaran berhasil ditolak!';

        return redirect()->route('coach.registrations.index')
            ->with('success', $message);
    }

    public function markAbsent(SessionRegistration $sessionRegistration)
    {
        // Ensure this registration is for the coach's session
        if ($sessionRegistration->trainingSession->coach_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $sessionRegistration->update([
            'attendance_status' => 'absent'
        ]);

        return redirect()->route('coach.registrations.index')
            ->with('success', 'Member berhasil ditandai sebagai tidak hadir!');
    }
}
