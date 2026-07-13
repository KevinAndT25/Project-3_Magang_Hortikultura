<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kuisioner;
use App\Models\Permohonan;
use App\Mail\KuisionerSelesaiMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class KuisionerController extends Controller
{
    /**
     * Menampilkan form kuisioner untuk permohonan tertentu
     */
    public function create($permohonan_id)
    {
        $permohonan = Permohonan::findOrFail($permohonan_id);
        
        // Hanya pemilik permohonan yang bisa mengisi kuisioner
        if (auth()->user()->role !== 'pemohon' || $permohonan->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        // Cek apakah test report sudah selesai
        if (!$permohonan->test_report_selesai) {
            return redirect()->route('dashboard.pemohon')
                           ->with('error', 'Test report belum tersedia.');
        }
        
        // Cek apakah kuisioner sudah disubmit
        if ($permohonan->kuisioner && $permohonan->kuisioner->is_submit) {
            return redirect()->route('kuisioner.show', $permohonan_id)
                           ->with('info', 'Kuisioner sudah disubmit dan tidak dapat diubah.');
        }
        
        return view('kuisioner.create', compact('permohonan'));
    }

    /**
     * Menyimpan data kuisioner
     */
    public function store(Request $request, $permohonan_id)
    {
        $request->validate([
            'nama_responden' => 'required|string|max:255',
            'telepon_responden' => 'required|string|max:20',
            'jenis_kelamin' => 'required|in:L,P',
            'usia' => 'required|integer|min:1',
            'pendidikan_terakhir' => 'required|string',
            'nama_perusahaan_instansi' => 'required|string|max:255',
            'alamat_perusahaan' => 'required|string',
            'jabatan' => 'required|string',
            'lama_bekerja_tahun' => 'required|integer|min:0',
            'pengujian_pertama' => 'required|boolean',
            'pengujian_ke' => 'nullable|integer|min:2',
            'mewakili' => 'required|in:diri_sendiri,perusahaan',
            'terakhir_mengajukan' => 'nullable|string|max:255',
            'unit_layanan' => 'required|in:uji_awal,uji_ulang,uji_perpanjangan',
            'hari_laporan_keluar' => 'required|integer|min:0',
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
        
        // Cek apakah kuisioner sudah ada
        if ($permohonan->kuisioner && $permohonan->kuisioner->is_submit) {
            return redirect()->route('kuisioner.show', $permohonan_id)
                           ->with('error', 'Kuisioner sudah disubmit dan tidak dapat diubah.');
        }

        // Buat atau update kuisioner
        Kuisioner::updateOrCreate(
            ['permohonan_id' => $permohonan_id],
            [
                'nama_responden' => $request->nama_responden,
                'telepon_responden' => $request->telepon_responden,
                'jenis_kelamin' => $request->jenis_kelamin,
                'usia' => $request->usia,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'nama_perusahaan_instansi' => $request->nama_perusahaan_instansi,
                'alamat_perusahaan' => $request->alamat_perusahaan,
                'jabatan' => $request->jabatan,
                'lama_bekerja_tahun' => $request->lama_bekerja_tahun,
                'pengujian_pertama' => $request->pengujian_pertama,
                'pengujian_ke' => $request->pengujian_ke,
                'mewakili' => $request->mewakili,
                'terakhir_mengajukan' => $request->terakhir_mengajukan,
                'unit_layanan' => $request->unit_layanan,
                'hari_laporan_keluar' => $request->hari_laporan_keluar,
                'servqual_1' => $request->servqual_1,
                'servqual_2' => $request->servqual_2,
                'servqual_3' => $request->servqual_3,
                'servqual_4' => $request->servqual_4,
                'servqual_5' => $request->servqual_5,
                'kesan_pesan' => $request->kesan_pesan,
                'kepuasan_umum' => $request->kepuasan_umum,
                'rekomendasi' => $request->rekomendasi,
                'ide_saran' => $request->ide_saran,
                'is_submit' => true,
            ]
        );

        // Update status permohonan
        $permohonan->kuisioner_selesai = true;
        $permohonan->status = 'selesai';

        // KIRIM EMAIL KE ADMIN
        $this->sendEmailToAdmin($permohonan);
        
        $permohonan->save();

        return redirect()->route('dashboard.pemohon')
                       ->with('success', 'Kuisioner berhasil disubmit. Terima kasih atas partisipasi Anda!');
    }

    /**
     * Menampilkan detail kuisioner
     */
    public function show($permohonan_id)
    {
        $permohonan = Permohonan::with('kuisioner')->findOrFail($permohonan_id);
        
        // Cek akses: admin atau pemilik permohonan
        if (auth()->user()->role !== 'admin' && $permohonan->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        $kuisioner = $permohonan->kuisioner;
        
        return view('kuisioner.show', compact('permohonan', 'kuisioner'));
    }

    /**
     * Kirim notifikasi email ke admin
     */
    private function sendEmailToAdmin($permohonan)
    {
        try {
            $admin = User::where('role', 'admin')->first();
            if ($admin && $admin->email) {
                Mail::to($admin->email)->send(new KuisionerSelesaiMail($permohonan));
            }
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email notifikasi kuisioner: ' . $e->getMessage());
        }
    }
}