<?php

$data = $data ?? null;

use App\Models\Fakultas;
use App\Models\Jenjang;

$fakultasOptions = Fakultas::all();
$jenjangOptions = Jenjang::all();

?>
@if(isset($data))
{!! Form::model($data, ['route' => ['prodi.update', $data->kode_prodi], 'method' => 'patch' , 'enctype' => 'multipart/form-data', 'id' => 'formModal']) !!}
@else
{!! Form::open(['route' => ['prodi.store'], 'method' => 'post', 'enctype' => 'multipart/form-data', 'id' => 'formModal']) !!}
@endif
<div class="form-group col-md-12">
    <label class="form-label" for="kode_prodi">Kode Prodi <span class="text-danger">*</span></label>
    {{ Form::text('kode_prodi', old('kode_prodi'), ['class' => 'form-control', 'placeholder' => 'Kodi Prodi', 'id' => 'kode_prodi', 'required']) }}
    </div>
<div class="form-group col-md-12">
    <label class="form-label" for="prodi">Nama Prodi <span class="text-danger">*</span></label>
    {{ Form::text('nama_prodi', old('nama_prodi'), ['class' => 'form-control', 'placeholder' => 'Nama Prodi', 'id' => 'prodi', 'required']) }}
</div>

<div class="form-group col-md-12">
    <label class="form-label" for="fakultas">Fakultas <span class="text-danger">*</span></label>
    {{ Form::select('fakultas_id', ['' => 'Pilih Fakultas'] + $fakultasOptions->pluck('nama_fakultas', 'id')->toArray(), old('fakultas_id'), [
        'class' => 'form-control select-fakultas',
        'id' => 'fakultas',
    ]) }}
</div>

<div class="form-group col-md-12">
    <label class="form-label" for="jenjang">Jenjang <span class="text-danger">*</span></label>
    {{ Form::select('jenjang_id',  ['' => 'Pilih Jenjang'] + $jenjangOptions->pluck('nama_jenjang', 'id')->toArray(), old('jenjang_id'), ['class' => 'form-control select-jenjang', 'id' => 'jenjang']) }}
</div>

<div class="float-end">

    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Kembali</button>
     <button type="submit" class="btn btn-sm btn-primary">{{$data !== null ? 'Update' : 'Tambah' }} Prodi</button>
</div>
     

   {!! Form::close() !!}

   <script>
    $(document).ready(function() {
        $('#formModal').on('shown.bs.modal', function() {
            $('.select-fakultas').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#formModal'),
                placeholder: 'Pilih Fakultas'
            });
        });
        $('#formModal').on('shown.bs.modal', function() {
            $('.select-jenjang').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#formModal'),
                placeholder: 'Pilih Jenjang'
            });
        });
    });

   </script>