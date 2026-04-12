@extends('frontoffice.jobseeker.templates.body')
@section('jobfair', 'active')
@section('page-title', 'Job Fair')
@section('page-subtitle', 'Daftar event job fair yang tersedia.')
@section('content')

<div class="resume">
    <div class="inner-content">
        <h4 class="mb-4">Job Fair</h4>

        @forelse($jobFairs as $fair)
        <div class="card border mb-3" style="border-left: 4px solid #2042e3 !important;">
            <div class="card-body p-3">
                <div class="d-flex align-items-start">
                    <div class="d-flex align-items-center justify-content-center bg-light rounded me-3 flex-shrink-0" style="width: 50px; height: 50px;">
                        <i class="lni lni-briefcase" style="font-size: 24px; color: #2042e3;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="mb-1"><a href="{{ route('jobseeker.job-fair.show', $fair) }}" class="text-dark">{{ $fair->nama }}</a></h5>
                        <p class="mb-2">{{ Str::limit($fair->deskripsi, 150) }}</p>
                        <ul class="list-inline mb-0 text-muted small">
                            <li class="list-inline-item"><i class="lni lni-map-marker"></i> {{ $fair->lokasi }}</li>
                            <li class="list-inline-item"><i class="lni lni-calendar"></i> {{ $fair->tanggal_mulai->format('d M Y') }} - {{ $fair->tanggal_selesai->format('d M Y') }}</li>
                        </ul>
                    </div>
                    <div class="flex-shrink-0 ms-3">
                        <a href="{{ route('jobseeker.job-fair.show', $fair) }}" class="btn btn-primary btn-sm">Lihat Lowongan</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="alert alert-info mb-0">Tidak ada job fair yang sedang aktif saat ini.</div>
        @endforelse
    </div>
</div>

@endsection
