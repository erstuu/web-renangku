<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TrainingSession;

class TrainingSessionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $trainingSessions = TrainingSession::where('coach_id', $user->id)
            ->with('sessionRegistrations')
            ->orderBy('start_time', 'desc')
            ->paginate(10);

        return view('coach.training-sessions.index', compact('trainingSessions'));
    }

    public function create()
    {
        return view('coach.training-sessions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'session_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required|string|max:255',
            'max_capacity' => 'required|integer|min:1|max:50',
            'price' => 'required|numeric|min:0',
            'session_type' => 'required|in:group,private,competition',
            'skill_level' => 'required|in:beginner,intermediate,advanced,all',
        ]);

        TrainingSession::create([
            'coach_id' => Auth::id(),
            'session_name' => $request->session_name,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location,
            'max_capacity' => $request->max_capacity,
            'price' => $request->price,
            'session_type' => $request->session_type,
            'skill_level' => $request->skill_level,
            'is_active' => true,
        ]);

        return redirect()->route('coach.training-sessions.index')
            ->with('success', 'Sesi latihan berhasil dibuat!');
    }

    public function edit(TrainingSession $trainingSession)
    {
        // Ensure coach owns this session
        if ($trainingSession->coach_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        return view('coach.training-sessions.edit', compact('trainingSession'));
    }

    public function update(Request $request, TrainingSession $trainingSession)
    {
        // Ensure coach owns this session
        if ($trainingSession->coach_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'session_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required|string|max:255',
            'max_capacity' => 'required|integer|min:1|max:50',
            'price' => 'required|numeric|min:0',
            'session_type' => 'required|in:group,private,competition',
            'skill_level' => 'required|in:beginner,intermediate,advanced,all',
            'is_active' => 'boolean',
        ]);

        $trainingSession->update($request->all());

        return redirect()->route('coach.training-sessions.index')
            ->with('success', 'Sesi latihan berhasil diperbarui!');
    }

    public function destroy(TrainingSession $trainingSession)
    {
        // Ensure coach owns this session
        if ($trainingSession->coach_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        // Check if there are any registrations
        if ($trainingSession->sessionRegistrations()->count() > 0) {
            return redirect()->route('coach.training-sessions.index')
                ->with('error', 'Tidak dapat menghapus sesi yang sudah memiliki pendaftaran!');
        }

        $trainingSession->delete();

        return redirect()->route('coach.training-sessions.index')
            ->with('success', 'Sesi latihan berhasil dihapus!');
    }
}
