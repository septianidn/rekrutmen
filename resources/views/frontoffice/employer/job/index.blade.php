@extends('frontoffice.employer.index')
@section('jobs', 'active')
@section('page-title', 'Daftar Lowongan')
@section('page-subtitle', 'Kelola lowongan yang Anda posting.')
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

<div class="job-items">
    <div class="mb-3">
        <a href="{{ route('employer.job.create') }}">
            <button class="btn btn-primary btn-sm">Tambah Lowongan</button>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped align-middle mb-0">
            <thead>
                <tr>
                    <th>Nama Pekerjaan</th>
                    <th>Tipe</th>
                    <th>Status</th>
                    <th>Pelamar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jobs as $j)
                <tr>
                    <td><a href="{{ route('employer.job.show', ['job' => $j->id]) }}"><strong>{{ $j->nama_pekerjaan }}</strong></a></td>
                    <td><span class="time">{{ worktimeLabel($j->worktime) }}</span></td>
                    <td>
                        @if($j->isOpen())
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Ditutup</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('employer.job.applicants', $j->id) }}" class="btn btn-outline-primary btn-sm">
                            {{ $j->applications_count ?? $j->applications()->count() }} Pelamar
                        </a>
                    </td>
                    <td class="text-nowrap">
                        <a href="{{ route('employer.job.edit', $j->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <a href="{{ route('employer.job.show', $j->id) }}" class="btn btn-info btn-sm">Detail</a>
                        @if($j->isOpen())
                            <form action="{{ route('employer.job.close', $j->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-secondary btn-sm"
                                        onclick="return confirm('Tutup lowongan ini? Pelamar baru tidak dapat melamar, tetapi riwayat lamaran tetap tersimpan.')">
                                    Tutup
                                </button>
                            </form>
                        @else
                            <form action="{{ route('employer.job.reopen', $j->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-success btn-sm">Buka Kembali</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($jobs->isEmpty())
        <div class="alert alert-info mt-3">Belum ada lowongan. Klik "Tambah Lowongan" untuk membuat lowongan baru.</div>
    @endif
</div>

@endsection
