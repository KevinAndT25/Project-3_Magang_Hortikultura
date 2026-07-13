<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Validasi;
use App\Models\Permohonan;
use Illuminate\Support\Facades\Storage;
use App\Mail\ValidasiSelesaiMail;
use Illuminate\Support\Facades\Mail;

class ValidasiController extends Controller
{
    /**
     * Menampilkan form validasi untuk permohonan tertentu
     */
    public function create($permohonan_id)
    {
        $permohonan = Permohonan::findOrFail($permohonan_id);
        
        // Cek akses: hanya admin
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat mengakses halaman ini.');
        }
        
        // Cek apakah sudah ada validasi yang disubmit
        if ($permohonan->validasi && $permohonan->validasi->is_submit) {
            return redirect()->route('validasi.show', $permohonan_id)
                           ->with('info', 'Validasi sudah disubmit dan tidak dapat diubah.');
        }
        
        return view('validasi.create', compact('permohonan'));
    }

    /**
     * Menyimpan validasi permohonan
     */
    public function store(Request $request, $permohonan_id)
    {
        // Cek akses: hanya admin
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat melakukan validasi.');
        }
        
        // Validasi file
        $request->validate([
            'file_kaji_ulang' => 'required|array',
            'file_kaji_ulang.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $permohonan = Permohonan::findOrFail($permohonan_id);
        
        // Cek apakah sudah ada validasi
        if ($permohonan->validasi && $permohonan->validasi->is_submit) {
            return redirect()->route('validasi.show', $permohonan_id)
                           ->with('error', 'Validasi sudah disubmit dan tidak dapat diubah.');
        }
        
        // Simpan multiple file
        $paths = [];
        if ($request->hasFile('file_kaji_ulang')) {
            foreach ($request->file('file_kaji_ulang') as $file) {
                if ($file->isValid()) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('validasi/' . $permohonan_id, $filename, 'public');
                    $paths[] = $path;
                }
            }
        }

        // Jika tidak ada file yang tersimpan
        if (empty($paths)) {
            return redirect()->back()
                           ->with('error', 'Gagal mengupload file. Silakan coba lagi.')
                           ->withInput();
        }

        // Buat atau update validasi
        Validasi::updateOrCreate(
            ['permohonan_id' => $permohonan_id],
            [
                'file_kaji_ulang_multiple' => $paths,
                'is_submit' => true,
            ]
        );

        // Update status permohonan
        $permohonan->validasi_selesai = true;

        // KIRIM EMAIL KE PEMOHON
        $this->sendEmailToPemohon($permohonan);

        $permohonan->save();

        return redirect()->route('dashboard.admin')
                       ->with('success', 'Validasi berhasil disimpan dan dikirim ke pemohon.');
    }

    /**
     * Menampilkan detail validasi
     */
    public function show($permohonan_id)
    {
        $permohonan = Permohonan::with('validasi')->findOrFail($permohonan_id);
        
        // Cek akses: admin atau pemilik permohonan
        if (auth()->user()->role !== 'admin' && $permohonan->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        $validasi = $permohonan->validasi;
        
        return view('validasi.show', compact('permohonan', 'validasi'));
    }

    /**
     * Kirim notifikasi email ke pemohon
     */
    private function sendEmailToPemohon($permohonan)
    {
        try {
            $pemohon = $permohonan->user;
            if ($pemohon && $pemohon->email) {
                Mail::to($pemohon->email)->send(new ValidasiSelesaiMail($permohonan));
            }
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email notifikasi validasi: ' . $e->getMessage());
        }
    }
}