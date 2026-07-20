<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    /**
     * Download atau view file dari storage
     */
    public function show($path)
    {
        // Cek apakah file ada
        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        // Cek akses: hanya user yang login
        if (!Auth::check()) {
            abort(403, 'Anda harus login untuk mengakses file ini.');
        }

        // Ambil file dari storage
        $file = Storage::disk('public')->get($path);
        $mimeType = Storage::disk('public')->mimeType($path);
        $filename = basename($path);

        // Tentukan apakah file akan di-download atau ditampilkan
        $isPdf = str_ends_with($path, '.pdf');
        $isImage = str_ends_with($path, '.jpg') || str_ends_with($path, '.jpeg') || str_ends_with($path, '.png');

        if ($isPdf) {
            // Untuk PDF, tampilkan di browser
            return response($file, 200)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'inline; filename="' . $filename . '"');
        } elseif ($isImage) {
            // Untuk gambar, tampilkan di browser
            return response($file, 200)
                ->header('Content-Type', $mimeType);
        } else {
            // Untuk file lain, force download
            return response($file, 200)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
        }
    }
}