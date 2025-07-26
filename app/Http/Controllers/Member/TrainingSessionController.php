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
            ->whereHas('coach', function ($query) {
                $query->where('is_active', true);
            })
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

        $registration = SessionRegistration::where('training_session_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        $isRegistered = $registration !== null;

        $registeredCount = $session->sessionRegistrations->count();
        $availableSlots = $session->max_capacity - $registeredCount;

        return view('member.training-sessions.show', compact('session', 'isRegistered', 'registration', 'availableSlots'));
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

        // Check if session has already started
        $session = $registration->trainingSession;
        if ($session->start_time <= now()) {
            return back()->with('error', 'Tidak dapat membatalkan pendaftaran karena sesi sudah dimulai.');
        }

        // Check if registration has been confirmed by coach
        if ($registration->attendance_status !== 'registered') {
            return back()->with('error', 'Tidak dapat membatalkan pendaftaran karena sudah dikonfirmasi oleh pelatih. Silakan hubungi pelatih untuk pembatalan.');
        }

        // Handle refund if payment was made
        if ($registration->payment_status === 'paid' && $session->price > 0) {
            // Set payment status to refunded
            $registration->update(['payment_status' => 'refunded']);

            // Delete the registration
            $registration->delete();

            return back()->with('success', 'Pendaftaran berhasil dibatalkan dan pembayaran akan dikembalikan.');
        } else {
            // For free sessions or unpaid registrations, just delete
            $registration->delete();
            return back()->with('success', 'Pendaftaran berhasil dibatalkan.');
        }
    }
}
