<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TestReport;
use App\Models\Permohonan;
use Illuminate\Support\Facades\Storage;
use App\Mail\TestReportSelesaiMail;
use Illuminate\Support\Facades\Mail;

class TestReportController extends Controller
{
    /**
     * Menampilkan form test report untuk permohonan tertentu
     */
    public function create($permohonan_id)
    {
        $permohonan = Permohonan::findOrFail($permohonan_id);
        
        // Cek akses: hanya admin
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat mengakses halaman ini.');
        }
        
        // Cek apakah pengujian sudah selesai
        if (!$permohonan->pengujian_selesai) {
            return redirect()->route('dashboard.admin')
                           ->with('error', 'Harap lengkapi pengujian terlebih dahulu.');
        }
        
        // Cek apakah sudah ada test report yang disubmit
        if ($permohonan->testReport && $permohonan->testReport->is_submit) {
            return redirect()->route('testreport.show', $permohonan_id)
                           ->with('info', 'Test Report sudah disubmit dan tidak dapat diubah.');
        }
        
        return view('testreport.create', compact('permohonan'));
    }

    /**
     * Menyimpan file test report
     */
    public function store(Request $request, $permohonan_id)
    {
        // Cek akses: hanya admin
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat melakukan upload test report.');
        }
        
        $request->validate([
            'file_test_report' => 'required|array',
            'file_test_report.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $permohonan = Permohonan::findOrFail($permohonan_id);
        
        // Cek apakah sudah ada test report
        if ($permohonan->testReport && $permohonan->testReport->is_submit) {
            return redirect()->route('testreport.show', $permohonan_id)
                           ->with('error', 'Test Report sudah disubmit dan tidak dapat diubah.');
        }

        // Simpan multiple file
        $paths = [];
        if ($request->hasFile('file_test_report')) {
            foreach ($request->file('file_test_report') as $file) {
                if ($file->isValid()) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('testreport/' . $permohonan_id, $filename, 'public');
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

        // Buat atau update test report
        TestReport::updateOrCreate(
            ['permohonan_id' => $permohonan_id],
            [
                'file_test_report_multiple' => $paths,
                'is_submit' => true,
            ]
        );

        // Update status permohonan
        $permohonan->test_report_selesai = true;

        // KIRIM EMAIL KE PEMOHON
        $this->sendEmailToPemohon($permohonan);

        $permohonan->save();

        return redirect()->route('dashboard.admin')
                       ->with('success', 'Test Report berhasil disimpan dan dikirim ke pemohon.');
    }

    /**
     * Menampilkan detail test report
     */
    public function show($permohonan_id)
    {
        $permohonan = Permohonan::with(['testReport', 'kuisioner'])->findOrFail($permohonan_id);
        
        // Cek akses: admin atau pemilik permohonan
        if (auth()->user()->role !== 'admin' && $permohonan->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        $testReport = $permohonan->testReport;
        
        return view('testreport.show', compact('permohonan', 'testReport'));
    }

    /**
     * Kirim notifikasi email ke pemohon
     */
    private function sendEmailToPemohon($permohonan)
    {
        try {
            $pemohon = $permohonan->user;
            if ($pemohon && $pemohon->email) {
                Mail::to($pemohon->email)->send(new TestReportSelesaiMail($permohonan));
            }
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email notifikasi test report: ' . $e->getMessage());
        }
    }
}