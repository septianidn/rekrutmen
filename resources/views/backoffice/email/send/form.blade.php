@php
$templateOptions = \App\Models\EmailTemplate::all() ?? null;
@endphp

<x-app-layout :assets="$assets ?? []">
    <div>
        {!! Form::open(['route' => ['backoffice.send.store'], 'method' => 'post', 'enctype' => 'multipart/form-data', 'novalidate']) !!}
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
                              <label class="col-sm-2 col-form-label" for="tujuan">Tipe<span class="text-danger">*</span></label>
                              <div class="col-sm-10">
                                {{ Form::select('tipe', ['single' => 'Single or Multiple', 'blasting' => 'Blasting From File'], null, ['class' => 'form-control', 'id' => 'tipe']) }}
                              </div>  
                          </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="tujuan">Tujuan<span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                 {{ Form::text('tujuan', null, ['class' => 'form-control', 'placeholder' => 'youremail@example.com', 'id' => 'tujuan']) }}
                                 <span class="m-0 mt-2" id="mutiple-text">
                                    <small>Jika tujuan lebih dari satu, pisah dengan tanda koma.</small>
                                  </span>
                                 {{ Form::file('blasting_file', ['class' => 'form-control', 'id' => 'blasting_file', 'accept' => '.csv']) }}
                                 <span class="m-0 mt-2" id="blasting-text">
                                    <small>Format file harus bertipe *.csv, download format file blasting <a href="{{ asset('format/blasting_email.csv') }}" download> disini </a></small>
                                  </span>
                                  

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="subjek">Subjek<span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    {{ Form::text('subjek', null, ['class' => 'form-control', 'placeholder' => 'Subjek', 'required','id' => 'subjek']) }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="isi">Isi<span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                 {{ Form::textarea('isi' , null, ['class' => 'form-control', 'placeholder' => 'Isi Email', 'required', 'id' => 'isi']) }}
                             </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="template">Template</label>
                                <div class="col-sm-10">
                                    {{ Form::select('id_template', ['default' => 'No Template'] + $templateOptions->pluck('nama_template', 'id')->toArray(), null , ['class' => 'form-control', 'id' => 'template']) }}
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

        
        var selectedTemplate =  $("#template");
        const tipeSelect = $("#tipe");
        const tujuanInput = $("#tujuan");
        const blastingFileInput = $("#blasting_file");
        const blastingText = $("#blasting-text");
        const mutipleText = $("#mutiple-text");
        let tagifyInstance; 

        $( '#tipe' ).select2( {
            theme: 'bootstrap-5'
        });
        $( '#template' ).select2( {
            theme: 'bootstrap-5'
        });

        tinymce.init({
        selector: '#isi',
        height : '800',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss mergetags',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat | mergetags',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        mergetags_list: [
            { value: 'nama', title: 'Nama' },
            { value: 'pin', title: 'PIN' },
        ]
        });

        function changeValueTemplate() {
            var selectedTemplateId =  $("#template").val();
            if (selectedTemplateId !== 'default') {
                var selectedTemplateIsi = @json($templateOptions->pluck('isi_template', 'id')->toArray());
                tinymce.activeEditor.setContent(selectedTemplateIsi[selectedTemplateId]);
                console.log(selectedTemplateIsi[selectedTemplateId]);
            } else {
                tinymce.activeEditor.setContent("");
            }
        }
        function changeValueSubject() {
            var selectedTemplateId =  $("#template").val();
            if (selectedTemplateId !== 'default') {
                var selectedTemplateIsi = @json($templateOptions->pluck('isi_template', 'id')->toArray());
                tinymce.activeEditor.setContent(selectedTemplateIsi[selectedTemplateId]);
                console.log(selectedTemplateIsi[selectedTemplateId]);
            } else {
                tinymce.activeEditor.setContent("");
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




