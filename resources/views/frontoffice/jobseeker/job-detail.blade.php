@extends('frontoffice.jobseeker.templates.body')
@section('jobs', 'active')
@section('page-title', 'Detail Lowongan')
@section('page-subtitle', 'Informasi lengkap lowongan pekerjaan.')
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
        @if(session('redirect_profile'))
            <br><a href="{{ session('redirect_profile') }}" class="alert-link">Lengkapi Profil Sekarang</a>
        @endif
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="resume">
    <div class="inner-content">
        <a href="{{ route('jobseeker.jobs') }}" class="btn btn-outline-secondary btn-sm mb-3">
            <i class="lni lni-arrow-left me-1"></i> Kembali ke Daftar Lowongan
        </a>

        {{-- Header lowongan --}}
        <div class="card border mb-3">
            <div class="card-body p-3">
                <div class="d-flex align-items-start gap-3">
                    <div class="flex-shrink-0">
                        @if($job->employer && $job->employer->logo_url)
                            <img src="{{ $job->employer->logo_url }}" alt="Logo"
                                style="width:64px;height:64px;object-fit:contain;border:1px solid #dee2e6;border-radius:8px;padding:3px;">
                        @else
                            <div style="width:64px;height:64px;border:1px solid #dee2e6;border-radius:8px;display:flex;align-items:center;justify-content:center;background:#f8f9fa;">
                                <i class="lni lni-apartment text-muted" style="font-size:1.6rem;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <h4 class="mb-0">{{ $job->nama_pekerjaan }}</h4>
                            <div class="flex-shrink-0 ms-2">
                                <span class="badge bg-light text-dark border">{{ worktimeLabel($job->worktime) }}</span>
                                @if($job->isOpen())
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Ditutup</span>
                                @endif
                                @if($applied)
                                    <span class="badge bg-info text-white">Sudah Dilamar</span>
                                @endif
                            </div>
                        </div>
                        <p class="text-muted mb-2"><strong>{{ $job->employer->nama_perusahaan ?? '-' }}</strong></p>
                        <ul class="list-inline mb-0 small text-muted">
                            @if($job->posisi && !is_object($job->posisi))
                                <li class="list-inline-item me-3"><i class="lni lni-briefcase me-1"></i>{{ $job->posisi }}</li>
                            @endif
                            <li class="list-inline-item me-3"><i class="lni lni-map-marker me-1"></i>{{ $job->alamat }}</li>
                            <li class="list-inline-item me-3"><i class="lni lni-dollar me-1"></i>Rp.{{ number_format($job->ekspektasi_gaji, 0, ',', '.') }}</li>
                            @if($job->application_deadline)
                                <li class="list-inline-item"><i class="lni lni-calendar me-1"></i>Batas lamaran: {{ \Carbon\Carbon::parse($job->application_deadline)->translatedFormat('d F Y') }}</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Deskripsi pekerjaan --}}
        <div class="card border mb-3">
            <div class="card-body p-3">
                <h5 class="mb-3"><i class="lni lni-clipboard me-1"></i> Deskripsi Pekerjaan</h5>
                <div class="small">{!! $job->deskripsi_pekerjaan ?: '<span class="text-muted">Tidak ada deskripsi.</span>' !!}</div>
            </div>
        </div>

        {{-- Persyaratan --}}
        <div class="card border mb-3">
            <div class="card-body p-3">
                <h5 class="mb-3"><i class="lni lni-checkmark-circle me-1"></i> Persyaratan</h5>
                <div class="small">{!! $job->requirement ?: '<span class="text-muted">Tidak ada persyaratan khusus.</span>' !!}</div>
            </div>
        </div>

        {{-- Tahapan seleksi --}}
        <div class="card border mb-3">
            <div class="card-body p-3">
                <h5 class="mb-3"><i class="lni lni-list me-1"></i> Tahapan Seleksi</h5>
                @forelse($job->steps as $step)
                    <div class="d-flex align-items-start gap-2 mb-2">
                        <span class="badge rounded-pill bg-success flex-shrink-0">{{ $step->urutan }}</span>
                        <div>
                            <strong class="small">{{ $step->label ?? '-' }}</strong>
                            @if($step->deskripsi)
                                <div class="small text-muted">{{ $step->deskripsi }}</div>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="small text-muted mb-0">Tahapan seleksi belum ditentukan.</p>
                @endforelse
            </div>
        </div>

        {{-- Aksi --}}
        @if($applied)
            <div class="alert alert-info mb-0"><i class="lni lni-checkmark-circle me-1"></i> Anda sudah melamar lowongan ini. Pantau perkembangannya pada halaman <a href="{{ route('jobseeker.my-applications') }}" class="alert-link">Lamaran Saya</a>.</div>
        @elseif(!$job->isOpen())
            <div class="alert alert-secondary mb-0">Lowongan ini sudah ditutup dan tidak menerima lamaran baru.</div>
        @else
            <form action="{{ route('jobseeker.jobs.apply', $job->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah Anda yakin ingin melamar pekerjaan ini?')">
                    <i class="lni lni-envelope me-1"></i> Lamar Sekarang
                </button>
            </form>
        @endif
    </div>
</div>

@endsection
