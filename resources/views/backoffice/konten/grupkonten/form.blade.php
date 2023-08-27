<?php
    use App\Models\StatusTerbit;

    $id = $id ?? null;
    $data = $data ?? null;
    $publishedOptions = StatusTerbit::all() ?? null;
?>
@if(isset($id))
{!! Form::model($data, ['route' => ['grup-konten.update', $id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
@else
{!! Form::open(['route' => ['grup-konten.store'], 'method' => 'post', 'enctype' => 'multipart/form-data', 'id' => 'formModal' ]) !!}
@endif
    <div class="form-group">
        <label class="form-label">Nama Grup</label>
        {{ Form::text('nama_grup', old('nama_grup'), ['class' => 'form-control','id' => 'nama_grup', 'placeholder' => 'Nama grup', 'required']) }}
    </div>
    <div class="form-group">
        <label class="form-label">Alias URL</label>
        {{ Form::text('alias_url', old('alias_url'), ['class' => 'form-control','id' => 'alias_url', 'placeholder' => 'Alias URL', 'required']) }}
    </div>
    <div class="form-group">
        <label class="form-label">Deskripsi</label>
        {{ Form::textarea('deskripsi', old('deskripsi' ?? null ), ['class' => 'form-control','id' => 'deskripsi', 'placeholder' => 'Deskripsi' ]) }}
    </div>
    <div class="form-group">
        <label class="form-label">Published</label>
        {{ Form::select('published', ['' => 'Pilih Status Terbit', 1 => 'Published',  0 => 'Not Published'], null, [
        'class' => 'form-control select-status-terbit',
        'id' => 'published',
    ]) }}
    
    </div>
    <div class="float-end">
        <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Kembali</button>
        <button type="submit" class="btn btn-sm btn-primary">{{$data !== null ? 'Update' : 'Tambah' }} Grup Konten </button>
    </div>
          
{{ Form::close() }}


<script>
    $(document).ready(function() {
        // Function to generate alias URL from the "Nama Grup"
        function generateAliasURL(namaGrup) {
            // Convert to lowercase
            let alias = namaGrup.toLowerCase();
            // Replace spaces with "-"
            alias = alias.replace(/\s+/g, '-');
            // Update the "Alias URL" field
            $('#alias_url').val("/"+ alias);
        }

        // Trigger alias URL generation when "Nama Grup" input changes
        $('#nama_grup').on('input', function() {
            const namaGrup = $(this).val();
            generateAliasURL(namaGrup);
        });
    });
</script>
