<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            // Redirect to role selector with message
            return redirect()->route('role.selector')
                ->with('warning', 'Silakan login terlebih dahulu untuk mengakses halaman tersebut.');
        }

        $user = Auth::user();

        // Check if user is active
        if (!$user->is_active) {
            Auth::logout(); // Logout inactive user
            return redirect()->route('role.selector')
                ->with('error', 'Akun Anda telah dinonaktifkan. Silakan hubungi administrator.');
        }

        // Check if user's role is in the allowed roles
        if (!in_array($user->role, $roles)) {
            // Redirect based on user's actual role instead of showing 403
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard')
                        ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
                case 'coach':
                    return redirect()->route('coach.dashboard')
                        ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
                case 'member':
                    return redirect()->route('member.dashboard')
                        ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
                default:
                    return redirect()->route('role.selector')
                        ->with('error', 'Role tidak valid.');
            }
        }

        return $next($request);
    }
}
