<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;

class DashboardController extends Controller
{
    public function admin()
    {
        // Permohonan Aktif (belum selesai semua tahap - cek relasi)
        $aktifPermohonans = Permohonan::where(function($q) {
                $q->whereDoesntHave('validasi')
                  ->orWhereDoesntHave('pengujian')
                  ->orWhereDoesntHave('testReport')
                  ->orWhereDoesntHave('kuisioner');
            })
            ->orderBy('created_at', 'desc')
            ->get();
        
        $permohonanAktif = $aktifPermohonans->count();
        
        // Permohonan Selesai (semua tahap selesai - cek relasi)
        $selesaiPermohonans = Permohonan::whereHas('validasi')
                            ->whereHas('pengujian')
                            ->whereHas('testReport')
                            ->whereHas('kuisioner')
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
        
        // Draft: permohonan yang belum memiliki relasi apapun
        $draftPermohonans = $user->permohonans()
                    ->whereDoesntHave('validasi')
                    ->whereDoesntHave('pengujian')
                    ->whereDoesntHave('testReport')
                    ->whereDoesntHave('kuisioner')
                    ->orderBy('created_at', 'desc')
                    ->get();
        
        $draft = $draftPermohonans->count();
        
        // Permohonan Aktif: sudah memiliki beberapa relasi tapi belum semua
        $aktifPermohonans = $user->permohonans()
                            ->where(function($q) {
                                $q->whereHas('validasi')
                                  ->orWhereHas('pengujian')
                                  ->orWhereHas('testReport');
                            })
                            ->where(function($q) {
                                $q->whereDoesntHave('validasi')
                                  ->orWhereDoesntHave('pengujian')
                                  ->orWhereDoesntHave('testReport')
                                  ->orWhereDoesntHave('kuisioner');
                            })
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        $permohonanAktif = $aktifPermohonans->count();
        
        // Permohonan Selesai: semua relasi ada
        $selesaiPermohonans = $user->permohonans()
                            ->whereHas('validasi')
                            ->whereHas('pengujian')
                            ->whereHas('testReport')
                            ->whereHas('kuisioner')
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