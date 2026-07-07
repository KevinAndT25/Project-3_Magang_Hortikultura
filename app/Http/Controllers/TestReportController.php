<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TestReport;
use App\Models\Permohonan;

class TestReportController extends Controller
{
    public function create($permohonan_id)
    {
        $permohonan = Permohonan::findOrFail($permohonan_id);
        if ($permohonan->testReport && $permohonan->testReport->is_submit) {
            return redirect()->route('testreport.show', $permohonan_id);
        }
        return view('testreport.create', compact('permohonan'));
    }

    public function store(Request $request, $permohonan_id)
    {
        $request->validate([
            'file_test_report' => 'required|array',
            'file_test_report.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg|max:2048',
        ]);

        $permohonan = Permohonan::findOrFail($permohonan_id);

        $paths = [];
        if ($request->hasFile('file_test_report')) {
            foreach ($request->file('file_test_report') as $file) {
                $paths[] = $file->store('testreport', 'public');
            }
        }

        TestReport::create([
            'permohonan_id' => $permohonan_id,
            'file_test_report_multiple' => $paths,
            'is_submit' => true,
        ]);

        $permohonan->test_report_selesai = true;
        $permohonan->save();

        return redirect()->route('dashboard.admin')->with('success', 'Test Report berhasil disubmit.');
    }

    public function show($permohonan_id)
    {
        $permohonan = Permohonan::findOrFail($permohonan_id);
        $testReport = $permohonan->testReport;
        return view('testreport.show', compact('permohonan', 'testReport'));
    }
}