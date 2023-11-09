<x-app-layout :assets="$assets ?? []">
    <div>
        <?php
        $id = $id ?? null;
        $grupKontenOptions = App\Models\GrupKonten::all();
        $kategoriKontenOptions = App\Models\KategoriKonten::all();
        ?>
        @if (isset($id))
            {!! Form::model($data, [
                'route' => ['backoffice.kelola-konten.update', $id],
                'method' => 'patch',
                'enctype' => 'multipart/form-data',
            ]) !!}
        @else
            {!! Form::open(['route' => ['backoffice.kelola-konten.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
        @endif
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">{{ $id !== null ? 'Update' : 'Tambah' }} Konten</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <label class="form-label" for="judul">Judul <span
                                            class="text-danger">*</span></label>
                                    {{ Form::text('judul', old('judul'), ['class' => 'form-control', 'placeholder' => 'Isikan Judul', 'required', 'id' => 'judul']) }}

                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="alias_url">Alias URL <span
                                            class="text-danger">*</span></label>
                                    {{ Form::text('alias_url', old('alias_url'), ['class' => 'form-control', 'placeholder' => 'Isi Alias Url', 'required', 'id' => 'alias_url']) }}

                                </div>
                                <div class="form-group">
                                    {{ Form::textarea('isi_konten', old('isi_konten'), ['class' => 'form-control', 'placeholder' => 'Isi Konten', 'id' => 'isi_konten']) }}
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="bd-example">
                                    <div class="accordion" id="accordionExample">
                                        <div class="accordion-item">
                                            <h4 class="accordion-header" id="headingOne">
                                                <button class="accordion-button" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                    aria-expanded="true" aria-controls="collapseOne">
                                                    Published
                                                </button>
                                            </h4>
                                            <div id="collapseOne" class="accordion-collapse collapse show"
                                                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="d-flex justify-content-between">
                                                        <button type="submit" class="btn  btn-soft-light">Save
                                                            Draft</button>
                                                        <button type="button"
                                                            class="btn btn-soft-light">Preview</button>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <label class="form-label" for="waktu_terbit">Waktu
                                                            Terbit</label>
                                                        {{ Form::datetimeLocal('waktu_terbit', old('waktu_terbit'), ['class' => 'form-control', 'placeholder' => 'Isi waktu terbit', 'id' => 'waktu_terbit']) }}
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label" for="waktu_tutup">Waktu Tutup </label>
                                                        {{ Form::datetimeLocal('waktu_tutup', old('waktu_tutup'), ['class' => 'form-control', 'placeholder' => 'Isi waktu tutup', 'id' => 'waktu_tutup']) }}
                                                    </div>
                                                    <hr>
                                                    <div class="d-flex justify-content-end">
                                                        <button type="submit"
                                                            class="btn btn-primary btn-xs ">Publish</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bd-example mt-2">
                                    <div class="accordion" id="kategori">
                                        <div class="accordion-item">
                                            <h4 class="accordion-header" id="headingKategori">
                                                <button class="accordion-button" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseKategori"
                                                    aria-expanded="true" aria-controls="collapseKategori">
                                                    Kategori
                                                </button>
                                            </h4>
                                            <div id="collapseKategori" class="accordion-collapse collapse show"
                                                aria-labelledby="headingKategori" data-bs-parent="#kategori">
                                                <div class="accordion-body">
                                                    <div class="form-group">
                                                        <label class="form-label" for="grup_konten_id">Grup
                                                            Konten</label>
                                                        {{ Form::select(
                                                            'grup_konten_id',
                                                            $grupKontenOptions->pluck('nama_grup', 'id')->toArray(),
                                                            old('grup_konten_id'),
                                                            [
                                                                'class' => 'form-control select-grup-konten',
                                                                'id' => 'grup_konten_id',
                                                            ],
                                                        ) }}
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label" for="kategori_konten_id">Kategori
                                                            Konten </label>
                                                        {{ Form::select(
                                                            'kategori_konten_id',
                                                            $kategoriKontenOptions->pluck('nama_kategori', 'id')->toArray(),
                                                            old('kategori_konten_id'),
                                                            [
                                                                'class' => 'form-control select-kategori-konten',
                                                                'id' => 'kategori_konten_id',
                                                            ],
                                                        ) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bd-example mt-2">
                                    <div class="accordion" id="tagsParent">
                                        <div class="accordion-item">
                                            <h4 class="accordion-header" id="headingTags">
                                                <button class="accordion-button" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseTags"
                                                    aria-expanded="true" aria-controls="collapseTags">
                                                    Tags
                                                </button>
                                            </h4>
                                            <div id="collapseTags" class="accordion-collapse collapse show"
                                                aria-labelledby="headingTags" data-bs-parent="#tagsParent">
                                                <div class="accordion-body">
                                                    <div class="form-group">
                                                        {{ Form::text('tags', old('tags'), ['class' => 'form-control', 'placeholder' => 'Isi tags', 'id' => 'tags']) }}
                                                        <p class="mt-2"><small>Jika tag lebih dari satu, pisah dengan
                                                                tanda koma.</small></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bd-example mt-2">
                                    <div class="accordion" id="gambarParent">
                                        <div class="accordion-item">
                                            <h4 class="accordion-header" id="headingGambar">
                                                <button class="accordion-button" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseGambar"
                                                    aria-expanded="true" aria-controls="collapseGambar">
                                                    Gambar Headline
                                                </button>
                                            </h4>
                                            <div id="collapseGambar" class="accordion-collapse collapse show"
                                                aria-labelledby="headingGambar" data-bs-parent="#gambarParent">
                                                <div class="accordion-body">
                                                    <div class="bd-example">
                                                        <figure class="figure">
                                                            <svg class="bd-placeholder-img figure-img img-fluid rounded"
                                                                width="400" height="200"
                                                                xmlns="http://www.w3.org/2000/svg" role="img"
                                                                aria-label="Placeholder: 400x200"
                                                                preserveAspectRatio="xMidYMid slice"
                                                                focusable="false">
                                                                <title>Placeholder</title>
                                                                <rect width="100%" height="100%" fill="#f5f5f5">
                                                                </rect>
                                                                <image id="selectedImage" x="0"
                                                                    y="0" width="100%" height="100%"
                                                                    xlink:href="" />
                                                            </svg>

                                                        </figure>
                                                        <button type="button" class="btn btn-primary w-100">
                                                            Tambah Gambar
                                                            <input type="file" id="fileInput"
                                                                accept=".png, .jpeg, .jpg, .svg"
                                                                style="opacity: 0; position: absolute; left: 0; top: 0;" />
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>


                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</x-app-layout>

<script>
    $('#fileInput').on('change', function() {
        var fileInput = this;
        var selectedImage = document.getElementById('selectedImage');

        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                selectedImage.setAttribute('xlink:href', e.target.result);
            };

            reader.readAsDataURL(fileInput.files[0]);
        }
    });
    const tags = $("#tags");
    tinymce.init({
        selector: '#isi_konten',
        height: '800',

        tinycomments_mode: 'embedded',

    });

    tagifyInstance = new Tagify(tags.get(0));

    function generateAliasURL(judul) {
        // Convert to lowercase
        let alias = judul.toLowerCase();
        // Replace spaces with "-"
        alias = alias.replace(/\s+/g, '-');
        // Update the "Alias URL" field
        $('#alias_url').val("/" + alias);
    }
    $('#judul').on('input', function() {
        const judul = $(this).val();
        generateAliasURL(judul);
    });

    $('.select-grup-konten').select2({
        theme: 'bootstrap-5'
    });
    $('.select-kategori-konten').select2({
        theme: 'bootstrap-5'

    })
    $('.select-grup-konten').on('change', function() {
        var selectedGrupKonten = $(this).val();

        var filteredKategoriOptions = {!! $kategoriKontenOptions->toJson() !!}.filter(function(kategori) {
            return selectedGrupKonten.includes(kategori.grup_konten_id.toString());
        });


        $('.select-kategori-konten').empty();


        filteredKategoriOptions.forEach(function(kategori) {
            $('.select-kategori-konten').append(new Option(kategori.nama_kategori, kategori.id, false,
                false));
        });

    });
</script>
