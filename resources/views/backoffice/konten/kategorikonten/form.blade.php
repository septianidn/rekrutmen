<?php
    use App\Models\GrupKonten;

    $id = $id ?? null;
    $data = $data ?? null;
    $grupKontenOptions = GrupKonten::all();
?>
@if(isset($id))
{!! Form::model($data, ['route' => ['kategori-konten.update', $id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
@else
{!! Form::open(['route' => ['kategori-konten.store'], 'method' => 'post', 'enctype' => 'multipart/form-data', 'id' => 'formModal' ]) !!}
@endif
    <div class="form-group">
        <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
        {{ Form::text('nama_kategori', old('nama_kategori'), ['class' => 'form-control','id' => 'nama_kategori', 'placeholder' => 'Nama Kategori', 'required']) }}
    </div>
    <div class="form-group">
        <label class="form-label">Alias URL <span class="text-danger">*</span></label>
        {{ Form::text('alias_url', old('alias_url'), ['class' => 'form-control','id' => 'alias_url', 'placeholder' => 'Alias URL', 'required']) }}
    </div>
    <div class="form-group">
        <label class="form-label">Deskripsi</label>
        {{ Form::textarea('deskripsi', old('deskripsi' ?? null ), ['class' => 'form-control','id' => 'deskripsi', 'placeholder' => 'Deskripsi' ]) }}
    </div>
    <div class="form-group col-md-12">
        <label class="form-label" for="grup_konten_id">Grup Konten <span class="text-danger">*</span></label>
        {{ Form::select('grup_konten_id', $grupKontenOptions->pluck('nama_grup', 'id')->toArray(), old('grup_konten_id'), ['class' => 'form-control select-grup-konten', 'id' => 'grup-konten-id']) }}
    </div>
    <div class="form-group">
        <label class="form-label">Published</label>
        {{ Form::select('published', [1 => 'Published',  0 => 'Not Published'], null, [
        'class' => 'form-control select-status-terbit',
        'id' => 'published',
    ]) }}
    
    </div>
    <div class="float-end">
        <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Kembali</button>
        <button type="submit" class="btn btn-sm btn-primary">{{$data !== null ? 'Update' : 'Tambah' }} Kategori Konten </button>
    </div>
          
{{ Form::close() }}


<script>
    $(document).ready(function() {
      
        function generateAliasURL(nama_kategori) {
            // Convert to lowercase
            let alias = nama_kategori.toLowerCase();
            // Replace spaces with "-"
            alias = alias.replace(/\s+/g, '-');
            // Update the "Alias URL" field
            $('#alias_url').val("/"+ alias);
        }
        $('#nama_kategori').on('input', function() {
            const nama_kategori = $(this).val();
            generateAliasURL(nama_kategori);
        });

        $('#formModal').on('shown.bs.modal', function() {
            $('#grup-konten-id').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#formModal'),
                placeholder: 'Pilih Grup Konten'
            });
        });
        $('#formModal').on('shown.bs.modal', function() {
            $('#published').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#formModal'),
                placeholder: 'Pilih Status Terbit'
            });
        });
        
    });
</script>
