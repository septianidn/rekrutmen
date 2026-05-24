@extends('frontoffice.employer.index')
@section('membership', 'active')
@section('page-title', 'Pembayaran Manual')
@section('page-subtitle', 'Transfer ke rekening di bawah, lalu unggah bukti transfer.')
@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">@foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
    </div>
@endif

<div class="row">
    <div class="col-md-5 mb-3">
        <div class="job-items h-100">
            <h5 class="mb-3"><i class="lni lni-package me-1"></i> Detail Paket</h5>
            <h4 class="mb-1">{{ $membership->nama_membership }}</h4>
            <div class="mb-2" style="font-size: 26px; font-weight: 700; color: #2042e3;">
                Rp {{ number_format($membership->harga, 0, ',', '.') }}
            </div>
            <small class="text-muted d-block mb-3">untuk {{ $membership->durasi_hari }} hari</small>
            @if($membership->deskripsi)
                <p class="text-muted small">{{ $membership->deskripsi }}</p>
            @endif
            <hr>
            <div class="small">
                @if($membership->can_post_job)
                    <div class="mb-1"><i class="lni lni-checkmark-circle text-success me-1"></i> Posting lowongan</div>
                @endif
                @if($membership->can_post_article)
                    <div class="mb-1"><i class="lni lni-checkmark-circle text-success me-1"></i> Posting artikel</div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-7 mb-3">
        <div class="job-items">
            <h5 class="mb-3"><i class="lni lni-bank me-1"></i> Rekening Tujuan Transfer</h5>

            @foreach($accounts as $account)
                <div class="card border mb-2" style="border-left: 4px solid #2042e3 !important;">
                    <div class="card-body p-3">
                        <div class="text-muted small">{{ $account->nama_bank }}</div>
                        <div class="fw-bold" style="font-size: 18px; letter-spacing: 1px;">
                            <code style="background: #f1f3f5; padding: 4px 10px; border-radius: 6px;">{{ $account->nomor_rekening }}</code>
                        </div>
                        <div class="small">a.n. <strong>{{ $account->nama_pemilik }}</strong></div>
                    </div>
                </div>
            @endforeach

            <div class="alert alert-info mt-3 small">
                <i class="lni lni-information me-1"></i>
                Transfer <strong>tepat sebesar Rp {{ number_format($membership->harga, 0, ',', '.') }}</strong>
                untuk mempermudah verifikasi admin.
            </div>

            <hr>

            <h5 class="mb-3 mt-4"><i class="lni lni-cloud-upload me-1"></i> Unggah Bukti Transfer</h5>

            <form method="POST" action="{{ route('employer.membership.manual-checkout.submit', $membership) }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Pilih Rekening yang Anda Tuju</label>
                    <select name="account_id" class="form-select" required>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}">
                                {{ $account->nama_bank }} — {{ $account->nomor_rekening }} ({{ $account->nama_pemilik }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Bukti Transfer</label>
                    <input type="file" name="bukti_transfer" class="form-control" accept="image/jpeg,image/png,application/pdf" required>
                    <small class="text-muted">Format: JPG/PNG/PDF, maks 2 MB.</small>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('employer.membership.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="lni lni-cloud-upload me-1"></i> Kirim Bukti Transfer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
