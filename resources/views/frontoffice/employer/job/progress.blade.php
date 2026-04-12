@extends('frontoffice.employer.index')
@section('jobs', 'active')
@section('page-title', 'Progress Seleksi')
@section('page-subtitle', 'Pantau kemajuan tahap seleksi pelamar.')
@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="job-items">
    <div class="mb-3">
        <a href="{{ route('employer.job.applicants', $application->job_id) }}" class="btn btn-outline-secondary btn-sm">
            &larr; Kembali ke Daftar Pelamar
        </a>
    </div>

    <h4 class="mb-1">Progress Seleksi</h4>
    <p class="text-muted mb-4">
        <strong>{{ $application->jobseeker->user->first_name ?? '' }} {{ $application->jobseeker->user->last_name ?? '' }}</strong>
        &middot; {{ $application->job->nama_pekerjaan }}
    </p>

    @if($application->job->steps->isEmpty())
        <div class="alert alert-warning">
            Belum ada tahap seleksi untuk lowongan ini. Atur tahap seleksi di halaman edit lowongan.
        </div>
    @else
        @php
            $currentStep = $application->currentStep();
        @endphp

        <div class="row">
            @foreach($application->job->steps as $step)
                @php
                    $progress = $progressMap->get($step->id);
                    $isCurrent = $currentStep && $currentStep->id === $step->id;
                @endphp
                <div class="col-lg-12 mb-3">
                    <div class="card shadow-sm" style="border-left: 4px solid
                        @if($progress && $progress->lulus) #28a745
                        @elseif($progress && !$progress->lulus) #dc3545
                        @elseif($isCurrent) #ffc107
                        @else #dee2e6 @endif;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start flex-wrap">
                                <div>
                                    <h5 class="mb-1">
                                        {{ $loop->iteration }}. {{ $step->proses->nama_proses ?? '-' }}
                                        @if($progress && $progress->lulus)
                                            <span class="badge bg-success ms-2">Lulus</span>
                                        @elseif($progress && !$progress->lulus)
                                            <span class="badge bg-danger ms-2">Tidak Lulus</span>
                                        @elseif($isCurrent)
                                            <span class="badge bg-warning text-dark ms-2">Sedang Berjalan</span>
                                        @else
                                            <span class="badge bg-secondary ms-2">Menunggu</span>
                                        @endif
                                    </h5>
                                    @if($step->deskripsi)
                                        <p class="text-muted mb-2"><em>{{ $step->deskripsi }}</em></p>
                                    @endif
                                    @if($progress && $progress->catatan)
                                        <p class="mb-1"><strong>Catatan:</strong> {{ $progress->catatan }}</p>
                                    @endif
                                </div>
                            </div>

                            <form action="{{ route('employer.application.progress.update', [$application->id, $step->id]) }}"
                                  method="POST" class="mt-3">
                                @csrf
                                <div class="row g-2 align-items-end">
                                    <div class="col-md-3">
                                        <label class="form-label mb-1">Hasil</label>
                                        <select name="lulus" class="form-control">
                                            <option value="1" {{ $progress && $progress->lulus ? 'selected' : '' }}>Lulus</option>
                                            <option value="0" {{ $progress && !$progress->lulus ? 'selected' : '' }}>Tidak Lulus</option>
                                        </select>
                                    </div>
                                    <div class="col-md-7">
                                        <label class="form-label mb-1">Catatan</label>
                                        <input type="text" name="catatan" class="form-control"
                                               value="{{ $progress->catatan ?? '' }}"
                                               placeholder="Catatan untuk pelamar (opsional)">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary w-100">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection
