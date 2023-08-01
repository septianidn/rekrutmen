<?php
$data = $data ?? null;

use App\Models\FakultasProdi;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\Jenjang;

$prodiOptions = Prodi::with('fakultas', 'jenjang')->get();

?>
@if(isset($data))
{!! Form::model($data, ['route' => ['databasealumni.update', $data->nim], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
@else
{!! Form::open(['route' => ['databasealumni.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
@endif
<div class="form-group col-md-12">
    <label class="form-label" for="fname">Nama <span class="text-danger">*</span></label>
    {{ Form::text('nama', old('nama'), ['class' => 'form-control', 'placeholder' => 'Nama', 'required']) }}
</div>
<div class="form-group col-md-12">
    <label class="form-label" for="fname">NIM <span class="text-danger">*</span></label>
    {{ Form::text('nim', old('nim'), ['class' => 'form-control', 'placeholder' => 'Nim', 'required']) }}
</div>
<div class="form-group col-md-12">
    <label class="form-label" for="fname">Prodi <span class="text-danger">*</span></label>
    {{ Form::select('kode_prodi_id', $prodiOptions->map(function ($item) {
        return [
            'id' => $item->kode_prodi,
            'text' => $item->nama_prodi . ' ' . $item->jenjang->nama_jenjang
        ];
    })->pluck('text', 'id'), old('kode_prodi_id'), ['class' => 'form-control', 'id' => 'kode_prodi_id', 'placeholder' => 'Pilih Prodi', 'required']) }}
</div>       
<div class="form-group col-md-12">
    <label class="form-label" for="fname">Email <span class="text-danger">*</span></label>
    {{ Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Email', 'required']) }}
</div>             
    <div class="form-group col-md-12">
    <label class="form-label" for="fname">Tahun Masuk <span class="text-danger">*</span></label>
    {{ Form::text('thn_masuk', old('thn_masuk'), ['class' => 'form-control', 'placeholder' => 'Tahun Masuk', 'required']) }}
</div>
<div class="form-group col-md-12">
    <label class="form-label" for="fname">Tahun Lulus <span class="text-danger">*</span></label>
    {{ Form::text('thn_lulus', old('thn_lulus'), ['class' => 'form-control', 'placeholder' => 'Tahun Lulus', 'required']) }}
</div>

<div class="float-end">

<button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Kembali</button>
 <button type="submit" class="btn btn-sm btn-primary">{{$data !== null ? 'Update' : 'Tambah' }} Alumni</button>
</div>
 
{!! Form::close() !!}
