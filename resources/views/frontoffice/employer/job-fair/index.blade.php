@extends('frontoffice.employer.index')
@section('jobfair', 'active')
@section('content')

<div class="job-items">
    <h4 class="mb-4">Job Fair</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @forelse($jobFairs as $fair)
    <div class="manage-content mb-3">
        <div class="row align-items-center">
            <div class="col-lg-6 col-12">
                <h5 class="mb-1">{{ $fair->nama }}</h5>
                <small class="text-muted">
                    <i class="lni lni-map-marker"></i> {{ $fair->lokasi }} &middot;
                    {{ $fair->tanggal_mulai->format('d M Y') }} - {{ $fair->tanggal_selesai->format('d M Y') }}
                </small>
            </div>
            <div class="col-lg-3 col-12">
                @php $count = isset($registeredMap[$fair->id]) ? $registeredMap[$fair->id]->count() : 0; @endphp
                <span class="badge bg-info">{{ $count }} lowongan terdaftar</span>
            </div>
            <div class="col-lg-3 col-12">
                <a href="{{ route('employer.job-fair.show', $fair) }}" class="btn btn-primary btn-sm">Lihat & Daftar</a>
            </div>
        </div>
    </div>
    @empty
    <div class="alert alert-info">Tidak ada job fair yang sedang aktif saat ini.</div>
    @endforelse
</div>

@endsection
