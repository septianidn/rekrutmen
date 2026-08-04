@extends('frontoffice.employer.index')
@section('jobs', 'active')
@section('page-title', 'Pelamar')
@section('page-subtitle', 'Daftar pelamar untuk lowongan Anda.')
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
        <div class="table-responsive">
            <table class="table table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nama Pelamar</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>CV</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $app)
                    <tr>
                        <td>
                            <h6 class="mb-0">{{ $app->jobseeker->user->first_name ?? '' }} {{ $app->jobseeker->user->last_name ?? '' }}</h6>
                            <small class="text-muted">{{ $app->jobseeker->user->email ?? '' }}</small>
                        </td>
                        <td><small>{{ $app->tanggal_apply->format('d/m/Y') }}</small></td>
                        <td>
                            @if($app->status === 'pending')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @elseif($app->status === 'accepted')
                                <span class="badge bg-success">Diterima</span>
                            @elseif($app->status === 'rejected')
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>
                        <td class="text-nowrap">
                            <a href="{{ route('employer.applicant.cv', $app->jobseeker->id) }}" class="btn btn-info btn-sm">Lihat CV</a>
                            <a href="{{ route('employer.applicant.cv-pdf', $app->jobseeker->id) }}" class="btn btn-outline-primary btn-sm" target="_blank">PDF</a>
                            <a href="{{ route('employer.application.progress', $app->id) }}" class="btn btn-outline-success btn-sm">Kelola Proses</a>
                        </td>
                        <td class="text-nowrap">
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
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection
