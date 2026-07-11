<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PermohonanPdfController extends Controller
{
    /**
     * Generate PDF dari permohonan
     */
    public function download($id)
    {
        $permohonan = Permohonan::with('user')->findOrFail($id);
        
        // Cek akses
        if (auth()->user()->isPemohon() && $permohonan->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke permohonan ini.');
        }
        
        // Jika draft dan user bukan pemilik, tidak bisa diakses
        if ($permohonan->status === 'draft' && auth()->user()->isAdmin()) {
            abort(404, 'Permohonan tidak ditemukan.');
        }
        
        $data = [
            'permohonan' => $permohonan,
            'tanggal_cetak' => now()->format('d F Y'),
        ];
        
        $pdf = Pdf::loadView('permohonan.pdf', $data);
        $pdf->setPaper('A4', 'portrait');
        
        // Buat nama file yang aman - replace karakter berbahaya
        $nomorSurat = $permohonan->nomor_surat_permohonan ?? 'PMH-' . str_pad($permohonan->id, 6, '0', STR_PAD_LEFT);
        
        // Hapus karakter yang tidak diizinkan: / \ dan spasi berlebih
        $safeFilename = preg_replace('/[\/\\\\]/', '-', $nomorSurat);
        $safeFilename = preg_replace('/\s+/', '_', $safeFilename);
        
        return $pdf->download('Permohonan_Pengujian_' . $safeFilename . '.pdf');
    }
}