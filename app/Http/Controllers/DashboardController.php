<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;

class DashboardController extends Controller
{
    /**
     * Dashboard untuk Admin
     */
    public function admin()
    {
        // Permohonan Aktif (status aktif dan belum selesai semua tahap)
        $aktifPermohonans = Permohonan::aktif()
                            ->where(function($q) {
                                $q->whereDoesntHave('validasi')
                                  ->orWhereDoesntHave('pengujian')
                                  ->orWhereDoesntHave('testReport')
                                  ->orWhereDoesntHave('kuisioner');
                            })
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        $permohonanAktif = $aktifPermohonans->count();
        
        // Permohonan Selesai (status selesai)
        $selesaiPermohonans = Permohonan::selesai()
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        $permohonanSelesai = $selesaiPermohonans->count();
        
        return view('dashboard.admin', compact(
            'permohonanAktif', 
            'permohonanSelesai',
            'aktifPermohonans',
            'selesaiPermohonans'
        ));
    }

    /**
     * Dashboard untuk Pemohon
     */
    public function pemohon()
    {
        $user = auth()->user();
        
        // Draft: permohonan dengan status draft
        $draftPermohonans = $user->permohonans()
                            ->draft()
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        $draft = $draftPermohonans->count();
        
        // Permohonan Aktif: status aktif
        $aktifPermohonans = $user->permohonans()
                            ->aktif()
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        $permohonanAktif = $aktifPermohonans->count();
        
        // Permohonan Selesai: status selesai
        $selesaiPermohonans = $user->permohonans()
                            ->selesai()
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        $permohonanSelesai = $selesaiPermohonans->count();

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