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

                        <form action="{{ route('employer.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Nama Perusahaan <span class="text-danger">*</span></label>
                                        <input type="text" name="nama_perusahaan" class="form-control"
                                            value="{{ old('nama_perusahaan', $employer->nama_perusahaan) }}" required>
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
                                <label class="form-label">Alamat Perusahaan</label>
                                <input type="text" name="alamat_perusahaan" class="form-control"
                                    value="{{ old('alamat_perusahaan', $employer->alamat_perusahaan) }}">
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
@endsection
