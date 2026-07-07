@extends('layouts.app')

@section('title', 'Test Report')

@section('content')
<div class="row">
    <div class="col-12">
        <h3>Form Test Report</h3>
        <p><strong>Permohonan:</strong> {{ $permohonan->nomor_permohonan ?? 'Belum ada nomor' }} - {{ $permohonan->nama_pemohon }}</p>
        <hr>
        <form method="POST" action="{{ route('testreport.store', $permohonan->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="file_test_report" class="form-label">Upload File Test Report (PDF, JPG, JPEG, DOC, boleh lebih dari satu)</label>
                        <input type="file" class="form-control" id="file_test_report" name="file_test_report[]" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg" required>
                        <small class="text-muted">Anda dapat memilih beberapa file sekaligus.</small>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit Test Report</button>
            <a href="{{ route('dashboard.admin') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection