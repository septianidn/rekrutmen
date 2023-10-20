<?php
$selectedIdBlasting = $selectedIdBlasting ?? null;
$paketSoalOption = $paketSoalOption ?? null;
$templateEmailOption = $templateEmailOption ?? null;
?>

{!! Form::open([
    'route' => ['databasealumni.store'],
    'method' => 'post',
    'enctype' => 'multipart/form-data',
    'id' => 'formModalBlasting',
]) !!}

<div class="row">
    <div class="form-group col-md-6">
        <label class="form-label" for="paket_soal_id">Paket Soal TS <span class="text-danger">*</span></label>
        {{ Form::select('paket_soal_id', $paketSoalOption, null, ['class' => 'form-control', 'placeholder' => 'Pilih Paket Soal', 'id' => 'paket_soal_id', 'required']) }}

    </div>
    <div class="form-group col-md-6">
        <label class="form-label" for="template_id">Template Email <span class="text-danger">*</span></label>
        {{ Form::select('template_id', $templateEmailOption, null, ['class' => 'form-control', 'placeholder' => 'Pilih Template Email', 'id' => 'template_id', 'required']) }}
        <small>Kelola temmplate email <a href="{{ route('template.index') }}">disini</a></small>
    </div>

</div>

<div class="float-end">
    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Kembali</button>
    <button type="submit" class="btn btn-sm btn-primary">Blasting Email</button>
</div>

{!! Form::close() !!}


<script>
    $(document).ready(function() {
        $('#formModal').on('shown.bs.modal', function() {
            $('#paket_soal_id').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#formModal'),
                placeholder: 'Pilih Paket Soal'
            });
            $('#template_id').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#formModal'),
                placeholder: 'Pilih Template Email'
            });

        });

    });
</script>
