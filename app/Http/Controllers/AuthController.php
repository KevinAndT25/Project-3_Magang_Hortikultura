<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;        
use Illuminate\Support\Str; 
use App\Models\User;
use App\Mail\ResetPasswordMail;  
use Illuminate\Validation\Rule; 

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

    /**
     * Tampilkan halaman lupa password
     */
    public function showForgotPassword()
    {
        return view('auth.forgot_password');
    }

    /**
     * Proses reset password
     */
    public function resetPassword(Request $request)
    {
        // Validasi email
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Email tidak ditemukan. Pastikan email yang Anda masukkan benar.',
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan.');
        }

        // Generate password baru (8 karakter acak)
        $newPassword = Str::random(8);

        // Update password user
        $user->password = Hash::make($newPassword);
        $user->save();

        try {
            // Kirim email dengan password baru
            Mail::to($user->email)->send(new ResetPasswordMail($user, $newPassword));

            return redirect()->route('login.pemohon')
                ->with('success', 'Password baru telah dikirim ke email Anda. Silakan cek inbox atau folder spam.');
        } catch (\Exception $e) {
            // Jika email gagal dikirim, rollback password
            $user->password = $user->getOriginal('password');
            $user->save();

            return back()->with('error', 'Gagal mengirim email. Silakan coba lagi nanti.');
        }
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

     /**
     * Update profil untuk semua user (admin dan pemohon)
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        // Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'no_hp' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Update data
        $user->name = $request->name;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();

        // Redirect berdasarkan role
        if ($user->isAdmin()) {
            return redirect()->route('dashboard.admin')->with('success', 'Profil berhasil diperbarui!');
        }
        
        return redirect()->route('dashboard.pemohon')->with('success', 'Profil berhasil diperbarui!');
    }
}