<x-app-layout :assets="$assets ?? []">
    <div>
       {!! Form::open(['route' => ['send.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
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
                                 <select class="form-select" id="tipe">
                                    <option value="single">Single</option>
                                    <option value="blasting">Blasting</option>
                                </select>        
                              </div>  
                          </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="tujuan">Tujuan<span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                 {{ Form::text('tujuan', null, ['class' => 'form-control', 'placeholder' => 'example@gmail.com', 'id' => 'tujuan']) }}
                                 {{ Form::file('blasting_file', ['class' => 'form-control', 'id' => 'blasting_file']) }}
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
                                 {{ Form::textarea('isi', null, ['class' => 'form-control', 'placeholder' => 'Isi Email', 'required', 'id' => 'isi']) }}

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
   tinymce.init({
     selector: 'textarea',
     height : '800',
     plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss',
     toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
     tinycomments_mode: 'embedded',
     tinycomments_author: 'Author name',
     mergetags_list: [
       { value: 'nama', title: 'Nama' },
       { value: 'pin', title: 'PIN' },
     ]
   });
 </script>

 <script>
$( '#tipe' ).select2( {
    theme: 'bootstrap-5'
} );
   </script>

<!-- (Kode yang telah Anda berikan sebelumnya) -->

<!-- (Kode yang telah Anda berikan sebelumnya) -->

<script>
    $(document).ready(function() {
        const tipeSelect = $("#tipe");
        const tujuanInput = $("#tujuan");
        const blastingFileInput = $("#blasting_file");

        function toggleInputs() {
            if (tipeSelect.val() === "single") {
                tujuanInput.show();
                blastingFileInput.hide();
            } else if (tipeSelect.val() === "blasting") {
                tujuanInput.hide();
                blastingFileInput.show();
            }
        }

        // Panggil fungsi toggleInputs untuk kondisi awal (default option single)
        toggleInputs();

        // Tambahkan event listener untuk menangkap perubahan pada dropdown "Tipe"
        tipeSelect.on("change", function() {
            // Panggil fungsi toggleInputs untuk menampilkan atau menyembunyikan elemen berdasarkan nilai yang dipilih
            toggleInputs();
        });

        // Set nilai default untuk dropdown "Tipe"
        const tipeValue = "{{ $assets['tipe'] ?? 'single' }}";
        tipeSelect.val(tipeValue);
    });
</script>



