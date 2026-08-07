<?php
$data = $data ?? null;
?>
@if(isset($data))
{!! Form::model($data, ['route' => ['backoffice.posisi.update', $data->id], 'method' => 'patch']) !!}
@else
{!! Form::open(['route' => ['backoffice.posisi.store'], 'method' => 'post']) !!}
@endif

<div class="form-group col-md-12">
    <label class="form-label" for="nama_posisi">Posisi <span class="text-danger">*</span></label>
    {{ Form::text('nama_posisi', old('nama_posisi'), ['class' => 'form-control', 'placeholder' => 'Nama Posisi', 'maxlength' => 100, 'required']) }}
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Kembali</button>
    <button type="submit" class="btn btn-sm btn-primary">{{ $data !== null ? 'Update' : 'Tambah' }} Posisi</button>
</div>

{!! Form::close() !!}
