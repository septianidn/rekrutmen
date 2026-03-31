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
        <a href="{{ route('employer.job.create') }}">
            <button class="btn btn-primary btn-sm">Tambah Lowongan</button>
        </a>
    </div>
    <div class="manage-list">
        <div class="row">
            <div class="col-lg-4 col-md-3 col-12">
                <p><strong>Nama Pekerjaan</strong></p>
            </div>
            <div class="col-lg-2 col-md-2 col-12">
                <p><strong>Tipe</strong></p>
            </div>
            <div class="col-lg-3 col-md-3 col-12">
                <p><strong>Pelamar</strong></p>
            </div>
            <div class="col-lg-3 col-md-3 col-12">
                <p><strong>Aksi</strong></p>
            </div>
        </div>
    </div>

    @foreach ($jobs as $j)
    <div class="manage-content">
        <div class="row align-items-center">
            <div class="col-lg-4 col-md-3 col-12">
                <h5 class="mb-0"><a href="{{ route('employer.job.show', ['job' => $j->id]) }}">{{ $j->nama_pekerjaan }}</a></h5>
            </div>
            <div class="col-lg-2 col-md-2 col-12">
                <span class="time">{{ $j->worktime }}</span>
            </div>
            <div class="col-lg-3 col-md-3 col-12">
                <a href="{{ route('employer.job.applicants', $j->id) }}" class="btn btn-outline-primary btn-sm">
                    {{ $j->applications_count ?? $j->applications()->count() }} Pelamar
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-12">
                <a href="{{ route('employer.job.edit', $j->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <a href="{{ route('employer.job.show', $j->id) }}" class="btn btn-info btn-sm">Detail</a>
            </div>
        </div>
    </div>
    @endforeach

    @if($jobs->isEmpty())
        <div class="alert alert-info mt-3">Belum ada lowongan. Klik "Tambah Lowongan" untuk membuat lowongan baru.</div>
    @endif
</div>

@endsection
