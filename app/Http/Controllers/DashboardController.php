<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Dashboard Admin
     */
    public function admin()
    {
        $permohonanAktif = Permohonan::where('status', 'aktif')->count();
        $permohonanSelesai = Permohonan::where('status', 'selesai')->count();
        
        $aktifPermohonans = Permohonan::with('user')
                            ->where('status', 'aktif')
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        $selesaiPermohonans = Permohonan::with('user')
                            ->where('status', 'selesai')
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        return view('dashboard.admin', compact(
            'permohonanAktif',
            'permohonanSelesai',
            'aktifPermohonans',
            'selesaiPermohonans'
        ));
    }

    /**
     * Dashboard Pemohon
     */
    public function pemohon()
    {
        $user = auth()->user();
        
        $draft = $user->permohonans()->where('status', 'draft')->count();
        $permohonanAktif = $user->permohonans()->where('status', 'aktif')->count();
        $permohonanSelesai = $user->permohonans()->where('status', 'selesai')->count();
        
        $draftPermohonans = $user->permohonans()
                            ->where('status', 'draft')
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        $aktifPermohonans = $user->permohonans()
                            ->where('status', 'aktif')
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        $selesaiPermohonans = $user->permohonans()
                            ->where('status', 'selesai')
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        return view('dashboard.pemohon', compact(
            'draft',
            'permohonanAktif',
            'permohonanSelesai',
            'draftPermohonans',
            'aktifPermohonans',
            'selesaiPermohonans'
        ));
    }
}