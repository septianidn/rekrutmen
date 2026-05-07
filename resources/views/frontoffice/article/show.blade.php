<x-front-office-layout>
    <section class="section" style="padding-top: 120px; min-height: 80vh;">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 mx-auto">

                    <a href="{{ route('artikel.index') }}" class="btn btn-link btn-sm ps-0 mb-3">
                        <i class="lni lni-arrow-left me-1"></i> Kembali ke Daftar Artikel
                    </a>

                    @if($article->cover_image)
                        <img src="{{ $article->cover_url }}" alt=""
                             style="width:100%;max-height:420px;object-fit:cover;border-radius:12px;margin-bottom:20px;">
                    @endif

                    @if($article->kategori)
                        <a href="{{ route('artikel.index', ['kategori' => $article->kategori]) }}"
                           class="badge bg-primary text-decoration-none mb-2">
                            <i class="lni lni-tag me-1"></i>{{ $article->kategori }}
                        </a>
                    @endif

                    <h1 class="mb-3" style="overflow-wrap:anywhere; line-height: 1.3;">{{ $article->judul }}</h1>

                    <div class="d-flex align-items-center gap-3 mb-4 flex-wrap">
                        @if($article->employer && $article->employer->logo_url)
                            <img src="{{ $article->employer->logo_url }}" alt=""
                                 style="width:48px;height:48px;object-fit:contain;border:1px solid #dee2e6;border-radius:8px;padding:3px;">
                        @else
                            <div style="width:48px;height:48px;border:1px solid #dee2e6;border-radius:8px;display:flex;align-items:center;justify-content:center;background:#f8f9fa;">
                                <i class="lni lni-apartment text-muted"></i>
                            </div>
                        @endif
                        <div>
                            <strong>{{ $article->employer->nama_perusahaan ?? '-' }}</strong>
                            <small class="d-block text-muted">
                                <i class="lni lni-calendar me-1"></i>Diterbitkan {{ $article->published_at?->format('d M Y') }}
                            </small>
                        </div>
                    </div>

                    <hr>

                    <div style="white-space: pre-wrap; line-height: 1.8; font-size: 16px; overflow-wrap: anywhere; word-break: break-word; max-width: 100%;">{{ $article->isi }}</div>

                    <hr class="mt-5">

                    @if($related->isNotEmpty())
                        <h5 class="mt-4 mb-3"><i class="lni lni-bookmark me-1"></i>Artikel Terkait</h5>
                        <div class="row">
                            @foreach($related as $r)
                                <div class="col-md-4 mb-3">
                                    <a href="{{ route('artikel.show', $r->slug) }}" class="text-decoration-none text-dark">
                                        <div class="card border h-100" style="border-left: 4px solid #2042e3 !important;">
                                            @if($r->cover_image)
                                                <img src="{{ $r->cover_url }}" alt=""
                                                     style="width:100%;height:120px;object-fit:cover;">
                                            @endif
                                            <div class="card-body p-3">
                                                @if($r->kategori)
                                                    <span class="badge bg-light text-dark mb-1" style="font-size:10px;">{{ $r->kategori }}</span>
                                                @endif
                                                <h6 class="mb-1" style="font-size:14px;overflow-wrap:anywhere;">{{ \Illuminate\Support\Str::limit($r->judul, 60) }}</h6>
                                                <small class="text-muted">{{ $r->employer->nama_perusahaan ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>

    @guest
        @include('partials.frontoffice._auth_modals')
    @endguest
</x-front-office-layout>
