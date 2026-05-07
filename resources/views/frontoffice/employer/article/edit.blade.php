@extends('frontoffice.employer.index')
@section('article', 'active')
@section('page-title', 'Edit Artikel')
@section('page-subtitle', 'Perbarui artikel Anda.')
@section('content')

@if($article->isApproved())
    <div class="alert alert-warning">
        <i class="lni lni-warning me-1"></i>
        <strong>Perhatian:</strong> Artikel ini sudah disetujui dan tayang publik.
        Menyimpan perubahan akan mengembalikannya ke status <strong>Menunggu</strong>
        dan menyembunyikannya dari publik sampai admin meninjau ulang.
    </div>
@elseif($article->isRejected() && $article->admin_note)
    <div class="alert alert-danger">
        <strong>Ditolak admin:</strong> {{ $article->admin_note }}<br>
        <small>Perbaiki konten dan simpan untuk mengirim ulang.</small>
    </div>
@endif

<div class="job-items">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('employer.article.update', $article) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label">Judul <span class="text-danger">*</span></label>
            <input type="text" name="judul" class="form-control" value="{{ old('judul', $article->judul) }}" required maxlength="150">
            <small class="text-muted">URL artikel <code>{{ $article->slug }}</code> tidak akan berubah meskipun judul diedit.</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <input type="text" name="kategori" class="form-control" value="{{ old('kategori', $article->kategori) }}" maxlength="50"
                   list="kategori-suggestions">
            <datalist id="kategori-suggestions">
                <option value="Karier">
                <option value="Magang">
                <option value="Industri">
                <option value="Tips Pencari Kerja">
                <option value="Pengembangan Diri">
                <option value="Berita Perusahaan">
            </datalist>
        </div>

        <div class="mb-3">
            <label class="form-label">Cover</label>
            <div class="d-flex align-items-center gap-3">
                @if($article->cover_image)
                    <img src="{{ $article->cover_url }}" alt="" id="cover-preview"
                         style="width:120px;height:120px;object-fit:cover;border:1px solid #dee2e6;border-radius:8px;flex-shrink:0;">
                @else
                    <div id="cover-preview-placeholder"
                         style="width:120px;height:120px;border:2px dashed #dee2e6;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#adb5bd;flex-shrink:0;">
                        <i class="lni lni-image" style="font-size:2rem;"></i>
                    </div>
                    <img src="" alt="" id="cover-preview"
                         style="width:120px;height:120px;object-fit:cover;border:1px solid #dee2e6;border-radius:8px;display:none;flex-shrink:0;">
                @endif
                <div class="flex-grow-1">
                    <input type="file" name="cover_image" id="cover-input" class="form-control" accept="image/jpeg,image/png,image/webp">
                    <small class="text-muted">Kosongkan jika tidak ingin mengganti. JPG, PNG, atau WEBP. Maks. 2MB.</small>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Isi Artikel <span class="text-danger">*</span></label>
            <textarea name="isi" class="form-control" rows="14" required minlength="50">{{ old('isi', $article->isi) }}</textarea>
            <small class="text-muted">Minimal 50 karakter. Baris kosong akan dipertahankan saat ditampilkan.</small>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('employer.article.show', $article) }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">
                <i class="lni lni-save me-1"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('cover-input');
    if (!input) return;
    input.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;
        const preview = document.getElementById('cover-preview');
        const placeholder = document.getElementById('cover-preview-placeholder');
        const reader = new FileReader();
        reader.onload = function (ev) {
            preview.src = ev.target.result;
            preview.style.display = 'block';
            if (placeholder) placeholder.style.display = 'none';
        };
        reader.readAsDataURL(file);
    });
});
</script>

@endsection
