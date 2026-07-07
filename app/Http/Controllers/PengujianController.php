<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengujian;
use App\Models\Permohonan;

class PengujianController extends Controller
{
    public function create($permohonan_id)
    {
        $permohonan = Permohonan::findOrFail($permohonan_id);
        if ($permohonan->pengujian && $permohonan->pengujian->is_submit) {
            return redirect()->route('pengujian.show', $permohonan_id);
        }
        return view('pengujian.create', compact('permohonan'));
    }

    public function store(Request $request, $permohonan_id)
    {
        $request->validate([
            'tanggal_pengujian' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $permohonan = Permohonan::findOrFail($permohonan_id);

        Pengujian::create([
            'permohonan_id' => $permohonan_id,
            'nomor_permohonan_uji' => $permohonan->nomor_permohonan,
            'tanggal_pengujian' => $request->tanggal_pengujian,
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'is_submit' => true,
        ]);

        $permohonan->pengujian_selesai = true;
        $permohonan->save();

        return redirect()->route('dashboard.admin')->with('success', 'Data pengujian berhasil disubmit.');
    }

    public function show($permohonan_id)
    {
        $permohonan = Permohonan::findOrFail($permohonan_id);
        $pengujian = $permohonan->pengujian;
        return view('pengujian.show', compact('permohonan', 'pengujian'));
    }
}