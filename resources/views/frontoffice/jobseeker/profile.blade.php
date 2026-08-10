@extends('frontoffice.jobseeker.templates.body')
@section('profile', 'active')
@section('page-title', 'Profil Saya')
@section('page-subtitle', 'Informasi lengkap profil dan CV Anda.')
@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(!$jobseeker)
    <div class="alert alert-warning">
        Profil belum lengkap.
        <a href="{{ route('jobseeker.profile.edit') }}" class="btn btn-primary btn-sm ms-2">Lengkapi Profil</a>
    </div>
@else
<div class="resume">
    <div class="inner-content">

        {{-- Personal Info + Contact --}}
        <div class="card border mb-3">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap">
                    <div class="me-3">
                        <h4 class="mb-1">
                            <i class="lni lni-user me-2 text-primary"></i>
                            {{ $user->first_name }} {{ $user->last_name }}
                        </h4>
                        <p class="text-muted mb-0 small">
                            <i class="lni lni-id-badge me-1"></i>
                            {{ $jobseeker->jobseekerType->name ?? 'Jobseeker' }}
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('jobseeker.profile.edit') }}" class="btn btn-warning btn-sm">
                            <i class="lni lni-pencil-alt me-1"></i> Edit Profil
                        </a>
                        <a href="{{ route('jobseeker.cv-pdf') }}" class="btn btn-primary btn-sm ms-1" target="_blank">
                            <i class="lni lni-download me-1"></i> Download CV
                        </a>
                    </div>
                </div>

                <hr class="my-3">

                <div class="row g-3 mb-3">
                    @if($jobseeker->jenis_kelamin && $jobseeker->jenis_kelamin !== '-')
                    <div class="col-12 col-md-6">
                        <p class="text-muted small mb-1">
                            <i class="lni lni-user me-1"></i> Jenis Kelamin
                        </p>
                        <p class="mb-0">{{ $jobseeker->jenis_kelamin }}</p>
                    </div>
                    @endif
                    @if($jobseeker->ttl)
                    <div class="col-12 col-md-6">
                        <p class="text-muted small mb-1">
                            <i class="lni lni-cake me-1"></i> Tanggal Lahir
                        </p>
                        <p class="mb-0">{{ $jobseeker->ttl->format('d M Y') }}</p>
                    </div>
                    @endif
                </div>

                <hr class="my-3">

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <p class="text-muted small mb-1">
                            <i class="lni lni-envelope me-1"></i> Email
                        </p>
                        <p class="mb-0">{{ $user->email ?: 'Belum diisi' }}</p>
                    </div>
                    <div class="col-12 col-md-6">
                        <p class="text-muted small mb-1">
                            <i class="lni lni-phone me-1"></i> Telepon
                        </p>
                        <p class="mb-0">{{ $user->phone_number ?: 'Belum diisi' }}</p>
                    </div>
                    <div class="col-12">
                        <p class="text-muted small mb-1">
                            <i class="lni lni-map-marker me-1"></i> Alamat
                        </p>
                        <p class="mb-0">{{ $user->street_addr ?: 'Belum diisi' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Riwayat Pendidikan --}}
        @if($jobseeker->riwayatPendidikans->isNotEmpty())
        <div class="card border mb-3">
            <div class="card-body p-4">
                <h5 class="mb-3">
                    <i class="lni lni-graduation me-1 text-primary"></i> Riwayat Pendidikan
                </h5>
                @foreach($jobseeker->riwayatPendidikans as $edu)
                <div class="d-flex align-items-start {{ !$loop->last ? 'mb-3 pb-3 border-bottom' : '' }}">
                    <div class="me-3">
                        <span class="badge bg-primary px-2 py-1">{{ $edu->jenjang?->nama_jenjang }}</span>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1">{{ $edu->instansi }}</h6>
                        @if($edu->prodi || $edu->prodi_lain)
                            <div class="small text-muted">{{ $edu->prodi?->nama_prodi ?? $edu->prodi_lain }}</div>
                        @endif
                        @if($edu->indeks_nilai)
                            <small class="text-muted">IPK/Nilai: {{ $edu->indeks_nilai }}</small>
                        @endif
                        @if($edu->keterangan)
                            <p class="mb-0 mt-1 small">{{ $edu->keterangan }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Pengalaman Kerja --}}
        @if($jobseeker->riwayatKerjas->isNotEmpty())
        <div class="card border mb-3">
            <div class="card-body p-4">
                <h5 class="mb-3">
                    <i class="lni lni-briefcase me-1 text-primary"></i> Pengalaman Kerja
                </h5>
                @foreach($jobseeker->riwayatKerjas as $work)
                <p class="mb-2 {{ !$loop->last ? 'pb-2 border-bottom' : '' }}">
                    {{ $work->keterangan }}
                </p>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Organisasi --}}
        @if($jobseeker->organisasis->isNotEmpty())
        <div class="card border mb-3">
            <div class="card-body p-4">
                <h5 class="mb-3">
                    <i class="lni lni-users me-1 text-primary"></i> Organisasi
                </h5>
                @foreach($jobseeker->organisasis as $org)
                <div class="{{ !$loop->last ? 'mb-3 pb-3 border-bottom' : '' }}">
                    <h6 class="mb-0">{{ $org->nama_organisasi }}</h6>
                    <small class="text-muted">{{ $org->jabatan }}</small>
                    @if($org->keterangan)
                        <p class="mb-0 mt-1 small">{{ $org->keterangan }}</p>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Prestasi --}}
        @if($jobseeker->prestasis->isNotEmpty())
        <div class="card border mb-3">
            <div class="card-body p-4">
                <h5 class="mb-3">
                    <i class="lni lni-medall me-1 text-primary"></i> Prestasi / Penghargaan
                </h5>
                @foreach($jobseeker->prestasis as $award)
                <div class="mb-2">
                    <i class="lni lni-star-filled text-warning me-1"></i>
                    <strong>{{ $award->nama_penghargaan }}</strong>
                    <small class="text-muted">({{ $award->tahun }})</small>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Pelatihan --}}
        @if($jobseeker->pelatihans->isNotEmpty())
        <div class="card border mb-3">
            <div class="card-body p-4">
                <h5 class="mb-3">
                    <i class="lni lni-certificate me-1 text-primary"></i> Pelatihan / Sertifikasi
                </h5>
                @foreach($jobseeker->pelatihans as $training)
                <div class="mb-2">
                    <i class="lni lni-checkmark-circle text-success me-1"></i>
                    <strong>{{ $training->nama_pelatihan }}</strong>
                    <small class="text-muted">({{ $training->tahun }})</small>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Bahasa --}}
        @if($jobseeker->bahasas->isNotEmpty())
        <div class="card border mb-3">
            <div class="card-body p-4">
                <h5 class="mb-3">
                    <i class="lni lni-world me-1 text-primary"></i> Bahasa
                </h5>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($jobseeker->bahasas as $lang)
                        <span class="badge bg-light text-dark border px-3 py-2">
                            <i class="lni lni-comments me-1"></i>
                            {{ $lang->bahasa }}
                            @if($lang->keterangan)
                                <small class="text-muted">({{ $lang->keterangan }})</small>
                            @endif
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- Rekomendasi --}}
        @if($jobseeker->rekomendasis->isNotEmpty())
        <div class="card border mb-3">
            <div class="card-body p-4">
                <h5 class="mb-3">
                    <i class="lni lni-thumbs-up me-1 text-primary"></i> Referensi
                </h5>
                @foreach($jobseeker->rekomendasis as $ref)
                <div class="{{ !$loop->last ? 'mb-3 pb-3 border-bottom' : '' }}">
                    <h6 class="mb-0">{{ $ref->nama_perekomendasi }}</h6>
                    <small class="text-muted">{{ $ref->posisi }}</small>
                    <p class="mb-0 small mt-1">
                        <i class="lni lni-phone me-1"></i> {{ $ref->no_hp }}
                        @if($ref->alamat)
                            &middot; <i class="lni lni-map-marker me-1"></i> {{ $ref->alamat }}
                        @endif
                    </p>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Empty state --}}
        @if(
            $jobseeker->riwayatPendidikans->isEmpty() &&
            $jobseeker->riwayatKerjas->isEmpty() &&
            $jobseeker->organisasis->isEmpty() &&
            $jobseeker->prestasis->isEmpty() &&
            $jobseeker->pelatihans->isEmpty() &&
            $jobseeker->bahasas->isEmpty() &&
            $jobseeker->rekomendasis->isEmpty()
        )
        <div class="alert alert-info">
            <i class="lni lni-information me-1"></i>
            Data CV masih kosong. Lengkapi riwayat pendidikan, pengalaman kerja, dan data lainnya untuk menghasilkan CV.
        </div>
        @endif
    </div>
</div>
@endif

@endsection
