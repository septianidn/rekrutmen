@extends('frontoffice.jobseeker.templates.body')
@section('jobs', 'active')
@section('page-title', 'Lowongan Pekerjaan')
@section('page-subtitle', 'Cari lowongan yang sesuai dan kirim lamaran.')
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
        @if(session('redirect_profile'))
            <br><a href="{{ session('redirect_profile') }}" class="alert-link">Lengkapi Profil Sekarang</a>
        @endif
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="resume">
    <div class="inner-content">
        <h4 class="mb-4">Lowongan Pekerjaan</h4>

        @forelse($jobs as $j)
        <div class="card border mb-3" style="border-left: 4px solid #2042e3 !important;">
            <div class="card-body p-3">
                <div class="d-flex align-items-start gap-3">
                    {{-- Company logo --}}
                    <div class="flex-shrink-0">
                        @if($j->employer && $j->employer->logo_url)
                            <img src="{{ $j->employer->logo_url }}" alt="Logo"
                                style="width:56px;height:56px;object-fit:contain;border:1px solid #dee2e6;border-radius:8px;padding:3px;">
                        @else
                            <div style="width:56px;height:56px;border:1px solid #dee2e6;border-radius:8px;display:flex;align-items:center;justify-content:center;background:#f8f9fa;">
                                <i class="lni lni-apartment text-muted" style="font-size:1.4rem;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <h5 class="mb-0">{{ $j->nama_pekerjaan }}</h5>
                            <div class="flex-shrink-0 ms-2">
                                <span class="badge bg-light text-dark border">{{ $j->worktime }}</span>
                                @if(in_array($j->id, $appliedJobIds))
                                    <span class="badge bg-info text-white">Sudah Dilamar</span>
                                @endif
                            </div>
                        </div>
                        <p class="text-muted mb-2"><strong>{{ $j->employer->nama_perusahaan ?? '-' }}</strong></p>
                        <p class="small mb-2">{!! Str::limit(strip_tags($j->deskripsi_pekerjaan), 150) !!}</p>
                        <ul class="list-inline mb-0 small text-muted">
                            <li class="list-inline-item"><i class="lni lni-map-marker me-1"></i>{{ $j->alamat }}</li>
                            <li class="list-inline-item"><i class="lni lni-dollar me-1"></i>Rp.{{ number_format($j->ekspektasi_gaji, 0, ',', '.') }}</li>
                        </ul>
                    </div>
                    </div>
                </div>
                <div class="mt-3 d-flex gap-2">
                    <a href="{{ route('jobseeker.jobs.show', $j->id) }}" class="btn btn-info btn-sm text-white">
                        <i class="lni lni-eye me-1"></i> Detail
                    </a>
                    @if(!in_array($j->id, $appliedJobIds))
                    <form action="{{ route('jobseeker.jobs.apply', $j->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Apakah Anda yakin ingin melamar pekerjaan ini?')">
                            <i class="lni lni-envelope me-1"></i> Lamar Sekarang
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="alert alert-info mb-0">Belum ada lowongan tersedia saat ini.</div>
        @endforelse

        <div class="d-flex justify-content-center mt-4">
            {{ $jobs->links('components.paginate') }}
        </div>
    </div>
</div>

@endsection
