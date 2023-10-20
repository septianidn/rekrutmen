<?php
$data = $data ?? null;
$datapedias = \App\Models\DataPediaS::all() ?? null;
?>
@if (isset($data))
    {!! Form::model($data, [
        'route' => ['datapedias.update', $data->id],
        'method' => 'patch',
        'enctype' => 'multipart/form-data',
    ]) !!}
@else
    {!! Form::open(['route' => ['datapedias.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
@endif

<div class="form-group col-md-12">
    <label class="form-label" for="value">Value<span class="text-danger">*</span></label>
    {{ Form::text('value', old('value'), ['class' => 'form-control', 'placeholder' => 'Isikan value', 'required']) }}
</div>
<div class="form-group col-md-12">
    <label class="form-label" for="label">Label</label>
    {{ Form::text('label', old('label'), ['class' => 'form-control', 'placeholder' => 'Isikan label']) }}
</div>
<div class="form-group col-md-12">
    <label class="form-label" for="parent_id">Parent<span class="text-danger">*</span></label>
    {{ Form::select('parent_id', [null => 'No Parent'] + $datapedias->pluck('label', 'id')->toArray(), old('parent_id'), ['class' => 'form-control parent_id', 'id' => 'parent_id']) }}

</div>
<div class="float-end">
    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Kembali</button>
    <button type="submit" class="btn btn-sm btn-primary">{{ $data !== null ? 'Update' : 'Tambah' }} Data Pedia</button>
</div>

{!! Form::close() !!}


<script>
    $(document).ready(function() {
        $('#formModal').on('shown.bs.modal', function() {
            $('.parent_id').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#formModal')
            });
        });

    });
</script>
