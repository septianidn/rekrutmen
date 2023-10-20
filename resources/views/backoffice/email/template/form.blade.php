<x-app-layout :assets="$assets ?? []">
    <div>
        <?php
        $id = $id ?? null;
        ?>
        @if (isset($id))
            {!! Form::model($data, [
                'route' => ['template.update', $id],
                'method' => 'patch',
                'enctype' => 'multipart/form-data',
            ]) !!}
        @else
            {!! Form::open(['route' => ['template.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
        @endif
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">{{ $id !== null ? 'Update' : 'Tambah' }} Template Email</h4>
                        </div>
                        <div class="card-action">
                            <a href="{{ route('template.index') }}" class="btn btn-sm btn-primary"
                                role="button">Kembali</a>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="nama_template">Nama Template <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    {{ Form::text('nama_template', old('nama_template'), ['class' => 'form-control', 'placeholder' => 'Nama Template', 'required', 'id' => 'nama_template']) }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="subjek_template">Subjek<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    {{ Form::text('subjek_template', old('subjek_template'), ['class' => 'form-control', 'placeholder' => 'Subjek Template', 'required', 'id' => 'subjek_template']) }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="isi_template">Isi<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    {{ Form::textarea('isi_template', old('isi_template'), ['class' => 'form-control', 'placeholder' => 'Isi Template', 'id' => 'isi_template']) }}

                                </div>
                            </div>

                        </div>
                        <hr>
                        <button type="submit" class="btn  btn-sm  btn-primary">{{ $id !== null ? 'Update' : 'Tambah' }}
                            Template</button>

                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</x-app-layout>

<script>
    tinymce.init({
        selector: '#isi_template',
        height: '800',
        branding: false,
        plugins: " advlist  anchor  autolink autosave template charmap  codesample directionality  emoticons  help image insertdatetime link  lists media   nonbreaking pagebreak   searchreplace table     visualchars wordcount",
        toolbar: "undo redo | template | blocks fontfamily fontsize | styleselect | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify  | link image | outdent indent | numlist bullist | align lineheight checklist bullist numlist | indent outdent | removeformat typography | template",
        menubar: 'file edit view insert format tools table',

        templates: [{
                title: 'Nama',
                description: '',
                content: '<span style="font-weight: bold;">{ $nama }</span>'
            },
            {
                title: 'NIM',
                description: '',
                content: '<span style="font-weight: bold;">{ $nim }</span>'
            },
            {
                title: 'PIN',
                description: '',
                content: '<span style="font-weight: bold;">{ $pin }</span>'
            },

            {
                title: 'Email',
                description: '',
                content: '<span  style="font-weight: bold;">{ $email }</span>'
            },
            {
                title: 'Tahun Masuk',
                description: '',
                content: '<span  style="font-weight: bold;">{ $thn_masuk }</span>'
            },
            {
                title: 'Tahun Lulus',
                description: '',
                content: '<span  style="font-weight: bold;">{ $thn_lulus }</span>'
            },
            {
                title: 'Prodi',
                description: '',
                content: '<span  style="font-weight: bold;">{ $nama_prodi }</span>'
            },
            {
                title: 'Link Pengisian',
                description: '',
                content: '<span  style="font-weight: bold;">{ $link_pengisian }</span>'
            },
            {
                title: 'Status TC',
                description: '',
                content: '<span style="font-weight: bold;">{ $status_tc }</span>'
            }
        ],
        image_title: true,
        automatic_uploads: true,
        file_picker_types: 'image',
        tinycomments_mode: 'embedded',
        mergetags_list: [{
                value: 'nama',
                title: 'Nama'
            },
            {
                value: 'pin',
                title: 'PIN'
            },
        ],
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px, font-weight: bold; }'
    });
</script>
