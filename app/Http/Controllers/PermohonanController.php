<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PermohonanController extends Controller
{
    public function create()
    {
        return view('permohonan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pemohon' => 'required|string|max:255',
            'status_pemohon' => 'required|in:UMKM,Pemerintah,Produsen',
            'perusahaan_instansi' => 'nullable|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'nomor_surat_permohonan' => 'required|string|max:255',
            'tanggal_surat_permohonan' => 'required|date',
            'jenis_alsintan' => 'required|string|max:255',
            'status_alsintan' => 'required|in:prototipe,produk_massal,impor',
            'status_produksi' => 'required|in:produk_lokal,impor',
            'merek_model_tipe' => 'required|string|max:255',
            'tahun_pembuatan' => 'required|integer|min:1900|max:' . date('Y'),
            'jumlah_unit' => 'required|integer|min:1',
            'daya_maksimal' => 'nullable|string',
            'putaran_mesin' => 'nullable|string',
            'bahan_bakar' => 'nullable|string',
            'sistem_pendinginan' => 'nullable|string',
            'dimensi' => 'nullable|string',
            'berat' => 'nullable|string',
            'kapasitas_kerja' => 'nullable|string',
            'perlengkapan' => 'nullable|string',
            'file_surat_permohonan' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg|max:2048',
            'file_akte' => 'nullable|file|mimes:pdf,jpg,jpeg|max:2048',
            'file_ktp' => 'nullable|file|mimes:pdf,jpg,jpeg|max:2048',
            'file_npwp' => 'nullable|file|mimes:pdf,jpg,jpeg|max:2048',
            'file_nib' => 'nullable|file|mimes:pdf,jpg,jpeg|max:2048',
        ]);

        // Upload files
        $data = $request->except(['_token', 'file_surat_permohonan', 'file_akte', 'file_ktp', 'file_npwp', 'file_nib']);
        
        $data['user_id'] = Auth::id();
        
        // Simpan file
        if ($request->hasFile('file_surat_permohonan')) {
            $data['file_surat_permohonan'] = $request->file('file_surat_permohonan')->store('permohonan/surat', 'public');
        }
        if ($request->hasFile('file_akte')) {
            $data['file_akte'] = $request->file('file_akte')->store('permohonan/akte', 'public');
        }
        if ($request->hasFile('file_ktp')) {
            $data['file_ktp'] = $request->file('file_ktp')->store('permohonan/ktp', 'public');
        }
        if ($request->hasFile('file_npwp')) {
            $data['file_npwp'] = $request->file('file_npwp')->store('permohonan/npwp', 'public');
        }
        if ($request->hasFile('file_nib')) {
            $data['file_nib'] = $request->file('file_nib')->store('permohonan/nib', 'public');
        }

        // Generate nomor permohonan otomatis (contoh: PM/2024/001)
        $tahun = date('Y');
        $count = Permohonan::whereYear('created_at', $tahun)->count() + 1;
        $data['nomor_permohonan'] = 'PM/' . $tahun . '/' . str_pad($count, 3, '0', STR_PAD_LEFT);

        $permohonan = Permohonan::create($data);

        return redirect()->route('dashboard.pemohon')->with('success', 'Permohonan berhasil diajukan.');
    }

    public function show($id)
    {
        $permohonan = Permohonan::with(['user', 'validasi', 'pengujian', 'testReport', 'kuisioner'])->findOrFail($id);
        
        // Cek akses: hanya admin atau pemilik
        if (auth()->user()->role !== 'admin' && $permohonan->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('permohonan.show', compact('permohonan'));
    }
}