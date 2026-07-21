<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua user (hanya untuk admin)
     */
    public function index()
    {
        // Ambil semua user kecuali admin (karena admin hanya 1)
        $users = User::where('role', 'pemohon')->orderBy('name')->get();
        
        // Total user (semua role)
        $totalUsers = User::count();
        
        // Total admin (hardcode = 1 karena hanya ada 1 admin)
        $totalAdmin = 1;
        
        // Total pemohon
        $totalPemohon = User::where('role', 'pemohon')->count();
        
        return view('admin.users', compact(
            'users',
            'totalUsers',
            'totalAdmin',
            'totalPemohon'
        ));
    }
}