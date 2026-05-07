<x-front-office-layout>
    <section class="section" style="padding-top: 120px; min-height: 80vh;">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h3>Artikel</h3>
                    <p class="text-muted">Tulisan dari mitra perusahaan Pusat Karir Unand seputar karier, magang, dan industri.</p>
                </div>
            </div>

            @if($categories->isNotEmpty())
                <div class="mb-4 d-flex flex-wrap gap-2">
                    <a href="{{ route('artikel.index') }}"
                       class="badge {{ $kategori === '' ? 'bg-primary' : 'bg-light text-dark' }} text-decoration-none p-2">
                        Semua
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('artikel.index', ['kategori' => $cat]) }}"
                           class="badge {{ $kategori === $cat ? 'bg-primary' : 'bg-light text-dark' }} text-decoration-none p-2">
                            {{ $cat }}
                        </a>
                    @endforeach
                </div>
            @endif

            <div class="row">
                @forelse($articles as $a)
                    <div class="col-lg-4 col-md-6 col-12 mb-4">
                        <a href="{{ route('artikel.show', $a->slug) }}" class="text-decoration-none text-dark">
                            <div class="card border h-100" style="border-left: 4px solid #2042e3 !important; transition: transform .2s, box-shadow .2s;"
                                 onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 14px 30px rgba(32,66,227,.10)';"
                                 onmouseout="this.style.transform='';this.style.boxShadow='';">
                                @if($a->cover_image)
                                    <img src="{{ $a->cover_url }}" alt=""
                                         style="width:100%;height:180px;object-fit:cover;">
                                @else
                                    <div style="width:100%;height:180px;background:linear-gradient(135deg,#2042e3 0%,#764ba2 100%);display:flex;align-items:center;justify-content:center;color:#fff;">
                                        <i class="lni lni-write" style="font-size:3rem;opacity:.6;"></i>
                                    </div>
                                @endif
                                <div class="card-body d-flex flex-column">
                                    @if($a->kategori)
                                        <span class="badge bg-light text-dark align-self-start mb-2">
                                            <i class="lni lni-tag me-1"></i>{{ $a->kategori }}
                                        </span>
                                    @endif
                                    <h5 class="card-title mb-2" style="overflow-wrap:anywhere;">{{ $a->judul }}</h5>
                                    <p class="small text-muted mb-2" style="overflow-wrap:anywhere;">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($a->isi), 120) }}
                                    </p>
                                    <div class="mt-auto pt-2 border-top small text-muted d-flex justify-content-between align-items-center flex-wrap gap-1">
                                        <span><i class="lni lni-apartment me-1"></i>{{ $a->employer->nama_perusahaan ?? '-' }}</span>
                                        <span><i class="lni lni-calendar me-1"></i>{{ $a->published_at?->format('d M Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            @if($kategori !== '')
                                Belum ada artikel pada kategori <strong>{{ $kategori }}</strong>.
                                <a href="{{ route('artikel.index') }}" class="alert-link">Lihat semua artikel</a>.
                            @else
                                Belum ada artikel yang dipublikasikan.
                            @endif
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $articles->links('components.paginate') }}
            </div>
        </div>
    </section>

    @guest
        @include('partials.frontoffice._auth_modals')
    @endguest
</x-front-office-layout>
