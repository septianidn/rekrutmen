<?php
$data = $data ?? null;

use App\Models\FakultasProdi;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\Jenjang;

$prodiOptions = Prodi::with('fakultas', 'jenjang')->get();

?>
@if (isset($data))
    {!! Form::model($data, [
        'route' => ['backoffice.databasealumni.update', $data->nim],
        'method' => 'patch',
        'enctype' => 'multipart/form-data',
        'id' => 'formModal',
    ]) !!}
@else
    {!! Form::open([
        'route' => ['backoffice.databasealumni.store'],
        'method' => 'post',
        'enctype' => 'multipart/form-data',
        'id' => 'formModal',
    ]) !!}
@endif

<div class="row">
    <div class="form-group col-md-6">
        <label class="form-label" for="nim">NIM <span class="text-danger">*</span></label>
        {{ Form::text('nim', old('nim'), ['class' => 'form-control', 'placeholder' => 'Nim', 'id' => 'nim', 'required']) }}
    </div>
    <div class="form-group col-md-6">
        <label class="form-label" for="nama">Nama <span class="text-danger">*</span></label>
        {{ Form::text('nama', old('nama'), ['class' => 'form-control', 'placeholder' => 'Nama', 'id' => 'nama', 'required']) }}
    </div>

</div>
<div class="row">
    <div class="form-group col-6">
        <label class="form-label" for="tempat_lahir">Tempat Lahir</span></label>
        {{ Form::text('tempat_lahir', old('tempat_lahir'), ['class' => 'form-control', 'placeholder' => 'Tempat Lahir', 'id' => 'tempat_lahir']) }}
    </div>

    <div class="form-group col-6">
        <label class="form-label" for="tanggal_lahir">Tanggal Lahir </label>
        {{ Form::date('tanggal_lahir', old('tanggal_lahir'), ['class' => 'form-control', 'placeholder' => 'Tanggal Lahir', 'id' => 'tanggal_lahir']) }}
    </div>
</div>
<div class="row">

    <div class="form-group col-md-6">
        <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
        {{ Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Email', 'required', 'id' => 'email']) }}
    </div>
    <div class="form-group col-md-6">
        <label class="form-label" for="nomor_handphone">Nomor Handphone</label>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">+62</span>
            </div>
            {{ Form::text('nomor_handphone', old('nomor_handphone'), ['class' => 'form-control', 'placeholder' => 'Nomor Handphone', 'id' => 'nomor_handphone']) }}
        </div>

    </div>
</div>
<div class="row">

    <div class="form-group col-md-4">
        <label class="form-label" for="pin">PIN </label>
        {{ Form::text('pin', old('pin'), ['class' => 'form-control', 'placeholder' => 'PIN', 'id' => 'pin']) }}
    </div>
    <div class="form-group col-md-4">
        <label class="form-label" for="thn_masuk">Tahun Masuk <span class="text-danger">*</span></label>
        {{ Form::text('thn_masuk', old('thn_masuk'), ['class' => 'form-control', 'id' => 'thn_masuk', 'placeholder' => 'Tahun Masuk', 'required']) }}
    </div>
    <div class="form-group col-md-4">
        <label class="form-label" for="thn_lulus">Tahun Keluar <span class="text-danger">*</span></label>
        {{ Form::text('thn_lulus', old('thn_lulus'), ['class' => 'form-control', 'placeholder' => 'Tahun Lulus', 'id' => 'thn_lulus', 'required']) }}
    </div>
</div>
<div class="row">
    <div class="form-group col-md-4">
        <label class="form-label" for="prodi">Prodi <span class="text-danger">*</span></label>
        {{ Form::select(
            'kode_prodi_id',
            $prodiOptions->map(function ($item) {
                    return [
                        'id' => $item->kode_prodi,
                        'text' => $item->nama_prodi . ' ' . $item->jenjang->nama_jenjang,
                    ];
                })->pluck('text', 'id'),
            old('kode_prodi_id'),
            ['class' => 'form-control', 'id' => 'kode_prodi_id', 'placeholder' => 'Pilih Prodi', 'required'],
        ) }}
    </div>
    <div class="form-group col-md-4">
        <label class="form-label" for="tipe_masuk">Jalur Masuk </label>
        {{ Form::select(
            'tipe_masuk',
            [
                'SNMPTN Jalur Undangan' => 'SNMPTN Jalur Undangan',
                'SNMPTN Jalur Ujian Tulis' => 'SNMPTN Jalur Ujian Tulis',
                'Reguler Mandiri' => 'Reguler Mandiri',
                'Program Internasional' => 'Program Internasional',
                'Pindahan' => 'Pindahan',
                'Transfer' => 'Transfer',
            ],
            old('tipe_masuk'),
            ['class' => 'form-control', 'placeholder' => 'Pilih Jalur Masuk', 'id' => 'tipe_masuk'],
        ) }}

    </div>
    <div class="form-group col-md-4">
        <label class="form-label" for="periode_wisuda">Periode Wisuda</label>
        {{ Form::select(
            'periode_wisuda',
            [
                'Wisuda I' => 'Wisuda I',
                'Wisuda II' => 'Wisuda II',
                'Wisuda III' => 'Wisuda III',
                'Wisuda IV' => 'Wisuda IV',
                'Wisuda V' => 'Wisuda V',
            ],
            old('periode_wisuda'),
            ['class' => 'form-control', 'placeholder' => 'Pilih Periode Wisuda', 'id' => 'periode_wisuda'],
        ) }}
    </div>
</div>
<div class="row">

    <div class="form-group col-md-6">
        <label class="form-label" for="nik">NIK</label>
        {{ Form::text('nik', old('nik'), ['class' => 'form-control', 'placeholder' => 'NIK', 'id' => 'nik']) }}
    </div>
    <div class="form-group col-md-6">
        <label class="form-label" for="npwp">NPWP</label>
        {{ Form::text('npwp', old('npwp'), ['class' => 'form-control', 'placeholder' => 'NPWP', 'id' => 'npwp']) }}
    </div>
</div>
<div class="form-group col-md-12">
    <label class="form-label" for="judul_tesis">Judul Tesis</label>
    {{ Form::textarea('judul_tesis', old('judul_tesis'), ['rows' => '2', 'class' => 'form-control', 'placeholder' => 'Judul Tesis', 'id' => 'judul_tesis']) }}
</div>


<div class="float-end">

    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Kembali</button>
    <button type="submit" class="btn btn-sm btn-primary">{{ $data !== null ? 'Update' : 'Tambah' }} Alumni</button>
</div>

{!! Form::close() !!}


<script>
    $(document).ready(function() {
        $('#formModal').on('shown.bs.modal', function() {
            $('#kode_prodi_id').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#formModal'),
                placeholder: 'Pilih Prodi'
            });
            $('#tipe_masuk').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#formModal'),
                placeholder: 'Pilih Jalur Masuk'
            });
            $('#periode_wisuda').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#formModal'),
                placeholder: 'Pilih Periode Wisuda'
            });
        });

    });
</script>
