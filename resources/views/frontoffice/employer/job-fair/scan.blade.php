@extends('frontoffice.employer.index')
@section('jobfair', 'active')
@section('page-title', 'Scan QR Jobseeker')
@section('page-subtitle', 'Konfirmasi kehadiran jobseeker di booth.')
@section('content')

<div class="mb-3">
    <a href="{{ route('employer.job-fair.queue', $jobFair) }}" class="btn btn-outline-secondary btn-sm">&larr; Kembali ke Antrian</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="job-items">
    <h5 class="mb-1">{{ $jobFair->nama }}</h5>
    <p class="text-muted small mb-3">Masukkan kode QR jobseeker untuk menyelesaikan interaksi dan mencatat lamaran.</p>

    <form action="{{ route('employer.job-fair.scan', $jobFair) }}" method="POST" class="row g-3">
        @csrf
        <div class="col-12 col-md-6">
            <label class="form-label">Kode QR Jobseeker</label>
            <input type="text" name="kode_qr" class="form-control"
                   placeholder="ATT-XXXXX" autofocus autocomplete="off"
                   value="{{ old('kode_qr') }}">
            <div class="form-text">Minta jobseeker menunjukkan kode di bawah QR mereka.</div>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Konfirmasi Kehadiran</button>
        </div>
    </form>
</div>

@endsection
