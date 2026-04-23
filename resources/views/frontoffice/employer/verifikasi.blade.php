<x-front-office-layout :assets="$assets ?? []">

    <!-- Start Breadcrumbs -->
    <div class="breadcrumbs overlay">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">Verifikasi Perusahaan</h1>
                        <p>Lengkapi data perusahaan Anda. Tim admin akan melakukan verifikasi<br>
                            sebelum Anda dapat memposting lowongan.</p>
                    </div>
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ route('landingpage') }}">Home</a></li>
                        <li>Verifikasi</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <section class="job-post section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1 col-12">

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @if (isset($employer) && $employer && $employer->isPending())
                        <div class="job-information">
                            <div class="alert alert-warning" role="alert">
                                <h4 class="alert-heading mb-2"><i class="lni lni-timer"></i> Menunggu Verifikasi Admin</h4>
                                <p class="mb-1">Terima kasih, data perusahaan <strong>{{ $employer->nama_perusahaan }}</strong> sudah kami terima.</p>
                                <p class="mb-0">Admin akan meninjau data Anda. Anda akan dinotifikasi begitu verifikasi selesai. Anda belum dapat memposting lowongan sampai disetujui.</p>
                            </div>
                            <dl class="row mt-4">
                                <dt class="col-sm-3">Nama Perusahaan</dt>
                                <dd class="col-sm-9">{{ $employer->nama_perusahaan }}</dd>
                                <dt class="col-sm-3">Alamat</dt>
                                <dd class="col-sm-9">{{ $employer->alamat_perusahaan }}</dd>
                                <dt class="col-sm-3">Telepon</dt>
                                <dd class="col-sm-9">{{ $employer->telp_perusahaan }}</dd>
                                <dt class="col-sm-3">Website</dt>
                                <dd class="col-sm-9">{{ $employer->website ?: '-' }}</dd>
                                <dt class="col-sm-3">Dikirim pada</dt>
                                <dd class="col-sm-9">{{ optional($employer->created_at)->format('d M Y H:i') }}</dd>
                                <dt class="col-sm-3">Dokumen Legalitas</dt>
                                <dd class="col-sm-9">
                                    @if($employer->dokumen_legalitas)
                                        <a href="{{ route('employer.dokumen-legalitas') }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                            <i class="lni lni-download"></i> Lihat Dokumen
                                        </a>
                                    @else
                                        <span class="text-muted">Tidak ada</span>
                                    @endif
                                </dd>
                            </dl>
                        </div>
                    @else
                        @if (isset($employer) && $employer && $employer->isRejected())
                            <div class="alert alert-danger" role="alert">
                                <h4 class="alert-heading mb-2"><i class="lni lni-close"></i> Verifikasi Ditolak</h4>
                                <p class="mb-1">Pengajuan sebelumnya ditolak admin. Silakan perbaiki data di bawah ini dan kirim ulang.</p>
                                @if ($employer->verification_note)
                                    <hr>
                                    <p class="mb-0"><strong>Catatan admin:</strong> {{ $employer->verification_note }}</p>
                                @endif
                            </div>
                        @endif

                        <div class="job-information">
                            <h3 class="title">Lengkapi Informasi Perusahaan</h3>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('employer.verifikasi') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="{{ $user->id }}" name="id_user">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="nama_perusahaan">Nama Perusahaan*</label>
                                            <input class="form-control" type="text" name="nama_perusahaan" id="nama_perusahaan"
                                                value="{{ old('nama_perusahaan', $employer->nama_perusahaan ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="alamat">Alamat Perusahaan*</label>
                                            <input type="text" name="alamat" id="alamat"
                                                value="{{ old('alamat', $employer->alamat_perusahaan ?? '') }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="telp">No.Telp Perusahaan*</label>
                                            <input type="text" name="telp" id="telp"
                                                value="{{ old('telp', $employer->telp_perusahaan ?? '') }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="id_industri_type">Tipe Industri*</label>
                                            <select class="select" name="id_industri_type" id="id_industri_type">
                                                @foreach ($industriTypes as $it)
                                                    <option value="{{ $it->id }}"
                                                        @selected(old('id_industri_type', $employer->industriType_id ?? null) == $it->id)>
                                                        {{ $it->nama_industri ?? $it->name ?? ('Industri #'.$it->id) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email Perusahaan*</label>
                                            <input type="text" name="email" id="email"
                                                value="{{ old('email', $user->email) }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="deskripsi_perusahaan">Deskripsi Perusahaan*</label>
                                            <textarea name="deskripsi_perusahaan" class="form-control" rows="5" id="deskripsi_perusahaan">{{ old('deskripsi_perusahaan', $employer->deskripsi_perusahaan ?? '') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            Website<input type="text" name="website" id="website"
                                                value="{{ old('website', $employer->website ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="logo">Logo Perusahaan</label>
                                            <div class="d-flex align-items-center gap-3">
                                                @if(isset($employer) && $employer && $employer->logo_url)
                                                    <img src="{{ $employer->logo_url }}" alt="Logo" id="logo-preview"
                                                        style="width:72px;height:72px;object-fit:contain;border:1px solid #dee2e6;border-radius:8px;padding:4px;">
                                                @else
                                                    <div id="logo-preview-placeholder"
                                                        style="width:72px;height:72px;border:2px dashed #dee2e6;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#adb5bd;">
                                                        <i class="lni lni-apartment" style="font-size:2rem;"></i>
                                                    </div>
                                                    <img src="" alt="Logo" id="logo-preview"
                                                        style="width:72px;height:72px;object-fit:contain;border:1px solid #dee2e6;border-radius:8px;padding:4px;display:none;">
                                                @endif
                                                <div>
                                                    <input type="file" name="logo" id="logo-input" class="form-control" accept="image/jpg,image/jpeg,image/png,image/webp">
                                                    <small class="text-muted">JPG, PNG, WEBP — maks. 2MB (opsional)</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="dokumen_legalitas">Dokumen Legalitas Usaha <span class="text-danger">*</span></label>
                                            @if(isset($employer) && $employer && $employer->dokumen_legalitas)
                                                <div class="mb-2">
                                                    <small class="text-muted">Sudah ada dokumen tersimpan. Upload file baru untuk mengganti.</small>
                                                </div>
                                            @endif
                                            <input type="file" name="dokumen_legalitas" id="dokumen_legalitas" class="form-control"
                                                   accept=".pdf,.jpg,.jpeg,.png,.webp">
                                            <small class="text-muted">PDF atau gambar (JPG, PNG, WEBP) — maks. 5MB. Contoh: SKU, NIB, Akta Pendirian.</small>
                                        </div>
                                    </div>

                                <div class="col-lg-12 button">
                                    <button class="btn" type="submit" name="verifikasi">
                                        Kirim untuk Verifikasi
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('logo-input');
    if (!input) return;
    input.addEventListener('change', function(e) {
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
});
</script>
</x-front-office-layout>
