@extends('frontoffice.employer.index')
@section('article', 'active')
@section('page-title', 'Artikel')
@section('page-subtitle', 'Kelola artikel yang Anda terbitkan di Pusat Karir Unand.')
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

<div class="job-items mb-3">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h5 class="mb-0"><i class="lni lni-write me-1"></i> Artikel Saya</h5>
        <a href="{{ route('employer.article.create') }}" class="btn btn-primary btn-sm">
            <i class="lni lni-plus me-1"></i> Tulis Artikel Baru
        </a>
    </div>

    <ul class="nav nav-tabs mb-3">
        @foreach([
            'all'      => ['Semua', 'secondary'],
            'pending'  => ['Menunggu', 'warning'],
            'approved' => ['Disetujui', 'success'],
            'rejected' => ['Ditolak', 'danger'],
        ] as $key => [$label, $cls])
            <li class="nav-item">
                <a class="nav-link {{ $status === $key ? 'active' : '' }}"
                   href="{{ route('employer.article.index', ['status' => $key]) }}">
                    {{ $label }}
                    <span class="badge bg-{{ $cls }} ms-1">{{ $counts[$key] }}</span>
                </a>
            </li>
        @endforeach
    </ul>

    @if($articles->isEmpty())
        <div class="alert alert-info mb-0">
            @if($status === 'all')
                Belum ada artikel. Klik <strong>Tulis Artikel Baru</strong> untuk memulai.
            @else
                Tidak ada artikel dengan status ini.
            @endif
        </div>
    @else
        @foreach($articles as $a)
            @php
                [$borderColor, $statusBg, $statusColor, $statusLabel, $statusIcon] = match($a->status) {
                    'approved' => ['#28a745', '#d4edda', '#155724', 'Disetujui', 'lni-checkmark-circle'],
                    'pending'  => ['#ffc107', '#fff3cd', '#856404', 'Menunggu',  'lni-timer'],
                    'rejected' => ['#dc3545', '#f8d7da', '#721c24', 'Ditolak',   'lni-close'],
                    default    => ['#adb5bd', '#f1f3f5', '#383d41', ucfirst($a->status), 'lni-question-circle'],
                };
            @endphp
            <div class="card border mb-2" style="border-left: 4px solid {{ $borderColor }} !important;">
                <div class="card-body p-3">
                    <div class="d-flex gap-3 align-items-start flex-wrap">
                        @if($a->cover_image)
                            <img src="{{ $a->cover_url }}" alt="" style="width:80px;height:80px;object-fit:cover;border-radius:8px;flex-shrink:0;">
                        @else
                            <div style="width:80px;height:80px;border-radius:8px;background:#f1f3f5;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="lni lni-write" style="font-size:28px;color:#adb5bd;"></i>
                            </div>
                        @endif
                        <div class="flex-grow-1" style="min-width: 0; overflow: hidden;">
                            <h6 class="mb-1" style="overflow-wrap: anywhere; word-break: break-word;">
                                <a href="{{ route('employer.article.show', $a) }}" class="text-dark text-decoration-none">{{ $a->judul }}</a>
                            </h6>
                            <small class="text-muted d-block">
                                <i class="lni lni-calendar me-1"></i>{{ $a->created_at->format('d M Y H:i') }}
                                @if($a->kategori)
                                    <span class="mx-2">·</span>
                                    <span class="badge bg-light text-dark">{{ $a->kategori }}</span>
                                @endif
                            </small>
                            @if($a->status === 'rejected' && $a->admin_note)
                                <small class="text-danger d-block mt-1" style="overflow-wrap: anywhere; word-break: break-word;">
                                    <i class="lni lni-warning me-1"></i> Catatan admin: {{ \Illuminate\Support\Str::limit($a->admin_note, 100) }}
                                </small>
                            @endif
                            @if($a->isi)
                                <p class="text-muted small mb-0 mt-1" style="overflow-wrap: anywhere; word-break: break-word;">{{ \Illuminate\Support\Str::limit(strip_tags($a->isi), 140) }}</p>
                            @endif
                        </div>
                        <div class="text-end" style="flex-shrink:0;">
                            <span style="font-size:11px;padding:4px 10px;border-radius:999px;background:{{ $statusBg }};color:{{ $statusColor }};font-weight:600;">
                                <i class="lni {{ $statusIcon }} me-1"></i>{{ $statusLabel }}
                            </span>
                            <div class="mt-2">
                                <a href="{{ route('employer.article.show', $a) }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="lni lni-eye"></i>
                                </a>
                                <a href="{{ route('employer.article.edit', $a) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="lni lni-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('employer.article.destroy', $a) }}" class="d-inline"
                                      onsubmit="return confirm('Hapus artikel ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="lni lni-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="mt-3">{{ $articles->links() }}</div>
    @endif
</div>

@endsection
