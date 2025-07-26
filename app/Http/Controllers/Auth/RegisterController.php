<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MemberRegisterRequest;
use App\Http\Requests\CoachRegisterRequest;

class RegisterController extends Controller
{
    public function index(Request $request)
    {
        // Ambil role dari URL parameter, default ke 'member'
        $role = $request->route('role') ?? 'member';

        // Admin tidak boleh register, hanya login
        if ($role === 'admin') {
            return redirect('/user/admin/login')->with('error', 'Admin tidak dapat mendaftar. Silakan login dengan akun admin yang sudah ada.');
        }

        // Validasi role yang diizinkan (hanya member dan coach)
        if (!in_array($role, ['coach', 'member'])) {
            $role = 'member';
        }

        return view('auth.register', compact('role'));
    }

    /**
     * Display the member register view.
     */
    public function createMember()
    {
        return view('auth.register-member');
    }

    /**
     * Display the coach register view.
     */
    public function createCoach()
    {
        return view('auth.register-coach');
    }

    public function store(Request $request)
    {
        $role = $request->route('role') ?? 'member';

        // Admin tidak boleh register
        if ($role === 'admin') {
            return redirect('/login')->with('error', 'Admin tidak dapat mendaftar. Silakan login dengan akun admin yang sudah ada.');
        }

        // Redirect ke method yang sesuai berdasarkan role
        if ($role === 'member') {
            return $this->storeMember($request);
        } elseif ($role === 'coach') {
            return $this->storeCoach($request);
        }

        return redirect()->route('register')
            ->withErrors(['role' => 'Role tidak valid.']);
    }

    public function storeMember(MemberRegisterRequest $request)
    {
        $validatedData = $request->validated();

        // Buat user baru
        $user = User::create([
            'full_name' => $validatedData['full_name'],
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'member',
            'is_active' => true,
        ]);

        // Login otomatis setelah registrasi
        Auth::login($user);

        return redirect()->route('member.dashboard')
            ->with('success', 'Registrasi member berhasil! Selamat datang.');
    }

    public function storeCoach(CoachRegisterRequest $request)
    {
        $validatedData = $request->validated();

        // Buat user baru dengan status pending approval
        $user = User::create([
            'full_name' => $validatedData['full_name'],
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'coach',
            'is_active' => true,
            'approval_status' => 'pending',
        ]);

        // Buat coach profile kosong
        $user->coachProfile()->create([]);

        // Login otomatis setelah registrasi
        Auth::login($user);

        return redirect()->route('profile.setup')
            ->with('info', 'Registrasi berhasil! Silakan lengkapi profil Anda untuk mendapatkan persetujuan admin.');
    }
}
