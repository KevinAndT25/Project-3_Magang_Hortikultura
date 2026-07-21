<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengujian;
use App\Models\Permohonan;
use App\Mail\PengujianSelesaiMail;
use App\Mail\PengujianDiterimaMail;
use App\Mail\PengujianDitolakMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

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
            'file_pengujian' => 'nullable|array',
            'file_pengujian.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $permohonan = Permohonan::findOrFail($permohonan_id);
        
        // Cek apakah sudah ada pengujian
        if ($permohonan->pengujian && $permohonan->pengujian->is_submit) {
            return redirect()->route('pengujian.show', $permohonan_id)
                           ->with('error', 'Pengujian sudah disubmit dan tidak dapat diubah.');
        }

        // Simpan file jika ada
        $filePaths = [];
        if ($request->hasFile('file_pengujian')) {
            foreach ($request->file('file_pengujian') as $file) {
                if ($file->isValid()) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('pengujian/' . $permohonan_id, $filename, 'public');
                    $filePaths[] = $path;
                }
            }
        }

        // Buat atau update pengujian
        Pengujian::updateOrCreate(
            ['permohonan_id' => $permohonan_id],
            [
                'nomor_permohonan_uji' => $permohonan->no_permohonan,
                'tanggal_pengujian' => $request->tanggal_pengujian,
                'lokasi' => $request->lokasi,
                'deskripsi' => $request->deskripsi,
                'file_pengujian_multiple' => $filePaths,
                'is_submit' => true,
            ]
        );

        // Update status permohonan
        $permohonan->pengujian_selesai = true;

        // KIRIM EMAIL KE PEMOHON
        $this->sendEmailToPemohon($permohonan);

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

    /**
     * Kirim notifikasi email ke pemohon
     */
    private function sendEmailToPemohon($permohonan)
    {
        try {
            $pemohon = $permohonan->user;
            if ($pemohon && $pemohon->email) {
                Mail::to($pemohon->email)->send(new PengujianSelesaiMail($permohonan));
            }
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email notifikasi pengujian: ' . $e->getMessage());
        }
    }

    /**
     * Menyetujui pengujian oleh pemohon
     */
    public function approve($permohonan_id)
    {
        $permohonan = Permohonan::findOrFail($permohonan_id);
        
        // Cek akses: hanya pemohon yang memiliki permohonan
        if (auth()->user()->role !== 'pemohon' || $permohonan->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses.');
        }
        
        // Cek apakah sudah ada persetujuan
        if ($permohonan->pengujian_disetujui || $permohonan->pengujian_ditolak) {
            return redirect()->back()->with('error', 'Anda sudah memberikan persetujuan untuk pengujian ini.');
        }
        
        // Update status
        $permohonan->pengujian_disetujui = true;
        $permohonan->save();

        $this->sendEmailToAdminDiterima($permohonan);
        
        return redirect()->route('pengujian.show', $permohonan_id)
                       ->with('success', 'Pengujian disetujui. Permohonan akan melanjutkan ke tahap Test Report.');
    }

    /**
     * Menolak pengujian oleh pemohon
     */
    public function reject($permohonan_id)
    {
        $permohonan = Permohonan::findOrFail($permohonan_id);
        
        // Cek akses: hanya pemohon yang memiliki permohonan
        if (auth()->user()->role !== 'pemohon' || $permohonan->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses.');
        }
        
        // Cek apakah sudah ada persetujuan
        if ($permohonan->pengujian_disetujui || $permohonan->pengujian_ditolak) {
            return redirect()->back()->with('error', 'Anda sudah memberikan persetujuan untuk pengujian ini.');
        }
        
        // Update status
        $permohonan->pengujian_ditolak = true;
        $permohonan->status = 'selesai'; // Ubah status menjadi selesai
        $permohonan->save();

        $this->sendEmailToAdminDitolak($permohonan);
        
        return redirect()->route('pengujian.show', $permohonan_id)
                       ->with('success', 'Pengujian ditolak. Permohonan telah diakhiri di tahap pengujian.');
    }

    /**
     * Kirim notifikasi email ke admin (Pengujian Diterima)
     */
    private function sendEmailToAdminDiterima($permohonan)
    {
        try {
            $admin = User::where('role', 'admin')->first();
            if ($admin && $admin->email) {
                Mail::to($admin->email)->send(new PengujianDiterimaMail($permohonan));
            }
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email notifikasi pengujian diterima: ' . $e->getMessage());
        }
    }

    /**
     * Kirim notifikasi email ke admin (Pengujian Ditolak)
     */
    private function sendEmailToAdminDitolak($permohonan)
    {
        try {
            $admin = User::where('role', 'admin')->first();
            if ($admin && $admin->email) {
                Mail::to($admin->email)->send(new PengujianDitolakMail($permohonan));
            }
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email notifikasi pengujian ditolak: ' . $e->getMessage());
        }
    }
}