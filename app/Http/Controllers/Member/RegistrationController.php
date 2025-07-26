<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\SessionRegistration;

class RegistrationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Check if user is member
        if ($user->role !== 'member') {
            abort(403, 'Unauthorized access');
        }

        // Get all registrations for the current member
        $registrations = SessionRegistration::where('user_id', $user->id)
            ->with([
                'trainingSession' => function ($query) {
                    $query->with('coach');
                }
            ])
            ->orderBy('registered_at', 'desc')
            ->paginate(15);

        return view('member.registrations.index', compact('registrations'));
    }
}
