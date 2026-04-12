@extends('frontoffice.jobseeker.templates.body')
@section('profile', 'active')
@section('page-title', 'Edit Profil')
@section('page-subtitle', 'Perbarui informasi profil dan CV Anda.')
@section('content')

<div class="resume">
    <div class="container">
        <div class="resume-inner">
            <div class="mb-3">
                <a href="{{ route('jobseeker.profile') }}" class="btn btn-outline-secondary btn-sm">&larr; Kembali ke Profil</a>
            </div>

            <h4 class="mb-3">Edit Profil</h4>

            <div class="alert alert-info py-2 px-3 small mb-4">
                <i class="lni lni-information"></i>
                Bagian bertanda <span class="badge bg-danger">Wajib</span> harus diisi minimal 1 data agar dapat melamar pekerjaan.
                Bagian bertanda <span class="badge bg-secondary">Opsional</span> tidak wajib, namun disarankan untuk dilengkapi.
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

            <form action="{{ route('jobseeker.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                {{-- ============ DATA PRIBADI ============ --}}
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white"><strong>Data Pribadi</strong></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label">Nama Depan</label>
                                <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $jobseeker->first_name) }}" required>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label">Nama Belakang</label>
                                <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $jobseeker->last_name) }}" required>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select">
                                    <option value="-" @selected($jobseeker->jenis_kelamin == '-')>-- Pilih --</option>
                                    <option value="Laki-laki" @selected($jobseeker->jenis_kelamin == 'Laki-laki')>Laki-laki</option>
                                    <option value="Perempuan" @selected($jobseeker->jenis_kelamin == 'Perempuan')>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="ttl" class="form-control" value="{{ old('ttl', $jobseeker->ttl?->format('Y-m-d')) }}">
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label">Tipe Jobseeker</label>
                                <select name="jobseeker_type_id" class="form-select">
                                    @foreach($jobseekerTypes as $type)
                                        <option value="{{ $type->id }}" @selected($jobseeker->jobseeker_type_id == $type->id)>{{ $type->jobseekerType }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ============ KONTAK ============ --}}
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white"><strong>Informasi Kontak</strong></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label">Telepon</label>
                                <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $user->phone_number) }}">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label">Alamat</label>
                                <input type="text" name="street_addr" class="form-control" value="{{ old('street_addr', $user->street_addr) }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ============ RIWAYAT PENDIDIKAN ============ --}}
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <span><strong>Riwayat Pendidikan</strong> <span class="badge bg-danger ms-1">Wajib</span></span>
                        <button type="button" class="btn btn-light btn-sm" onclick="addRow('pendidikan')">+ Tambah</button>
                    </div>
                    <div class="card-body" id="pendidikan-container">
                        @forelse($jobseeker->riwayatPendidikans as $i => $edu)
                        <div class="row mb-3 item-row">
                            <div class="col-12 col-md-2">
                                <label class="form-label">Jenjang</label>
                                <select name="pendidikan[{{ $i }}][jenjang]" class="form-select">
                                    @foreach(['SD','SMP','SMA','D3','S1','S2','S3'] as $j)
                                        <option value="{{ $j }}" @selected($edu->jenjang == $j)>{{ $j }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Instansi</label>
                                <input type="text" name="pendidikan[{{ $i }}][instansi]" class="form-control" value="{{ $edu->instansi }}">
                            </div>
                            <div class="col-12 col-md-2">
                                <label class="form-label">IPK/Nilai</label>
                                <input type="text" name="pendidikan[{{ $i }}][indeks_nilai]" class="form-control" value="{{ $edu->indeks_nilai }}">
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label">Keterangan</label>
                                <input type="text" name="pendidikan[{{ $i }}][keterangan]" class="form-control" value="{{ $edu->keterangan }}">
                            </div>
                            <div class="col-12 col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.item-row').remove()">X</button>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted" id="pendidikan-empty">Belum ada data. Klik "+ Tambah" untuk menambahkan.</p>
                        @endforelse
                    </div>
                </div>

                {{-- ============ PENGALAMAN KERJA ============ --}}
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <span><strong>Pengalaman Kerja</strong> <span class="badge bg-secondary ms-1">Opsional</span></span>
                        <button type="button" class="btn btn-light btn-sm" onclick="addRow('kerja')">+ Tambah</button>
                    </div>
                    <div class="card-body" id="kerja-container">
                        @forelse($jobseeker->riwayatKerjas as $i => $work)
                        <div class="row mb-3 item-row">
                            <div class="col-12 col-md-11">
                                <label class="form-label">Keterangan</label>
                                <textarea name="kerja[{{ $i }}][keterangan]" class="form-control" rows="2">{{ $work->keterangan }}</textarea>
                            </div>
                            <div class="col-12 col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.item-row').remove()">X</button>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted" id="kerja-empty">Belum ada data.</p>
                        @endforelse
                    </div>
                </div>

                {{-- ============ ORGANISASI ============ --}}
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <span><strong>Organisasi</strong> <span class="badge bg-secondary ms-1">Opsional</span></span>
                        <button type="button" class="btn btn-light btn-sm" onclick="addRow('organisasi')">+ Tambah</button>
                    </div>
                    <div class="card-body" id="organisasi-container">
                        @forelse($jobseeker->organisasis as $i => $org)
                        <div class="row mb-3 item-row">
                            <div class="col-12 col-md-4">
                                <label class="form-label">Nama Organisasi</label>
                                <input type="text" name="organisasi[{{ $i }}][nama_organisasi]" class="form-control" value="{{ $org->nama_organisasi }}">
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label">Jabatan</label>
                                <input type="text" name="organisasi[{{ $i }}][jabatan]" class="form-control" value="{{ $org->jabatan }}">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Keterangan</label>
                                <input type="text" name="organisasi[{{ $i }}][keterangan]" class="form-control" value="{{ $org->keterangan }}">
                            </div>
                            <div class="col-12 col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.item-row').remove()">X</button>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted" id="organisasi-empty">Belum ada data.</p>
                        @endforelse
                    </div>
                </div>

                {{-- ============ PRESTASI ============ --}}
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <span><strong>Prestasi / Penghargaan</strong> <span class="badge bg-secondary ms-1">Opsional</span></span>
                        <button type="button" class="btn btn-light btn-sm" onclick="addRow('prestasi')">+ Tambah</button>
                    </div>
                    <div class="card-body" id="prestasi-container">
                        @forelse($jobseeker->prestasis as $i => $award)
                        <div class="row mb-3 item-row">
                            <div class="col-12 col-md-6">
                                <label class="form-label">Nama Penghargaan</label>
                                <input type="text" name="prestasi[{{ $i }}][nama_penghargaan]" class="form-control" value="{{ $award->nama_penghargaan }}">
                            </div>
                            <div class="col-12 col-md-2">
                                <label class="form-label">Tahun</label>
                                <input type="text" name="prestasi[{{ $i }}][tahun]" class="form-control" value="{{ $award->tahun }}" maxlength="4">
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label">Dokumen</label>
                                <input type="text" name="prestasi[{{ $i }}][dokumen]" class="form-control" value="{{ $award->dokumen }}">
                            </div>
                            <div class="col-12 col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.item-row').remove()">X</button>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted" id="prestasi-empty">Belum ada data.</p>
                        @endforelse
                    </div>
                </div>

                {{-- ============ PELATIHAN ============ --}}
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <span><strong>Pelatihan / Sertifikasi</strong> <span class="badge bg-secondary ms-1">Opsional</span></span>
                        <button type="button" class="btn btn-light btn-sm" onclick="addRow('pelatihan')">+ Tambah</button>
                    </div>
                    <div class="card-body" id="pelatihan-container">
                        @forelse($jobseeker->pelatihans as $i => $t)
                        <div class="row mb-3 item-row">
                            <div class="col-12 col-md-5">
                                <label class="form-label">Nama Pelatihan</label>
                                <input type="text" name="pelatihan[{{ $i }}][nama_pelatihan]" class="form-control" value="{{ $t->nama_pelatihan }}">
                            </div>
                            <div class="col-12 col-md-2">
                                <label class="form-label">Tahun</label>
                                <input type="text" name="pelatihan[{{ $i }}][tahun]" class="form-control" value="{{ $t->tahun }}" maxlength="4">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Sertifikat</label>
                                <input type="text" name="pelatihan[{{ $i }}][sertifikat]" class="form-control" value="{{ $t->sertifikat }}">
                            </div>
                            <div class="col-12 col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.item-row').remove()">X</button>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted" id="pelatihan-empty">Belum ada data.</p>
                        @endforelse
                    </div>
                </div>

                {{-- ============ BAHASA ============ --}}
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <span><strong>Bahasa</strong> <span class="badge bg-danger ms-1">Wajib</span></span>
                        <button type="button" class="btn btn-light btn-sm" onclick="addRow('bahasa')">+ Tambah</button>
                    </div>
                    <div class="card-body" id="bahasa-container">
                        @forelse($jobseeker->bahasas as $i => $lang)
                        <div class="row mb-3 item-row">
                            <div class="col-12 col-md-5">
                                <label class="form-label">Bahasa</label>
                                <input type="text" name="bahasa[{{ $i }}][bahasa]" class="form-control" value="{{ $lang->bahasa }}">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Keterangan (level)</label>
                                <input type="text" name="bahasa[{{ $i }}][keterangan]" class="form-control" value="{{ $lang->keterangan }}">
                            </div>
                            <div class="col-12 col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.item-row').remove()">X</button>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted" id="bahasa-empty">Belum ada data.</p>
                        @endforelse
                    </div>
                </div>

                {{-- ============ REKOMENDASI ============ --}}
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <span><strong>Referensi</strong> <span class="badge bg-secondary ms-1">Opsional</span></span>
                        <button type="button" class="btn btn-light btn-sm" onclick="addRow('rekomendasi')">+ Tambah</button>
                    </div>
                    <div class="card-body" id="rekomendasi-container">
                        @forelse($jobseeker->rekomendasis as $i => $ref)
                        <div class="row mb-3 item-row">
                            <div class="col-12 col-md-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="rekomendasi[{{ $i }}][nama_perekomendasi]" class="form-control" value="{{ $ref->nama_perekomendasi }}">
                            </div>
                            <div class="col-12 col-md-2">
                                <label class="form-label">Posisi</label>
                                <input type="text" name="rekomendasi[{{ $i }}][posisi]" class="form-control" value="{{ $ref->posisi }}">
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label">No HP</label>
                                <input type="text" name="rekomendasi[{{ $i }}][no_hp]" class="form-control" value="{{ $ref->no_hp }}">
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label">Alamat</label>
                                <input type="text" name="rekomendasi[{{ $i }}][alamat]" class="form-control" value="{{ $ref->alamat }}">
                            </div>
                            <div class="col-12 col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.item-row').remove()">X</button>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted" id="rekomendasi-empty">Belum ada data.</p>
                        @endforelse
                    </div>
                </div>

                <div class="text-end mb-5">
                    <button type="submit" class="btn btn-success px-5">Simpan Profil</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const templates = {
    pendidikan: (i) => `<div class="row mb-3 item-row">
        <div class="col-12 col-md-2"><label class="form-label">Jenjang</label><select name="pendidikan[${i}][jenjang]" class="form-select"><option value="SD">SD</option><option value="SMP">SMP</option><option value="SMA">SMA</option><option value="D3">D3</option><option value="S1" selected>S1</option><option value="S2">S2</option><option value="S3">S3</option></select></div>
        <div class="col-12 col-md-4"><label class="form-label">Instansi</label><input type="text" name="pendidikan[${i}][instansi]" class="form-control"></div>
        <div class="col-12 col-md-2"><label class="form-label">IPK/Nilai</label><input type="text" name="pendidikan[${i}][indeks_nilai]" class="form-control"></div>
        <div class="col-12 col-md-3"><label class="form-label">Keterangan</label><input type="text" name="pendidikan[${i}][keterangan]" class="form-control"></div>
        <div class="col-12 col-md-1 d-flex align-items-end"><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.item-row').remove()">X</button></div>
    </div>`,
    kerja: (i) => `<div class="row mb-3 item-row">
        <div class="col-12 col-md-11"><label class="form-label">Keterangan</label><textarea name="kerja[${i}][keterangan]" class="form-control" rows="2"></textarea></div>
        <div class="col-12 col-md-1 d-flex align-items-end"><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.item-row').remove()">X</button></div>
    </div>`,
    organisasi: (i) => `<div class="row mb-3 item-row">
        <div class="col-12 col-md-4"><label class="form-label">Nama Organisasi</label><input type="text" name="organisasi[${i}][nama_organisasi]" class="form-control"></div>
        <div class="col-12 col-md-3"><label class="form-label">Jabatan</label><input type="text" name="organisasi[${i}][jabatan]" class="form-control"></div>
        <div class="col-12 col-md-4"><label class="form-label">Keterangan</label><input type="text" name="organisasi[${i}][keterangan]" class="form-control"></div>
        <div class="col-12 col-md-1 d-flex align-items-end"><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.item-row').remove()">X</button></div>
    </div>`,
    prestasi: (i) => `<div class="row mb-3 item-row">
        <div class="col-12 col-md-6"><label class="form-label">Nama Penghargaan</label><input type="text" name="prestasi[${i}][nama_penghargaan]" class="form-control"></div>
        <div class="col-12 col-md-2"><label class="form-label">Tahun</label><input type="text" name="prestasi[${i}][tahun]" class="form-control" maxlength="4"></div>
        <div class="col-12 col-md-3"><label class="form-label">Dokumen</label><input type="text" name="prestasi[${i}][dokumen]" class="form-control"></div>
        <div class="col-12 col-md-1 d-flex align-items-end"><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.item-row').remove()">X</button></div>
    </div>`,
    pelatihan: (i) => `<div class="row mb-3 item-row">
        <div class="col-12 col-md-5"><label class="form-label">Nama Pelatihan</label><input type="text" name="pelatihan[${i}][nama_pelatihan]" class="form-control"></div>
        <div class="col-12 col-md-2"><label class="form-label">Tahun</label><input type="text" name="pelatihan[${i}][tahun]" class="form-control" maxlength="4"></div>
        <div class="col-12 col-md-4"><label class="form-label">Sertifikat</label><input type="text" name="pelatihan[${i}][sertifikat]" class="form-control"></div>
        <div class="col-12 col-md-1 d-flex align-items-end"><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.item-row').remove()">X</button></div>
    </div>`,
    bahasa: (i) => `<div class="row mb-3 item-row">
        <div class="col-12 col-md-5"><label class="form-label">Bahasa</label><input type="text" name="bahasa[${i}][bahasa]" class="form-control"></div>
        <div class="col-12 col-md-6"><label class="form-label">Keterangan (level)</label><input type="text" name="bahasa[${i}][keterangan]" class="form-control"></div>
        <div class="col-12 col-md-1 d-flex align-items-end"><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.item-row').remove()">X</button></div>
    </div>`,
    rekomendasi: (i) => `<div class="row mb-3 item-row">
        <div class="col-12 col-md-3"><label class="form-label">Nama</label><input type="text" name="rekomendasi[${i}][nama_perekomendasi]" class="form-control"></div>
        <div class="col-12 col-md-2"><label class="form-label">Posisi</label><input type="text" name="rekomendasi[${i}][posisi]" class="form-control"></div>
        <div class="col-12 col-md-3"><label class="form-label">No HP</label><input type="text" name="rekomendasi[${i}][no_hp]" class="form-control"></div>
        <div class="col-12 col-md-3"><label class="form-label">Alamat</label><input type="text" name="rekomendasi[${i}][alamat]" class="form-control"></div>
        <div class="col-12 col-md-1 d-flex align-items-end"><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.item-row').remove()">X</button></div>
    </div>`,
};

let counters = {};

function addRow(section) {
    const container = document.getElementById(section + '-container');
    const emptyMsg = document.getElementById(section + '-empty');
    if (emptyMsg) emptyMsg.remove();

    if (!counters[section]) {
        counters[section] = container.querySelectorAll('.item-row').length;
    }
    counters[section]++;
    container.insertAdjacentHTML('beforeend', templates[section](counters[section]));
}
</script>

@endsection
