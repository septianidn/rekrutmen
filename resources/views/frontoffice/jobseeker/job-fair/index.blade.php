@extends('frontoffice.jobseeker.templates.body')
@section('jobfair', 'active')
@section('content')

<section>
    <div class="container">
        <h4 class="mb-4">Job Fair</h4>

        @forelse($jobFairs as $fair)
        <div class="single-job mb-3">
            <div class="job-content">
                <h4>{{ $fair->nama }}</h4>
                <p class="mb-1">{{ Str::limit($fair->deskripsi, 150) }}</p>
                <ul>
                    <li><i class="lni lni-map-marker"></i> {{ $fair->lokasi }}</li>
                    <li><i class="lni lni-calendar"></i> {{ $fair->tanggal_mulai->format('d M Y') }} - {{ $fair->tanggal_selesai->format('d M Y') }}</li>
                </ul>
            </div>
            <div class="job-button">
                <ul>
                    <li><a href="{{ route('jobseeker.job-fair.show', $fair) }}">Lihat Lowongan</a></li>
                </ul>
            </div>
        </div>
        @empty
        <div class="alert alert-info">Tidak ada job fair yang sedang aktif saat ini.</div>
        @endforelse
    </div>
</section>

@endsection
