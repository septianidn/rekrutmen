<?php
$data = $data ?? null;
?>
@if (isset($data))
    {!! Form::model($data, [
        'route' => ['backoffice.provinsi.update', $data->id],
        'method' => 'patch',
        'enctype' => 'multipart/form-data',
    ]) !!}
@else
    {!! Form::open(['route' => ['backoffice.provinsi.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
@endif

<div class="form-group col-md-12">
    <label class="form-label" for="kode_provinsi">Kode Provinsi <span class="text-danger">*</span></label>
    {{ Form::text('kode_provinsi', old('kode_provinsi'), ['class' => 'form-control', 'placeholder' => 'Kode provinsi', 'required']) }}
</div>
<div class="form-group col-md-12">
    <label class="form-label" for="nama_provinsi">Nama Provinsi <span class="text-danger">*</span></label>
    {{ Form::text('nama_provinsi', old('nama_provinsi'), ['class' => 'form-control', 'placeholder' => 'Nama provinsi', 'required']) }}
</div>
<div class="float-end">
    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Kembali</button>
    <button type="submit" class="btn btn-sm btn-primary">{{ $data !== null ? 'Update' : 'Tambah' }} Provinsi</button>
</div>

{!! Form::close() !!}
