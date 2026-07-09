<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengujian;
use App\Models\Permohonan;

class PengujianController extends Controller
{
    /**
     * Menampilkan form pengujian untuk permohonan tertentu
     */
    public function create($permohonan_id)
    {
        $permohonan = Permohonan::findOrFail($permohonan_id);
        
        // Cek akses: hanya admin
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat mengakses halaman ini.');
        }
        
        // Cek apakah validasi sudah selesai
        if (!$permohonan->validasi_selesai) {
            return redirect()->route('dashboard.admin')
                           ->with('error', 'Harap lengkapi validasi terlebih dahulu.');
        }
        
        // Cek apakah sudah ada pengujian yang disubmit
        if ($permohonan->pengujian && $permohonan->pengujian->is_submit) {
            return redirect()->route('pengujian.show', $permohonan_id)
                           ->with('info', 'Pengujian sudah disubmit dan tidak dapat diubah.');
        }
        
        return view('pengujian.create', compact('permohonan'));
    }

    /**
     * Menyimpan data pengujian
     */
    public function store(Request $request, $permohonan_id)
    {
        // Cek akses: hanya admin
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat melakukan pengujian.');
        }
        
        $request->validate([
            'tanggal_pengujian' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $permohonan = Permohonan::findOrFail($permohonan_id);
        
        // Cek apakah sudah ada pengujian
        if ($permohonan->pengujian && $permohonan->pengujian->is_submit) {
            return redirect()->route('pengujian.show', $permohonan_id)
                           ->with('error', 'Pengujian sudah disubmit dan tidak dapat diubah.');
        }

        // Buat atau update pengujian
        Pengujian::updateOrCreate(
            ['permohonan_id' => $permohonan_id],
            [
                'nomor_permohonan_uji' => $permohonan->no_permohonan,
                'tanggal_pengujian' => $request->tanggal_pengujian,
                'lokasi' => $request->lokasi,
                'deskripsi' => $request->deskripsi,
                'is_submit' => true,
            ]
        );

        // Update status permohonan
        $permohonan->pengujian_selesai = true;
        $permohonan->save();

        return redirect()->route('dashboard.admin')
                       ->with('success', 'Data pengujian berhasil disimpan.');
    }

    /**
     * Menampilkan detail pengujian
     */
    public function show($permohonan_id)
    {
        $permohonan = Permohonan::with('pengujian')->findOrFail($permohonan_id);
        
        // Cek akses: admin atau pemilik permohonan
        if (auth()->user()->role !== 'admin' && $permohonan->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        $pengujian = $permohonan->pengujian;
        
        return view('pengujian.show', compact('permohonan', 'pengujian'));
    }
}