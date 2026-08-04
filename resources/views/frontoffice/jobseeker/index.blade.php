@extends('frontoffice.jobseeker.templates.body')
@section('home', 'active')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan profil dan lamaran Anda.')
@section('content')

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        @if(session('redirect_profile'))
            <br><a href="{{ session('redirect_profile') }}" class="alert-link">Lengkapi Profil Sekarang</a>
        @endif
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Welcome Banner --}}
<div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #2042e3 0%, #764ba2 100%);">
    <div class="card-body p-4 text-white">
        <div class="row align-items-center">
            <div class="col-12 col-md-8">
                <h3 class="mb-1 text-white">Selamat Datang, {{ $user->first_name }}!</h3>
                <p class="mb-0 opacity-75">Temukan peluang karir terbaik untukmu. Pastikan profilmu lengkap agar perusahaan lebih mudah menemukan kamu.</p>
            </div>
            <div class="col-12 col-md-4 text-md-end mt-3 mt-md-0">
                <a href="{{ route('jobseeker.profile') }}" class="btn btn-light btn-sm"><i class="lni lni-user me-1"></i> Lihat Profil</a>
                <a href="{{ route('jobseeker.jobs') }}" class="btn btn-outline-light btn-sm ms-1"><i class="lni lni-search me-1"></i> Cari Lowongan</a>
            </div>
        </div>
    </div>
</div>

{{-- Profile Completeness --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="mb-0"><i class="lni lni-user me-1"></i> Kelengkapan Profil</h6>
            <span class="fw-bold {{ $profilePercent >= 80 ? 'text-success' : ($profilePercent >= 50 ? 'text-warning' : 'text-danger') }}">{{ $profilePercent }}%</span>
        </div>
        <div class="progress" style="height: 10px;">
            <div class="progress-bar {{ $profilePercent >= 80 ? 'bg-success' : ($profilePercent >= 50 ? 'bg-warning' : 'bg-danger') }}"
                 role="progressbar" style="width: {{ $profilePercent }}%" aria-valuenow="{{ $profilePercent }}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <small class="text-muted d-block mt-2">{{ $profileScore }} dari {{ $profileTotal }} informasi telah dilengkapi.
            @if($profilePercent < 100)
                <a href="{{ route('jobseeker.profile.edit') }}">Lengkapi sekarang</a>
            @endif
        </small>

        @if(!$mandatoryComplete)
        <div class="alert alert-warning mt-3 mb-0 py-2 px-3 small">
            <strong>Wajib dilengkapi untuk melamar:</strong>
            <ul class="mb-0 mt-1">
                @foreach($profileItems as $item)
                    @if($item['required'] && !$item['filled'])
                        <li>{{ $item['label'] }} belum diisi</li>
                    @endif
                @endforeach
            </ul>
        </div>
        @endif

        @if($profileItems)
        <div class="mt-3">
            <small class="text-muted d-block mb-2">Detail kelengkapan:</small>
            <div class="d-flex flex-wrap gap-2">
                @foreach($profileItems as $item)
                <span class="badge {{ $item['filled'] ? 'bg-success' : ($item['required'] ? 'bg-danger' : 'bg-secondary') }} bg-opacity-75">
                    @if($item['filled'])
                        <i class="lni lni-checkmark me-1"></i>
                    @else
                        <i class="lni lni-close me-1"></i>
                    @endif
                    {{ $item['label'] }}
                    @if($item['required'] && !$item['filled'])
                        (wajib)
                    @endif
                </span>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Application Stats --}}
<div class="row mb-4">
    <div class="col-6 col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width:48px;height:48px;background:#e8edff;">
                    <i class="lni lni-briefcase" style="font-size:20px;color:#2042e3;"></i>
                </div>
                <h3 class="mb-0">{{ $stats['total'] }}</h3>
                <small class="text-muted">Total Lamaran</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width:48px;height:48px;background:#fff3cd;">
                    <i class="lni lni-timer" style="font-size:20px;color:#ffc107;"></i>
                </div>
                <h3 class="mb-0">{{ $stats['pending'] }}</h3>
                <small class="text-muted">Menunggu</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width:48px;height:48px;background:#d4edda;">
                    <i class="lni lni-checkmark-circle" style="font-size:20px;color:#28a745;"></i>
                </div>
                <h3 class="mb-0">{{ $stats['accepted'] }}</h3>
                <small class="text-muted">Diterima</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width:48px;height:48px;background:#f8d7da;">
                    <i class="lni lni-cross-circle" style="font-size:20px;color:#dc3545;"></i>
                </div>
                <h3 class="mb-0">{{ $stats['rejected'] }}</h3>
                <small class="text-muted">Ditolak</small>
            </div>
        </div>
    </div>
</div>

{{-- Latest Jobs --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0"><i class="lni lni-briefcase me-1"></i> Lowongan Terbaru</h5>
            <a href="{{ route('jobseeker.jobs') }}" class="btn btn-outline-primary btn-sm">Lihat Semua</a>
        </div>

        @if($latestJobs->isEmpty())
            <div class="alert alert-info mb-0">Belum ada lowongan tersedia saat ini.</div>
        @else
            <div class="row">
                @foreach($latestJobs as $job)
                <div class="col-12 col-md-6 mb-3">
                    <div class="card h-100 border" style="border-left: 4px solid #2042e3 !important;">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h6 class="mb-0">{{ $job->nama_pekerjaan }}</h6>
                                @if(in_array($job->id, $appliedJobIds))
                                    <span class="badge bg-info text-white">Dilamar</span>
                                @endif
                            </div>
                            <p class="text-muted small mb-2">{{ $job->employer->nama_perusahaan ?? '-' }}</p>
                            <ul class="list-unstyled small mb-0">
                                <li class="mb-1"><i class="lni lni-map-marker me-1"></i> {{ $job->alamat ?? '-' }}</li>
                                <li class="mb-1"><i class="lni lni-dollar me-1"></i> Rp.{{ number_format($job->ekspektasi_gaji, 0, ',', '.') }}</li>
                                <li><i class="lni lni-timer me-1"></i> {{ worktimeLabel($job->worktime) }}</li>
                            </ul>
                            @if(!in_array($job->id, $appliedJobIds))
                            <form action="{{ route('jobseeker.jobs.apply', $job->id) }}" method="POST" class="mt-2">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm w-100" onclick="return confirm('Apakah Anda yakin ingin melamar pekerjaan ini?')">
                                    <i class="lni lni-envelope me-1"></i> Lamar Sekarang
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@endsection
