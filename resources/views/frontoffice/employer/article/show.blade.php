@extends('frontoffice.employer.index')
@section('article', 'active')
@section('page-title', 'Pratinjau Artikel')
@section('page-subtitle', 'Tampilan artikel sebagaimana akan dilihat publik.')
@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Status banner --}}
@php
    [$bg, $icon, $title, $msg] = match($article->status) {
        'pending'  => [
            'linear-gradient(135deg, #ffc107 0%, #f0a500 100%)',
            'lni-timer',
            'Menunggu Persetujuan Admin',
            'Artikel ini belum tayang publik. Anda akan diberitahu setelah admin meninjau.'
        ],
        'approved' => [
            'linear-gradient(135deg, #28a745 0%, #1e7e34 100%)',
            'lni-checkmark-circle',
            'Disetujui &amp; Tayang',
            'Artikel ini tayang publik di /artikel/' . $article->slug . '. Diterbitkan ' . optional($article->published_at)->format('d M Y') . '.'
        ],
        'rejected' => [
            'linear-gradient(135deg, #dc3545 0%, #a71d2a 100%)',
            'lni-close',
            'Ditolak Admin',
            $article->admin_note ? 'Catatan admin: ' . $article->admin_note : 'Lihat catatan admin atau perbaiki dan kirim ulang.'
        ],
        default    => ['#6c757d', 'lni-question-circle', ucfirst($article->status), ''],
    };
@endphp

<div class="job-items mb-3" style="background: {{ $bg }}; color: #fff;">
    <div class="d-flex align-items-start gap-3">
        <div style="width:48px;height:48px;border-radius:12px;background:rgba(255,255,255,.18);display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;">
            <i class="lni {{ $icon }}"></i>
        </div>
        <div class="flex-grow-1">
            <h5 class="mb-1 text-white">{!! $title !!}</h5>
            <p class="mb-0" style="opacity:.9;font-size:14px;">{!! $msg !!}</p>
        </div>
        <div class="d-flex gap-2 flex-shrink-0">
            <a href="{{ route('employer.article.edit', $article) }}" class="btn btn-light btn-sm">
                <i class="lni lni-pencil me-1"></i> Edit
            </a>
            <form method="POST" action="{{ route('employer.article.destroy', $article) }}" class="d-inline"
                  onsubmit="return confirm('Hapus artikel ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-outline-light btn-sm">
                    <i class="lni lni-trash-can me-1"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Article preview --}}
<div class="job-items">
    @if($article->cover_image)
        <img src="{{ $article->cover_url }}" alt="" style="width:100%;max-height:360px;object-fit:cover;border-radius:8px;margin-bottom:16px;">
    @endif

    @if($article->kategori)
        <span class="badge bg-light text-dark mb-2">
            <i class="lni lni-tag me-1"></i>{{ $article->kategori }}
        </span>
    @endif

    <h2 class="mb-2" style="color:#1d2939;">{{ $article->judul }}</h2>

    <p class="text-muted small mb-3">
        <i class="lni lni-user me-1"></i>{{ $article->employer->nama_perusahaan ?? '-' }}
        <span class="mx-2">·</span>
        <i class="lni lni-calendar me-1"></i>{{ $article->created_at->format('d M Y') }}
        @if($article->isApproved() && $article->published_at)
            <span class="mx-2">·</span>
            <span class="text-success">Diterbitkan {{ $article->published_at->format('d M Y') }}</span>
        @endif
    </p>

    <hr>

    <div style="white-space: pre-wrap; line-height: 1.7; font-size: 15px; overflow-wrap: anywhere; word-break: break-word; max-width: 100%;">{{ $article->isi }}</div>

    <hr class="mt-4">

    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <small class="text-muted">
            URL:
            @if($article->isApproved())
                <a href="{{ route('artikel.show', $article->slug) }}" target="_blank">
                    <code>/artikel/{{ $article->slug }}</code>
                </a>
            @else
                <code>/artikel/{{ $article->slug }}</code>
                <span class="ms-2 text-warning">(belum tayang publik)</span>
            @endif
        </small>
        <a href="{{ route('employer.article.index') }}" class="btn btn-link btn-sm">
            <i class="lni lni-arrow-left me-1"></i> Kembali ke Daftar Artikel
        </a>
    </div>
</div>

@endsection
