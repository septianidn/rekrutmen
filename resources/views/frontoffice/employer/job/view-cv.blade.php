@extends('frontoffice.employer.index')
@section('jobs', 'active')
@section('page-title', 'CV Pelamar')
@section('page-subtitle', 'Lihat CV pelamar secara lengkap.')
@section('content')

<div class="job-items">
    <div class="mb-3 d-flex justify-content-between">
        <a href="javascript:history.back()" class="btn btn-outline-secondary btn-sm">&larr; Kembali</a>
        <a href="{{ route('employer.applicant.cv-pdf', $jobseeker->id) }}" class="btn btn-primary btn-sm" target="_blank">
            <i class="lni lni-download"></i> Download CV (PDF)
        </a>
    </div>

    <div class="inner-content">
        <!-- Personal Info -->
        <div class="personal-top-content">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-12">
                    <div class="name-head">
                        <h4 class="mb-1">{{ $user->first_name }} {{ $user->last_name }}</h4>
                        <p class="text-muted">{{ $jobseeker->jobseekerType->jobseekerType ?? 'Jobseeker' }}</p>
                        @if($jobseeker->jenis_kelamin && $jobseeker->jenis_kelamin != '-')
                            <p class="mb-0"><small>{{ $jobseeker->jenis_kelamin }}</small></p>
                        @endif
                        @if($jobseeker->ttl)
                            <p class="mb-0"><small>TTL: {{ $jobseeker->ttl->format('d M Y') }}</small></p>
                        @endif
                    </div>
                </div>
                <div class="col-lg-7 col-md-7 col-12">
                    <div class="content-right">
                        <h5 class="title-main">Informasi Kontak</h5>
                        <div class="single-list">
                            <h5 class="title">Email</h5>
                            <p>{{ $user->email }}</p>
                        </div>
                        <div class="single-list">
                            <h5 class="title">Telepon</h5>
                            <p>{{ $user->phone_number ?? '-' }}</p>
                        </div>
                        <div class="single-list">
                            <h5 class="title">Alamat</h5>
                            <p>{{ $user->street_addr ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Pendidikan -->
        @if($jobseeker->riwayatPendidikans->isNotEmpty())
        <div class="single-section education mt-4">
            <h4>Riwayat Pendidikan</h4>
            @foreach($jobseeker->riwayatPendidikans as $edu)
            <div class="single-edu mb-3">
                <div class="d-flex align-items-start">
                    <div class="me-3">
                        <span class="badge bg-primary px-2 py-1">{{ $edu->jenjang }}</span>
                    </div>
                    <div>
                        <h5 class="mb-0">{{ $edu->instansi }}</h5>
                        @if($edu->indeks_nilai)
                            <small class="text-muted">IPK/Nilai: {{ $edu->indeks_nilai }}</small>
                        @endif
                        @if($edu->keterangan)
                            <p class="mb-0 mt-1">{{ $edu->keterangan }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <!-- Pengalaman Kerja -->
        @if($jobseeker->riwayatKerjas->isNotEmpty())
        <div class="single-section mt-4">
            <h4>Pengalaman Kerja</h4>
            @foreach($jobseeker->riwayatKerjas as $work)
            <div class="mb-3">
                <p class="mb-0">{{ $work->keterangan }}</p>
            </div>
            @endforeach
        </div>
        @endif

        <!-- Organisasi -->
        @if($jobseeker->organisasis->isNotEmpty())
        <div class="single-section mt-4">
            <h4>Organisasi</h4>
            @foreach($jobseeker->organisasis as $org)
            <div class="mb-3">
                <h5 class="mb-0">{{ $org->nama_organisasi }}</h5>
                <small class="text-muted">{{ $org->jabatan }}</small>
                @if($org->keterangan)
                    <p class="mb-0 mt-1">{{ $org->keterangan }}</p>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        <!-- Prestasi -->
        @if($jobseeker->prestasis->isNotEmpty())
        <div class="single-section mt-4">
            <h4>Prestasi / Penghargaan</h4>
            @foreach($jobseeker->prestasis as $award)
            <div class="mb-2">
                <strong>{{ $award->nama_penghargaan }}</strong> <small class="text-muted">({{ $award->tahun }})</small>
            </div>
            @endforeach
        </div>
        @endif

        <!-- Pelatihan -->
        @if($jobseeker->pelatihans->isNotEmpty())
        <div class="single-section mt-4">
            <h4>Pelatihan / Sertifikasi</h4>
            @foreach($jobseeker->pelatihans as $training)
            <div class="mb-2">
                <strong>{{ $training->nama_pelatihan }}</strong> <small class="text-muted">({{ $training->tahun }})</small>
            </div>
            @endforeach
        </div>
        @endif

        <!-- Bahasa -->
        @if($jobseeker->bahasas->isNotEmpty())
        <div class="single-section skill mt-4">
            <h4>Bahasa</h4>
            <ul class="list-unstyled d-flex align-items-center flex-wrap">
                @foreach($jobseeker->bahasas as $lang)
                <li class="me-2">
                    <a href="#">{{ $lang->bahasa }} @if($lang->keterangan)({{ $lang->keterangan }})@endif</a>
                </li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Referensi -->
        @if($jobseeker->rekomendasis->isNotEmpty())
        <div class="single-section mt-4">
            <h4>Referensi</h4>
            @foreach($jobseeker->rekomendasis as $ref)
            <div class="mb-3">
                <h5 class="mb-0">{{ $ref->nama_perekomendasi }}</h5>
                <small class="text-muted">{{ $ref->posisi }}</small>
                <p class="mb-0">{{ $ref->no_hp }} &middot; {{ $ref->alamat }}</p>
            </div>
            @endforeach
        </div>
        @endif

        @if(
            $jobseeker->riwayatPendidikans->isEmpty() &&
            $jobseeker->riwayatKerjas->isEmpty() &&
            $jobseeker->organisasis->isEmpty() &&
            $jobseeker->prestasis->isEmpty() &&
            $jobseeker->pelatihans->isEmpty() &&
            $jobseeker->bahasas->isEmpty() &&
            $jobseeker->rekomendasis->isEmpty()
        )
        <div class="alert alert-info mt-4">Pelamar belum melengkapi data CV.</div>
        @endif
    </div>
</div>

@endsection
