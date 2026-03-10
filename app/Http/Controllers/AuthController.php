<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Guru;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    /* =================================
       FORM LOGIN
    ================================= */

    public function showLogin()
    {
        return view('auth.login');
    }


    /* =================================
       PROSES LOGIN
    ================================= */

    public function loginProcess(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'guru') {
                return redirect()->route('guru.dashboard');
            }

            if ($user->role === 'kepsek') {
                return redirect()->route('kepsek.dashboard');
            }

            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Role tidak dikenali');
        }

        return back()->withInput()->with('error', 'Email atau password salah');
    }


    /* =================================
       FORM REGISTER
    ================================= */

    public function showRegister()
    {
        return view('auth.register');
    }


    /* =================================
       PROSES REGISTER
    ================================= */

    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:6|confirmed',
            'role'         => 'required|in:guru,kepsek',
        ]);

        $user = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'role'         => $request->role,
        ]);

        // Hanya guru yang punya data di tabel guru
        if ($request->role === 'guru') {
            Guru::create([
                'user_id' => $user->id
            ]);
        }

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil, silakan login');
    }


    /* =================================
       LOGOUT
    ================================= */

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}