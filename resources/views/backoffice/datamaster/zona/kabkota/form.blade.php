<?php
$data = $data ?? null;
?>
@if(isset($data))
{!! Form::model($data, ['route' => ['backoffice.fakultas.update', $data->id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
@else
{!! Form::open(['route' => ['backoffice.fakultas.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
@endif

<div class="form-group col-md-12">
    <label class="form-label" for="fname">Fakultas <span class="text-danger">*</span></label>
    {{ Form::text('nama_fakultas', old('nama_fakultas'), ['class' => 'form-control', 'placeholder' => 'Nama fakultas', 'required']) }}
</div>
<div class="float-end">
    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Kembali</button>
    <button type="submit" class="btn btn-sm btn-primary">{{$data !== null ? 'Update' : 'Tambah' }} Fakultas</button>
</div>
      
{!! Form::close() !!}
