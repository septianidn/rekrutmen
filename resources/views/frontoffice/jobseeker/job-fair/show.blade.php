@extends('frontoffice.jobseeker.templates.body')
@section('jobfair', 'active')
@section('page-title', 'Detail Job Fair')
@section('page-subtitle', 'Informasi event job fair.')
@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="resume mb-3">
    <div class="inner-content">
        <div class="d-flex align-items-start justify-content-between flex-wrap gap-2 mb-2">
            <a href="{{ route('jobseeker.job-fair.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Kembali</a>
            <div class="d-flex gap-2">
                @if($attendance)
                    <a href="{{ route('jobseeker.job-fair.qr', $jobFair) }}" class="btn btn-outline-primary btn-sm">
                        <i class="lni lni-qr-code"></i> Lihat QR Saya
                    </a>
                @else
                    <form action="{{ route('jobseeker.job-fair.register', $jobFair) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm"
                                onclick="return confirm('Daftar ke job fair ini?')">
                            Daftar ke Job Fair
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <h4 class="mb-1">{{ $jobFair->nama }}</h4>
        <p class="text-muted">
            <i class="lni lni-map-marker"></i> {{ $jobFair->lokasi }} &middot;
            {{ $jobFair->tanggal_mulai->format('d M Y') }} - {{ $jobFair->tanggal_selesai->format('d M Y') }}
        </p>
        @if($jobFair->deskripsi)
            <p class="mb-0">{{ $jobFair->deskripsi }}</p>
        @endif

        @if($attendance)
            <div class="mt-3 p-2 bg-light rounded small">
                <i class="lni lni-checkmark-circle text-success"></i>
                Anda sudah terdaftar.
                @if($attendance->isCheckedIn())
                    <strong class="text-success ms-1">Check-in: {{ $attendance->checked_in_at->format('d M Y H:i') }}</strong>
                @else
                    <span class="text-warning ms-1">Belum check-in di pintu masuk.</span>
                @endif
            </div>
        @endif
    </div>
</div>

<h5 class="mb-3">Lowongan di Job Fair ini ({{ $jobs->count() }})</h5>

@forelse($jobs as $job)
<div class="resume mb-3">
    <div class="inner-content">
        <div class="d-flex align-items-start flex-wrap gap-2">
            <div class="flex-grow-1">
                <h5 class="mb-1">{{ $job->nama_pekerjaan }}</h5>
                <p class="text-muted mb-1"><strong>{{ $job->employer->nama_perusahaan ?? '-' }}</strong></p>
                @if($job->pivot->lokasi_booth)
                    <p class="mb-1 small">
                        <i class="lni lni-map-marker text-primary"></i>
                        <strong>Booth:</strong> {{ $job->pivot->lokasi_booth }}
                    </p>
                @endif
                <ul class="list-inline mb-0 small text-muted">
                    <li class="list-inline-item"><i class="lni lni-map-marker"></i> {{ $job->alamat }}</li>
                    <li class="list-inline-item"><i class="lni lni-dollar"></i> Rp.{{ number_format($job->ekspektasi_gaji, 0, ',', '.') }}</li>
                    <li class="list-inline-item"><i class="lni lni-briefcase"></i> {{ $job->worktime }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@empty
<div class="alert alert-info">Belum ada lowongan yang disetujui untuk job fair ini.</div>
@endforelse

@endsection
