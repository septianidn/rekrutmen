<x-app-layout :assets="$assets ?? []">
    <div>
        {!! Form::open([
            'route' => ['backoffice.send.store'],
            'method' => 'post',
            'enctype' => 'multipart/form-data',
        ]) !!}
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Kirim Email</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="tujuan">Tipe<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    {{ Form::select('tipe', ['single' => 'Single or Multiple', 'blasting' => 'Blasting From File', 'email_from_file' => 'Import Email From File'], old('tipe'), ['class' => 'form-control', 'id' => 'tipe']) }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="tujuan">Tujuan<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    {{ Form::text('tujuan', null, ['class' => 'form-control', 'placeholder' => 'youremail@example.com', 'id' => 'tujuan']) }}
                                    <span class="m-0 mt-2" id="mutiple-text">
                                        <small>Jika tujuan lebih dari satu, pisah dengan tanda koma.</small>
                                    </span>

                                    {{ Form::file('blasting_file', ['class' => 'form-control', 'id' => 'blasting_file', 'accept' => '.csv']) }}
                                    <span class="m-0 mt-2" id="blasting-text">
                                        <small>Format file harus bertipe *.csv, sesuaikan kolom dengan field yang akan
                                            dikirim.
                                        </small>
                                    </span>

                                    {{ Form::file('email_from_file', ['class' => 'form-control', 'id' => 'email_from_file', 'accept' => '.csv']) }}
                                    <span class="m-0 mt-2" id="email_from_file-text">
                                        <small>Format file harus bertipe *.csv, download format file blasting <a
                                                href="{{ asset('format/send_to_emails.csv') }}" download> disini
                                            </a></small>
                                    </span>


                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="subjek">Subjek<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    {{ Form::text('subjek', old('subjek'), ['class' => 'form-control', 'placeholder' => 'Subjek', 'required', 'id' => 'subjek']) }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="isi">Isi<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    {{ Form::textarea('isi', old('isi'), ['class' => 'form-control', 'placeholder' => 'Isi Email', 'id' => 'isi']) }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="template">Template</label>
                                <div class="col-sm-10">
                                    {{ Form::select('template_id', $templateOptions->pluck('nama_template', 'id')->toArray(), null, ['class' => 'form-control', 'id' => 'template']) }}
                                </div>
                            </div>

                        </div>
                        <hr>
                        <button type="submit" class="btn  btn-sm  btn-primary">Kirim</button>

                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</x-app-layout>


<script>
    $(document).ready(function() {


        var selectedTemplate = $("#template");
        const tipeSelect = $("#tipe");
        const tujuanInput = $("#tujuan");
        const mutipleText = $("#mutiple-text");

        const blastingFileInput = $("#blasting_file");
        const blastingText = $("#blasting-text");

        const emailFromFileInput = $("#email_from_file");
        const emailFromFileText = $("#email_from_file-text");

        let tagifyInstance;

        $('#tipe').select2({
            theme: 'bootstrap-5'
        });
        $('#template').select2({
            theme: 'bootstrap-5'
        });

        tinymce.init({
            selector: '#isi',
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

        function changeValueTemplate() {
            var selectedTemplateId = $("#template").val();
            if (selectedTemplateId !== 1) {
                var selectedTemplateIsi = @json($templateOptions->pluck('isi_template', 'id')->toArray());
                tinymce.activeEditor.setContent(selectedTemplateIsi[selectedTemplateId]);
                console.log(selectedTemplateIsi[selectedTemplateId]);
            } else {
                tinymce.activeEditor.setContent("");
            }
        }

        function changeValueSubject() {
            var selectedTemplateId = $("#template").val();
            const subjectElement = $('#subjek')
            if (selectedTemplateId !== 1) {
                var selectedTemplateSubject = @json($templateOptions->pluck('subjek_template', 'id')->toArray());
                subjectElement.val(selectedTemplateSubject[selectedTemplateId]);

            } else {
                subjectElement.val("");
            }
        }

        changeValueTemplate();
        changeValueSubject();
        selectedTemplate.on("change", function() {
            changeValueTemplate();
            changeValueSubject();
        });


        function toggleInputs() {
            if (tipeSelect.val() === "single") {
                tujuanInput.show();
                mutipleText.show();
                emailFromFileInput.hide();
                emailFromFileText.hide();
                blastingFileInput.hide();
                blastingText.hide();
                if (!tagifyInstance) {
                    tagifyInstance = new Tagify(tujuanInput.get(0), {
                        pattern: /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/,
                    });
                }

            } else if (tipeSelect.val() === "blasting") {
                tujuanInput.hide();
                mutipleText.hide();
                if (tagifyInstance) {
                    tagifyInstance.destroy();
                    tagifyInstance = null;
                }
                blastingFileInput.show();
                blastingText.show();
                emailFromFileInput.hide();
                emailFromFileText.hide();
            } else if (tipeSelect.val() === "email_from_file") {
                if (tagifyInstance) {
                    tagifyInstance.destroy();
                    tagifyInstance = null;
                }
                emailFromFileInput.show();
                emailFromFileText.show();
                tujuanInput.hide();
                mutipleText.hide();
                blastingFileInput.hide();
                blastingText.hide();

            }
        }
        toggleInputs();
        tipeSelect.on("change", function() {
            toggleInputs();
        });
        const tipeValue = "{{ $assets['tipe'] ?? 'single' }}";
        tipeSelect.val(tipeValue);


    });
</script>
