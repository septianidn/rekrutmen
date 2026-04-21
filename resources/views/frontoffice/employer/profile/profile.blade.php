@extends('frontoffice.employer.index')
@section('profile', 'active')
@section('page-title', 'Profil Perusahaan')
@section('page-subtitle', 'Informasi lengkap tentang perusahaan Anda.')
@section('content')
    <div class="resume">
        <div class="container">
            <div class="inner-content">

                <div class="card border">
                    <div class="card-body p-4">
                        {{-- Header --}}
                        <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap">
                            <div class="d-flex align-items-center gap-3 me-3">
                                @if($employer->getFirstMediaUrl('logo'))
                                    <img src="{{ $employer->getFirstMediaUrl('logo') }}" alt="Logo"
                                        style="width:72px;height:72px;object-fit:contain;border:1px solid #dee2e6;border-radius:10px;padding:4px;flex-shrink:0;">
                                @else
                                    <div style="width:72px;height:72px;border:1px solid #dee2e6;border-radius:10px;display:flex;align-items:center;justify-content:center;background:#f8f9fa;flex-shrink:0;">
                                        <i class="lni lni-apartment text-muted" style="font-size:2rem;"></i>
                                    </div>
                                @endif
                                <div>
                                    <h4 class="mb-1">{{ $employer->nama_perusahaan ?? '-' }}</h4>
                                    @if($employer->industriType?->nama_industri)
                                        <p class="text-muted mb-0 small">
                                            <i class="lni lni-briefcase me-1"></i>
                                            {{ $employer->industriType->nama_industri }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route('employer.profile.edit') }}" class="btn btn-primary btn-sm">
                                <i class="lni lni-pencil-alt me-1"></i> Edit Profil
                            </a>
                        </div>

                        <hr class="my-3">

                        {{-- Contact grid --}}
                        <div class="row g-3 mb-3">
                            <div class="col-12">
                                <p class="text-muted small mb-1">
                                    <i class="lni lni-map-marker me-1"></i> Alamat
                                </p>
                                <p class="mb-0">{{ $employer->alamat_perusahaan ?: 'Belum diisi' }}</p>
                            </div>
                            <div class="col-12 col-md-6">
                                <p class="text-muted small mb-1">
                                    <i class="lni lni-phone me-1"></i> Telepon
                                </p>
                                <p class="mb-0">{{ $employer->telp_perusahaan ?: 'Belum diisi' }}</p>
                            </div>
                            <div class="col-12 col-md-6">
                                <p class="text-muted small mb-1">
                                    <i class="lni lni-world me-1"></i> Website
                                </p>
                                <p class="mb-0 text-truncate">
                                    @if($employer->website)
                                        <a href="{{ $employer->website }}" target="_blank" rel="noopener">{{ $employer->website }}</a>
                                    @else
                                        Belum diisi
                                    @endif
                                </p>
                            </div>
                        </div>

                        <hr class="my-3">

                        {{-- About --}}
                        <div>
                            <p class="text-muted small mb-1">
                                <i class="lni lni-information me-1"></i> Tentang Perusahaan
                            </p>
                            @if($employer->deskripsi_perusahaan)
                                <p class="mb-0" style="line-height: 1.7;">{{ $employer->deskripsi_perusahaan }}</p>
                            @else
                                <p class="text-muted mb-0">Belum ada deskripsi perusahaan.</p>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
