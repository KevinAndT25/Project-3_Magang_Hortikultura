<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class KuisionerPdfController extends Controller
{
    /**
     * Generate PDF kuisioner
     */
    public function download($permohonan_id)
    {
        $permohonan = Permohonan::with('kuisioner')->findOrFail($permohonan_id);
        
        // Cek akses: admin atau pemilik permohonan
        if (auth()->user()->role !== 'admin' && $permohonan->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        // Cek apakah kuisioner sudah diisi
        if (!$permohonan->kuisioner || !$permohonan->kuisioner->is_submit) {
            abort(404, 'Kuisioner belum diisi.');
        }
        
        $data = [
            'permohonan' => $permohonan,
            'kuisioner' => $permohonan->kuisioner,
            'tanggal_cetak' => now()->format('d F Y'),
        ];
        
        $pdf = Pdf::loadView('kuisioner.pdf', $data);
        $pdf->setPaper('A4', 'portrait');
        
        // Buat nama file yang aman
        $nomorSurat = $permohonan->nomor_surat_permohonan ?? 'PMH-' . str_pad($permohonan->id, 6, '0', STR_PAD_LEFT);
        $safeFilename = preg_replace('/[\/\\\\]/', '-', $nomorSurat);
        $safeFilename = preg_replace('/\s+/', '_', $safeFilename);
        
        return $pdf->download('Kuisioner_' . $safeFilename . '.pdf');
    }
}