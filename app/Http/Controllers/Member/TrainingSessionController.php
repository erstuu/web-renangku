<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\TrainingSession;
use App\Models\SessionRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingSessionController extends Controller
{
    /**
     * Display a listing of available training sessions.
     */
    public function index()
    {
        $availableSessions = TrainingSession::with(['coach'])
            ->where('is_active', true)
            ->where('start_time', '>', now())
            ->orderBy('start_time', 'asc')
            ->get();

        $registeredSessionIds = SessionRegistration::where('user_id', Auth::id())
            ->pluck('training_session_id')
            ->toArray();

        return view('member.training-sessions.index', compact('availableSessions', 'registeredSessionIds'));
    }

    /**
     * Display the specified training session.
     */
    public function show($id)
    {
        $session = TrainingSession::with(['coach', 'sessionRegistrations.member'])
            ->findOrFail($id);

        $isRegistered = SessionRegistration::where('training_session_id', $id)
            ->where('user_id', Auth::id())
            ->exists();

        $registeredCount = $session->sessionRegistrations->count();
        $availableSlots = $session->max_capacity - $registeredCount;

        return view('member.training-sessions.show', compact('session', 'isRegistered', 'availableSlots'));
    }

    /**
     * Register member to a training session.
     */
    public function register(Request $request, $sessionId)
    {
        $session = TrainingSession::findOrFail($sessionId);

        // Check if already registered
        $existingRegistration = SessionRegistration::where('training_session_id', $sessionId)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingRegistration) {
            return back()->with('error', 'Anda sudah terdaftar untuk sesi ini.');
        }

        // Check capacity
        $registeredCount = SessionRegistration::where('training_session_id', $sessionId)->count();
        if ($registeredCount >= $session->max_capacity) {
            return back()->with('error', 'Sesi sudah penuh.');
        }

        // Check if session is still available
        if ($session->start_time <= now()) {
            return back()->with('error', 'Sesi sudah dimulai atau telah berakhir.');
        }

        // Redirect to payment page instead of direct registration
        return redirect()->route('member.payment.show', $sessionId);
    }

    /**
     * Cancel member registration.
     */
    public function cancelRegistration($sessionId)
    {
        $registration = SessionRegistration::where('training_session_id', $sessionId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$registration) {
            return back()->with('error', 'Anda tidak terdaftar untuk sesi ini.');
        }

        $registration->delete();

        return back()->with('success', 'Pendaftaran berhasil dibatalkan.');
    }
}
