@extends('frontoffice.employer.index')
@section('jobfair', 'active')
@section('page-title', 'Job Fair')
@section('page-subtitle', 'Daftar event job fair yang tersedia.')
@section('content')

<h4 class="mb-4">Job Fair</h4>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@forelse($jobFairs as $fair)
<div class="job-items mb-3">
    <div class="d-flex align-items-center">
        <div class="flex-grow-1">
            <h5 class="mb-1">{{ $fair->nama }}</h5>
            <small class="text-muted">
                <i class="lni lni-map-marker"></i> {{ $fair->lokasi }} &middot;
                {{ $fair->tanggal_mulai->format('d M Y') }} - {{ $fair->tanggal_selesai->format('d M Y') }}
            </small>
        </div>
        <div class="flex-shrink-0 mx-3">
            @php $count = isset($registeredMap[$fair->id]) ? $registeredMap[$fair->id]->count() : 0; @endphp
            <span class="badge bg-info">{{ $count }} lowongan terdaftar</span>
        </div>
        <div class="flex-shrink-0">
            <a href="{{ route('employer.job-fair.show', $fair) }}" class="btn btn-primary btn-sm">Lihat & Daftar</a>
        </div>
    </div>
</div>
@empty
<div class="alert alert-info">Tidak ada job fair yang sedang aktif saat ini.</div>
@endforelse

@endsection
