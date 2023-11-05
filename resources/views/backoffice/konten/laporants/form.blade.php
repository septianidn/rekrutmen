<x-app-layout :assets="$assets ?? []">
    <div>
        <?php
        $id = $id ?? null;
        $data = $data ?? null;
        ?>
        @if (isset($id))
            {!! Form::model($data, [
                'route' => ['backoffice.laporan.update', $id],
                'method' => 'patch',
                'enctype' => 'multipart/form-data',
            ]) !!}
        @else
            {!! Form::open([
                'route' => ['backoffice.laporan.store'],
                'method' => 'post',
                'enctype' => 'multipart/form-data',
                'id' => 'formModal',
            ]) !!}
        @endif
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">{{ $id !== null ? 'Update' : 'Tambah' }} Laporan Tracer Study</h4>
                        </div>
                        <div class="card-action">
                            <a href="{{ route('backoffice.laporan.index') }}" class="btn btn-sm btn-danger"
                                role="button">Kembali</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Paket Soal</label>
                                    @if ($data)
                                        {{ Form::select('paket_soal_id', $tcOptionsAll, old('paket_soal_id'), ['class' => 'form-control', 'id' => 'paket_soal_id', 'placeholder' => 'Pilih Paket Soal', 'required']) }}
                                    @else
                                        {{ Form::select('paket_soal_id', $tcOptions, old('paket_soal_id'), ['class' => 'form-control', 'id' => 'paket_soal_id', 'placeholder' => 'Pilih Paket Soal', 'required']) }}
                                    @endif
                                    <small class="mb-2">Jika pilihan tidak tersedia, silahkan tambahkan paket soal
                                        terlebih
                                        dahulu <a href="{{ route('backoffice.paket-soal.index') }}">disini</a></small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Deskripsi</label>
                                    {{ Form::textarea('deskripsi', old('deskripsi' ?? null), ['class' => 'form-control', 'id' => 'deskripsi', 'placeholder' => 'Deskripsi', 'rows' => 3]) }}
                                </div>

                                <div class="form-group">
                                    <label class="form-label">File Laporan Tracer Study</label>

                                    <input type="file" class="filepond" name="lokasi_laporan" id="lokasi_laporan"
                                        data-max-file-size="5MB" data-min-file-size="1MB" data-max-files="1">
                                    <small>Silahkan unggah dokumen laporan dengan format <strong> .pdf </strong>, dengan
                                        ukuran
                                        maksimal
                                        5MB</small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Published</label>
                                    {{ Form::select('published', [1 => 'Published', 0 => 'Draft'], null, [
                                        'class' => 'form-control select-status-terbit',
                                        'id' => 'published',
                                    ]) }}

                                </div>

                            </div>

                            <hr>

                        </div>

                        <div class="float-end">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        {!! Form::close() !!}
    </div>
</x-app-layout>


@php
    $laporants = optional($data)->getFirstMedia('laporants');
    $laporantsUrl = $laporants ? $laporants->getUrl() : null;
@endphp

<script>
    // Register any plugins
    FilePond.registerPlugin(FilePondPluginFileValidateType, FilePondPluginFileValidateSize, FilePondPluginPdfPreview);


    var inputElement = document.querySelector('#lokasi_laporan');
    var pond = FilePond.create(inputElement, {
        allowProcess: true,
        allowPdfPreview: true,
        pdfPreviewHeight: 1200,
        acceptedFileTypes: "application/pdf",
        pdfComponentExtraParams: 'toolbar=0&view=fit&page=1',
        @if ($laporantsUrl !== null)
            files: [{

                source: '{{ $laporantsUrl }}',
                options: {
                    type: 'local'
                }

            }],
        @endif
        server: {
            url: "/backoffic3", // Ganti URL sesuai dengan endpoint Anda
            process: {
                url: "/upload-laporants",
                method: 'POST', // Tambahkan metode POST di sini
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                },
                onerror: (response) => {
                    // Tangani kesalahan di sini dan cetak pesan kesalahan
                    console.error('Kesalahan saat memproses unggahan:', response);
                },
            },
            revert: {
                url: "/delete-laporants",
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                onerror: (response) => {
                    // Tangani kesalahan di sini dan cetak pesan kesalahan
                    console.error('Kesalahan saat menghapus unggahan:', response);
                },
            },
            load: (uniqueFileId, load, error, progress, abort, headers) => {
                fetch('{{ $laporantsUrl }}')
                    .then((res) => {
                        if (!res.ok) {
                            throw new Error(`Network response was not ok: ${res.status}`);
                        }
                        return res.blob();
                    })
                    .then(load)
                    .catch(error);
            },
        },
    });

    function destroyFilePondAndRemoveInputElement() {
        if (pond) {
            pond.destroy();
        } else if (inputElement) {
            inputElement = null;
        }

    }

    $('#formModal').on('hidden.bs.modal', function() {
        destroyFilePondAndRemoveInputElement();
    });
</script>
