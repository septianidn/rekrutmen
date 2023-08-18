<?php
$data = $data ?? null;
$id_datapedia ?? null;
?>
@if(isset($data))
{!! Form::model($data, ['route' => ['datapediadetail.update', $data->id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
@else
{!! Form::open(['route' => ['datapediadetail.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
@endif

{{ Form::hidden('data_pedia_id', isset($id_datapedia) ? $id_datapedia : old('data_pedia_id'), ['class' => 'form-control']) }}

<div class="form-group col-md-12">
    <label class="form-label" for="fname">Data Label<span class="text-danger">*</span></label>
    {{ Form::text('label', old('label'), ['class' => 'form-control', 'placeholder' => 'Isikan label', 'id' => 'label', 'required']) }}
</div>
<div class="form-group col-md-12">
    <label class="form-label" for="fname">Data Value</label>
    {{ Form::text('value', old('value'), ['class' => 'form-control', 'placeholder' => 'Isikan value', 'id' => 'value']) }}
</div>
<div class="form-group col-md-12">
    <label class="form-label" for="fname">Published<span class="text-danger">*</span></label>
    {{ Form::select('publish', [1 => 'Published', 0 => 'Not Published'], old('publish'), ['class' => 'form-control',  'required']) }}
</div>
<div class="float-end">
    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Kembali</button>
    <button type="submit" class="btn btn-sm btn-primary">{{$data !== null ? 'Update' : 'Tambah' }}</button>
</div>
      
{!! Form::close() !!}


<script>
    $(document).ready(function() {
        function generateAliasURL(label) {
            let alias = label.toLowerCase();
            $('#value').val(alias);
        }

        $('#label').on('input', function() {
            const label = $(this).val();
            generateAliasURL(label);
        });
    });
</script>