<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\CoachLoginRequest;
use App\Http\Requests\MemberLoginRequest;

class LoginController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Display the admin login view.
     */
    public function createAdmin()
    {
        return view('auth.login-admin');
    }

    /**
     * Display the coach login view.
     */
    public function createCoach()
    {
        return view('auth.login-coach');
    }

    /**
     * Display the member login view.
     */
    public function createMember()
    {
        return view('auth.login-member');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        // Deteksi role berdasarkan email atau berdasarkan intent
        // Untuk sementara kita gunakan validasi umum dulu, 
        // atau bisa dibuat endpoint terpisah per role

        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect berdasarkan role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard')
                        ->with('success', 'Selamat datang kembali, Admin!');
                case 'coach':
                    return redirect()->route('coach.dashboard')
                        ->with('success', 'Selamat datang kembali, Coach!');
                case 'member':
                    return redirect()->route('member.dashboard')
                        ->with('success', 'Selamat datang kembali, Member!');
                default:
                    return redirect('/');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak valid.',
        ])->onlyInput('email');
    }

    /**
     * Handle admin login with AdminLoginRequest
     */
    public function storeAdmin(AdminLoginRequest $request)
    {
        $validatedData = $request->validated();

        if (Auth::attempt($validatedData, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Pastikan user yang login adalah admin
            if ($user->role !== 'admin') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun ini bukan akun admin.',
                ])->onlyInput('email');
            }

            return redirect()->route('admin.dashboard')
                ->with('success', 'Selamat datang kembali, Admin!');
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak valid.',
        ])->onlyInput('email');
    }

    /**
     * Handle coach login with CoachLoginRequest
     */
    public function storeCoach(CoachLoginRequest $request)
    {
        $validatedData = $request->validated();

        if (Auth::attempt($validatedData, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Pastikan user yang login adalah coach
            if ($user->role !== 'coach') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun ini bukan akun coach.',
                ])->onlyInput('email');
            }

            return redirect()->route('coach.dashboard')
                ->with('success', 'Selamat datang kembali, Coach!');
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak valid.',
        ])->onlyInput('email');
    }

    /**
     * Handle member login with MemberLoginRequest
     */
    public function storeMember(MemberLoginRequest $request)
    {
        $validatedData = $request->validated();

        if (Auth::attempt($validatedData, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Pastikan user yang login adalah member
            if ($user->role !== 'member') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun ini bukan akun member.',
                ])->onlyInput('email');
            }

            return redirect()->route('member.dashboard')
                ->with('success', 'Selamat datang kembali, Member!');
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak valid.',
        ])->onlyInput('email');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        // Simpan role user sebelum logout
        $userRole = Auth::user()->role;

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect berdasarkan role ke halaman login yang sesuai
        switch ($userRole) {
            case 'admin':
                return redirect('/user/admin/login')->with('success', 'Admin telah berhasil logout.');
            case 'coach':
                return redirect('/user/coach/login')->with('success', 'Coach telah berhasil logout.');
            case 'member':
                return redirect('/user/member/login')->with('success', 'Member telah berhasil logout.');
            default:
                return redirect('/login')->with('success', 'Anda telah berhasil logout.');
        }
    }
}
