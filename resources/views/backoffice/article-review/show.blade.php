<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Detail Artikel</h4>
                    <a href="{{ route('backoffice.article-review.index') }}" class="btn btn-link btn-sm">
                        <i class="lni lni-arrow-left me-1"></i> Kembali ke Daftar
                    </a>
                </div>
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-info">{{ session('info') }}</div>
                    @endif

                    @php
                        $cls = match($article->status) {
                            'pending'  => 'warning',
                            'approved' => 'success',
                            'rejected' => 'danger',
                            default    => 'secondary',
                        };
                        $label = match($article->status) {
                            'pending'  => 'Menunggu',
                            'approved' => 'Disetujui',
                            'rejected' => 'Ditolak',
                            default    => ucfirst($article->status),
                        };
                    @endphp

                    {{-- Status + employer info --}}
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <div>
                            <span class="badge bg-{{ $cls }} fs-6">{{ $label }}</span>
                            @if($article->reviewed_at)
                                <small class="text-muted ms-2">
                                    Ditinjau {{ $article->reviewed_at->format('d M Y H:i') }}
                                    oleh {{ $article->reviewer->name ?? '-' }}
                                </small>
                            @endif
                        </div>
                        <div class="text-end">
                            <strong>{{ $article->employer->nama_perusahaan ?? '-' }}</strong>
                            <small class="d-block text-muted">{{ $article->employer->user->email ?? '-' }}</small>
                        </div>
                    </div>

                    @if($article->status === 'rejected' && $article->admin_note)
                        <div class="alert alert-danger">
                            <strong>Catatan penolakan sebelumnya:</strong> {{ $article->admin_note }}
                        </div>
                    @endif

                    {{-- Article preview --}}
                    @if($article->cover_image)
                        <img src="{{ route('backoffice.article-review.cover', $article) }}" alt=""
                             style="width:100%;max-height:340px;object-fit:cover;border-radius:8px;margin-bottom:16px;">
                    @endif

                    @if($article->kategori)
                        <span class="badge bg-light text-dark mb-2">
                            <i class="lni lni-tag me-1"></i>{{ $article->kategori }}
                        </span>
                    @endif

                    <h2 class="mb-2" style="overflow-wrap:anywhere;">{{ $article->judul }}</h2>
                    <p class="text-muted small mb-3">
                        <i class="lni lni-calendar me-1"></i>{{ $article->created_at->format('d M Y H:i') }}
                        <span class="mx-2">·</span>
                        <code>/artikel/{{ $article->slug }}</code>
                    </p>

                    <hr>

                    <div style="white-space: pre-wrap; line-height: 1.7; font-size: 15px; overflow-wrap: anywhere; word-break: break-word; max-width: 100%;">{{ $article->isi }}</div>
                </div>
            </div>

            {{-- Action card (only for pending) --}}
            @if($article->isPending())
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card border-success h-100">
                            <div class="card-body">
                                <h5 class="text-success"><i class="lni lni-checkmark-circle me-1"></i> Setujui Artikel</h5>
                                <p class="text-muted small">Artikel akan tayang publik dan dapat diakses oleh siapa pun via <code>/artikel/{slug}</code>.</p>
                                <form method="POST" action="{{ route('backoffice.article-review.approve', $article) }}"
                                      onsubmit="return confirm('Setujui dan publikasikan artikel ini?')">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100">Setujui &amp; Publikasikan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card border-danger h-100">
                            <div class="card-body">
                                <h5 class="text-danger"><i class="lni lni-close me-1"></i> Tolak Artikel</h5>
                                <p class="text-muted small">Berikan catatan jelas. Employer akan dinotifikasi dan dapat memperbaiki lalu mengirim ulang.</p>
                                <form method="POST" action="{{ route('backoffice.article-review.reject', $article) }}">
                                    @csrf
                                    <textarea name="admin_note" class="form-control mb-2" rows="3" required maxlength="1000"
                                              placeholder="Misal: konten tidak relevan dengan karier mahasiswa, atau melanggar kode etik publikasi.">{{ old('admin_note') }}</textarea>
                                    @error('admin_note')
                                        <div class="alert alert-danger small mb-2">{{ $message }}</div>
                                    @enderror
                                    <button type="submit" class="btn btn-danger w-100">Tolak Artikel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($article->isApproved())
                <div class="card border-success">
                    <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <strong class="text-success">
                                <i class="lni lni-checkmark-circle me-1"></i>Artikel sudah tayang publik
                            </strong>
                            @if($article->published_at)
                                <small class="text-muted d-block">Diterbitkan {{ $article->published_at->format('d M Y H:i') }}</small>
                            @endif
                        </div>
                        <form method="POST" action="{{ route('backoffice.article-review.reject', $article) }}"
                              onsubmit="return confirm('Tarik artikel ini dari publik dan tandai ditolak?')">
                            @csrf
                            <input type="hidden" name="admin_note" value="Artikel ditarik admin setelah review ulang.">
                            <button type="submit" class="btn btn-outline-danger btn-sm">Tarik dari Publik</button>
                        </form>
                    </div>
                </div>
            @elseif($article->isRejected())
                <div class="card border-warning">
                    <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <strong class="text-warning">
                                <i class="lni lni-warning me-1"></i>Artikel ditolak.
                            </strong>
                            <small class="text-muted d-block">Employer dapat memperbaiki dan mengirim ulang.</small>
                        </div>
                        <form method="POST" action="{{ route('backoffice.article-review.approve', $article) }}"
                              onsubmit="return confirm('Setujui artikel ini sekarang? Status akan berubah dari Ditolak ke Disetujui.')">
                            @csrf
                            <button type="submit" class="btn btn-outline-success btn-sm">Setujui Sekarang</button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
