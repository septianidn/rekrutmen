@extends('frontoffice.employer.index')
@section('home', 'active')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan aktivitas perusahaan Anda.')
@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Welcome Banner --}}
<div class="job-items mb-3" style="background: linear-gradient(135deg, #2042e3 0%, #764ba2 100%); color: #fff;">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h3 class="mb-1 text-white">Selamat Datang, {{ $employer->nama_perusahaan }}!</h3>
            <p class="mb-0" style="opacity: .8;">Kelola lowongan, pantau pelamar, dan ikuti job fair dari sini.</p>
        </div>
        <div class="mt-2 mt-md-0">
            <a href="{{ route('employer.job.create') }}" class="btn btn-light btn-sm"><i class="lni lni-plus me-1"></i> Buat Lowongan</a>
            <a href="{{ route('employer.profile') }}" class="btn btn-outline-light btn-sm ms-1"><i class="lni lni-user me-1"></i> Profil</a>
        </div>
    </div>
</div>

{{-- Profile Completeness --}}
@if($profilePercent < 100)
<div class="job-items mb-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="mb-0"><i class="lni lni-user me-1"></i> Kelengkapan Profil Perusahaan</h6>
        <span class="fw-bold {{ $profilePercent >= 80 ? 'text-success' : ($profilePercent >= 50 ? 'text-warning' : 'text-danger') }}">{{ $profilePercent }}%</span>
    </div>
    <div class="progress mb-2" style="height: 10px;">
        <div class="progress-bar {{ $profilePercent >= 80 ? 'bg-success' : ($profilePercent >= 50 ? 'bg-warning' : 'bg-danger') }}"
             role="progressbar" style="width: {{ $profilePercent }}%"></div>
    </div>
    <div class="d-flex flex-wrap gap-2">
        @foreach($profileItems as $item)
        <span class="badge {{ $item['filled'] ? 'bg-success' : 'bg-secondary' }} bg-opacity-75">
            <i class="lni {{ $item['filled'] ? 'lni-checkmark' : 'lni-close' }} me-1"></i>{{ $item['label'] }}
        </span>
        @endforeach
    </div>
    <small class="text-muted d-block mt-2"><a href="{{ route('employer.profile.edit') }}">Lengkapi sekarang</a></small>
</div>
@endif

{{-- Stats Cards --}}
<div class="row mb-3">
    <div class="col-6 col-md-3 mb-3">
        <div class="job-items h-100 text-center">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width:48px;height:48px;background:#e8edff;">
                <i class="lni lni-briefcase" style="font-size:20px;color:#2042e3;"></i>
            </div>
            <h3 class="mb-0">{{ $totalJobs }}</h3>
            <small class="text-muted">Total Lowongan</small>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="job-items h-100 text-center">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width:48px;height:48px;background:#d4edda;">
                <i class="lni lni-checkmark-circle" style="font-size:20px;color:#28a745;"></i>
            </div>
            <h3 class="mb-0">{{ $activeJobs }}</h3>
            <small class="text-muted">Lowongan Aktif</small>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="job-items h-100 text-center">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width:48px;height:48px;background:#fff3cd;">
                <i class="lni lni-users" style="font-size:20px;color:#ffc107;"></i>
            </div>
            <h3 class="mb-0">{{ $stats['total'] }}</h3>
            <small class="text-muted">Total Pelamar</small>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="job-items h-100 text-center">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width:48px;height:48px;background:#e8edff;">
                <i class="lni lni-timer" style="font-size:20px;color:#2042e3;"></i>
            </div>
            <h3 class="mb-0">{{ $stats['pending'] }}</h3>
            <small class="text-muted">Menunggu Review</small>
        </div>
    </div>
</div>

{{-- Recent Applications --}}
<div class="job-items mb-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0"><i class="lni lni-users me-1"></i> Pelamar Terbaru</h5>
        <a href="{{ route('employer.job.index') }}" class="btn btn-outline-primary btn-sm">Lihat Semua Lowongan</a>
    </div>

    @if($recentApplications->isEmpty())
        <div class="alert alert-info mb-0">Belum ada pelamar masuk.</div>
    @else
        @foreach($recentApplications as $app)
        <div class="card border mb-2" style="border-left: 4px solid {{ $app->status === 'accepted' ? '#28a745' : ($app->status === 'rejected' ? '#dc3545' : '#ffc107') }} !important;">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">{{ $app->jobseeker->user->full_name ?? '-' }}</h6>
                        <small class="text-muted">Melamar: <strong>{{ $app->job->nama_pekerjaan }}</strong></small>
                        <br><small class="text-muted">{{ $app->tanggal_apply->format('d M Y') }}</small>
                    </div>
                    <div class="text-end">
                        @if($app->status === 'pending')
                            <span class="badge bg-warning text-dark">Menunggu</span>
                        @elseif($app->status === 'accepted')
                            <span class="badge bg-success">Diterima</span>
                        @else
                            <span class="badge bg-danger">Ditolak</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>

{{-- Active Job Fairs --}}
<div class="job-items mb-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0"><i class="lni lni-calendar me-1"></i> Job Fair Aktif</h5>
        <a href="{{ route('employer.job-fair.index') }}" class="btn btn-outline-primary btn-sm">Lihat Semua</a>
    </div>

    @if($activeJobFairs->isEmpty())
        <div class="alert alert-info mb-0">Tidak ada job fair aktif saat ini.</div>
    @else
        @foreach($activeJobFairs as $fair)
        <div class="card border mb-2" style="border-left: 4px solid #2042e3 !important;">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">{{ $fair->nama }}</h6>
                        <small class="text-muted">
                            <i class="lni lni-map-marker"></i> {{ $fair->lokasi }} &middot;
                            {{ $fair->tanggal_mulai->format('d M Y') }} - {{ $fair->tanggal_selesai->format('d M Y') }}
                        </small>
                    </div>
                    <a href="{{ route('employer.job-fair.show', $fair) }}" class="btn btn-primary btn-sm">Lihat & Daftar</a>
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>

@endsection
