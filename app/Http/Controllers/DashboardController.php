<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Dashboard Admin dengan Filter
     */
    public function admin(Request $request)
    {
        $aktifQuery = Permohonan::with('user')->where('status', 'aktif');
        $selesaiQuery = Permohonan::with('user')->where('status', 'selesai');
        
        // Filter berdasarkan search (nomor surat, nama pemohon, jenis alsintan, merek)
        if ($request->filled('search')) {
            $search = $request->search;
            $aktifQuery->where(function($query) use ($search) {
                $query->where('nomor_surat_permohonan', 'like', "%{$search}%")
                    ->orWhere('nama_pemohon', 'like', "%{$search}%")
                    ->orWhere('jenis_alsintan', 'like', "%{$search}%")
                    ->orWhere('merek_model_tipe', 'like', "%{$search}%");
            });
            $selesaiQuery->where(function($query) use ($search) {
                $query->where('nomor_surat_permohonan', 'like', "%{$search}%")
                    ->orWhere('nama_pemohon', 'like', "%{$search}%")
                    ->orWhere('jenis_alsintan', 'like', "%{$search}%")
                    ->orWhere('merek_model_tipe', 'like', "%{$search}%");
            });
        }
        
        // Filter berdasarkan status pemohon
        if ($request->filled('status')) {
            $status = $request->status;
            $aktifQuery->where('status_pemohon', $status);
            $selesaiQuery->where('status_pemohon', $status);
        }
        
        // Ambil data
        $aktifPermohonans = $aktifQuery->orderBy('created_at', 'desc')->get();
        $selesaiPermohonans = $selesaiQuery->orderBy('created_at', 'desc')->get();
        
        // Hitung total (untuk widget)
        $permohonanAktif = Permohonan::where('status', 'aktif')->count();
        $permohonanSelesai = Permohonan::where('status', 'selesai')->count();
        
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