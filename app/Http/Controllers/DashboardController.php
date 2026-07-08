<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;

class DashboardController extends Controller
{
    public function admin()
    {
        // Permohonan Aktif (belum selesai semua tahap)
        $aktifPermohonans = Permohonan::where(function($q) {
                $q->where('validasi_selesai', false)
                  ->orWhere('pengujian_selesai', false)
                  ->orWhere('test_report_selesai', false)
                  ->orWhere('kuisioner_selesai', false);
            })
            ->orderBy('created_at', 'desc')
            ->get();
        
        $permohonanAktif = $aktifPermohonans->count();
        
        // Permohonan Selesai (semua tahap selesai)
        $selesaiPermohonans = Permohonan::where('validasi_selesai', true)
                            ->where('pengujian_selesai', true)
                            ->where('test_report_selesai', true)
                            ->where('kuisioner_selesai', true)
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

    public function pemohon()
    {
        $user = auth()->user();
        
        // Draft: permohonan yang belum di-submit (semua tahap false)
        $draftPermohonans = $user->permohonans()
                    ->where('validasi_selesai', false)
                    ->where('pengujian_selesai', false)
                    ->where('test_report_selesai', false)
                    ->where('kuisioner_selesai', false)
                    ->orderBy('created_at', 'desc')
                    ->get();
        
        $draft = $draftPermohonans->count();
        
        // Permohonan Aktif: sudah melewati tahap draft, tapi belum selesai
        $aktifPermohonans = $user->permohonans()
                            ->where(function($q) {
                                $q->where('validasi_selesai', true)
                                  ->orWhere('pengujian_selesai', true)
                                  ->orWhere('test_report_selesai', true);
                            })
                            ->where(function($q) {
                                $q->where('validasi_selesai', false)
                                  ->orWhere('pengujian_selesai', false)
                                  ->orWhere('test_report_selesai', false)
                                  ->orWhere('kuisioner_selesai', false);
                            })
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        $permohonanAktif = $aktifPermohonans->count();
        
        // Permohonan Selesai: semua tahap selesai
        $selesaiPermohonans = $user->permohonans()
                            ->where('validasi_selesai', true)
                            ->where('pengujian_selesai', true)
                            ->where('test_report_selesai', true)
                            ->where('kuisioner_selesai', true)
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