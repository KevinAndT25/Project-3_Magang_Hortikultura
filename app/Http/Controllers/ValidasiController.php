<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Validasi;
use App\Models\Permohonan;

class ValidasiController extends Controller
{
    public function create($permohonan_id)
    {
        $permohonan = Permohonan::findOrFail($permohonan_id);
        if ($permohonan->validasi && $permohonan->validasi->is_submit) {
            return redirect()->route('validasi.show', $permohonan_id);
        }
        return view('validasi.create', compact('permohonan'));
    }

    public function store(Request $request, $permohonan_id)
    {
        $request->validate([
            'file_kaji_ulang' => 'required|array',
            'file_kaji_ulang.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg|max:2048',
        ]);

        $permohonan = Permohonan::findOrFail($permohonan_id);
        
        // Simpan multiple file
        $paths = [];
        if ($request->hasFile('file_kaji_ulang')) {
            foreach ($request->file('file_kaji_ulang') as $file) {
                $paths[] = $file->store('validasi', 'public');
            }
        }

        Validasi::create([
            'permohonan_id' => $permohonan_id,
            'file_kaji_ulang_multiple' => $paths,
            'is_submit' => true,
        ]);

        // Update status permohonan
        $permohonan->validasi_selesai = true;
        $permohonan->save();

        return redirect()->route('dashboard.admin')->with('success', 'Validasi berhasil disubmit.');
    }

    public function show($permohonan_id)
    {
        $permohonan = Permohonan::findOrFail($permohonan_id);
        $validasi = $permohonan->validasi;
        return view('validasi.show', compact('permohonan', 'validasi'));
    }
}