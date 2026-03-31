@extends('frontoffice.jobseeker.templates.body')
@section('jobs', 'active')
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

<section class="find-job job-list">
    <div class="container">
        <div class="single-head">
            <div class="row">
                <div class="col-lg-6 col-12">
                    @foreach ($jobs as $j)
                    <div class="single-job">
                        <div class="job-image">
                            <img src="{{ asset('assets/images/jobs/img1.png') }}" alt="#">
                        </div>
                        <div class="job-content">
                            <h4><a href="#">{{ $j->nama_pekerjaan }}</a></h4>
                            <p>{!! Str::limit(strip_tags($j->deskripsi_pekerjaan), 100) !!}</p>
                            <ul>
                                <li><i class="lni lni-briefcase"></i> {{ $j->employer->nama_perusahaan ?? '-' }}</li>
                                <li><i class="lni lni-dollar"></i> Rp.{{ number_format($j->ekspektasi_gaji, 0, ',', '.') }}</li>
                                <li><i class="lni lni-map-marker"></i> {{ $j->alamat }}</li>
                            </ul>
                        </div>
                        <div class="job-button">
                            <ul>
                                @if(in_array($j->id, $appliedJobIds))
                                    <li><span class="badge bg-info text-white px-3 py-2">Sudah Dilamar</span></li>
                                @else
                                    <li>
                                        <form action="{{ route('jobseeker.jobs.apply', $j->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Apakah Anda yakin ingin melamar pekerjaan ini?')">Apply</button>
                                        </form>
                                    </li>
                                @endif
                                <li><span>{{ $j->worktime }}</span></li>
                            </ul>
                        </div>
                    </div>
                    @endforeach
                </div>
                {{ $jobs->links('components.paginate') }}
            </div>
        </div>
    </div>
</section>

@endsection
