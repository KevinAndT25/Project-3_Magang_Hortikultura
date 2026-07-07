<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kuisioner;
use App\Models\Permohonan;

class KuisionerController extends Controller
{
    // Tampilkan form kuisioner (jika sudah diisi, tampilkan readonly)
    public function show($permohonan_id)
    {
        $permohonan = Permohonan::findOrFail($permohonan_id);
        // Hanya pemilik atau admin yang bisa lihat
        if (auth()->user()->role == 'pemohon' && $permohonan->user_id != auth()->id()) {
            abort(403);
        }
        // Cek apakah test report sudah selesai (agar kuisioner bisa diisi)
        // Jika belum, mungkin arahkan ke dashboard dengan pesan
        if (!$permohonan->test_report_selesai) {
            return redirect()->route('pemohon.dashboard')->with('error', 'Test report belum tersedia, silahkan tunggu.');
        }
        $kuisioner = Kuisioner::where('permohonan_id', $permohonan_id)->first();
        return view('kuisioner.form', compact('permohonan', 'kuisioner'));
    }

    // Submit kuisioner
    public function store(Request $request, $permohonan_id)
    {
        $request->validate([
            'nama_responden' => 'required|string|max:255',
            'telepon_responden' => 'required|string|max:20',
            'jenis_kelamin' => 'required|in:L,P',
            'usia' => 'required|integer|min:1|max:120',
            'pendidikan_terakhir' => 'required|string',
            'nama_perusahaan_instansi' => 'required|string|max:255',
            'alamat_perusahaan' => 'required|string',
            'jabatan' => 'required|string|max:255',
            'lama_bekerja_tahun' => 'required|integer|min:0',
            'pengujian_pertama' => 'required|boolean',
            'pengujian_ke' => 'nullable|integer|min:2',
            'mewakili' => 'required|in:diri_sendiri,perusahaan',
            'terakhir_mengajukan' => 'nullable|string|max:255',
            'unit_layanan' => 'required|in:uji_awal,uji_ulang,uji_perpanjangan',
            'hari_laporan_keluar' => 'required|integer|min:1',
            'servqual_1' => 'required|integer|min:1|max:5',
            'servqual_2' => 'required|integer|min:1|max:5',
            'servqual_3' => 'required|integer|min:1|max:5',
            'servqual_4' => 'required|integer|min:1|max:5',
            'servqual_5' => 'required|integer|min:1|max:5',
            'kesan_pesan' => 'nullable|string',
            'kepuasan_umum' => 'required|in:sangat_tidak_puas,tidak_puas,netral,puas,sangat_puas',
            'rekomendasi' => 'required|in:sangat_tidak,tidak,terserah,merekomendasikan,sangat_merekomendasikan',
            'ide_saran' => 'nullable|string',
        ]);

        $permohonan = Permohonan::findOrFail($permohonan_id);
        // Pastikan pemohon yang login adalah pemilik
        if (auth()->user()->role == 'pemohon' && $permohonan->user_id != auth()->id()) {
            abort(403);
        }
        // Cek apakah sudah ada kuisioner dan sudah submit
        $kuisioner = Kuisioner::where('permohonan_id', $permohonan_id)->first();
        if ($kuisioner && $kuisioner->is_submit) {
            return back()->with('error', 'Kuisioner sudah pernah diisi, tidak bisa diubah.');
        }

        $data = $request->all();
        $data['permohonan_id'] = $permohonan_id;
        $data['is_submit'] = true;

        if ($kuisioner) {
            $kuisioner->update($data);
        } else {
            Kuisioner::create($data);
        }

        $permohonan->kuisioner_selesai = true;
        $permohonan->save();

        return redirect()->route('pemohon.dashboard')->with('success', 'Kuisioner berhasil disubmit, sekarang Anda dapat mendownload test report.');
    }
}