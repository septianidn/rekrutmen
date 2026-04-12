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

<div class="resume mb-3">
    <div class="inner-content">
        <div class="mb-3">
            <a href="{{ route('jobseeker.job-fair.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Kembali</a>
        </div>

        <h4 class="mb-1">{{ $jobFair->nama }}</h4>
        <p class="text-muted">
            <i class="lni lni-map-marker"></i> {{ $jobFair->lokasi }} &middot;
            {{ $jobFair->tanggal_mulai->format('d M Y') }} - {{ $jobFair->tanggal_selesai->format('d M Y') }}
        </p>
        @if($jobFair->deskripsi)
            <p>{{ $jobFair->deskripsi }}</p>
        @endif
    </div>
</div>

<h5 class="mb-3">Lowongan di Job Fair ini ({{ $jobs->count() }})</h5>

@forelse($jobs as $job)
<div class="resume mb-3">
    <div class="inner-content">
        <div class="d-flex align-items-start">
            <div class="flex-grow-1">
                <h5 class="mb-1">{{ $job->nama_pekerjaan }}</h5>
                <p class="text-muted mb-2"><strong>{{ $job->employer->nama_perusahaan ?? '-' }}</strong></p>
                <ul class="list-inline mb-0 small text-muted">
                    <li class="list-inline-item"><i class="lni lni-map-marker"></i> {{ $job->alamat }}</li>
                    <li class="list-inline-item"><i class="lni lni-dollar"></i> Rp.{{ number_format($job->ekspektasi_gaji, 0, ',', '.') }}</li>
                    <li class="list-inline-item"><i class="lni lni-briefcase"></i> {{ $job->worktime }}</li>
                </ul>
            </div>
            <div class="flex-shrink-0 ms-3 text-end">
                @if(in_array($job->id, $appliedJobIds))
                    <span class="badge bg-info text-white px-3 py-2">Sudah Dilamar</span>
                @else
                    <form action="{{ route('jobseeker.jobs.apply', $job->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Lamar pekerjaan ini?')">Apply</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@empty
<div class="alert alert-info">Belum ada lowongan yang disetujui untuk job fair ini.</div>
@endforelse

@endsection
