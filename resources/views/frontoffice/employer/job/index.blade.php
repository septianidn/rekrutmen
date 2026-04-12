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
                    <th>Pelamar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jobs as $j)
                <tr>
                    <td><a href="{{ route('employer.job.show', ['job' => $j->id]) }}"><strong>{{ $j->nama_pekerjaan }}</strong></a></td>
                    <td><span class="time">{{ $j->worktime }}</span></td>
                    <td>
                        <a href="{{ route('employer.job.applicants', $j->id) }}" class="btn btn-outline-primary btn-sm">
                            {{ $j->applications_count ?? $j->applications()->count() }} Pelamar
                        </a>
                    </td>
                    <td class="text-nowrap">
                        <a href="{{ route('employer.job.edit', $j->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <a href="{{ route('employer.job.show', $j->id) }}" class="btn btn-info btn-sm">Detail</a>
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
