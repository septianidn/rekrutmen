<x-app-layout :assets="$assets ?? []">
    <?php
    $datapediaOptions = App\Models\DataPedia::all() ?? null;
    $id = $id ?? null;
    ?>
    <div>
        @if (isset($id))
            {!! Form::model($data, [
                'route' => ['paket-soal.update', $id],
                'method' => 'patch',
                'enctype' => 'multipart/form-data',
                'id' => 'form-wizard1',
            ]) !!}
        @else
            {!! Form::open([
                'route' => ['paket-soal.store'],
                'method' => 'post',
                'enctype' => 'multipart/form-data',
                'id' => 'form-wizard1',
            ]) !!}
        @endif
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">{{ $id !== null ? 'Update' : 'Tambah' }} Paket Soal</h4>
                                </div>
                                <div class="card-action">
                                    <a href="{{ route('paket-soal.index') }}" class="btn btn-sm btn-primary"
                                        role="button">Kembali</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label text-black" for="nama_paket">Nama Paket<span
                                            class="text-danger">*</span></label>
                                    {{ Form::text('nama_paket', old('nama_paket'), ['class' => 'form-control', 'placeholder' => 'Isi nama paket', 'required', 'id' => 'nama_paket']) }}

                                </div>
                                <div class="form-group ">
                                    <label class="form-label text-black" for="alias_url">Alias URL<span
                                            class="text-danger">*</span></label>

                                    {{ Form::text('alias_url', old('alias_url'), ['class' => 'form-control', 'placeholder' => 'Isi alias url', 'required', 'id' => 'alias_url']) }}

                                </div>
                                <div class="form-group">
                                    <label class="form-label text-black" for="deskripsi_paket">Deskripsi Paket</label>
                                    {{ Form::textarea('deskripsi_paket', old('deskripsi_paket'), ['class' => 'form-control', 'placeholder' => 'Isi deskripsi', 'id' => 'deskripsi_paket']) }}
                                </div>
                                <div class="form-group">
                                    <label class="form-label text-black" for="tahun_pelaksanaan">Tahun Pelaksanaan<span
                                            class="text-danger">*</span></label>
                                        
                                    {{ Form::text('tahun_pelaksanaan', old('tahun_pelaksanaan'), ['class' => 'form-control year-picker', 'placeholder' => 'Isi tahun pelaksanaan', 'required', 'id' => 'tahun_pelaksanaan']) }}

                                </div>
                                <div class="form-group">
                                    <label class="form-label text-black" for="untuk_lulusan">Untuk Lulusan<span
                                            class="text-danger">*</span></label>
                                        
                                    {{ Form::text('untuk_lulusan', old('untuk_lulusan'), ['class' => 'form-control year-picker', 'placeholder' => 'Isi untuk lulusan', 'required', 'id' => 'untuk_lulusan']) }}

                                </div>
                                <div class="form-group">
                                    <label class="form-label text-black" for="tgl_tayang">Tanggal Tayang<span
                                            class="text-danger">*</span></label>

                                    {{ Form::date('tgl_tayang', old('tgl_tayang'), ['class' => 'form-control', 'placeholder' => 'Isi tanggal tayang', 'required', 'id' => 'tgl_tayang']) }}

                                </div>
                                <div class="form-group">
                                    <label class="form-label text-black" for="tgl_selesai_tayang">Tanggal Selesai
                                        Tayang<span class="text-danger">*</span></label>

                                    {{ Form::date('tgl_selesai_tayang', old('tgl_selesai_tayang'), ['class' => 'form-control', 'placeholder' => 'Isi tanggal selesai tayang', 'required', 'id' => 'tgl_selesai_tayang']) }}

                                </div>
                                <hr>
                                <button type="submit" 
                                    class="btn btn-primary btn-sm float-end" >Tambah Paket
                                    Soal</button>
                            </div>
                        </div>
                    </div>
                </div>
           
        
        {!! Form::close() !!}
    </div>
</x-app-layout>

<script src="https://kit.fontawesome.com/243e6ffe26.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<script>
    $(document).ready(function() {
        tinymce.init({
            selector: `textarea#deskripsi_paket`,
            branding: false,
            plugins: 'image code advlist anchor autolink autoresize charmap codesample emoticons fullscreen insertdatetime link lists media preview searchreplace table template visualchars wordcount',
        });
        $("#tahun_pelaksanaan").datepicker({
            format: "yyyy",
            viewMode: "years", 
            minViewMode: "years",
            keyboardNavigation: false 
            });
        $("#untuk_lulusan").datepicker({
        format: "yyyy",
        viewMode: "years", 
        minViewMode: "years"
        });
        function generateAliasURL(namaPaket) {
            // Convert to lowercase
            let alias = namaPaket.toLowerCase();
            // Replace spaces with "-"
            alias = alias.replace(/\s+/g, '-');
            // Update the "Alias URL" field
            $('#alias_url').val("/"+ alias);
        }

        $('#nama_paket').on('input', function() {
            const namaPaket = $(this).val();
            generateAliasURL(namaPaket);
        });
    });
 </script>
 