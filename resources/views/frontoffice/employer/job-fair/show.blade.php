@extends('frontoffice.employer.index')
@section('jobfair', 'active')
@section('content')

<div class="job-items">
    <div class="mb-3">
        <a href="{{ route('employer.job-fair.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Kembali</a>
    </div>

    <h4 class="mb-1">{{ $jobFair->nama }}</h4>
    <p class="text-muted">
        <i class="lni lni-map-marker"></i> {{ $jobFair->lokasi }} &middot;
        {{ $jobFair->tanggal_mulai->format('d M Y') }} - {{ $jobFair->tanggal_selesai->format('d M Y') }}
    </p>
    @if($jobFair->deskripsi)
        <p>{{ $jobFair->deskripsi }}</p>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <hr>

    {{-- Register a job --}}
    <h5>Daftarkan Lowongan</h5>
    @if($jobs->isEmpty())
        <div class="alert alert-warning">Anda belum memiliki lowongan. Buat lowongan terlebih dahulu.</div>
    @else
        <form action="{{ route('employer.job-fair.register', $jobFair) }}" method="POST" class="row mb-4">
            @csrf
            <div class="col-md-8">
                <select name="job_id" class="form-select">
                    @foreach($jobs as $job)
                        @if(!in_array($job->id, $registeredJobIds))
                            <option value="{{ $job->id }}">{{ $job->nama_pekerjaan }} ({{ $job->posisi }})</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                @if(count($registeredJobIds) < $jobs->count())
                    <button type="submit" class="btn btn-primary btn-sm">Daftarkan</button>
                @else
                    <span class="text-muted">Semua lowongan sudah terdaftar</span>
                @endif
            </div>
        </form>
    @endif

    {{-- Registered jobs --}}
    @if($registrations->isNotEmpty())
    <h5>Lowongan Terdaftar</h5>
    <div class="table-responsive">
        <table class="table table-striped">
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
    @endif
</div>

@endsection
