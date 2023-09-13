<?php
    use App\Models\PaketSoal;
    $id = $id ?? null;
    $data = $data ?? null;

    $paketSoalOption = PaketSoal::all();
   
?>
@if(isset($id))
{!! Form::model($data, ['route' => ['laporan-tracer-study.update', $id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
@else
{!! Form::open(['route' => ['laporan-tracer-study.store'], 'method' => 'post', 'enctype' => 'multipart/form-data', 'id' => 'formModal' ]) !!}
@endif
    <div class="form-group">
        <label class="form-label">Paket Soal</label>
        {{ Form::select('paket_soal_id', $paketSoalOption->pluck('nama_paket', 'id'), old('paket_soal_id'), ['class' => 'form-control', 'id' => 'paket_soal_id', 'placeholder' => 'Pilih Paket Soal', 'required']) }}
    </div>
    <div class="form-group">
        <label class="form-label">Deskripsi</label>
        {{ Form::textarea('deskripsi', old('deskripsi' ?? null), ['class' => 'form-control', 'id' => 'deskripsi', 'placeholder' => 'Deskripsi', 'rows' => 3]) }}
    </div>
    
    <div class="form-group">
        <label class="form-label">File Laporan Tracer Study</label>
        <input type="file" 
        class="filepond"
        name="filepond" 
        multiple 
        data-allow-reorder="true"
        data-max-file-size="3MB"
        data-max-files="3">

    </div>
    <div class="form-group">
        <label class="form-label">Published</label>
        {{ Form::select('published', [ 1 => 'Published',  0 => 'Draft'], null, [
        'class' => 'form-control select-status-terbit',
        'id' => 'published',
    ]) }}
    
    </div>
    <div class="float-end">
        <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Kembali</button>
        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
    </div>
          
{{ Form::close() }}


{{-- <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script> --}}
<script>

    // Register any plugins
    FilePond.registerPlugin();

    // Create FilePond object
    const inputElement = document.querySelector('.filepond');
    const pond = FilePond.create(inputElement);
  
</script>
