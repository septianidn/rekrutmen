@extends('frontoffice.employer.index')
@section('jobs', 'active')
@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="job-items">
    <div class="mb-3">
        <a href="{{ route('employer.job.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Kembali ke Daftar Lowongan</a>
    </div>

    <h4 class="mb-3">Pelamar untuk: {{ $job->nama_pekerjaan }}</h4>
    <p class="text-muted mb-4">{{ $job->posisi }} &middot; {{ $job->alamat }}</p>

    @if($applications->isEmpty())
        <div class="alert alert-info">Belum ada pelamar untuk lowongan ini.</div>
    @else
        <div class="manage-list">
            <div class="row">
                <div class="col-lg-3 col-12"><p><strong>Nama Pelamar</strong></p></div>
                <div class="col-lg-1 col-12"><p><strong>Tanggal</strong></p></div>
                <div class="col-lg-1 col-12"><p><strong>Status</strong></p></div>
                <div class="col-lg-3 col-12"><p><strong>CV</strong></p></div>
                <div class="col-lg-4 col-12"><p><strong>Aksi</strong></p></div>
            </div>
        </div>

        @foreach($applications as $app)
        <div class="manage-content">
            <div class="row align-items-center">
                <div class="col-lg-3 col-12">
                    <h5 class="mb-0">
                        {{ $app->jobseeker->user->first_name ?? '' }} {{ $app->jobseeker->user->last_name ?? '' }}
                    </h5>
                    <small class="text-muted">{{ $app->jobseeker->user->email ?? '' }}</small>
                </div>
                <div class="col-lg-1 col-12">
                    <small>{{ $app->tanggal_apply->format('d/m/Y') }}</small>
                </div>
                <div class="col-lg-1 col-12">
                    @if($app->status === 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                    @elseif($app->status === 'accepted')
                        <span class="badge bg-success">Diterima</span>
                    @elseif($app->status === 'rejected')
                        <span class="badge bg-danger">Ditolak</span>
                    @endif
                </div>
                <div class="col-lg-3 col-12">
                    <a href="{{ route('employer.applicant.cv', $app->jobseeker->id) }}" class="btn btn-info btn-sm">Lihat CV</a>
                    <a href="{{ route('employer.applicant.cv-pdf', $app->jobseeker->id) }}" class="btn btn-outline-primary btn-sm" target="_blank">PDF</a>
                </div>
                <div class="col-lg-4 col-12">
                    @if($app->status === 'pending')
                        <form action="{{ route('employer.application.update-status', $app->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="accepted">
                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Terima pelamar ini?')">Terima</button>
                        </form>
                        <form action="{{ route('employer.application.update-status', $app->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tolak pelamar ini?')">Tolak</button>
                        </form>
                    @else
                        <form action="{{ route('employer.application.update-status', $app->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="pending">
                            <button type="submit" class="btn btn-outline-secondary btn-sm">Reset</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>

@endsection
