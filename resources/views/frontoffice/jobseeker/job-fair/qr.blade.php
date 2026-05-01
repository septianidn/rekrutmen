@extends('frontoffice.jobseeker.templates.body')
@section('jobfair', 'active')
@section('page-title', 'QR Code Saya')
@section('page-subtitle', 'Tunjukkan QR ini saat hadir di job fair.')
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
@if(session('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="mb-3">
    <a href="{{ route('jobseeker.job-fair.show', $jobFair) }}" class="btn btn-outline-secondary btn-sm">&larr; Kembali</a>
</div>

{{-- Personal QR --}}
<div class="resume mb-3">
    <div class="inner-content text-center">
        <h5 class="mb-1">{{ $jobFair->nama }}</h5>
        <p class="text-muted small mb-3">{{ $jobFair->lokasi }} &middot; {{ $jobFair->tanggal_mulai->format('d M Y') }}</p>

        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(180)->generate($attendance->kode_qr) !!}
        <p class="mt-2 mb-0 font-monospace fs-5 text-secondary">{{ $attendance->kode_qr }}</p>
        <p class="small text-muted">Tunjukkan kepada petugas di pintu masuk dan kepada employer.</p>

        @if($attendance->isCheckedIn())
            <span class="badge bg-success px-3 py-2">
                <i class="lni lni-checkmark"></i> Check-in: {{ $attendance->checked_in_at->format('d M Y H:i') }}
            </span>
        @else
            <div class="alert alert-warning mt-3 mb-0">
                Belum check-in. Scan QR pintu masuk saat tiba di venue.
            </div>
        @endif
    </div>
</div>

{{-- Check-in form (manual input for dev/demo) --}}
@if(!$attendance->isCheckedIn())
<div class="resume mb-3">
    <div class="inner-content">
        <h6 class="mb-2">Check-in di Pintu Masuk</h6>
        <p class="small text-muted mb-2">Masukkan ID job fair yang ditampilkan petugas (untuk demo: <code>{{ $jobFair->id }}</code>).</p>
        <form action="{{ route('jobseeker.job-fair.checkin') }}" method="POST" class="row g-2">
            @csrf
            <div class="col-8 col-md-4">
                <input type="text" name="kode_fair" class="form-control form-control-sm"
                       placeholder="ID Job Fair" value="{{ old('kode_fair') }}">
            </div>
            <div class="col-4">
                <button type="submit" class="btn btn-sm btn-success">Check-in</button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- Booth scan form --}}
@if($attendance->isCheckedIn())
<div class="resume mb-3">
    <div class="inner-content">
        <h6 class="mb-2">Scan Booth Employer</h6>
        <p class="small text-muted mb-2">Masukkan kode booth yang tertera di QR booth employer.</p>
        <form action="{{ route('jobseeker.job-fair.booth-scan') }}" method="POST" class="row g-2" id="boothScanForm">
            @csrf
            <div class="col-12 col-md-4 mb-2">
                <input type="text" name="kode_booth" id="kode_booth" class="form-control form-control-sm"
                       placeholder="BOOTH-XXXXX" value="{{ old('kode_booth') }}" autocomplete="off">
            </div>
            <div class="col-12 col-md-4 mb-2">
                <select name="job_id" id="job_id" class="form-select form-select-sm">
                    <option value="">-- Pilih posisi --</option>
                </select>
                <div class="form-text" id="boothHint">Isi kode booth dulu untuk melihat posisi yang tersedia.</div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-sm btn-primary">Masuk Antrian</button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- My queue entries --}}
@if($myScans->isNotEmpty())
<div class="resume mb-3">
    <div class="inner-content">
        <h6 class="mb-3">Booth yang Sudah Dikunjungi</h6>
        @foreach($myScans as $scan)
        <div class="d-flex justify-content-between align-items-start border-bottom py-2 flex-wrap gap-2">
            <div>
                <strong>{{ $scan->jobFairJob->employer->nama_perusahaan ?? '-' }}</strong>
                @if($scan->jobFairJob->lokasi_booth)
                    <span class="text-muted small ms-1">— {{ $scan->jobFairJob->lokasi_booth }}</span>
                @endif
                <br>
                <small class="text-muted">{{ $scan->job->nama_pekerjaan }}</small>
            </div>
            <div class="text-end">
                @if($scan->status === 'menunggu')
                    <span class="badge bg-secondary">Menunggu</span>
                @elseif($scan->status === 'dipanggil')
                    <span class="badge bg-warning text-dark">Dipanggil!</span>
                    <form action="{{ route('jobseeker.job-fair.queue.ack', $scan) }}" method="POST" class="mt-1">
                        @csrf
                        <button type="submit" class="btn btn-xs btn-sm btn-outline-warning">Sedang Menuju</button>
                    </form>
                @elseif($scan->status === 'sedang_diproses')
                    <span class="badge bg-primary">Sedang Diproses</span>
                @elseif($scan->status === 'selesai')
                    <span class="badge bg-success">Selesai</span>
                @elseif($scan->status === 'tidak_hadir')
                    <span class="badge bg-danger">Tidak Hadir</span>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

@push('scripts')
<script>
document.getElementById('kode_booth')?.addEventListener('change', function () {
    const kode = this.value.trim();
    const select = document.getElementById('job_id');
    const hint   = document.getElementById('boothHint');

    if (!kode) return;

    fetch('/jobseeker/job-fair/booth-jobs?kode_booth=' + encodeURIComponent(kode))
        .then(r => r.json())
        .then(jobs => {
            select.innerHTML = '<option value="">-- Pilih posisi --</option>';
            jobs.forEach(j => {
                select.innerHTML += `<option value="${j.id}">${j.nama_pekerjaan}</option>`;
            });
            hint.textContent = jobs.length ? '' : 'Kode booth tidak ditemukan atau booth belum aktif.';
        })
        .catch(() => { hint.textContent = 'Gagal memuat posisi.'; });
});
</script>
@endpush

@endsection
