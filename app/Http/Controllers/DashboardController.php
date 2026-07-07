<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->role == 'admin') {
            // Ambil semua permohonan dengan relasi
            $permohonans = Permohonan::with('user')->orderBy('created_at', 'desc')->get();
            return view('admin.dashboard', compact('permohonans'));
        } else {
            // Pemohon: ambil miliknya
            $permohonans = Permohonan::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
            return view('pemohon.dashboard', compact('permohonans'));
        }
    }
}