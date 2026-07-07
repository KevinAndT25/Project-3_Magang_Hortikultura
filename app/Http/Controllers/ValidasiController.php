<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Validasi;
use App\Models\Permohonan;
use Illuminate\Support\Facades\Storage;

class ValidasiController extends Controller
{
    // Tampilkan form validasi (atau view jika sudah disubmit)
    public function show($permohonan_id)
    {
        $permohonan = Permohonan::findOrFail($permohonan_id);
        $validasi = Validasi::where('permohonan_id', $permohonan_id)->first();
        return view('admin.validasi', compact('permohonan', 'validasi'));
    }

    // Simpan atau update validasi (hanya bisa sekali submit)
    public function store(Request $request, $permohonan_id)
    {
        $request->validate([
            'file_kaji_ulang' => 'required|array', // multiple files
            'file_kaji_ulang.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
        ]);

        $permohonan = Permohonan::findOrFail($permohonan_id);
        // Cek apakah sudah disubmit
        $validasi = Validasi::where('permohonan_id', $permohonan_id)->first();
        if ($validasi && $validasi->is_submit) {
            return back()->with('error', 'Validasi sudah pernah disubmit, tidak bisa diubah.');
        }

        $filePaths = [];
        if ($request->hasFile('file_kaji_ulang')) {
            foreach ($request->file('file_kaji_ulang') as $file) {
                $path = $file->store('validasi/' . $permohonan_id, 'public');
                $filePaths[] = $path;
            }
        }

        if ($validasi) {
            // Update
            $validasi->update([
                'file_kaji_ulang_multiple' => $filePaths,
                'is_submit' => true,
            ]);
        } else {
            Validasi::create([
                'permohonan_id' => $permohonan_id,
                'file_kaji_ulang_multiple' => $filePaths,
                'is_submit' => true,
            ]);
        }

        // Tandai validasi selesai di permohonan
        $permohonan->validasi_selesai = true;
        $permohonan->save();

        return redirect()->route('admin.dashboard')->with('success', 'Validasi berhasil disubmit.');
    }

    // Download file validasi (untuk pemohon atau admin)
    public function download($permohonan_id, $fileIndex = 0)
    {
        $validasi = Validasi::where('permohonan_id', $permohonan_id)->firstOrFail();
        $files = $validasi->file_kaji_ulang_multiple;
        if (!isset($files[$fileIndex])) {
            abort(404);
        }
        $filePath = $files[$fileIndex];
        if (!Storage::disk('public')->exists($filePath)) {
            abort(404);
        }
        return Storage::disk('public')->download($filePath);
    }
}