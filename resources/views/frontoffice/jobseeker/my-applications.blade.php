@extends('frontoffice.jobseeker.templates.body')
@section('applications', 'active')
@section('page-title', 'Lamaran Saya')
@section('page-subtitle', 'Daftar lamaran pekerjaan yang sudah Anda kirim.')
@section('content')

<div class="resume">
    <div class="inner-content">
        <h4 class="mb-4">Lamaran Saya</h4>

        @if($applications->isEmpty())
            <div class="alert alert-info">Anda belum melamar pekerjaan apapun.</div>
        @else
            @foreach($applications as $app)
            @php
                $borderColor = $app->status === 'accepted' ? '#28a745' : ($app->status === 'rejected' ? '#dc3545' : '#ffc107');
                $hasSteps = $app->job->steps->isNotEmpty();
                $currentStep = $hasSteps ? $app->currentStep() : null;
            @endphp

            <div class="card border mb-3" style="border-left: 4px solid {{ $borderColor }} !important;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-1 flex-wrap">
                        <h5 class="mb-0">{{ $app->job->nama_pekerjaan }}</h5>
                        <div class="flex-shrink-0 ms-2">
                            @if($app->status === 'pending')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @elseif($app->status === 'accepted')
                                <span class="badge bg-success">Diterima</span>
                            @elseif($app->status === 'rejected')
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                            <span class="badge bg-light text-dark border">{{ $app->job->worktime }}</span>
                        </div>
                    </div>
                    <p class="text-muted mb-2"><strong>{{ $app->job->employer->nama_perusahaan ?? '-' }}</strong></p>
                    <ul class="list-inline mb-2 small text-muted">
                        <li class="list-inline-item"><i class="lni lni-map-marker me-1"></i>{{ $app->job->alamat }}</li>
                        <li class="list-inline-item"><i class="lni lni-dollar me-1"></i>Rp.{{ number_format($app->job->ekspektasi_gaji, 0, ',', '.') }}</li>
                        <li class="list-inline-item"><i class="lni lni-calendar me-1"></i>Dilamar: {{ $app->tanggal_apply->format('d M Y') }}</li>
                    </ul>

                    @php
                        if (!$hasSteps) {
                            $stepLabel = 'Belum ada tahap';
                            $stepBg = '#f1f3f5';
                            $stepFg = '#6c757d';
                            $stepBorder = '#dee2e6';
                        } elseif ($currentStep) {
                            $stepLabel = 'Tahap saat ini: ' . ($currentStep->proses->nama_proses ?? '-');
                            $stepBg = '#fff8e1';
                            $stepFg = '#8a6d00';
                            $stepBorder = '#ffe08a';
                        } else {
                            $stepLabel = 'Semua tahap selesai';
                            $stepBg = '#e6f5ea';
                            $stepFg = '#1e7e34';
                            $stepBorder = '#b8e0c3';
                        }
                    @endphp
                    <div class="mb-2">
                        <span class="badge rounded-pill"
                              style="background: {{ $stepBg }}; color: {{ $stepFg }}; border: 1px solid {{ $stepBorder }}; font-weight: 500; padding: 6px 12px;">
                            <i class="lni lni-timer me-1"></i> {{ $stepLabel }}
                        </span>
                    </div>

                    <a href="{{ route('jobseeker.application.progress', $app->id) }}" class="btn btn-outline-primary btn-sm">
                        <i class="lni lni-timer me-1"></i> Lihat Progress Seleksi
                    </a>
                </div>
            </div>
            @endforeach
        @endif
    </div>
</div>

@endsection
