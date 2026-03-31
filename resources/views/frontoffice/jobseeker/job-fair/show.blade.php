@extends('frontoffice.jobseeker.templates.body')
@section('jobfair', 'active')
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

<section>
    <div class="container">
        <div class="mb-3">
            <a href="{{ route('jobseeker.job-fair.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Kembali</a>
        </div>

        <h4 class="mb-1">{{ $jobFair->nama }}</h4>
        <p class="text-muted">
            <i class="lni lni-map-marker"></i> {{ $jobFair->lokasi }} &middot;
            {{ $jobFair->tanggal_mulai->format('d M Y') }} - {{ $jobFair->tanggal_selesai->format('d M Y') }}
        </p>
        @if($jobFair->deskripsi)
            <p>{{ $jobFair->deskripsi }}</p>
        @endif
        <hr>

        <h5 class="mb-3">Lowongan di Job Fair ini ({{ $jobs->count() }})</h5>

        @forelse($jobs as $job)
        <div class="single-job mb-3">
            <div class="job-content">
                <h4>{{ $job->nama_pekerjaan }}</h4>
                <p class="mb-1"><strong>{{ $job->employer->nama_perusahaan ?? '-' }}</strong></p>
                <ul>
                    <li><i class="lni lni-map-marker"></i> {{ $job->alamat }}</li>
                    <li><i class="lni lni-dollar"></i> Rp.{{ number_format($job->ekspektasi_gaji, 0, ',', '.') }}</li>
                    <li><i class="lni lni-briefcase"></i> {{ $job->worktime }}</li>
                </ul>
            </div>
            <div class="job-button">
                <ul>
                    @if(in_array($job->id, $appliedJobIds))
                        <li><span class="badge bg-info text-white px-3 py-2">Sudah Dilamar</span></li>
                    @else
                        <li>
                            <form action="{{ route('jobseeker.jobs.apply', $job->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Lamar pekerjaan ini?')">Apply</button>
                            </form>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        @empty
        <div class="alert alert-info">Belum ada lowongan yang disetujui untuk job fair ini.</div>
        @endforelse
    </div>
</section>

@endsection
