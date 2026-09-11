<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ── Landing ─────────────────────────────────────────────────
    public function landing()
    {
        return view('landing');
    }

    // ── Siswa Auth ───────────────────────────────────────────────
    public function showLoginSiswa()
    {
        return view('auth.login-siswa');
    }

    public function loginSiswa(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()
                ->withErrors(['email' => 'Email tidak ditemukan.'])
                ->withInput($request->only('email'));
        }

        if ($user->role !== 'siswa') {
            return back()
                ->withErrors(['email' => 'Akun ini bukan akun siswa.'])
                ->withInput($request->only('email'));
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors(['email' => 'Password salah.'])
                ->withInput($request->only('email'));
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();
        return redirect()->route('siswa.dashboard');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:100',
            'nis'           => 'required|string|unique:users,nis',
            'kelas'         => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6|confirmed',
        ]);

        User::create([
            'name'          => $request->name,
            'nis'           => $request->nis,
            'kelas'         => $request->kelas,
            'jenis_kelamin' => $request->jenis_kelamin,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'role'          => 'siswa',
        ]);

        // Tidak langsung login, arahkan ke halaman login dengan pesan sukses
        return redirect()->route('login.siswa')
            ->with('success', 'Akun berhasil dibuat! Silakan login untuk melanjutkan.');
    }

    // ── Admin Auth ───────────────────────────────────────────────
    public function showLoginAdmin()
    {
        return view('auth.login-admin');
    }

    public function loginAdmin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()
                ->withErrors(['email' => 'Email tidak ditemukan.'])
                ->withInput($request->only('email'));
        }

        if ($user->role !== 'admin') {
            return back()
                ->withErrors(['email' => 'Akun ini bukan akun admin.'])
                ->withInput($request->only('email'));
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors(['email' => 'Password salah.'])
                ->withInput($request->only('email'));
        }

        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('admin.dashboard');
    }

    // ── Logout ───────────────────────────────────────────────────
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('landing');
    }
}