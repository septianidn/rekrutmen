@extends('frontoffice.employer.index')
@section('membership', 'active')
@section('page-title', 'Membership')
@section('page-subtitle', 'Kelola langganan posting lowongan dan artikel.')
@section('content')

<style>
    .tier-card {
        transition: transform .2s ease, box-shadow .2s ease;
        border: 2px solid #eef0f7;
        border-radius: 14px;
        overflow: hidden;
    }
    .tier-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 30px rgba(32, 66, 227, 0.10);
    }
    .tier-card.tier-recommended {
        border-color: #2042e3;
        box-shadow: 0 8px 22px rgba(32, 66, 227, 0.12);
    }
    .tier-icon-wrap {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    .tier-feature {
        display: flex;
        align-items: center;
        padding: 6px 0;
        font-size: 14px;
    }
    .tier-feature .check {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
        font-size: 12px;
    }
    .tier-feature.on .check { background: #d4edda; color: #28a745; }
    .tier-feature.off .check { background: #f1f3f5; color: #adb5bd; }
    .tier-feature.off { color: #adb5bd; text-decoration: line-through; }
    .tier-recommended-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: linear-gradient(135deg, #2042e3 0%, #764ba2 100%);
        color: #fff;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .3px;
    }
    .tier-current-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: #28a745;
        color: #fff;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
    }
    .history-status-pill {
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 999px;
        font-weight: 600;
    }
    .status-row {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .status-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: rgba(255,255,255,.18);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        color: #fff;
        flex-shrink: 0;
    }
</style>

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

{{-- ── STATUS HERO ─────────────────────────────────────── --}}
@if($activeContract)
    <div class="job-items mb-3" style="background: linear-gradient(135deg, #fd7e14 0%, #e67e22 100%); color: #fff;">
        <div class="status-row">
            <div class="status-icon"><i class="lni lni-handshake"></i></div>
            <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <h4 class="mb-0 text-white">Mitra Kerja Aktif</h4>
                    <span class="badge bg-light text-dark">Tanpa Biaya</span>
                </div>
                <p class="mb-1" style="opacity: .9;">
                    Akun Anda terdaftar sebagai mitra kerja Pusat Karir Unand.
                    Berlaku <strong>{{ $activeContract->tanggal_mulai->format('d M Y') }}</strong>
                    sampai <strong>{{ $activeContract->tanggal_berakhir->format('d M Y') }}</strong>.
                </p>
                <small style="opacity: .85;">
                    <i class="lni lni-checkmark-circle me-1"></i> Posting lowongan
                    <span class="mx-2">·</span>
                    <i class="lni lni-checkmark-circle me-1"></i> Posting artikel (perlu disetujui admin)
                </small>
            </div>
        </div>
    </div>
@elseif($activeMemberships->isNotEmpty())
    <div class="job-items mb-3" style="background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); color: #fff;">
        <div class="status-row">
            <div class="status-icon"><i class="lni lni-checkmark-circle"></i></div>
            <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                    <h4 class="mb-0 text-white">
                        @if($activeMemberships->count() === 1)
                            {{ $activeMemberships->first()->membership->nama_membership ?? 'Membership Aktif' }}
                        @else
                            {{ $activeMemberships->count() }} Membership Aktif
                        @endif
                    </h4>
                    <span class="badge bg-light text-dark">Aktif</span>
                </div>

                @if($activeMemberships->count() === 1)
                    @php $first = $activeMemberships->first(); @endphp
                    <p class="mb-1" style="opacity: .9;">
                        Berlaku sampai <strong>{{ $first->tgl_berakhir?->format('d M Y') }}</strong>
                        @if($first->tgl_berakhir)
                            ({{ now()->startOfDay()->diffInDays($first->tgl_berakhir, false) }} hari lagi)
                        @endif
                    </p>
                @else
                    <ul class="mb-1 ps-3" style="opacity: .9; list-style: none;">
                        @foreach($activeMemberships as $am)
                            <li>
                                <i class="lni lni-package me-1"></i>
                                <strong>{{ $am->membership->nama_membership ?? '-' }}</strong>
                                — sampai {{ $am->tgl_berakhir?->format('d M Y') }}
                                @if($am->tgl_berakhir)
                                    ({{ now()->startOfDay()->diffInDays($am->tgl_berakhir, false) }} hari)
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif

                <small style="opacity: .85;">
                    Akses:
                    @if($hasJobAccess)
                        <i class="lni lni-checkmark-circle me-1"></i>Posting lowongan
                    @endif
                    @if($hasJobAccess && $hasArticleAccess)
                        <span class="mx-2">·</span>
                    @endif
                    @if($hasArticleAccess)
                        <i class="lni lni-checkmark-circle me-1"></i>Posting artikel (perlu disetujui admin)
                    @endif
                </small>
            </div>
        </div>
    </div>
@elseif($awaitingVerification)
    <div class="job-items mb-3" style="background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%); color: #fff;">
        <div class="status-row">
            <div class="status-icon"><i class="lni lni-shield"></i></div>
            <div class="flex-grow-1">
                <h4 class="mb-1 text-white">Menunggu Verifikasi Admin</h4>
                <p class="mb-1" style="opacity: .9;">
                    Bukti transfer untuk paket
                    <strong>{{ $awaitingVerification->membership->nama_membership ?? '-' }}</strong>
                    sudah diunggah {{ $awaitingVerification->created_at->diffForHumans() }}.
                </p>
                <small style="opacity: .85;">
                    <i class="lni lni-information me-1"></i>
                    Membership akan aktif otomatis setelah admin memverifikasi pembayaran Anda
                    (biasanya 1x24 jam kerja).
                </small>
            </div>
        </div>
    </div>
@elseif($pendingPembayaran)
    <div class="job-items mb-3" style="background: linear-gradient(135deg, #ffc107 0%, #f0a500 100%); color: #fff;">
        <div class="status-row">
            <div class="status-icon"><i class="lni lni-timer"></i></div>
            <div class="flex-grow-1">
                <h4 class="mb-1 text-white">Pembayaran Menunggu</h4>
                <p class="mb-2" style="opacity: .9;">
                    Paket <strong>{{ $pendingPembayaran->membership->nama_membership ?? '-' }}</strong>
                    dibuat {{ $pendingPembayaran->created_at->diffForHumans() }}.
                </p>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('employer.membership.checkout.resume', $pendingPembayaran) }}" class="btn btn-light btn-sm">
                        <i class="lni lni-credit-cards me-1"></i> Lanjutkan Pembayaran
                    </a>
                    <form method="POST" action="{{ route('employer.membership.checkout.cancel', $pendingPembayaran) }}"
                          onsubmit="return confirm('Batalkan pembayaran ini dan pilih paket lain?')">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">
                            <i class="lni lni-close me-1"></i> Batalkan & Pilih Paket Lain
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="job-items mb-3" style="background: linear-gradient(135deg, #2042e3 0%, #764ba2 100%); color: #fff;">
        <div class="status-row">
            <div class="status-icon"><i class="lni lni-tag"></i></div>
            <div class="flex-grow-1">
                <h4 class="mb-1 text-white">Belum Berlangganan</h4>
                <p class="mb-0" style="opacity: .9;">
                    Pilih paket di bawah untuk mulai memposting lowongan atau artikel di Pusat Karir Unand.
                </p>
            </div>
        </div>
    </div>
@endif

{{-- ── PACKAGE TIERS ──────────────────────────────────── --}}
<div class="job-items mb-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0"><i class="lni lni-package me-1"></i> Pilih Paket Langganan</h5>
        <small class="text-muted">{{ $memberships->count() }} paket tersedia</small>
    </div>

    <div class="row">
        @foreach($memberships as $m)
            @php
                $isFull        = $m->can_post_job && $m->can_post_article;
                $isJobOnly     = $m->can_post_job && !$m->can_post_article;
                $tierIcon      = $isFull ? 'lni-crown' : ($isJobOnly ? 'lni-briefcase' : 'lni-write');
                $tierColor     = $isFull ? '#2042e3' : ($isJobOnly ? '#28a745' : '#764ba2');
                $tierBg        = $isFull ? '#e8edff' : ($isJobOnly ? '#d4edda' : '#f3eaff');
                $isCurrent     = $activeMemberships->contains('membership_id', $m->id);
                $isPendingTier = $pendingPembayaran && $pendingPembayaran->membership_id === $m->id;

                // What new capability does this tier add on top of what user already has?
                $addsJob       = $m->can_post_job && !$hasJobAccess;
                $addsArticle   = $m->can_post_article && !$hasArticleAccess;
                $addsNothing   = !$addsJob && !$addsArticle;

                $addsHint = null;
                if ($addsJob && $addsArticle) {
                    $addsHint = null; // user has nothing — no hint needed, tier speaks for itself
                } elseif ($addsJob) {
                    $addsHint = 'menambah akses lowongan';
                } elseif ($addsArticle) {
                    $addsHint = 'menambah akses artikel';
                }

                // Detect overlap warning: tier covers a capability user already has,
                // AND a cheaper alternative exists that provides only what's missing
                $redundantJob     = $m->can_post_job && $hasJobAccess;
                $redundantArticle = $m->can_post_article && $hasArticleAccess;
                $hasRedundancy    = $redundantJob || $redundantArticle;

                $cheaperAlternative = null;
                $overlapExpiry = null;

                if ($hasRedundancy && !$addsNothing) {
                    $cheaperAlternative = $memberships
                        ->reject(fn ($alt) => $alt->id === $m->id)
                        ->reject(fn ($alt) => $alt->harga >= $m->harga)
                        ->filter(function ($alt) use ($addsJob, $addsArticle) {
                            // Must cover everything user actually needs
                            if ($addsJob && !$alt->can_post_job) return false;
                            if ($addsArticle && !$alt->can_post_article) return false;
                            return true;
                        })
                        ->sortBy('harga')
                        ->first();

                    $overlapExpiry = $activeMemberships
                        ->filter(function ($am) use ($redundantJob, $redundantArticle) {
                            if (!$am->membership) return false;
                            return ($redundantJob && $am->membership->can_post_job)
                                || ($redundantArticle && $am->membership->can_post_article);
                        })
                        ->max('tgl_berakhir');
                }

                $overlapLabel = match (true) {
                    $redundantJob && $redundantArticle => 'lowongan dan artikel',
                    $redundantJob                       => 'lowongan',
                    $redundantArticle                   => 'artikel',
                    default                              => null,
                };
            @endphp
            <div class="col-md-4 mb-3">
                <div class="card h-100 tier-card position-relative {{ $isFull ? 'tier-recommended' : '' }}">
                    @if($isCurrent)
                        <span class="tier-current-badge"><i class="lni lni-checkmark-circle me-1"></i>Aktif</span>
                    @elseif($isFull && !$hasJobAccess && !$hasArticleAccess)
                        <span class="tier-recommended-badge">PALING POPULER</span>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <div class="tier-icon-wrap mb-3" style="background: {{ $tierBg }}; color: {{ $tierColor }};">
                            <i class="lni {{ $tierIcon }}"></i>
                        </div>
                        <h5 class="card-title mb-1" style="color: {{ $tierColor }};">{{ $m->nama_membership }}</h5>
                        <div class="mb-3">
                            <span style="font-size: 28px; font-weight: 700; color: #1d2939;">
                                Rp {{ number_format($m->harga, 0, ',', '.') }}
                            </span>
                            <small class="text-muted d-block">untuk {{ $m->durasi_hari }} hari</small>
                        </div>
                        @if($m->deskripsi)
                            <p class="text-muted small mb-3">{{ $m->deskripsi }}</p>
                        @endif

                        <div class="mb-3">
                            <div class="tier-feature {{ $m->can_post_job ? 'on' : 'off' }}">
                                <span class="check">
                                    <i class="lni {{ $m->can_post_job ? 'lni-checkmark' : 'lni-close' }}"></i>
                                </span>
                                Posting lowongan
                            </div>
                            <div class="tier-feature {{ $m->can_post_article ? 'on' : 'off' }}">
                                <span class="check">
                                    <i class="lni {{ $m->can_post_article ? 'lni-checkmark' : 'lni-close' }}"></i>
                                </span>
                                Posting artikel
                            </div>
                        </div>

                        <div class="mt-auto">
                            <form method="POST" action="{{ route('employer.membership.checkout') }}">
                                @csrf
                                <input type="hidden" name="membership_id" value="{{ $m->id }}">
                                @if($isCurrent)
                                    <button type="button" class="btn btn-success w-100" disabled>
                                        <i class="lni lni-checkmark-circle me-1"></i> Sedang Aktif
                                    </button>
                                @elseif($activeContract)
                                    <button type="button" class="btn btn-outline-secondary w-100" disabled>
                                        Mitra Kerja
                                    </button>
                                @elseif($awaitingVerification)
                                    <button type="button" class="btn btn-info w-100" disabled>
                                        <i class="lni lni-shield me-1"></i> Menunggu Verifikasi
                                    </button>
                                @elseif($isPendingTier)
                                    <button type="button" class="btn btn-warning w-100" disabled>
                                        <i class="lni lni-timer me-1"></i> Menunggu Pembayaran
                                    </button>
                                @elseif($addsNothing)
                                    <button type="button" class="btn btn-outline-secondary w-100" disabled>
                                        <i class="lni lni-checkmark me-1"></i> Sudah Tercakup
                                    </button>
                                @else
                                    <button type="submit" class="btn w-100"
                                        style="background: {{ $tierColor }}; color: #fff; border-color: {{ $tierColor }};">
                                        <i class="lni lni-credit-cards me-1"></i> Bayar via Midtrans
                                    </button>
                                    <a href="{{ route('employer.membership.manual-checkout', $m) }}" class="btn btn-outline-secondary w-100 mt-2">
                                        <i class="lni lni-bank me-1"></i> Bayar Manual (Transfer Bank)
                                    </a>
                                    @if($addsHint)
                                        <small class="text-muted d-block text-center mt-1" style="font-size: 11px;">
                                            ({{ $addsHint }})
                                        </small>
                                    @endif

                                @if($hasRedundancy && $overlapExpiry)
                                    <div class="mt-2" style="border-left: 3px solid #ffc107; background: #fff8e1; padding: 8px 10px; border-radius: 6px; font-size: 11px; line-height: 1.45;">
                                        <i class="lni lni-warning me-1" style="color: #f0a500;"></i>
                                        Akses <strong>{{ $overlapLabel }}</strong> sudah aktif sampai
                                        <strong>{{ \Carbon\Carbon::parse($overlapExpiry)->format('d M Y') }}</strong>.
                                        @if($cheaperAlternative)
                                            <span class="d-block mt-1">
                                                <strong>{{ $cheaperAlternative->nama_membership }}</strong>
                                                (Rp {{ number_format($cheaperAlternative->harga, 0, ',', '.') }})
                                                lebih hemat untuk menambah yang Anda butuhkan.
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            @endif
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- ── PAYMENT HISTORY ────────────────────────────────── --}}
@if($history->isNotEmpty())
    <div class="job-items mb-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0"><i class="lni lni-list me-1"></i> Riwayat Pembayaran</h5>
            <small class="text-muted">{{ $history->count() }} terakhir</small>
        </div>

        @foreach($history as $h)
            @php
                [$borderColor, $statusBg, $statusColor, $statusLabel, $statusIcon] = match($h->status) {
                    'lunas'                 => ['#28a745', '#d4edda', '#155724', 'Lunas',              'lni-checkmark-circle'],
                    'pending'               => ['#ffc107', '#fff3cd', '#856404', 'Pending',            'lni-timer'],
                    'awaiting_verification' => ['#17a2b8', '#d1ecf1', '#0c5460', 'Menunggu Verifikasi','lni-shield'],
                    'gagal'                 => ['#dc3545', '#f8d7da', '#721c24', 'Gagal',              'lni-close'],
                    'expired'               => ['#6c757d', '#e9ecef', '#383d41', 'Expired',            'lni-alarm-clock'],
                    default                 => ['#adb5bd', '#f1f3f5', '#383d41', ucfirst($h->status),  'lni-question-circle'],
                };
            @endphp
            <div class="card border mb-2" style="border-left: 4px solid {{ $borderColor }} !important;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h6 class="mb-1">{{ $h->membership->nama_membership ?? '-' }}</h6>
                            <small class="text-muted">
                                <i class="lni lni-calendar me-1"></i>{{ $h->created_at->format('d M Y H:i') }}
                                @if($h->tgl_mulai && $h->tgl_berakhir)
                                    <span class="mx-2">·</span>
                                    Berlaku {{ $h->tgl_mulai->format('d M Y') }} &mdash; {{ $h->tgl_berakhir->format('d M Y') }}
                                @endif
                            </small>
                            @if($h->midtrans_order_id)
                                <br><small class="text-muted" style="font-size: 11px;">
                                    <code style="background: #f1f3f5; padding: 1px 6px; border-radius: 4px;">{{ $h->midtrans_order_id }}</code>
                                </small>
                            @endif
                        </div>
                        <div class="text-end">
                            <div class="fw-bold mb-1" style="font-size: 16px;">
                                Rp {{ number_format($h->amount, 0, ',', '.') }}
                            </div>
                            <span class="history-status-pill" style="background: {{ $statusBg }}; color: {{ $statusColor }};">
                                <i class="lni {{ $statusIcon }} me-1"></i>{{ $statusLabel }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection
