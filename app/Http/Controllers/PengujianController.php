<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengujian;
use App\Models\Permohonan;

class PengujianController extends Controller
{
    public function show($permohonan_id)
    {
        $permohonan = Permohonan::findOrFail($permohonan_id);
        $pengujian = Pengujian::where('permohonan_id', $permohonan_id)->first();
        return view('admin.pengujian', compact('permohonan', 'pengujian'));
    }

    public function store(Request $request, $permohonan_id)
    {
        $request->validate([
            'tanggal_pengujian' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $permohonan = Permohonan::findOrFail($permohonan_id);
        $pengujian = Pengujian::where('permohonan_id', $permohonan_id)->first();
        if ($pengujian && $pengujian->is_submit) {
            return back()->with('error', 'Pengujian sudah disubmit, tidak bisa diubah.');
        }

        $data = $request->all();
        $data['nomor_permohonan_uji'] = $permohonan->nomor_permohonan;
        $data['permohonan_id'] = $permohonan_id;
        $data['is_submit'] = true;

        if ($pengujian) {
            $pengujian->update($data);
        } else {
            Pengujian::create($data);
        }

        $permohonan->pengujian_selesai = true;
        $permohonan->save();

        return redirect()->route('admin.dashboard')->with('success', 'Pengujian berhasil disubmit.');
    }
}