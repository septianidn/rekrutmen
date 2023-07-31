<?php
    $id = $id ?? null;
    $data = $data ?? null;
    $parentOptions = \Spatie\Permission\Models\Permission::all() ?? null;
?>
@if(isset($id))
{!! Form::model($data, ['route' => ['permission.update', $id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
@else
{!! Form::open(['route' => ['permission.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
@endif
    <div class="form-group">
        <label class="form-label">Nama Permission</label>
        {{ Form::text('title', old('title'), ['class' => 'form-control','id' => 'permission-title', 'placeholder' => 'Permission Title', 'required']) }}
    </div>
    <div class="form-group">
        <label class="form-label">Parent</label>
        {{ Form::select('parent_id', [null => 'No Parent'] + $parentOptions->pluck('title', 'id')->toArray(), old('parent_id'), ['class' => 'form-control select-permission-parent', 'id' => 'permission-parent']) }}
    </div>
    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Simpan</button>
    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>

{{ Form::close() }}

<script>
    $(document).ready(function() {
        $('#formModal').on('shown.bs.modal', function() {
            $('.select-permission-parent').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#formModal')
            });
        });

        $('#formModal').on('hidden.bs.modal', function() {
            $('.select-permission-parent').select2('destroy');
        });
    });
</script>




