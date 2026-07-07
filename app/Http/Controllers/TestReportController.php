<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TestReport;
use App\Models\Permohonan;
use Illuminate\Support\Facades\Storage;

class TestReportController extends Controller
{
    public function show($permohonan_id)
    {
        $permohonan = Permohonan::findOrFail($permohonan_id);
        $testReport = TestReport::where('permohonan_id', $permohonan_id)->first();
        return view('admin.test_report', compact('permohonan', 'testReport'));
    }

    public function store(Request $request, $permohonan_id)
    {
        $request->validate([
            'file_test_report' => 'required|array',
            'file_test_report.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
        ]);

        $permohonan = Permohonan::findOrFail($permohonan_id);
        $testReport = TestReport::where('permohonan_id', $permohonan_id)->first();
        if ($testReport && $testReport->is_submit) {
            return back()->with('error', 'Test Report sudah disubmit, tidak bisa diubah.');
        }

        $filePaths = [];
        if ($request->hasFile('file_test_report')) {
            foreach ($request->file('file_test_report') as $file) {
                $path = $file->store('testreport/' . $permohonan_id, 'public');
                $filePaths[] = $path;
            }
        }

        if ($testReport) {
            $testReport->update([
                'file_test_report_multiple' => $filePaths,
                'is_submit' => true,
            ]);
        } else {
            TestReport::create([
                'permohonan_id' => $permohonan_id,
                'file_test_report_multiple' => $filePaths,
                'is_submit' => true,
            ]);
        }

        $permohonan->test_report_selesai = true;
        $permohonan->save();

        return redirect()->route('admin.dashboard')->with('success', 'Test Report berhasil disubmit.');
    }

    // Download untuk pemohon (hanya jika kuisioner sudah diisi)
    public function download($permohonan_id, $fileIndex = 0)
    {
        $testReport = TestReport::where('permohonan_id', $permohonan_id)->firstOrFail();
        $permohonan = Permohonan::findOrFail($permohonan_id);
        // Cek jika pemohon, harus sudah mengisi kuisioner (kuisioner_selesai = true)
        if (auth()->user()->role == 'pemohon' && !$permohonan->kuisioner_selesai) {
            abort(403, 'Anda harus mengisi kuisioner terlebih dahulu untuk mendownload test report.');
        }
        $files = $testReport->file_test_report_multiple;
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