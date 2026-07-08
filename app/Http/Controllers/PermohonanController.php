<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;

class PermohonanController extends Controller
{
    /**
     * Menampilkan daftar permohonan berdasarkan role
     */
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            // Admin melihat semua permohonan
            $permohonans = Permohonan::with('user')->orderBy('created_at', 'desc')->get();
        } else {
            // Pemohon hanya melihat permohonan milik sendiri
            $permohonans = $user->permohonans()->orderBy('created_at', 'desc')->get();
        }
        
        return view('permohonan.index', compact('permohonans'));
    }

    public function show($id)
    {
        $permohonan = Permohonan::with('user')->findOrFail($id);
        
        // Cek akses: admin bisa lihat semua, pemohon hanya milik sendiri
        if (auth()->user()->isPemohon() && $permohonan->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke permohonan ini.');
        }
        
        return view('permohonan.show', compact('permohonan'));
    }

    public function create()
    {
        return view('permohonan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_permohonan' => 'required|unique:permohonans',
            'tanggal_permohonan' => 'required|date',
            'nama_pemohon' => 'required',
            'jenis_pemohon' => 'required',
            'jenis_alsintan' => 'required',
            'merk_model_tipe' => 'required',
        ]);

        $permohonan = new Permohonan();
        $permohonan->user_id = auth()->id();
        $permohonan->no_permohonan = $request->no_permohonan;
        $permohonan->tanggal_permohonan = $request->tanggal_permohonan;
        $permohonan->nama_pemohon = $request->nama_pemohon;
        $permohonan->jenis_pemohon = $request->jenis_pemohon;
        $permohonan->jenis_alsintan = $request->jenis_alsintan;
        $permohonan->merk_model_tipe = $request->merk_model_tipe;
        $permohonan->save();

        return redirect()->route('permohonan.show', $permohonan->id)
                         ->with('success', 'Permohonan berhasil dibuat!');
    }
}