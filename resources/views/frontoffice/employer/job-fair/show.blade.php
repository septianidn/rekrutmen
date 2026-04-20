@extends('frontoffice.employer.index')
@section('jobfair', 'active')
@section('page-title', 'Detail Job Fair')
@section('page-subtitle', 'Informasi event job fair.')
@section('content')

<div class="mb-3">
    <a href="{{ route('employer.job-fair.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Kembali</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

{{-- Job Fair Info --}}
<div class="job-items mb-3">
    <h4 class="mb-1">{{ $jobFair->nama }}</h4>
    <p class="text-muted">
        <i class="lni lni-map-marker"></i> {{ $jobFair->lokasi }} &middot;
        {{ $jobFair->tanggal_mulai->format('d M Y') }} - {{ $jobFair->tanggal_selesai->format('d M Y') }}
    </p>
    @if($jobFair->deskripsi)
        <p class="mb-0">{{ $jobFair->deskripsi }}</p>
    @endif
</div>

{{-- Register a job --}}
<div class="job-items mb-3">
    <h5 class="mb-3">Daftarkan Lowongan</h5>

    @php
        $registrationOpen = $jobFair->isRegistrationOpen();
        $hasCapacity = $jobFair->hasCapacity();
        $registered = $jobFair->registeredCount();
    @endphp

    <p class="text-muted small mb-2">
        Kuota terpakai: <strong>{{ $registered }}</strong> / {{ $jobFair->kuota ?? 'tanpa batas' }}
        @if(!$registrationOpen)
            &middot; <span class="text-danger">Pendaftaran ditutup</span>
        @elseif(!$hasCapacity)
            &middot; <span class="text-danger">Kuota penuh</span>
        @endif
    </p>

    @if($jobs->isEmpty())
        <div class="alert alert-warning mb-0">Anda belum memiliki lowongan. Buat lowongan terlebih dahulu.</div>
    @elseif(!$registrationOpen)
        <div class="alert alert-secondary mb-0">Pendaftaran untuk job fair ini sudah ditutup.</div>
    @elseif(!$hasCapacity)
        <div class="alert alert-secondary mb-0">Kuota pendaftar untuk job fair ini sudah penuh.</div>
    @else
        <form action="{{ route('employer.job-fair.register', $jobFair) }}" method="POST" class="row">
            @csrf
            <div class="col-12 col-md-8 mb-2 mb-md-0">
                <select name="job_id" class="form-select">
                    @foreach($jobs as $job)
                        @if(!in_array($job->id, $registeredJobIds))
                            <option value="{{ $job->id }}">{{ $job->nama_pekerjaan }} ({{ $job->posisi }})</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-4">
                @if(count($registeredJobIds) < $jobs->count())
                    <button type="submit" class="btn btn-primary btn-sm">Daftarkan</button>
                @else
                    <span class="text-muted">Semua lowongan sudah terdaftar</span>
                @endif
            </div>
        </form>
    @endif
</div>

{{-- Registered jobs --}}
@if($registrations->isNotEmpty())
<div class="job-items mb-3">
    <h5 class="mb-3">Lowongan Terdaftar</h5>
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Lowongan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($registrations as $reg)
                <tr>
                    <td>{{ $reg->nama_pekerjaan }}</td>
                    <td>
                        @if($reg->status === 'pending')
                            <span class="badge bg-warning text-dark">Menunggu</span>
                        @elseif($reg->status === 'approved')
                            <span class="badge bg-success">Disetujui</span>
                        @else
                            <span class="badge bg-danger">Ditolak</span>
                        @endif
                    </td>
                    <td>
                        @if($reg->status === 'pending')
                            <form action="{{ route('employer.job-fair.cancel', [$jobFair, $reg->job_id]) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Batalkan pendaftaran?')">Batalkan</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection
