<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PermohonanController extends Controller
{
    // Tampilkan form permohonan baru
    public function create()
    {
        return view('permohonan.create');
    }

    // Simpan permohonan baru
    public function store(Request $request)
    {
        $request->validate([
            // Data Pemohon
            'nama_pemohon' => 'required|string|max:255',
            'status_pemohon' => 'required|in:UMKM,Pemerintah,Produsen',
            'perusahaan_instansi' => 'nullable|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'nomor_surat_permohonan' => 'required|string|max:255',
            'tanggal_surat_permohonan' => 'required|date',
            // Alsintan
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
        ]);

        // Upload file sesuai status pemohon
        $data = $request->all();
        $data['user_id'] = Auth::id();

        // Upload file surat permohonan (wajib)
        if ($request->hasFile('file_surat_permohonan')) {
            $data['file_surat_permohonan'] = $request->file('file_surat_permohonan')->store('permohonan/surat', 'public');
        }

        // File opsional berdasarkan status
        if ($request->status_pemohon == 'UMKM') {
            // hanya KTP dan surat sudah di atas
            if ($request->hasFile('file_ktp')) {
                $data['file_ktp'] = $request->file('file_ktp')->store('permohonan/ktp', 'public');
            }
        } elseif ($request->status_pemohon == 'Pemerintah') {
            // hanya surat permohonan saja (sudah)
        } elseif ($request->status_pemohon == 'Produsen') {
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
        }

        // Buat nomor permohonan otomatis: format PM/YYYY/MM/xxx (contoh)
        $year = date('Y');
        $month = date('m');
        $count = Permohonan::whereYear('created_at', $year)->whereMonth('created_at', $month)->count() + 1;
        $nomor = 'PM/' . $year . '/' . $month . '/' . str_pad($count, 4, '0', STR_PAD_LEFT);
        $data['nomor_permohonan'] = $nomor;

        $permohonan = Permohonan::create($data);

        return redirect()->route('pemohon.dashboard')->with('success', 'Permohonan berhasil diajukan.');
    }

    // Tampilkan detail permohonan (readonly)
    public function show($id)
    {
        $permohonan = Permohonan::with(['user', 'validasi', 'pengujian', 'testReport', 'kuisioner'])->findOrFail($id);
        // Cek akses: hanya pemilik atau admin
        if (Auth::user()->role == 'pemohon' && $permohonan->user_id != Auth::id()) {
            abort(403);
        }
        return view('permohonan.show', compact('permohonan'));
    }

    // Download file
    public function downloadFile($id, $type)
    {
        $permohonan = Permohonan::findOrFail($id);
        // Cek akses
        if (Auth::user()->role == 'pemohon' && $permohonan->user_id != Auth::id()) {
            abort(403);
        }
        // Tentukan field dan path
        $filePath = null;
        switch ($type) {
            case 'surat':
                $filePath = $permohonan->file_surat_permohonan;
                break;
            case 'ktp':
                $filePath = $permohonan->file_ktp;
                break;
            case 'akte':
                $filePath = $permohonan->file_akte;
                break;
            case 'npwp':
                $filePath = $permohonan->file_npwp;
                break;
            case 'nib':
                $filePath = $permohonan->file_nib;
                break;
            default:
                abort(404);
        }
        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            abort(404);
        }
        return Storage::disk('public')->download($filePath);
    }
}