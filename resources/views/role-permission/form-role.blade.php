<?php
    $id = $id ?? null;
    $data = $data ?? null;
?>
@if(isset($id))
{!! Form::model($data, ['route' => ['backoffice.role.update', $id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
@else
{!! Form::open(['route' => ['backoffice.role.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
@endif
    <div class="form-group">
        <label class="form-label">Nama Role</label>
        {{ Form::text('title', old('title'), ['class' => 'form-control','id' => 'role-title', 'placeholder' => 'Role Title', 'required']) }}
    </div>
    <label class="form-label">Status</label>
    <div class="form-check">
        {{ Form::radio('status', '1',old('status'), ['class' => 'form-check-input', 'id' => 'roleassigned']); }}
        <label class="form-check-label" for="roleassigned">Yes</label>
    </div>
    <div class="mb-3 form-check">
        {{ Form::radio('status', '0',old('status'), ['class' => 'form-check-input', 'id' => 'rolenotassigned']); }}
        <label class="form-check-label" for="rolenotassigned">No</label>
    </div>
    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Simpan</button>
    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
{{ Form::close() }}

