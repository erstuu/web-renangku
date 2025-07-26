<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\TrainingSession;
use App\Models\SessionRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Show payment page for a training session.
     */
    public function show($sessionId)
    {
        $session = TrainingSession::with(['coach'])->findOrFail($sessionId);

        // Check if already registered
        $existingRegistration = SessionRegistration::where('training_session_id', $sessionId)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingRegistration) {
            return redirect()->route('member.training-sessions.show', $sessionId)
                ->with('error', 'Anda sudah terdaftar untuk sesi ini.');
        }

        // Check capacity
        $registeredCount = SessionRegistration::where('training_session_id', $sessionId)->count();
        if ($registeredCount >= $session->max_capacity) {
            return redirect()->route('member.training-sessions.show', $sessionId)
                ->with('error', 'Sesi sudah penuh.');
        }

        // Check if session is still available
        if ($session->start_time <= now()) {
            return redirect()->route('member.training-sessions.show', $sessionId)
                ->with('error', 'Sesi sudah dimulai atau telah berakhir.');
        }

        // For free sessions, directly register without payment process
        if ($session->price == 0) {
            return $this->registerDirectly($sessionId);
        }

        return view('member.payment.show', compact('session'));
    }

    /**
     * Register directly for free sessions.
     */
    private function registerDirectly($sessionId)
    {
        try {
            DB::beginTransaction();

            $session = TrainingSession::findOrFail($sessionId);

            // Debug log
            Log::info('Registering user to free session', [
                'user_id' => Auth::id(),
                'session_id' => $sessionId,
                'session_name' => $session->session_name,
                'price' => $session->price
            ]);

            // Create registration for free session
            $registration = SessionRegistration::create([
                'training_session_id' => $sessionId,
                'user_id' => Auth::id(),
                'registered_at' => now(),
                'attendance_status' => 'registered', // Use valid enum value
                'payment_status' => 'paid', // Free = considered paid
            ]);

            Log::info('Registration created successfully', [
                'registration_id' => $registration->id
            ]);

            DB::commit();

            return redirect()->route('member.registrations.index')
                ->with('success', 'Berhasil mendaftar ke sesi gratis! Pendaftaran Anda sudah dikonfirmasi.');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error in registerDirectly', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'session_id' => $sessionId
            ]);

            return redirect()->route('member.training-sessions.show', $sessionId)
                ->with('error', 'Terjadi kesalahan saat mendaftar: ' . $e->getMessage());
        }
    }
    /**
     * Process payment for a training session.
     */
    public function process(Request $request, $sessionId)
    {
        $request->validate([
            'payment_method' => 'required|in:bank_transfer,e_wallet,credit_card',
            'phone_number' => 'required_if:payment_method,e_wallet|string|max:20',
            'bank_name' => 'required_if:payment_method,bank_transfer|string|max:50',
            'account_number' => 'required_if:payment_method,bank_transfer|string|max:30',
        ]);

        $session = TrainingSession::findOrFail($sessionId);

        try {
            DB::beginTransaction();

            // Check again for race conditions
            $existingRegistration = SessionRegistration::where('training_session_id', $sessionId)
                ->where('user_id', Auth::id())
                ->first();

            if ($existingRegistration) {
                DB::rollBack();
                return back()->with('error', 'Anda sudah terdaftar untuk sesi ini.');
            }

            // Check capacity again
            $registeredCount = SessionRegistration::where('training_session_id', $sessionId)->count();
            if ($registeredCount >= $session->max_capacity) {
                DB::rollBack();
                return back()->with('error', 'Sesi sudah penuh.');
            }

            // Create registration with pending payment
            $registration = SessionRegistration::create([
                'training_session_id' => $sessionId,
                'user_id' => Auth::id(),
                'registered_at' => now(),
                'attendance_status' => 'registered',
                'payment_status' => 'pending',
            ]);

            // Here you would integrate with actual payment gateway
            // For now, we'll simulate payment processing
            $paymentData = [
                'registration_id' => $registration->id,
                'amount' => $session->price,
                'payment_method' => $request->payment_method,
                'payment_reference' => 'PAY-' . strtoupper(uniqid()),
                'status' => 'pending',
                'created_at' => now(),
            ];

            // Store payment information (you might want to create a payments table)
            // For demo purposes, we'll add it to the notes field
            $registration->update([
                'notes' => json_encode([
                    'payment_method' => $request->payment_method,
                    'payment_reference' => $paymentData['payment_reference'],
                    'amount' => $session->price,
                    'phone_number' => $request->phone_number,
                    'bank_name' => $request->bank_name,
                    'account_number' => $request->account_number,
                ])
            ]);

            DB::commit();

            return redirect()->route('member.payment.confirmation', $registration->id)
                ->with('success', 'Pendaftaran berhasil! Silakan lakukan pembayaran.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses pendaftaran.');
        }
    }

    /**
     * Show payment confirmation page.
     */
    public function confirmation($registrationId)
    {
        $registration = SessionRegistration::with(['trainingSession.coach'])
            ->where('user_id', Auth::id())
            ->findOrFail($registrationId);

        $paymentInfo = json_decode($registration->notes, true);

        return view('member.payment.confirmation', compact('registration', 'paymentInfo'));
    }

    /**
     * Simulate payment completion
     */
    public function complete(Request $request, $registrationId)
    {
        $registration = SessionRegistration::where('user_id', Auth::id())
            ->findOrFail($registrationId);

        // Update payment status
        $registration->update([
            'payment_status' => 'paid',
            'attendance_status' => 'registered' // Use valid enum value
        ]);

        return redirect()->route('member.registrations.index')
            ->with('success', 'Pembayaran berhasil! Pendaftaran Anda telah dikonfirmasi.');
    }
}
