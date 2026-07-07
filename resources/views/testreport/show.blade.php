@extends('layouts.app')

@section('title', 'Detail Test Report')

@section('content')
<div class="row">
    <div class="col-12">
        <h3>Detail Test Report</h3>
        <p><strong>Nomor Permohonan:</strong> {{ $permohonan->nomor_permohonan }}</p>
        <hr>
        <div class="card">
            <div class="card-body">
                <h5>File Test Report</h5>
                @if($testReport && $testReport->file_test_report_multiple)
                    @foreach($testReport->file_test_report_multiple as $file)
                        <div>
                            <a href="{{ asset('storage/' . $file) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-file-earmark-text"></i> Download File
                            </a>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">Belum ada file test report.</p>
                @endif
            </div>
        </div>
        <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</div>
@endsection