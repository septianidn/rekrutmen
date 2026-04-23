@extends('frontoffice.employer.index')
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
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="resume">
    <div class="inner-content">

        <div class="mb-3">
            <a href="{{ route('employer.job.index') }}" class="btn btn-outline-secondary btn-sm">
                &larr; Kembali ke Daftar Lowongan
            </a>
        </div>

        {{-- Header card --}}
        <div class="card border mb-3" style="border-left: 4px solid #2042e3 !important;">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <div>
                        <h4 class="mb-1">{{ $jobs->nama_pekerjaan }}</h4>
                        <p class="text-muted mb-0">
                            <strong>{{ $jobs->employer->nama_perusahaan ?? '-' }}</strong>
                            @if(!empty($jobs->posisi))
                                &middot; {{ $jobs->posisi }}
                            @endif
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="badge bg-light text-dark border">{{ $jobs->worktime }}</span>
                    </div>
                </div>

                <ul class="list-inline mb-3 small text-muted">
                    <li class="list-inline-item me-3"><i class="lni lni-map-marker me-1"></i>{{ $jobs->alamat }}</li>
                    <li class="list-inline-item me-3"><i class="lni lni-dollar me-1"></i>Rp.{{ number_format($jobs->ekspektasi_gaji, 0, ',', '.') }}</li>
                    @if($jobs->application_deadline)
                        <li class="list-inline-item me-3"><i class="lni lni-calendar me-1"></i>Deadline: {{ \Carbon\Carbon::parse($jobs->application_deadline)->format('d M Y') }}</li>
                    @endif
                </ul>

                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('employer.job.applicants', $jobs->id) }}" class="btn btn-primary btn-sm">
                        <i class="lni lni-users me-1"></i> Lihat Pelamar
                    </a>
                    <a href="{{ route('employer.job.edit', $jobs->id) }}" class="btn btn-outline-primary btn-sm">
                        <i class="lni lni-pencil me-1"></i> Edit
                    </a>
                    @if($jobs->status === 'closed')
                        <form action="{{ route('employer.job.reopen', $jobs->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-success btn-sm">
                                <i class="lni lni-checkmark-circle me-1"></i> Buka Kembali
                            </button>
                        </form>
                    @else
                        <form action="{{ route('employer.job.close', $jobs->id) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin menutup lowongan ini? Pelamar baru tidak dapat melamar.');" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="lni lni-close me-1"></i> Tutup Lowongan
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        {{-- Deskripsi --}}
        <div class="card border mb-3">
            <div class="card-body p-3">
                <h5 class="mb-2">Deskripsi Pekerjaan</h5>
                @if(!empty($jobs->deskripsi_pekerjaan))
                    <div class="small">{!! $jobs->deskripsi_pekerjaan !!}</div>
                @else
                    <p class="text-muted mb-0"><em>Belum ada deskripsi pekerjaan.</em></p>
                @endif
            </div>
        </div>

        {{-- Requirement --}}
        <div class="card border mb-3">
            <div class="card-body p-3">
                <h5 class="mb-2">Persyaratan</h5>
                @if(!empty($jobs->requirement))
                    <div class="small">{!! $jobs->requirement !!}</div>
                @else
                    <p class="text-muted mb-0"><em>Belum ada persyaratan yang ditentukan.</em></p>
                @endif
            </div>
        </div>

        {{-- Tahap Seleksi --}}
        <div class="card border mb-3">
            <div class="card-body p-4">
                <h5 class="mb-3"><i class="lni lni-timer me-1"></i> Tahap Seleksi</h5>
                @if($jobs->steps->isEmpty())
                    <p class="text-muted mb-0"><em>Belum ada tahap seleksi yang diatur untuk lowongan ini.</em></p>
                @else
                    <div class="position-relative">
                        @foreach($jobs->steps as $step)
                            <div class="d-flex mb-4 position-relative">
                                <div class="flex-shrink-0 text-center" style="width: 40px;">
                                    <div style="width: 28px; height: 28px; border-radius: 50%; background: #adb5bd; color: #fff; margin: 0 auto; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 600; border: 3px solid #fff; box-shadow: 0 0 0 2px #adb5bd;">
                                        {{ $loop->iteration }}
                                    </div>
                                    @if(!$loop->last)
                                        <div style="width: 2px; height: calc(100% + 10px); background: #dee2e6; margin: 4px auto 0;"></div>
                                    @endif
                                </div>
                                <div class="flex-grow-1 ps-3">
                                    <h6 class="mb-1">{{ $step->proses->nama_proses ?? '-' }}</h6>
                                    @if(!empty($step->deskripsi))
                                        <p class="text-muted small mb-0">{{ $step->deskripsi }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

@endsection
