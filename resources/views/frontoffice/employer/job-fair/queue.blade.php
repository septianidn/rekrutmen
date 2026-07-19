@extends('frontoffice.employer.index')
@section('jobfair', 'active')
@section('page-title', 'Antrian Booth')
@section('page-subtitle', 'Kelola antrian jobseeker di booth Anda.')
@section('content')

<div class="mb-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
    <a href="{{ route('employer.job-fair.show', $jobFair) }}" class="btn btn-outline-secondary btn-sm">&larr; Kembali</a>
    <div>
        <strong>{{ $jobFair->nama }}</strong>
        <span class="text-muted ms-2">{{ $jobFair->tanggal_mulai->format('d M Y') }}</span>
        <a href="{{ route('employer.job-fair.scan.form', $jobFair) }}" class="btn btn-primary btn-sm ms-3">
            <i class="lni lni-scan"></i> Scan QR Jobseeker
        </a>
        <button class="btn btn-outline-secondary btn-sm ms-1" onclick="location.reload()">
            <i class="lni lni-reload"></i> Refresh
        </button>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@php
    $menunggu       = $scans['menunggu']       ?? collect();
    $dipanggil      = $scans['dipanggil']      ?? collect();
    $sedang         = $scans['sedang_diproses'] ?? collect();
    $selesai        = $scans['selesai']        ?? collect();
    $tidakHadir     = $scans['tidak_hadir']    ?? collect();
@endphp

{{-- Dipanggil --}}
@if($dipanggil->isNotEmpty())
<div class="job-items mb-3">
    <h5 class="mb-3 text-warning"><i class="lni lni-bullhorn"></i> Dipanggil ({{ $dipanggil->count() }})</h5>
    @foreach($dipanggil as $scan)
    <div class="border border-warning rounded p-3 mb-2 d-flex flex-wrap justify-content-between align-items-start gap-2">
        <div>
            <strong>{{ $scan->jobseeker->first_name }} {{ $scan->jobseeker->last_name }}</strong>
            <span class="text-muted ms-2 small">{{ $scan->job->nama_pekerjaan }}</span><br>
            <small class="text-muted">Dipanggil {{ $scan->dipanggil_at->diffForHumans() }}</small>
            @php $cooldownEnd = $scan->cooldownEndsAt(); @endphp
            @if(!$scan->canMarkAbsent())
                <small class="text-muted ms-2">— Tidak hadir bisa diklik {{ $cooldownEnd->diffForHumans() }}</small>
            @endif
        </div>
        <div class="d-flex gap-2">
            <form action="{{ route('employer.job-fair.queue.absent', $scan) }}" method="POST">
                @csrf
                <button type="submit"
                        class="btn btn-sm btn-outline-danger {{ !$scan->canMarkAbsent() ? 'disabled' : '' }}"
                        {{ !$scan->canMarkAbsent() ? 'disabled' : '' }}
                        onclick="return confirm('Tandai tidak hadir?')">
                    Tidak Hadir
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- Sedang Diproses --}}
@if($sedang->isNotEmpty())
<div class="job-items mb-3">
    <h5 class="mb-3 text-primary"><i class="lni lni-users"></i> Sedang Diproses ({{ $sedang->count() }})</h5>
    @foreach($sedang as $scan)
    <div class="border border-primary rounded p-3 mb-2">
        <strong>{{ $scan->jobseeker->first_name }} {{ $scan->jobseeker->last_name }}</strong>
        <span class="text-muted ms-2 small">{{ $scan->job->nama_pekerjaan }}</span>
        <small class="text-muted ms-2">Sedang dalam sesi</small>
    </div>
    @endforeach
</div>
@endif

{{-- Menunggu --}}
<div class="job-items mb-3">
    <h5 class="mb-3"><i class="lni lni-timer"></i> Menunggu ({{ $menunggu->count() }})</h5>
    @if($menunggu->isEmpty())
        <p class="text-muted small">Tidak ada jobseeker dalam antrian.</p>
    @else
        @foreach($menunggu as $scan)
        <div class="border rounded p-3 mb-2 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <strong>{{ $scan->jobseeker->first_name }} {{ $scan->jobseeker->last_name }}</strong>
                <span class="text-muted ms-2 small">{{ $scan->job->nama_pekerjaan }}</span><br>
                <small class="text-muted">Masuk antrian {{ $scan->created_at->diffForHumans() }}</small>
            </div>
            <form action="{{ route('employer.job-fair.queue.call', $scan) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm btn-success">Panggil</button>
            </form>
        </div>
        @endforeach
    @endif
</div>

{{-- Tidak Hadir --}}
@if($tidakHadir->isNotEmpty())
<div class="job-items mb-3">
    <h5 class="mb-3 text-danger"><i class="lni lni-close"></i> Tidak Hadir ({{ $tidakHadir->count() }})</h5>
    @foreach($tidakHadir as $scan)
    <div class="border border-danger rounded p-3 mb-2 d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
            <strong>{{ $scan->jobseeker->first_name }} {{ $scan->jobseeker->last_name }}</strong>
            <span class="text-muted ms-2 small">{{ $scan->job->nama_pekerjaan }}</span><br>
            <small class="text-muted">Ditandai {{ $scan->tidak_hadir_at->diffForHumans() }}</small>
        </div>
        <form action="{{ route('employer.job-fair.queue.reactivate', $scan) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-secondary">Aktifkan Kembali</button>
        </form>
    </div>
    @endforeach
</div>
@endif

{{-- Selesai --}}
@if($selesai->isNotEmpty())
<div class="job-items mb-3">
    <h5 class="mb-3 text-success"><i class="lni lni-checkmark-circle"></i> Selesai ({{ $selesai->count() }})</h5>
    @foreach($selesai as $scan)
    @php $applicationId = $applicationMap[$scan->jobseeker_id . '-' . $scan->job_id] ?? null; @endphp
    <div class="border border-success rounded p-3 mb-2 d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
            <strong>{{ $scan->jobseeker->first_name }} {{ $scan->jobseeker->last_name }}</strong>
            <span class="text-muted ms-2 small">{{ $scan->job->nama_pekerjaan }}</span>
            <small class="text-muted ms-2">Selesai {{ $scan->selesai_at->diffForHumans() }}</small>
        </div>
        @if($applicationId)
            <a href="{{ route('employer.application.progress', $applicationId) }}" class="btn btn-sm btn-outline-success">
                <i class="lni lni-files"></i> Lihat Lamaran
            </a>
        @endif
    </div>
    @endforeach
</div>
@endif

@endsection
