@extends('frontoffice.employer.index')
@section('profile', 'active')
@section('page-title', 'Edit Profil')
@section('page-subtitle', 'Perbarui informasi perusahaan Anda.')
@section('content')
<div class="resume">
    <div class="container">
        <div class="resume-inner">
            <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="inner-content">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="mb-0">Edit Profil Perusahaan</h4>
                            <a href="{{ route('employer.profile') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="lni lni-arrow-left"></i> Kembali
                            </a>
                        </div>

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        @php $isVerified = $employer && $employer->isVerified(); @endphp

                        @if($isVerified && isset($pendingRequest) && $pendingRequest)
                            <div class="alert alert-warning">
                                <strong>Permintaan perubahan sedang ditinjau admin.</strong>
                                Field
                                @foreach(array_keys($pendingRequest->payload ?? []) as $key)
                                    <code>{{ $key }}</code>@if(!$loop->last), @endif
                                @endforeach
                                tidak dapat diubah sampai keputusan diterima. Anda masih dapat memperbarui field lain.
                                <br><small class="text-muted">Diajukan {{ $pendingRequest->created_at?->format('d M Y H:i') }} &middot; Alasan: {{ $pendingRequest->reason }}</small>
                            </div>
                        @elseif($isVerified)
                            <div class="alert alert-info">
                                <i class="lni lni-information"></i>
                                Akun Anda sudah terverifikasi. Perubahan pada <strong>nama perusahaan, alamat, logo, dan dokumen legalitas</strong> memerlukan persetujuan admin terlebih dahulu. Field lain dapat diperbarui langsung.
                            </div>
                        @endif

                        @php $gatedLocked = $isVerified && isset($pendingRequest) && $pendingRequest; @endphp

                        <form action="{{ route('employer.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- Logo Upload --}}
                            <div class="form-group mb-4">
                                <label class="form-label">
                                    Logo Perusahaan
                                    @if($isVerified)
                                        <span class="badge bg-warning ms-1">perlu persetujuan admin</span>
                                    @endif
                                </label>
                                <div class="d-flex align-items-center gap-3">
                                    @if($employer->logo_url)
                                        <img src="{{ $employer->logo_url }}" alt="Logo" id="logo-preview"
                                            style="width:80px;height:80px;object-fit:contain;border:1px solid #dee2e6;border-radius:8px;padding:4px;">
                                    @else
                                        <div id="logo-preview-placeholder"
                                            style="width:80px;height:80px;border:2px dashed #dee2e6;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#adb5bd;">
                                            <i class="lni lni-apartment" style="font-size:2rem;"></i>
                                        </div>
                                        <img src="" alt="Logo" id="logo-preview"
                                            style="width:80px;height:80px;object-fit:contain;border:1px solid #dee2e6;border-radius:8px;padding:4px;display:none;">
                                    @endif
                                    <div>
                                        <input type="file" name="logo" id="logo-input" class="form-control" accept="image/jpg,image/jpeg,image/png,image/webp" style="max-width:280px;" {{ $gatedLocked ? 'disabled' : '' }}>
                                        <small class="text-muted">JPG, PNG, WEBP — maks. 2MB.</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">
                                            Nama Perusahaan <span class="text-danger">*</span>
                                            @if($isVerified)
                                                <span class="badge bg-warning ms-1">perlu persetujuan admin</span>
                                            @endif
                                        </label>
                                        <input type="text" name="nama_perusahaan" class="form-control"
                                            value="{{ old('nama_perusahaan', $employer->nama_perusahaan) }}" required {{ $gatedLocked ? 'readonly' : '' }}>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Tipe Industri <span class="text-danger">*</span></label>
                                        <select name="industriType_id" class="form-control" required>
                                            <option value="">-- Pilih Tipe Industri --</option>
                                            @foreach($industriTypes as $type)
                                                <option value="{{ $type->id }}"
                                                    {{ old('industriType_id', $employer->industriType_id) == $type->id ? 'selected' : '' }}>
                                                    {{ $type->nama_industri }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">
                                    Alamat Perusahaan
                                    @if($isVerified)
                                        <span class="badge bg-warning ms-1">perlu persetujuan admin</span>
                                    @endif
                                </label>
                                <input type="text" name="alamat_perusahaan" class="form-control"
                                    value="{{ old('alamat_perusahaan', $employer->alamat_perusahaan) }}" {{ $gatedLocked ? 'readonly' : '' }}>
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Telepon Perusahaan</label>
                                        <input type="text" name="telp_perusahaan" class="form-control"
                                            value="{{ old('telp_perusahaan', $employer->telp_perusahaan) }}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Website</label>
                                        <input type="text" name="website" class="form-control"
                                            value="{{ old('website', $employer->website) }}"
                                            placeholder="https://example.com">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Deskripsi Perusahaan <span class="text-danger">*</span></label>
                                <textarea name="deskripsi_perusahaan" class="form-control" rows="5" required>{{ old('deskripsi_perusahaan', $employer->deskripsi_perusahaan) }}</textarea>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">
                                    Dokumen Legalitas Usaha
                                    @if($isVerified)
                                        <span class="badge bg-warning ms-1">perlu persetujuan admin</span>
                                    @endif
                                </label>
                                @if($employer->dokumen_legalitas)
                                    <div class="mb-2">
                                        <a href="{{ route('employer.dokumen-legalitas') }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                            <i class="lni lni-download me-1"></i> Lihat Dokumen Tersimpan
                                        </a>
                                        <small class="text-muted ms-2">Upload file baru untuk mengganti.</small>
                                    </div>
                                @endif
                                <input type="file" name="dokumen_legalitas" class="form-control"
                                       accept=".pdf,.jpg,.jpeg,.png,.webp" style="max-width:400px;" {{ $gatedLocked ? 'disabled' : '' }}>
                                <small class="text-muted">PDF atau gambar (JPG, PNG, WEBP) — maks. 5MB.</small>
                            </div>

                            @if($isVerified && !$gatedLocked)
                                <div class="form-group mb-3">
                                    <label class="form-label">Alasan Perubahan <span class="text-muted">(wajib jika mengubah field bertanda kuning)</span></label>
                                    <textarea name="reason" class="form-control" rows="3"
                                        placeholder="Jelaskan alasan perubahan profil ini agar admin dapat meninjau.">{{ old('reason') }}</textarea>
                                </div>
                            @endif

                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="lni lni-save"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('employer.profile') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
document.getElementById('logo-input').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    const preview = document.getElementById('logo-preview');
    const placeholder = document.getElementById('logo-preview-placeholder');
    const reader = new FileReader();
    reader.onload = function(ev) {
        preview.src = ev.target.result;
        preview.style.display = 'block';
        if (placeholder) placeholder.style.display = 'none';
    };
    reader.readAsDataURL(file);
});
</script>
@endpush
@endsection
