@extends('frontoffice.employer.index')
@section('article', 'active')
@section('page-title', 'Tulis Artikel')
@section('page-subtitle', 'Bagikan tulisan untuk audiens Pusat Karir Unand. Akan ditinjau admin sebelum tayang.')
@section('content')

<div class="job-items">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('employer.article.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Judul <span class="text-danger">*</span></label>
            <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required maxlength="150" placeholder="Tulis judul yang jelas dan menarik">
            <small class="text-muted">Maksimal 150 karakter.</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <input type="text" name="kategori" class="form-control" value="{{ old('kategori') }}" maxlength="50"
                   list="kategori-suggestions" placeholder="Misal: Karier, Magang, Industri">
            <datalist id="kategori-suggestions">
                <option value="Karier">
                <option value="Magang">
                <option value="Industri">
                <option value="Tips Pencari Kerja">
                <option value="Pengembangan Diri">
                <option value="Berita Perusahaan">
            </datalist>
            <small class="text-muted">Opsional. Membantu pembaca menemukan artikel sejenis.</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Cover (opsional)</label>
            <div class="d-flex align-items-center gap-3">
                <div id="cover-preview-placeholder"
                     style="width:120px;height:120px;border:2px dashed #dee2e6;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#adb5bd;flex-shrink:0;">
                    <i class="lni lni-image" style="font-size:2rem;"></i>
                </div>
                <img src="" alt="" id="cover-preview"
                     style="width:120px;height:120px;object-fit:cover;border:1px solid #dee2e6;border-radius:8px;display:none;flex-shrink:0;">
                <div class="flex-grow-1">
                    <input type="file" name="cover_image" id="cover-input" class="form-control" accept="image/jpeg,image/png,image/webp">
                    <small class="text-muted">JPG, PNG, atau WEBP. Maks. 2MB.</small>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Isi Artikel <span class="text-danger">*</span></label>
            <textarea name="isi" class="form-control" rows="14" required minlength="50" placeholder="Tulis isi artikel di sini. Pisahkan paragraf dengan baris kosong.">{{ old('isi') }}</textarea>
            <small class="text-muted">Minimal 50 karakter. Baris kosong akan dipertahankan saat ditampilkan.</small>
        </div>

        <div class="alert alert-info small mb-3">
            <i class="lni lni-information me-1"></i>
            Setelah dikirim, artikel berstatus <strong>Menunggu</strong> dan baru tayang publik setelah admin Pusat Karir menyetujui.
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('employer.article.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">
                <i class="lni lni-cloud-upload me-1"></i> Kirim untuk Ditinjau
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
