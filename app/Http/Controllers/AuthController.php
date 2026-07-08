<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan login admin
    public function showLoginAdmin()
    {
        return view('auth.login_admin');
    }

    // Tampilkan login pemohon
    public function showLoginPemohon()
    {
        return view('auth.login_pemohon');
    }

    // Tampilkan register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses login dengan role
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'role' => 'required|in:admin,pemohon', // Tambahkan validasi role
        ]);

        $credentials = [
            'name' => $request->username,
            'password' => $request->password,
            'role' => $request->role, // Cek role juga
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            
            // Redirect berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->route('dashboard.admin');
            }
            return redirect()->route('dashboard.pemohon');
        }

        return back()->withErrors(['username' => "Username atau password tidak valid."]);
    }

    // Proses register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pemohon',
        ]);

        Auth::login($user);
        return redirect()->route('dashboard.pemohon');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}