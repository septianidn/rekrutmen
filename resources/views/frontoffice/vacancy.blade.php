<x-front-office-layout>
    <section class="section" style="padding-top: 120px; min-height: 80vh;">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h3>Lowongan Pekerjaan</h3>
                    <p class="text-muted">Temukan lowongan pekerjaan terbaru dari berbagai perusahaan.</p>
                </div>
            </div>

            <div class="row">
                @forelse($jobs as $job)
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="card border h-100" style="border-left: 4px solid #2042e3 !important;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-1">{{ $job->nama_pekerjaan }}</h5>
                            <p class="text-muted mb-2"><strong>{{ $job->employer->nama_perusahaan ?? '-' }}</strong></p>
                            <p class="small mb-3">{!! Str::limit(strip_tags($job->deskripsi_pekerjaan), 100) !!}</p>
                            <ul class="list-unstyled small text-muted mt-auto mb-0">
                                <li class="mb-1"><i class="lni lni-map-marker me-1"></i>{{ $job->alamat }}</li>
                                <li class="mb-1"><i class="lni lni-dollar me-1"></i>Rp.{{ number_format($job->ekspektasi_gaji, 0, ',', '.') }}</li>
                                <li class="mb-1"><i class="lni lni-briefcase me-1"></i>{{ $job->worktime }}</li>
                                @if($job->application_deadline)
                                <li><i class="lni lni-calendar me-1"></i>Deadline: {{ \Carbon\Carbon::parse($job->application_deadline)->format('d M Y') }}</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info">Belum ada lowongan tersedia saat ini.</div>
                </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $jobs->links('components.paginate') }}
            </div>
        </div>
    </section>

    @guest
        @include('partials.frontoffice._auth_modals')
    @endguest
</x-front-office-layout>
