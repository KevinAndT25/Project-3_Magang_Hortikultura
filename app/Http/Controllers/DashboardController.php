<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;

class DashboardController extends Controller
{
    public function admin()
    {
        $totalPermohonan = Permohonan::count();
        $menungguTindakan = Permohonan::where('validasi_selesai', false)
                                    ->orWhere('pengujian_selesai', false)
                                    ->orWhere('test_report_selesai', false)
                                    ->count();
        $menungguKuisioner = Permohonan::where('test_report_selesai', true)
                                    ->where('kuisioner_selesai', false)
                                    ->count();
        $selesai = Permohonan::where('validasi_selesai', true)
                            ->where('pengujian_selesai', true)
                            ->where('test_report_selesai', true)
                            ->where('kuisioner_selesai', true)
                            ->count();
        
        $permohonans = Permohonan::with('user')->orderBy('created_at', 'desc')->get();
        return view('dashboard.admin', compact('totalPermohonan', 'menungguTindakan', 'menungguKuisioner', 'selesai', 'permohonans'));
    }

    public function pemohon()
    {
        $user = auth()->user();
        $totalPermohonan = $user->permohonans()->count();
        $sedangDiproses = $user->permohonans()
                            ->where(function($q) {
                                $q->where('validasi_selesai', false)
                                  ->orWhere('pengujian_selesai', false)
                                  ->orWhere('test_report_selesai', false)
                                  ->orWhere('kuisioner_selesai', false);
                            })
                            ->count();
        $selesai = $user->permohonans()
                        ->where('validasi_selesai', true)
                        ->where('pengujian_selesai', true)
                        ->where('test_report_selesai', true)
                        ->where('kuisioner_selesai', true)
                        ->count();

        $permohonans = $user->permohonans()->orderBy('created_at', 'desc')->get();
        return view('dashboard.pemohon', compact('totalPermohonan', 'sedangDiproses', 'selesai', 'permohonans'));
    }
}