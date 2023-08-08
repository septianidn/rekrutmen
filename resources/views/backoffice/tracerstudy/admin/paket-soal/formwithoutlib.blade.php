<x-app-layout :assets="$assets ?? []">
   <?php
      $id = $id ?? null;
      ?>
   <div>
      @if(isset($id))
      {!! Form::model($data, ['route' => ['paket-soal.update', $id], 'method' => 'patch' , 'enctype' => 'multipart/form-data', 'id' => 'form-wizard1']) !!}
      @else
      {!! Form::open(['route' => ['paket-soal.store'], 'method' => 'post', 'enctype' => 'multipart/form-data', 'id' => 'form-wizard1']) !!}
      @endif
      <!-- fieldsets -->
      <fieldset>
         <div class="form-card text-start">
               <div class="row">
                   <div class="col-sm-12 col-lg-12">
                       <div class="card">
                           <div class="card-header d-flex justify-content-between">
                               <div class="header-title">
                               <h4 class="card-title">{{$id !== null ? 'Update' : 'Tambah' }} Paket Soal</h4>
                               </div>
                               <div class="card-action">
                               <a href="{{route('paket-soal.index')}}" class="btn btn-sm btn-primary" role="button">Kembali</a>
                               </div>
                           </div>
                           <div class="card-body">
                               <div class="form-group row">
                               <label class="col-sm-2 col-form-label text-black" for="nama_paket">Nama Paket<span class="text-danger">*</span></label>
                               <div class="col-sm-10">
                                   {{ Form::text('nama_paket', old('nama_paket'), ['class' => 'form-control', 'placeholder' => 'Isi nama paket', 'required','id' => 'nama_paket']) }}
                               </div>
                               </div>
                               <div class="form-group row">
                               <label class="col-sm-2 col-form-label text-black" for="alias_url">Alias URL<span class="text-danger">*</span></label>
                               <div class="col-sm-10">
                                   {{ Form::text('alias_url', old('alias_url'), ['class' => 'form-control', 'placeholder' => 'Isi alias url', 'required','id' => 'alias_url']) }}
                               </div>
                               </div>
                               <div class="form-group row">
                               <label class="col-sm-2 col-form-label text-black" for="tanggal_tayang">Tanggal Tayang<span class="text-danger">*</span></label>
                               <div class="col-sm-10">
                                   {{ Form::date('tanggal_tayang', old('tanggal_tayang'), ['class' => 'form-control', 'placeholder' => 'Isi tanggal tayang', 'required','id' => 'tanggal_tayang']) }}
                               </div>
                               </div>
                               <div class="form-group row">
                               <label class="col-sm-2 col-form-label text-black" for="tgl_selesai_tayang">Tanggal Selesai Tayang<span class="text-danger">*</span></label>
                               <div class="col-sm-10">
                                   {{ Form::date('tgl_selesai_tayang', old('tgl_selesai_tayang'), ['class' => 'form-control', 'placeholder' => 'Isi tanggal selesai tayang', 'required','id' => 'tgl_selesai_tayang']) }}
                               </div>
                               </div>
                               <hr>
                               <button type="button" name="next" class="btn btn-primary btn-sm next action-button float-end" value="Next" >Input Soal</button>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
      </fieldset>
      <fieldset>
       {{-- FIELD SET INPUT SOAL --}}
           <div class="form-card text-start">
               <div class="row">
                   <div class="col-sm-12 col-lg-12">
                       <div class="card">
                           <h4 class="card-title p-4">{{$id !== null ? 'Update' : 'Tambah' }} Soal</h4>
                       </div>
                   </div>
                   <div class="col-sm-12 col-lg-12" id="card_container">
                    
               
                   </div>  
                   <div class="d-flex justify-content-end my-4"> 
                       <button type="button" name="previous" class="btn btn-dark btn-sm previous action-button-previous me-1" value="Previous" >Kembali</button> 
                       <button type="button" name="next" class="btn btn-primary btn-sm next action-button" value="Next" >Selanjutnya</button>
                   </div>   
               </div>  
           </div>
       </fieldset>
      {!! Form::close() !!}
   </div>
</x-app-layout>

<script>
   document.addEventListener("DOMContentLoaded", function () {

       $('.add_pertanyaan').each(function (index) {
           const addPertanyaan = $(this);

           addPertanyaan.on('click', function () {
               const id = addPertanyaan.attr('id');
               addCard(id);;
           });
       });

       function addCard(id){
           console.log(id)
           refreshCard(2);

       }

       function refreshCard(card){
           for (var i = 1; i <= card; i++) {
               var cardHTML = generateCard(i);
               console.log(cardHTML)
               $("#card_container").append(cardHTML);
           }
       }

       refreshCard(1);

       function generateCard(i) {
               return `<div class="card card-soal[${i}]">
                           <div class="card-body">
                               <div class="row">
                                   <div class="form-group col-sm-10">
                                       <label class="form-label text-black">Pertanyaan <span class="text-danger">*</span></label>
                                       <textarea class="form-control pertanyaan-textarea" name="pertanyaan" placeholder="Isi Pertanyaan" id="pertanyaan[${i}]"></textarea>
                                   </div>
                                  
                                   <div class="col-sm-2 col-lg-2" id="selectTypeJawaban_div[${i}]">
                                       <select class="form-select type-jawaban-select" aria-label="Actions" id="selectTypeJawaban[${i}]">
                                           <option value="shortanswer_type" data-input="shortanswer_input[${i}]" data-image='<svg width="18px" height="18px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                               <path d="M3 10H21M3 14H12" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                               </svg>'>
                                           Jawaban Singkat                        
                                           </option>
                                           <option value="paragraph_type[${i}]" data-input="paragraph_input[${i}]" data-image='<svg width="15px" height="15px" viewBox="0 0 24 28" version="1.1" xmlns="http://www.w3.org/2000/svg" 
                                               <title>align-left</title>
                                               <desc>Created with Sketch Beta.</desc>
                                               <defs>
                                               </defs>
                                               <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                               <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-308.000000, -206.000000)" fill="#000000">
                                               <path d="M335,222 L309,222 C308.447,222 308,222.448 308,223 C308,223.553 308.447,224 309,224 L335,224 C335.553,224 336,223.553 336,223 C336,222.448 335.553,222 335,222 L335,222 Z M324,230 L309,230 C308.447,230 308,230.447 308,231 C308,231.553 308.447,232 309,232 L324,232 C324.553,232 325,231.553 325,231 C325,230.447 324.553,230 324,230 L324,230 Z M309,208 L335,208 C335.553,208 336,207.553 336,207 C336,206.448 335.553,206 335,206 L309,206 C308.447,206 308,206.448 308,207 C308,207.553 308.447,208 309,208 L309,208 Z M309,216 L327,216 C327.553,216 328,215.553 328,215 C328,214.448 327.553,214 327,214 L309,214 C308.447,214 308,214.448 308,215 C308,215.553 308.447,216 309,216 L309,216 Z" id="align-left" sketch:type="MSShapeGroup">
                                               </path>
                                               </g>
                                               </g>
                                               </svg>'>
                                           Paragraf
                                           </option>
                                           <option value="multiplechoice_type[${i}]" data-input="multiplechoice_div[${i}]" data-input="paragraph_input"data-image='<svg xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none">                                <circle cx="12" cy="12" r="7.5" stroke="currentColor"></circle>                            </svg>                        '>
                                           Pilihan Ganda
                                           </option>
                                           <option value="checkbox_type[${i}]" data-input="checkbox_div[${i}]" data-image='<i class="fa-solid fa-check"></i> '>
                                           Kontak Centang
                                           </option>
                                           <option value="skala_type[${i}]" data-input="scala_div[${i}]" data-image='<i class="fa-solid fa-check"></i> '>
                                           Skala Linier
                                           </option>
                                           <option value="date_type[${i}]" data-input="date_input[${i}]" data-image='<svg width="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path d="M3.09277 9.40421H20.9167" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M16.442 13.3097H16.4512" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M12.0045 13.3097H12.0137" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M7.55818 13.3097H7.56744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M16.442 17.1962H16.4512" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M12.0045 17.1962H12.0137" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M7.55818 17.1962H7.56744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M16.0433 2V5.29078" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M7.96515 2V5.29078" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.2383 3.5791H7.77096C4.83427 3.5791 3 5.21504 3 8.22213V17.2718C3 20.3261 4.83427 21.9999 7.77096 21.9999H16.229C19.175 21.9999 21 20.3545 21 17.3474V8.22213C21.0092 5.21504 19.1842 3.5791 16.2383 3.5791Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                            </svg>                        '>
                                           Tanggal
                                           </option>
                                           <option value="time_type[${i}]" data-input="time_input[${i}]" data-image='<svg width="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path fill-rule="evenodd" clip-rule="evenodd" d="M21.25 12.0005C21.25 17.1095 17.109 21.2505 12 21.2505C6.891 21.2505 2.75 17.1095 2.75 12.0005C2.75 6.89149 6.891 2.75049 12 2.75049C17.109 2.75049 21.25 6.89149 21.25 12.0005Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M15.4316 14.9429L11.6616 12.6939V7.84692" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                            </svg>                        '>
                                           Waktu
                                           </option>
                                       </select>
                                   </div>
                               </div>
                          
                               <div class="row">
                                   <div class="col-lg-10">
                                       <label class="form-label text-black">Jawaban <span class="text-danger">*</span></label>
                                       <div class="form-group inputtype[${i}]" id="shortanswer_input[${i}]">
                                           <input type="text" class="form-control" placeholder="Teks jawaban singkat">
                                       </div>
                                       <div class="form-group inputtype[${i}]" id="paragraph_input[${i}]">
                                           <textarea class="form-control" placeholder="Paragraf"></textarea>
                                       </div>

                                       <div class="form-group inputtype[${i}]" id="multiplechoice_div[${i}]">
                                           <div class="form-check d-block">
                                               <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                               <label class="form-check-label" for="flexRadioDefault1">
                                                   Radio
                                               </label>
                                           </div>
                                           <div class="form-check d-block ">
                                               <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                               <label class="form-check-label" for="flexRadioDefault1">
                                                   Radio
                                               </label>
                                           </div>
                                       </div>
                                       <div class="form-group inputtype[${i}]" id="checkbox_div[${i}]">
                                           <div class="form-check d-block">
                                               <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                               <label class="form-check-label" for="flexCheckDefault2">
                                                   Pilihan 1 
                                               </label>
                                           </div>
                                           <div class="form-check d-block">
                                               <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                               <label class="form-check-label" for="flexCheckDefault2">
                                                   Pilihan 1 
                                               </label>
                                           </div>
                                       </div>
                                       <div class="form-group inputtype[${i}]" id="scala_div[${i}]">
                                           <label for="customRange" class="form-label">Skala Linier</label>
                                           <input type="range" class="form-range" min="1" max="5" step="1" id="customRange">
                                           <div class="d-flex justify-content-between">
                                               <span>1</span>
                                               <span>2</span>
                                               <span>3</span>
                                               <span>4</span>
                                               <span>5</span>
                                           </div>
                                       </div>
                                       <div class="form-group inputtype[${i}]"  id="date_input">
                                           <label for="date_input">Date:</label>
                                           <input type="date" class="form-control">
                                       </div>
                                       <div class="form-group inputtype[${i}]" id="time_input">
                                           <label for="time_input">Time:</label>
                                           <input type="time" class="form-control" >
                                       </div>
                                   </div>
                               </div>
                               <br>
                               <div class="row">
                                   <div class="col-lg-12">
                                       <div class="d-flex float-end">
                                           <a class="mx-1"  type="button"  id="delete_card[${i}]">
                                               <svg width="21" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                              
                                               <path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826" stroke="#009A4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                
                                               <path d="M20.708 6.23975H3.75" stroke="#009A4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                              
                                               <path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973" stroke="#009A4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                          
                                               </svg>     
                                           </a> 
                                           <a class="mx-2" type="button" id="duplicate_card[${i}]">                  
                                               <svg width="20px" height="20px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#009A4B" stroke="#009A4B"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>duplicate</title> <desc>Created with Sketch Beta.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"> <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-204.000000, -931.000000)" fill="#009A4B"> <path d="M234,951 C234,952.104 233.104,953 232,953 L216,953 C214.896,953 214,952.104 214,951 L214,935 C214,933.896 214.896,933 216,933 L232,933 C233.104,933 234,933.896 234,935 L234,951 L234,951 Z M232,931 L216,931 C213.791,931 212,932.791 212,935 L212,951 C212,953.209 213.791,955 216,955 L232,955 C234.209,955 236,953.209 236,951 L236,935 C236,932.791 234.209,931 232,931 L232,931 Z M226,959 C226,960.104 225.104,961 224,961 L208,961 C206.896,961 206,960.104 206,959 L206,943 C206,941.896 206.896,941 208,941 L210,941 L210,939 L208,939 C205.791,939 204,940.791 204,943 L204,959 C204,961.209 205.791,963 208,963 L224,963 C226.209,963 228,961.209 228,959 L228,957 L226,957 L226,959 L226,959 Z" id="duplicate" sketch:type="MSShapeGroup"> </path> </g> </g> </g></svg>                        
                                           </a>
                                           <hr class="hr-vertial">
                                           <div class="form-check form-switch mx-2">
                                               <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                                               <label class="form-check-label text-black" for="flexSwitchCheckDefault">Wajib Diisi</label>
                                           </div>
                                           <div class="dropup mx-2 more_dropdown[${i}]">
                                               <a class="px-2" type="button" id="dropdownMenu[${i}]" data-bs-toggle="dropdown" aria-expanded="false">
                                                   <span class="fa-solid fa-ellipsis-vertical" style="color: #009a4b;"></span>
                                               </a>
                                               <ul class="dropdown-menu" aria-labelledby="dropdownMenu[${i}]" role="menu">
                                                   <li><a class="dropdown-item"  id="add_heading[${i}]" type="button"><svg fill="#009a4b" width="20px" height="20px" viewBox="0 0 24.00 24.00" xmlns="http://www.w3.org/2000/svg" stroke="#009a4b" stroke-width="0.00024000000000000003"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M17,11 L17,6 L15.5,6 C15.2238576,6 15,5.77614237 15,5.5 C15,5.22385763 15.2238576,5 15.5,5 L19.5,5 C19.7761424,5 20,5.22385763 20,5.5 C20,5.77614237 19.7761424,6 19.5,6 L18,6 L18,18 L19.5,18 C19.7761424,18 20,18.2238576 20,18.5 C20,18.7761424 19.7761424,19 19.5,19 L15.5,19 C15.2238576,19 15,18.7761424 15,18.5 C15,18.2238576 15.2238576,18 15.5,18 L17,18 L17,12 L7,12 L7,18 L8.5,18 C8.77614237,18 9,18.2238576 9,18.5 C9,18.7761424 8.77614237,19 8.5,19 L4.5,19 C4.22385763,19 4,18.7761424 4,18.5 C4,18.2238576 4.22385763,18 4.5,18 L6,18 L6,6 L4.5,6 C4.22385763,6 4,5.77614237 4,5.5 C4,5.22385763 4.22385763,5 4.5,5 L8.5,5 C8.77614237,5 9,5.22385763 9,5.5 C9,5.77614237 8.77614237,6 8.5,6 L7,6 L7,11 L17,11 Z"></path> </g></svg> Tambah Judul</a></li>
                                                   <li><a class="dropdown-item add_pertanyaan" id="add_pertanyaan[${i}]" type="button"><svg width="18px" height="18px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000" stroke-width="0.00024000000000000003"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2.75C6.89137 2.75 2.75 6.89137 2.75 12C2.75 17.1086 6.89137 21.25 12 21.25C17.1086 21.25 21.25 17.1086 21.25 12C21.25 6.89137 17.1086 2.75 12 2.75ZM1.25 12C1.25 6.06294 6.06294 1.25 12 1.25C17.9371 1.25 22.75 6.06294 22.75 12C22.75 17.9371 17.9371 22.75 12 22.75C6.06294 22.75 1.25 17.9371 1.25 12ZM12 7.75C11.3787 7.75 10.875 8.25368 10.875 8.875C10.875 9.28921 10.5392 9.625 10.125 9.625C9.71079 9.625 9.375 9.28921 9.375 8.875C9.375 7.42525 10.5503 6.25 12 6.25C13.4497 6.25 14.625 7.42525 14.625 8.875C14.625 9.83834 14.1056 10.6796 13.3353 11.1354C13.1385 11.2518 12.9761 11.3789 12.8703 11.5036C12.7675 11.6246 12.75 11.7036 12.75 11.75V13C12.75 13.4142 12.4142 13.75 12 13.75C11.5858 13.75 11.25 13.4142 11.25 13V11.75C11.25 11.2441 11.4715 10.8336 11.7266 10.533C11.9786 10.236 12.2929 10.0092 12.5715 9.84439C12.9044 9.64739 13.125 9.28655 13.125 8.875C13.125 8.25368 12.6213 7.75 12 7.75ZM12 17C12.5523 17 13 16.5523 13 16C13 15.4477 12.5523 15 12 15C11.4477 15 11 15.4477 11 16C11 16.5523 11.4477 17 12 17Z" fill="#009A4B"></path> </g></svg>  Tambah Pertanyaan</a></li>
                                                   <li><a class="dropdown-item" id="add_bagian[${i}]" type="button"><svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3 6.5C3 3.87479 3.02811 3 6.5 3C9.97189 3 10 3.87479 10 6.5C10 9.12521 10.0111 10 6.5 10C2.98893 10 3 9.12521 3 6.5Z" stroke="#009A4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path fill-rule="evenodd" clip-rule="evenodd" d="M14 6.5C14 3.87479 14.0281 3 17.5 3C20.9719 3 21 3.87479 21 6.5C21 9.12521 21.0111 10 17.5 10C13.9889 10 14 9.12521 14 6.5Z" stroke="#009A4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3 17.5C3 14.8748 3.02811 14 6.5 14C9.97189 14 10 14.8748 10 17.5C10 20.1252 10.0111 21 6.5 21C2.98893 21 3 20.1252 3 17.5Z" stroke="#009A4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path fill-rule="evenodd" clip-rule="evenodd" d="M14 17.5C14 14.8748 14.0281 14 17.5 14C20.9719 14 21 14.8748 21 17.5C21 20.1252 21.0111 21 17.5 21C13.9889 21 14 20.1252 14 17.5Z" stroke="#009A4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                            </svg>                        Tambah Bagian</a></li>
                                               </ul>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>`;
       }

      

       const textareaPertanyaan = document.querySelectorAll("textarea[id^=pertanyaan\\[]");
       textareaPertanyaan.forEach(function (textarea) {
           const index = textarea.id.match(/\[(\d+)\]/)[1];
           tinymce.init({
               selector: `textarea#pertanyaan\\[${index}\\]`,
               branding: false,
           });
       });

       $('.type-jawaban-select').each(function (index) {
           const selectElement = $(this);
           selectElement.select2({
               theme: 'bootstrap-5',
               minimumResultsForSearch: Infinity,
               templateResult: formatState,
               templateSelection: formatState
           });
           toggleInputs(selectElement);
           selectElement.on('change', function () {
           toggleInputs($(this));
            });
       });
       
       
       
   });

      
   
       function toggleInputs(selectElement) {
           const selectedInput = selectElement.find(':selected').data('input');
           const indexs = selectElement.attr('id').match(/\d+/)[0];
           const inputElements = selectElement.closest('.card-body').find(`.form-group.inputtype\\[${indexs}\\]`);
           inputElements.each(function() {
               const inputElement = $(this);
               const inputId = inputElement.attr('id');

               if (inputId === selectedInput) {
                   inputElement.show();
               } else {
                   inputElement.hide();
               }
           });
       }
          
   function formatState(opt) {
       if (!opt.id) {
               return opt.text;
       }
       var optimage = $(opt.element).attr('data-image');
       if (!optimage) {
           return opt.text;
       } else {
           var $opt = $('<span>' + optimage + opt.text + '</span>');
           return $opt;
       }
   }

   function toggleActiveClassCard(event) {
       const clickedElement = event.target.closest('.card-soal');
           if (clickedElement) {
               clickedElement.classList.add('active');
           }
   }
</script>

   