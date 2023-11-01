<?php
$data = $data ?? null;
?>
@if(isset($data))
{!! Form::model($data, ['route' => ['backoffice.jenjang.update', $data->id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
@else
{!! Form::open(['route' => ['backoffice.jenjang.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
@endif

<div class="form-group col-md-12">
    <label class="form-label" for="fname">Jenjang <span class="text-danger">*</span></label>
    {{ Form::text('nama_jenjang', old('nama_jenjang'), ['class' => 'form-control', 'placeholder' => 'Nama Jenjang', 'required']) }}
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Kembali</button>
    <button type="submit" class="btn btn-sm btn-primary">{{$data !== null ? 'Update' : 'Tambah' }} Jenjang</button>
</div>

{!! Form::close() !!}
