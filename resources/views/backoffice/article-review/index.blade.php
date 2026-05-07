<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Review Artikel</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('info'))
                        <div class="alert alert-info">{{ session('info') }}</div>
                    @endif

                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item">
                            <a class="nav-link {{ $status === 'pending' ? 'active' : '' }}"
                               href="{{ route('backoffice.article-review.index', ['status' => 'pending']) }}">
                                Menunggu <span class="badge bg-warning ms-1">{{ $counts['pending'] }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $status === 'approved' ? 'active' : '' }}"
                               href="{{ route('backoffice.article-review.index', ['status' => 'approved']) }}">
                                Disetujui <span class="badge bg-success ms-1">{{ $counts['approved'] }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $status === 'rejected' ? 'active' : '' }}"
                               href="{{ route('backoffice.article-review.index', ['status' => 'rejected']) }}">
                                Ditolak <span class="badge bg-danger ms-1">{{ $counts['rejected'] }}</span>
                            </a>
                        </li>
                    </ul>

                    <style>
                        .article-review-table { table-layout: fixed; width: 100%; }
                        .article-review-table td,
                        .article-review-table th {
                            overflow: hidden;
                            word-break: break-word;
                            overflow-wrap: anywhere;
                            vertical-align: top;
                        }
                        .article-review-table .cell-truncate {
                            display: -webkit-box;
                            -webkit-line-clamp: 2;
                            -webkit-box-orient: vertical;
                            overflow: hidden;
                            word-break: break-word;
                            overflow-wrap: anywhere;
                        }
                    </style>
                    <div class="table-responsive">
                        <table class="table table-striped align-middle article-review-table">
                            <colgroup>
                                <col style="width: 80px;">
                                <col>
                                <col style="width: 22%;">
                                <col style="width: 110px;">
                                <col style="width: 130px;">
                                @if($status === 'approved' || $status === 'rejected')
                                    <col style="width: 140px;">
                                @endif
                                <col style="width: 90px;">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Judul</th>
                                    <th>Perusahaan</th>
                                    <th>Kategori</th>
                                    <th>Dikirim</th>
                                    @if($status === 'approved' || $status === 'rejected')
                                        <th>Ditinjau oleh</th>
                                    @endif
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($articles as $a)
                                    <tr>
                                        <td>
                                            @if($a->cover_image)
                                                <img src="{{ route('backoffice.article-review.cover', $a) }}" alt=""
                                                     style="width:60px;height:60px;object-fit:cover;border-radius:6px;">
                                            @else
                                                <div style="width:60px;height:60px;border-radius:6px;background:#f1f3f5;display:flex;align-items:center;justify-content:center;">
                                                    <i class="lni lni-write" style="color:#adb5bd;"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong class="cell-truncate">{{ $a->judul }}</strong>
                                            <small class="d-block text-muted cell-truncate">{{ \Illuminate\Support\Str::limit(strip_tags($a->isi), 80) }}</small>
                                        </td>
                                        <td>
                                            <span class="cell-truncate">{{ $a->employer->nama_perusahaan ?? '-' }}</span>
                                            <small class="d-block text-muted cell-truncate">{{ $a->employer->user->email ?? '-' }}</small>
                                        </td>
                                        <td><span class="cell-truncate">{{ $a->kategori ?? '-' }}</span></td>
                                        <td><small>{{ $a->created_at->format('d M Y H:i') }}</small></td>
                                        @if($status === 'approved' || $status === 'rejected')
                                            <td>
                                                <span class="cell-truncate">{{ $a->reviewer->name ?? '-' }}</span>
                                            </td>
                                        @endif
                                        <td>
                                            <a href="{{ route('backoffice.article-review.show', $a) }}" class="btn btn-info btn-sm">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $status === 'pending' ? 6 : 7 }}" class="text-center text-muted">Tidak ada data.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $articles->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
