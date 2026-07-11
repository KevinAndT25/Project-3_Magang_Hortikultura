<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; 

class PermohonanController extends Controller
{
    /**
     * Menampilkan daftar permohonan berdasarkan role
     */
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            // Admin melihat semua permohonan (kecuali draft)
            $aktifPermohonans = Permohonan::with('user')
                                ->where('status', 'aktif')
                                ->orderBy('created_at', 'desc')
                                ->get();
            
            $selesaiPermohonans = Permohonan::with('user')
                                ->where('status', 'selesai')
                                ->orderBy('created_at', 'desc')
                                ->get();
            
            $draftPermohonans = collect(); // Kosong untuk admin
            
        } else {
            // Pemohon melihat semua permohonan milik sendiri
            $draftPermohonans = $user->permohonans()
                                ->where('status', 'draft')
                                ->orderBy('created_at', 'desc')
                                ->get();
            
            $aktifPermohonans = $user->permohonans()
                                ->where('status', 'aktif')
                                ->orderBy('created_at', 'desc')
                                ->get();
            
            $selesaiPermohonans = $user->permohonans()
                                ->where('status', 'selesai')
                                ->orderBy('created_at', 'desc')
                                ->get();
        }
        
        return view('permohonan.index', compact(
            'draftPermohonans',
            'aktifPermohonans',
            'selesaiPermohonans'
        ));
    }

    /**
     * Menampilkan detail permohonan
     */
    public function show($id)
    {
        $permohonan = Permohonan::with('user')->findOrFail($id);
        
        // Cek akses: admin bisa lihat semua, pemohon hanya milik sendiri
        if (auth()->user()->isPemohon() && $permohonan->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke permohonan ini.');
        }
        
        // Jika draft dan user bukan pemilik, tidak bisa diakses
        if ($permohonan->status === 'draft' && auth()->user()->isAdmin()) {
            abort(404, 'Permohonan tidak ditemukan.');
        }
        
        return view('permohonan.show', compact('permohonan'));
    }

    /**
     * Menampilkan form buat permohonan baru
     */
    public function create()
    {
        $user = auth()->user();
        return view('permohonan.create', compact('user'));
    }

    /**
     * Menyimpan permohonan baru (draft atau submit)
     */
    public function store(Request $request)
    {
        // Validasi dasar
        $rules = [
            'nama_pemohon' => 'required|string|max:255',
            'status_pemohon' => 'required|in:UMKM,Pemerintah,Produsen',
            'perusahaan_instansi' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'nomor_surat_permohonan' => 'required|string|max:100',
            'tanggal_surat_permohonan' => 'required|date',
            'jenis_alsintan' => 'required|string|max:255',
            'status_alsintan' => 'required|in:prototipe,produk_massal,impor',
            'status_produksi' => 'required|in:produk_lokal,impor',
            'merek_model_tipe' => 'required|string|max:255',
            'tahun_pembuatan' => 'nullable|integer|min:1900|max:' . date('Y'),
            'jumlah_unit' => 'required|integer|min:1',
            'daya_maksimal' => 'nullable|string|max:100',
            'putaran_mesin' => 'nullable|string|max:100',
            'bahan_bakar' => 'nullable|string|max:100',
            'sistem_pendinginan' => 'nullable|string|max:100',
            'dimensi_p' => 'nullable|string|max:50',
            'dimensi_l' => 'nullable|string|max:50',
            'dimensi_t' => 'nullable|string|max:50',
            'berat' => 'nullable|string|max:50',
            'kapasitas_kerja' => 'nullable|string|max:100',
            'perlengkapan' => 'nullable|string|max:255',
        ];
        
        // Validasi file berdasarkan status pemohon
        $statusPemohon = $request->status_pemohon;
        $fileRules = [
            'file_surat_permohonan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];
        
        if ($statusPemohon === 'UMKM') {
            $fileRules['file_ktp'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:5120';
        } elseif ($statusPemohon === 'Produsen') {
            $fileRules['file_ktp'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:5120';
            $fileRules['file_akte'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:5120';
            $fileRules['file_npwp'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:5120';
            $fileRules['file_nib'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:5120';
        }
        
        // Jika action draft, file tidak wajib
        if ($request->action === 'draft') {
            foreach ($fileRules as $key => $rule) {
                $fileRules[$key] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120';
            }
        }
        
        $rules = array_merge($rules, $fileRules);
        $request->validate($rules);

        // Buat nomor permohonan otomatis
        $noPermohonan = 'PMH-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        
        // Simpan data permohonan
        $permohonan = new Permohonan();
        $permohonan->user_id = auth()->id();
        $permohonan->no_permohonan = $noPermohonan;
        $permohonan->nama_pemohon = $request->nama_pemohon;
        $permohonan->status_pemohon = $request->status_pemohon;
        $permohonan->perusahaan_instansi = $request->perusahaan_instansi;
        $permohonan->alamat = $request->alamat;
        $permohonan->telepon = $request->telepon;
        $permohonan->nomor_surat_permohonan = $request->nomor_surat_permohonan;
        $permohonan->tanggal_surat_permohonan = $request->tanggal_surat_permohonan;
        $permohonan->jenis_alsintan = $request->jenis_alsintan;
        $permohonan->status_alsintan = $request->status_alsintan;
        $permohonan->status_produksi = $request->status_produksi;
        $permohonan->merek_model_tipe = $request->merek_model_tipe;
        $permohonan->tahun_pembuatan = $request->tahun_pembuatan;
        $permohonan->jumlah_unit = $request->jumlah_unit;
        $permohonan->daya_maksimal = $request->daya_maksimal;
        $permohonan->putaran_mesin = $request->putaran_mesin;
        $permohonan->bahan_bakar = $request->bahan_bakar;
        $permohonan->sistem_pendinginan = $request->sistem_pendinginan;
        $permohonan->dimensi_p = $request->dimensi_p;
        $permohonan->dimensi_l = $request->dimensi_l;
        $permohonan->dimensi_t = $request->dimensi_t;
        $permohonan->berat = $request->berat;
        $permohonan->kapasitas_kerja = $request->kapasitas_kerja;
        $permohonan->perlengkapan = $request->perlengkapan;
        
        // Set status berdasarkan action
        if ($request->action === 'draft') {
            $permohonan->status = 'draft';
            $message = 'Permohonan berhasil disimpan sebagai draft. Anda dapat mengeditnya nanti.';
        } else {
            $permohonan->status = 'aktif';
            $message = 'Permohonan berhasil disubmit! Menunggu proses validasi oleh admin.';
        }
        
        $permohonan->save();

        // Upload files jika ada
        $this->uploadFiles($permohonan, $request);

        return redirect()->route('permohonan.show', $permohonan->id)
                         ->with('success', $message);
    }

    /**
     * Upload files untuk permohonan
     */
    private function uploadFiles($permohonan, $request)
    {
        $fileFields = [
            'file_surat_permohonan' => 'surat_permohonan',
            'file_ktp' => 'ktp',
            'file_akte' => 'akte',
            'file_npwp' => 'npwp',
            'file_nib' => 'nib',
        ];
        
        foreach ($fileFields as $field => $column) {
            if ($request->hasFile($field) && $request->file($field)->isValid()) {
                $file = $request->file($field);
                $filename = time() . '_' . $permohonan->id . '_' . $column . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('permohonan/' . $permohonan->id, $filename, 'public');
                $permohonan->$column = $path;
            }
        }
        
        $permohonan->save();
    }

    /**
     * Menampilkan form edit untuk draft
     */
    public function edit($id)
    {
        $permohonan = Permohonan::where('id', $id)
                        ->where('user_id', auth()->id())
                        ->where('status', 'draft')
                        ->firstOrFail();
        
        return view('permohonan.edit', compact('permohonan'));
    }

    /**
     * Mengupdate draft
     */
    public function update(Request $request, $id)
    {
        $permohonan = Permohonan::where('id', $id)
                        ->where('user_id', auth()->id())
                        ->where('status', 'draft')
                        ->firstOrFail();
        
        // Validasi sama seperti store
        $rules = [
            'nama_pemohon' => 'required|string|max:255',
            'status_pemohon' => 'required|in:UMKM,Pemerintah,Produsen',
            'perusahaan_instansi' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'nomor_surat_permohonan' => 'required|string|max:100',
            'tanggal_surat_permohonan' => 'required|date',
            'jenis_alsintan' => 'required|string|max:255',
            'status_alsintan' => 'required|in:prototipe,produk_massal,impor',
            'status_produksi' => 'required|in:produk_lokal,impor',
            'merek_model_tipe' => 'required|string|max:255',
            'tahun_pembuatan' => 'nullable|integer|min:1900|max:' . date('Y'),
            'jumlah_unit' => 'required|integer|min:1',
            'daya_maksimal' => 'nullable|string|max:100',
            'putaran_mesin' => 'nullable|string|max:100',
            'bahan_bakar' => 'nullable|string|max:100',
            'sistem_pendinginan' => 'nullable|string|max:100',
            'dimensi' => 'nullable|string|max:100',
            'berat' => 'nullable|string|max:50',
            'kapasitas_kerja' => 'nullable|string|max:100',
            'perlengkapan' => 'nullable|string|max:255',
            'file_surat_permohonan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'file_ktp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'file_akte' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'file_npwp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'file_nib' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];
        
        $request->validate($rules);
        
        // Update data (tanpa file)
        $permohonan->update($request->except(['_token', '_method', 'action', 'file_surat_permohonan', 'file_ktp', 'file_akte', 'file_npwp', 'file_nib']));
        
        // Upload files jika ada
        $this->uploadFiles($permohonan, $request);
        
        // Jika action submit, panggil method submitDraft
        if ($request->action === 'submit') {
            return $this->submitDraft($id);
        }
        
        return redirect()->route('permohonan.show', $permohonan->id)
                         ->with('success', 'Draft permohonan berhasil diperbarui.');
    }

    /**
     * Submit draft menjadi aktif
     */
    public function submitDraft($id)
    {
        $permohonan = Permohonan::where('id', $id)
                        ->where('user_id', auth()->id())
                        ->where('status', 'draft')
                        ->firstOrFail();
        
        // Cek kelengkapan data menggunakan method dari model
        if ($permohonan->isSubmittable()) {
            // Proses submit
            $permohonan->status = 'aktif';
            $permohonan->save();
            
            return redirect()->route('permohonan.show', $permohonan->id)
                             ->with('success', 'Permohonan berhasil disubmit! Menunggu proses validasi oleh admin.');
        } else {
            // Tampilkan field yang kurang
            $missing = $permohonan->getMissingFields();
            return redirect()->route('permohonan.edit', $permohonan->id)
                             ->with('error', 'Mohon lengkapi data berikut sebelum submit: ' . implode(', ', $missing));
        }
    }

    /**
     * Hapus permohonan beserta semua data terkait
     */
    public function destroy($id)
    {
        $user = auth()->user();
        $permohonan = Permohonan::findOrFail($id);

        // Cek akses
        if ($user->isPemohon()) {
            // Pemohon hanya bisa menghapus draft milik sendiri
            if ($permohonan->user_id !== $user->id) {
                abort(403, 'Anda tidak memiliki akses untuk menghapus permohonan ini.');
            }
            if (!$permohonan->isDraft()) {
                return redirect()->back()->with('error', 'Hanya permohonan dengan status draft yang dapat dihapus.');
            }
        } elseif ($user->isAdmin()) {
            // Admin hanya bisa menghapus permohonan aktif (bukan draft dan bukan selesai)
            if ($permohonan->isDraft()) {
                return redirect()->back()->with('error', 'Admin tidak dapat menghapus permohonan draft.');
            }
            if ($permohonan->isSelesai()) {
                return redirect()->back()->with('error', 'Admin tidak dapat menghapus permohonan yang sudah selesai.');
            }
        } else {
            abort(403, 'Anda tidak memiliki akses untuk menghapus permohonan ini.');
        }

        // Hapus file-file terkait
        $this->deletePermohonanFiles($permohonan);

        // Hapus data relasi
        if ($permohonan->validasi) {
            $this->deleteFiles($permohonan->validasi->file_kaji_ulang_multiple ?? []);
            $permohonan->validasi->delete();
        }

        if ($permohonan->pengujian) {
            $permohonan->pengujian->delete();
        }

        if ($permohonan->testReport) {
            $this->deleteFiles($permohonan->testReport->file_test_report_multiple ?? []);
            $permohonan->testReport->delete();
        }

        if ($permohonan->kuisioner) {
            $permohonan->kuisioner->delete();
        }

        // Hapus permohonan
        $permohonan->delete();

        // Redirect berdasarkan role
        if ($user->isAdmin()) {
            return redirect()->route('dashboard.admin')
                           ->with('success', 'Permohonan berhasil dihapus.');
        }

        return redirect()->route('dashboard.pemohon')
                       ->with('success', 'Permohonan draft berhasil dihapus.');
    }

    /**
     * Hapus file-file permohonan dari storage
     */
    private function deletePermohonanFiles($permohonan)
    {
        $fileFields = ['surat_permohonan', 'ktp', 'akte', 'npwp', 'nib'];
        
        foreach ($fileFields as $field) {
            if (!empty($permohonan->$field)) {
                Storage::disk('public')->delete($permohonan->$field);
            }
        }
    }

    /**
     * Hapus multiple files dari storage
     */
    private function deleteFiles($files)
    {
        if (empty($files)) return;
        
        foreach ($files as $file) {
            Storage::disk('public')->delete($file);
        }
    }
}