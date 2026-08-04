@extends('frontoffice.jobseeker.templates.body')
@section('applications', 'active')
@section('page-title', 'Progres Seleksi')
@section('page-subtitle', 'Pantau kemajuan tahap seleksi lamaran Anda.')
@section('content')

@php
    $steps = $application->job->steps;
    $job = $application->job;
    $borderColor = $application->status === 'accepted' ? '#28a745' : ($application->status === 'rejected' ? '#dc3545' : '#ffc107');
@endphp

<div class="resume">
    <div class="inner-content">
        <div class="mb-3">
            <a href="{{ route('jobseeker.my-applications') }}" class="btn btn-outline-secondary btn-sm">
                &larr; Kembali ke Lamaran Saya
            </a>
        </div>

        <div class="card border mb-3" style="border-left: 4px solid {{ $borderColor }} !important;">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start mb-1 flex-wrap">
                    <h4 class="mb-0">{{ $job->nama_pekerjaan }}</h4>
                    <div class="flex-shrink-0 ms-2">
                        @if($application->status === 'pending')
                            <span class="badge bg-warning text-dark">Menunggu</span>
                        @elseif($application->status === 'accepted')
                            <span class="badge bg-success">Diterima</span>
                        @elseif($application->status === 'rejected')
                            <span class="badge bg-danger">Ditolak</span>
                        @endif
                        <span class="badge bg-light text-dark border">{{ worktimeLabel($job->worktime) }}</span>
                    </div>
                </div>
                <p class="text-muted mb-2"><strong>{{ $job->employer->nama_perusahaan ?? '-' }}</strong></p>
                <ul class="list-inline mb-0 small text-muted">
                    <li class="list-inline-item"><i class="lni lni-map-marker me-1"></i>{{ $job->alamat }}</li>
                    <li class="list-inline-item"><i class="lni lni-dollar me-1"></i>Rp.{{ number_format($job->ekspektasi_gaji, 0, ',', '.') }}</li>
                    <li class="list-inline-item"><i class="lni lni-calendar me-1"></i>Dilamar: {{ $application->tanggal_apply->format('d M Y') }}</li>
                </ul>
            </div>
        </div>

        <div class="card border mb-3">
            <div class="card-body p-4">
                <h5 class="mb-3"><i class="lni lni-timer me-1"></i> Progres Seleksi</h5>

                @if($steps->isEmpty())
                    <div class="alert alert-info mb-0">
                        Employer belum mengatur tahap seleksi untuk lowongan ini.
                    </div>
                @else
                    @if($application->status === 'rejected')
                        <div class="alert alert-danger mb-3">
                            Lamaran Anda tidak lolos pada salah satu tahap seleksi.
                        </div>
                    @elseif(!$currentStep)
                        <div class="alert alert-success mb-3">
                            Semua tahap seleksi telah selesai.
                        </div>
                    @else
                        <div class="alert alert-warning mb-3">
                            <strong>Tahap saat ini:</strong> {{ $currentStep->label ?? '-' }}
                            @if($currentStep->deskripsi)
                                <br><span class="small">{{ $currentStep->deskripsi }}</span>
                            @endif
                        </div>
                    @endif

                    <div class="position-relative">
                        @foreach($steps as $step)
                            @php
                                $p = $progressMap->get($step->id);
                                $isCurrent = $currentStep && $currentStep->id === $step->id;

                                if ($p && $p->lulus) {
                                    $state = 'passed';
                                    $dotColor = '#28a745';
                                    $badgeClass = 'bg-success';
                                    $badgeLabel = 'Lulus';
                                } elseif ($p && !$p->lulus) {
                                    $state = 'failed';
                                    $dotColor = '#dc3545';
                                    $badgeClass = 'bg-danger';
                                    $badgeLabel = 'Tidak Lulus';
                                } elseif ($isCurrent) {
                                    $state = 'current';
                                    $dotColor = '#ffc107';
                                    $badgeClass = 'bg-warning text-dark';
                                    $badgeLabel = 'Sedang Berjalan';
                                } elseif ($application->status === 'rejected') {
                                    $state = 'skipped';
                                    $dotColor = '#ced4da';
                                    $badgeClass = 'bg-light text-muted border';
                                    $badgeLabel = 'Tidak Dilanjutkan';
                                } else {
                                    $state = 'waiting';
                                    $dotColor = '#adb5bd';
                                    $badgeClass = 'bg-secondary';
                                    $badgeLabel = 'Menunggu';
                                }
                            @endphp

                            <div class="d-flex mb-4 position-relative">
                                <div class="flex-shrink-0 text-center" style="width: 40px;">
                                    <div style="width: 24px; height: 24px; border-radius: 50%; background: {{ $dotColor }}; margin: 0 auto; border: 3px solid #fff; box-shadow: 0 0 0 2px {{ $dotColor }};"></div>
                                    @if(!$loop->last)
                                        <div style="width: 2px; height: calc(100% + 10px); background: #dee2e6; margin: 4px auto 0;"></div>
                                    @endif
                                </div>
                                <div class="flex-grow-1 ps-3">
                                    <div class="d-flex align-items-center mb-1 flex-wrap">
                                        <h6 class="mb-0 me-2">
                                            {{ $loop->iteration }}. {{ $step->label ?? '-' }}
                                        </h6>
                                        <span class="badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
                                    </div>
                                    @if($step->deskripsi)
                                        <p class="text-muted small mb-1">{{ $step->deskripsi }}</p>
                                    @endif
                                    @if($p && $p->catatan)
                                        <div class="alert alert-light border py-2 px-3 mb-0 small">
                                            <strong>Catatan employer:</strong> {{ $p->catatan }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
