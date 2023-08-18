<?php
$data = $data ?? null;
?>
@if(isset($data))
{!! Form::model($data, ['route' => ['datapedia.update', $data->id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
@else
{!! Form::open(['route' => ['datapedia.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
@endif

<div class="form-group col-md-12">
    <label class="form-label" for="fname">Nama Data Pedia<span class="text-danger">*</span></label>
    {{ Form::text('nama_data', old('nama_data'), ['class' => 'form-control', 'placeholder' => 'Isikan nama data pedia', 'required']) }}
</div>
<div class="form-group col-md-12">
    <label class="form-label" for="fname">Deskripsi Data Pedia</label>
    {{ Form::textarea('deskripsi_data', old('deskripsi_data'), ['class' => 'form-control', 'placeholder' => 'Isikan deskripsi data pedia']) }}
</div>
<div class="form-group col-md-12">
    <label class="form-label" for="fname">Published<span class="text-danger">*</span></label>
    {{ Form::select('publish', [1 => 'Published', 0 => 'Not Published'], old('publish'), ['class' => 'form-control', 'required']) }}

</div>
<div class="float-end">
    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Kembali</button>
    <button type="submit" class="btn btn-sm btn-primary">{{$data !== null ? 'Update' : 'Tambah' }} Data Pedia</button>
</div>
      
{!! Form::close() !!}
