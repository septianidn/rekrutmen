@extends('frontoffice.jobseeker.templates.body')
@section('applications', 'active')
@section('content')

<section class="find-job job-list">
    <div class="container">
        <h4 class="mb-4">Lamaran Saya</h4>

        @if($applications->isEmpty())
            <div class="alert alert-info">Anda belum melamar pekerjaan apapun.</div>
        @else
            @foreach($applications as $app)
            <div class="single-job mb-3" style="border-left: 4px solid {{ $app->status === 'accepted' ? '#28a745' : ($app->status === 'rejected' ? '#dc3545' : '#ffc107') }};">
                <div class="job-content">
                    <h4>{{ $app->job->nama_pekerjaan }}</h4>
                    <p class="mb-1">
                        <strong>{{ $app->job->employer->nama_perusahaan ?? '-' }}</strong>
                    </p>
                    <ul>
                        <li><i class="lni lni-map-marker"></i> {{ $app->job->alamat }}</li>
                        <li><i class="lni lni-dollar"></i> Rp.{{ number_format($app->job->ekspektasi_gaji, 0, ',', '.') }}</li>
                        <li><i class="lni lni-calendar"></i> Dilamar: {{ $app->tanggal_apply->format('d M Y') }}</li>
                    </ul>
                </div>
                <div class="job-button">
                    <ul>
                        <li>
                            @if($app->status === 'pending')
                                <span class="badge bg-warning text-dark px-3 py-2">Menunggu</span>
                            @elseif($app->status === 'accepted')
                                <span class="badge bg-success px-3 py-2">Diterima</span>
                            @elseif($app->status === 'rejected')
                                <span class="badge bg-danger px-3 py-2">Ditolak</span>
                            @endif
                        </li>
                        <li><span>{{ $app->job->worktime }}</span></li>
                    </ul>
                </div>
            </div>
            @endforeach
        @endif
    </div>
</section>

@endsection
