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
                                <div class="form-group">
                                <label class="form-label text-black" for="nama_paket">Nama Paket<span class="text-danger">*</span></label>
                                  {{ Form::text('nama_paket', old('nama_paket'), ['class' => 'form-control', 'placeholder' => 'Isi nama paket', 'required','id' => 'nama_paket']) }}
                           
                                </div>
                                <div class="form-group ">
                                <label class="form-label text-black" for="alias_url">Alias URL<span class="text-danger">*</span></label>
                      
                                    {{ Form::text('alias_url', old('alias_url'), ['class' => 'form-control', 'placeholder' => 'Isi alias url', 'required','id' => 'alias_url']) }}
                           
                                </div>
                                <div class="form-group">
                                    <label class="form-label text-black" for="deskripsi_paket">Deskripsi Paket</label>
                                      {{ Form::textarea('deskripsi_paket', old('deskripsi_paket'), ['class' => 'form-control', 'placeholder' => 'Isi deskripsi','id' => 'deskripsi_paket']) }}   
                                </div>
                                <div class="form-group">
                                <label class="form-label text-black" for="tanggal_tayang">Tanggal Tayang<span class="text-danger">*</span></label>
                  
                                    {{ Form::date('tanggal_tayang', old('tanggal_tayang'), ['class' => 'form-control', 'placeholder' => 'Isi tanggal tayang', 'required','id' => 'tanggal_tayang']) }}
                     
                                </div>
                                <div class="form-group">
                                <label class="form-label text-black" for="tgl_selesai_tayang">Tanggal Selesai Tayang<span class="text-danger">*</span></label>
           
                                    {{ Form::date('tgl_selesai_tayang', old('tgl_selesai_tayang'), ['class' => 'form-control', 'placeholder' => 'Isi tanggal selesai tayang', 'required','id' => 'tgl_selesai_tayang']) }}
                            
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
                        <button type="button" name="next" class="btn btn-primary btn-sm next action-button" value="Next" >Halaman Ke-2</button>
                    </div>   
                </div>  
            </div>
        </fieldset>
       {!! Form::close() !!}
    </div>
 </x-app-layout>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>


 <script>
    tinymce.init({
        selector: `textarea#deskripsi_paket`,
        branding: false,
        plugins: 'image code advlist anchor autolink autoresize charmap codesample emoticons fullscreen insertdatetime link lists media preview searchreplace table template visualchars wordcount',
    });
 
</script>

 <script>
    document.addEventListener("DOMContentLoaded", function () {
        initialize();     
        dragCard();

        $(document).on('click', '.add-radio-option', function() {
        var newElement = `
        <div class="form-check radio-option" id="option">
                <div class="d-flex align-items-center">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                    <div class="row align-items-center px-3">
                        <div class="col-3 px-1">
                            <input type="text" class="form-control" placeholder="Kode">
                        </div>
                        <div class="col-5 px-1">
                            <input type="text" class="form-control" placeholder="Pilihan">
                        </div>
                        <div class="col-3 px-1">
                            <input type="text" class="form-control" placeholder="Nilai">
                        </div>
                        <div class="col-1 px-1 d-flex align-items-center justify-content-between">
                            <div class="add-radio-option px-1"> <svg  width="20px" height="20px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>plus-circle</title> <desc>Created with Sketch Beta.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"> <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-464.000000, -1087.000000)" fill="#009A4B"> <path d="M480,1117 C472.268,1117 466,1110.73 466,1103 C466,1095.27 472.268,1089 480,1089 C487.732,1089 494,1095.27 494,1103 C494,1110.73 487.732,1117 480,1117 L480,1117 Z M480,1087 C471.163,1087 464,1094.16 464,1103 C464,1111.84 471.163,1119 480,1119 C488.837,1119 496,1111.84 496,1103 C496,1094.16 488.837,1087 480,1087 L480,1087 Z M486,1102 L481,1102 L481,1097 C481,1096.45 480.553,1096 480,1096 C479.447,1096 479,1096.45 479,1097 L479,1102 L474,1102 C473.447,1102 473,1102.45 473,1103 C473,1103.55 473.447,1104 474,1104 L479,1104 L479,1109 C479,1109.55 479.447,1110 480,1110 C480.553,1110 481,1109.55 481,1109 L481,1104 L486,1104 C486.553,1104 487,1103.55 487,1103 C487,1102.45 486.553,1102 486,1102 L486,1102 Z" id="plus-circle" sketch:type="MSShapeGroup"> </path> </g> </g> </g></svg>
                            </div>
                            <div  class="delete-radio-option">  <svg width="20px" height="20px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>cross-circle</title> <desc>Created with Sketch Beta.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"> <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-568.000000, -1087.000000)" fill="#009A4B"> <path d="M584,1117 C576.268,1117 570,1110.73 570,1103 C570,1095.27 576.268,1089 584,1089 C591.732,1089 598,1095.27 598,1103 C598,1110.73 591.732,1117 584,1117 L584,1117 Z M584,1087 C575.163,1087 568,1094.16 568,1103 C568,1111.84 575.163,1119 584,1119 C592.837,1119 600,1111.84 600,1103 C600,1094.16 592.837,1087 584,1087 L584,1087 Z M589.717,1097.28 C589.323,1096.89 588.686,1096.89 588.292,1097.28 L583.994,1101.58 L579.758,1097.34 C579.367,1096.95 578.733,1096.95 578.344,1097.34 C577.953,1097.73 577.953,1098.37 578.344,1098.76 L582.58,1102.99 L578.314,1107.26 C577.921,1107.65 577.921,1108.29 578.314,1108.69 C578.708,1109.08 579.346,1109.08 579.74,1108.69 L584.006,1104.42 L588.242,1108.66 C588.633,1109.05 589.267,1109.05 589.657,1108.66 C590.048,1108.27 590.048,1107.63 589.657,1107.24 L585.42,1103.01 L589.717,1098.71 C590.11,1098.31 590.11,1097.68 589.717,1097.28 L589.717,1097.28 Z" id="cross-circle" sketch:type="MSShapeGroup"> </path> </g> </g> </g></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
            $(this).closest('.radio-option').after(newElement);
        });

        $(document).on('click', '.delete-radio-option', function() {
            $(this).closest('.radio-option').remove();
        });

        $(document).on('click', '.add-checkbox-option', function() {
        var newElementCheckbox = `
     
            <div class="form-check checkbox-option" id="checkbox">
                <div class="d-flex align-items-center">
                    <input class="form-check-input" type="checkbox">
                    <div class="row align-items-center px-3">
                        <div class="col-3 px-1">
                            <input type="text" class="form-control" placeholder="Kode">
                        </div>
                        <div class="col-5 px-1">
                            <input type="text" class="form-control" placeholder="Pilihan">
                        </div>
                        <div class="col-3 px-1">
                            <input type="text" class="form-control" placeholder="Nilai">
                        </div>
                        <div class="col-1 px-1 d-flex align-items-center justify-content-between">
                            <div class="add-checkbox-option px-1"> <svg  width="20px" height="20px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>plus-circle</title> <desc>Created with Sketch Beta.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"> <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-464.000000, -1087.000000)" fill="#009A4B"> <path d="M480,1117 C472.268,1117 466,1110.73 466,1103 C466,1095.27 472.268,1089 480,1089 C487.732,1089 494,1095.27 494,1103 C494,1110.73 487.732,1117 480,1117 L480,1117 Z M480,1087 C471.163,1087 464,1094.16 464,1103 C464,1111.84 471.163,1119 480,1119 C488.837,1119 496,1111.84 496,1103 C496,1094.16 488.837,1087 480,1087 L480,1087 Z M486,1102 L481,1102 L481,1097 C481,1096.45 480.553,1096 480,1096 C479.447,1096 479,1096.45 479,1097 L479,1102 L474,1102 C473.447,1102 473,1102.45 473,1103 C473,1103.55 473.447,1104 474,1104 L479,1104 L479,1109 C479,1109.55 479.447,1110 480,1110 C480.553,1110 481,1109.55 481,1109 L481,1104 L486,1104 C486.553,1104 487,1103.55 487,1103 C487,1102.45 486.553,1102 486,1102 L486,1102 Z" id="plus-circle" sketch:type="MSShapeGroup"> </path> </g> </g> </g></svg>
                            </div>
                            <div  class="delete-checkbox-option"> <svg width="20px" height="20px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>cross-circle</title> <desc>Created with Sketch Beta.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"> <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-568.000000, -1087.000000)" fill="#009A4B"> <path d="M584,1117 C576.268,1117 570,1110.73 570,1103 C570,1095.27 576.268,1089 584,1089 C591.732,1089 598,1095.27 598,1103 C598,1110.73 591.732,1117 584,1117 L584,1117 Z M584,1087 C575.163,1087 568,1094.16 568,1103 C568,1111.84 575.163,1119 584,1119 C592.837,1119 600,1111.84 600,1103 C600,1094.16 592.837,1087 584,1087 L584,1087 Z M589.717,1097.28 C589.323,1096.89 588.686,1096.89 588.292,1097.28 L583.994,1101.58 L579.758,1097.34 C579.367,1096.95 578.733,1096.95 578.344,1097.34 C577.953,1097.73 577.953,1098.37 578.344,1098.76 L582.58,1102.99 L578.314,1107.26 C577.921,1107.65 577.921,1108.29 578.314,1108.69 C578.708,1109.08 579.346,1109.08 579.74,1108.69 L584.006,1104.42 L588.242,1108.66 C588.633,1109.05 589.267,1109.05 589.657,1108.66 C590.048,1108.27 590.048,1107.63 589.657,1107.24 L585.42,1103.01 L589.717,1098.71 C590.11,1098.31 590.11,1097.68 589.717,1097.28 L589.717,1097.28 Z" id="cross-circle" sketch:type="MSShapeGroup"> </path> </g> </g> </g></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
       
        `;
            $(this).closest('.checkbox-option').after(newElementCheckbox);
        });

        $(document).on('click', '.delete-checkbox-option', function() {
            $(this).closest('.checkbox-option').remove();
        });

    });

    

    function dragCard(){
            new Sortable(document.getElementById('card_container'), {
            handle: '.drag-icon', // handle's class
            animation: 150,
            onEnd: function (evt) {
                resetIndex();
               
            },
        });

      
    }

    function initialize() {
        $("#card_container").append(generateHeading(0));
        $("#card_container").append(generateCard(1));
        listenerCard();

    }   

    function listenerCard() {  

            $(document).off('click', '.card-soal');
            $(document).on('click', '.card-soal', function() {
                $(this).addClass("active").siblings().removeClass("active");
            });

            $(document).off('click', '.add_pertanyaan'); 
            $(document).on('click', '.add_pertanyaan', function() {
                const id = $(this).attr('id');
                const index = id.match(/\d+/)[0]; 
                addCard(index, $(this));
      
            });

            $(document).off('click', '.add_heading'); 
            $(document).on('click', '.add_heading', function() {
                const id = $(this).attr('id');
                const index = id.match(/\d+/)[0]; 
                addHeading(index, $(this));
      
            });


            $(document).off('click', '.duplicate_card'); 
            $(document).on('click', '.duplicate_card', function() {
                console.log("hoi")
                const id = $(this).attr('id');
                const index = id.match(/\d+/)[0]; 
                duplicateCard(index, $(this));
      
            });

            $(document).off('click', '.delete_card'); 
            $(document).on('click', '.delete_card', function() {
                console.log("hoi")
                const id = $(this).attr('id');
                const index = id.match(/\d+/)[0]; 
                deleteCard(index, $(this));
      
            })


            initializeTinymce();
            initializeSelect2();
            initializeTagify();  
        }

        function initializeTagify() { 
            const multipleInputs = document.querySelectorAll("input[id^=multipleinput_input\\[]");
            const initialWords = ["Jawaban A", "Jawaban B", "dll"];
            multipleInputs.forEach(function (inputElement) {
            const index = inputElement.id.match(/\[(\d+)\]/)[1];
        
            
            const tagify = new Tagify(inputElement, {
                readonly: true

            });

            tagify.addTags(initialWords.join(","));
    });
        }
        function initializeTinymce() { 
            tinymce.remove();
            const textareaPertanyaan = document.querySelectorAll("textarea[id^=pertanyaan\\[]");
                textareaPertanyaan.forEach(function (textarea) {
                    const index = textarea.id.match(/\[(\d+)\]/)[1];
                    tinymce.init({
                        selector: `textarea#pertanyaan\\[${index}\\]`,
                        branding: false,
                        setup : function(ed) {
                        ed.on("click", function() {
                            const cardSoal = $(textarea).closest('.card-soal');
                            cardSoal.addClass("active").siblings().removeClass("active");
                        });
                    }
                });
            });
            }
            function initializeSelect2() {
            // Loop through each .type-jawaban-select element
            $('.type-jawaban-select').each(function () {
                const selectElement = $(this);

                // Check if the element has a Select2 instance
                if (selectElement.hasClass('select2-hidden-accessible')) {
                    // Destroy the Select2 instance
                    selectElement.select2('destroy');
                }

                // Initialize the Select2 instance
                selectElement.select2({
                    theme: 'bootstrap-5',
                    minimumResultsForSearch: Infinity,
                    templateResult: formatState,
                    templateSelection: formatState
                });
                
                toggleInputs($(this));
                $(this).on('change', function () {
                    toggleInputs($(this));
                });
     
            });
        }

      

        function toggleInputs(selectElement) {
            const selectedInput = selectElement.find(':selected').data('input');
            const indexs = selectElement.attr('id').match(/\d+/)[0];
            const inputElements = selectElement.closest('.card-body').find(`.form-group.inputtype`);
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

        function resetIndex() {
            const cardElements = $('.card-soal');
            const pattern = /\w+\[(\d+)\]/;

            cardElements.each(function(index) {   
                const thisCardELements = $(this);
                thisCardELements.attr('id', `card-soal[${index}]`);
                thisCardELements.attr('data-id', index);
            

                $(this).find("[id], [data-input]").each(function() {
                    const id = $(this).attr("id");
                    const dataInput = $(this).attr("data-input");
                    const matches = id.match(pattern);
                    
                    if (matches) {
                        const newId = id.replace(matches[1], index);
                        $(this).attr('id', `${newId}`);
                    }
                    if (dataInput && matches) {
                        const newDataInput = dataInput.replace(matches[1], index);
                        $(this).attr('data-input', newDataInput);
                    }
                });
               
            });

            listenerCard();
        }

   
        function addCard(indexCard, cardSelector) {
            const addCard = generateCard(parseInt(indexCard) + 1);
            const cardBefore = $(`#card-soal\\[${indexCard}\\]`);
            const cardAfter = $(`#card-soal\\[${indexCard+1}\\]`);
            
            if (cardAfter.length > 0) {
                // Jika cardSoalAfter ditemukan, sisipkan elemen addCard di antara cardSoalBefore dan cardSoalAfter
                cardBefore.after(addCard);
            } else {
                // Jika cardSoalAfter tidak ditemukan, sisipkan elemen addCard setelah cardSoalBefore
                cardBefore.after(addCard);
            }
            resetIndex();         
        };

        function addHeading(indexCard, cardSelector) {
            const addHeading = generateHeading(parseInt(indexCard) + 1);
            const cardBeforeHeading = $(`#card-soal\\[${indexCard}\\]`);
            const cardAfterHeading = $(`#card-soal\\[${indexCard+1}\\]`);
            
            if (cardAfterHeading.length > 0) {
               
                cardBeforeHeading.after(addHeading);
            } else {
              
                cardBeforeHeading.after(addHeading);
            }
            resetIndex();         
        };

        function duplicateCard(indexCard, cardSelector){

            //TODO FIX THE SELECT2 
            const cardToDuplicate = $(`#card-soal\\[${indexCard}\\]`);
            const clonedCard = cardToDuplicate.clone();
            cardToDuplicate.after(clonedCard);
          
            resetIndex();
        }

        
        function deleteCard(indexCard, cardSelector){

            const cardToDelete = $(`#card-soal\\[${indexCard}\\]`);
            cardToDelete.remove();
            resetIndex();
        }


        function generateHeading(i){
            return `<div class="card card-soal" data-id="${i}" id="card-soal[${i}]">
                            <div class="d-flex justify-content-center align-items-center drag-icon" id="drag-icon[${i}]">
                                <svg width="25px" height="20px" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M1.5 5.5C1.5 4.94772 1.94772 4.5 2.5 4.5C3.05228 4.5 3.5 4.94772 3.5 5.5C3.5 6.05228 3.05228 6.5 2.5 6.5C1.94772 6.5 1.5 6.05228 1.5 5.5ZM6.5 5.5C6.5 4.94772 6.94772 4.5 7.5 4.5C8.05228 4.5 8.5 4.94772 8.5 5.5C8.5 6.05228 8.05228 6.5 7.5 6.5C6.94772 6.5 6.5 6.05228 6.5 5.5ZM11.5 5.5C11.5 4.94772 11.9477 4.5 12.5 4.5C13.0523 4.5 13.5 4.94772 13.5 5.5C13.5 6.05228 13.0523 6.5 12.5 6.5C11.9477 6.5 11.5 6.05228 11.5 5.5ZM1.5 9.5C1.5 8.94772 1.94772 8.5 2.5 8.5C3.05228 8.5 3.5 8.94772 3.5 9.5C3.5 10.0523 3.05228 10.5 2.5 10.5C1.94772 10.5 1.5 10.0523 1.5 9.5ZM6.5 9.5C6.5 8.94772 6.94772 8.5 7.5 8.5C8.05228 8.5 8.5 8.94772 8.5 9.5C8.5 10.0523 8.05228 10.5 7.5 10.5C6.94772 10.5 6.5 10.0523 6.5 9.5ZM11.5 9.5C11.5 8.94772 11.9477 8.5 12.5 8.5C13.0523 8.5 13.5 8.94772 13.5 9.5C13.5 10.0523 13.0523 10.5 12.5 10.5C11.9477 10.5 11.5 10.0523 11.5 9.5Z" fill="#d1d2d1"></path> </g></svg>  
                                 </div>

                                <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <label class="form-label text-black">Judul</label>
                                            <input class="form-control" name="judul" placeholder="Isi Judul" id="judul[${i}]">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="d-flex float-end">
                                            <a class="mx-1 delete_card" type="button" id="delete_card[${i}]">
                                                <svg width="21" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                              
                                                <path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826" stroke="#009A4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                
                                                <path d="M20.708 6.23975H3.75" stroke="#009A4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                              
                                                <path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973" stroke="#009A4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                          
                                                </svg>     
                                            </a> 
                                            <a class="mx-2 duplicate_card" type="button" id="duplicate_card[${i}]">                  
                                                <svg width="20px" height="20px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#009A4B" stroke="#009A4B"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>duplicate</title> <desc>Created with Sketch Beta.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"> <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-204.000000, -931.000000)" fill="#009A4B"> <path d="M234,951 C234,952.104 233.104,953 232,953 L216,953 C214.896,953 214,952.104 214,951 L214,935 C214,933.896 214.896,933 216,933 L232,933 C233.104,933 234,933.896 234,935 L234,951 L234,951 Z M232,931 L216,931 C213.791,931 212,932.791 212,935 L212,951 C212,953.209 213.791,955 216,955 L232,955 C234.209,955 236,953.209 236,951 L236,935 C236,932.791 234.209,931 232,931 L232,931 Z M226,959 C226,960.104 225.104,961 224,961 L208,961 C206.896,961 206,960.104 206,959 L206,943 C206,941.896 206.896,941 208,941 L210,941 L210,939 L208,939 C205.791,939 204,940.791 204,943 L204,959 C204,961.209 205.791,963 208,963 L224,963 C226.209,963 228,961.209 228,959 L228,957 L226,957 L226,959 L226,959 Z" id="duplicate" sketch:type="MSShapeGroup"> </path> </g> </g> </g></svg>                        
                                            </a>
                                            <div class="dropup mx-2 more_dropdown[${i}]">
                                                <a class="px-2" type="button" id="dropdownMenu[${i}]" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span class="fa-solid fa-ellipsis-vertical" style="color: #009a4b;"></span>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu[${i}]" role="menu">
                                                    <li><a class="dropdown-item add_heading" id="add_heading[${i}]" type="button"><svg fill="#009a4b" width="20px" height="20px" viewBox="0 0 24.00 24.00" xmlns="http://www.w3.org/2000/svg" stroke="#009a4b" stroke-width="0.00024000000000000003"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M17,11 L17,6 L15.5,6 C15.2238576,6 15,5.77614237 15,5.5 C15,5.22385763 15.2238576,5 15.5,5 L19.5,5 C19.7761424,5 20,5.22385763 20,5.5 C20,5.77614237 19.7761424,6 19.5,6 L18,6 L18,18 L19.5,18 C19.7761424,18 20,18.2238576 20,18.5 C20,18.7761424 19.7761424,19 19.5,19 L15.5,19 C15.2238576,19 15,18.7761424 15,18.5 C15,18.2238576 15.2238576,18 15.5,18 L17,18 L17,12 L7,12 L7,18 L8.5,18 C8.77614237,18 9,18.2238576 9,18.5 C9,18.7761424 8.77614237,19 8.5,19 L4.5,19 C4.22385763,19 4,18.7761424 4,18.5 C4,18.2238576 4.22385763,18 4.5,18 L6,18 L6,6 L4.5,6 C4.22385763,6 4,5.77614237 4,5.5 C4,5.22385763 4.22385763,5 4.5,5 L8.5,5 C8.77614237,5 9,5.22385763 9,5.5 C9,5.77614237 8.77614237,6 8.5,6 L7,6 L7,11 L17,11 Z"></path> </g></svg> Tambah Judul</a></li>
                                                    <li><a class="dropdown-item add_pertanyaan" id="add_pertanyaan[${i}]" type="button"><svg width="18px" height="18px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000" stroke-width="0.00024000000000000003"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2.75C6.89137 2.75 2.75 6.89137 2.75 12C2.75 17.1086 6.89137 21.25 12 21.25C17.1086 21.25 21.25 17.1086 21.25 12C21.25 6.89137 17.1086 2.75 12 2.75ZM1.25 12C1.25 6.06294 6.06294 1.25 12 1.25C17.9371 1.25 22.75 6.06294 22.75 12C22.75 17.9371 17.9371 22.75 12 22.75C6.06294 22.75 1.25 17.9371 1.25 12ZM12 7.75C11.3787 7.75 10.875 8.25368 10.875 8.875C10.875 9.28921 10.5392 9.625 10.125 9.625C9.71079 9.625 9.375 9.28921 9.375 8.875C9.375 7.42525 10.5503 6.25 12 6.25C13.4497 6.25 14.625 7.42525 14.625 8.875C14.625 9.83834 14.1056 10.6796 13.3353 11.1354C13.1385 11.2518 12.9761 11.3789 12.8703 11.5036C12.7675 11.6246 12.75 11.7036 12.75 11.75V13C12.75 13.4142 12.4142 13.75 12 13.75C11.5858 13.75 11.25 13.4142 11.25 13V11.75C11.25 11.2441 11.4715 10.8336 11.7266 10.533C11.9786 10.236 12.2929 10.0092 12.5715 9.84439C12.9044 9.64739 13.125 9.28655 13.125 8.875C13.125 8.25368 12.6213 7.75 12 7.75ZM12 17C12.5523 17 13 16.5523 13 16C13 15.4477 12.5523 15 12 15C11.4477 15 11 15.4477 11 16C11 16.5523 11.4477 17 12 17Z" fill="#009A4B"></path> </g></svg>  Tambah Pertanyaan</a></li>
                                                    <li><a class="dropdown-item add_bagian" id="add_bagian[${i}]" type="button"><svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3 6.5C3 3.87479 3.02811 3 6.5 3C9.97189 3 10 3.87479 10 6.5C10 9.12521 10.0111 10 6.5 10C2.98893 10 3 9.12521 3 6.5Z" stroke="#009A4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path fill-rule="evenodd" clip-rule="evenodd" d="M14 6.5C14 3.87479 14.0281 3 17.5 3C20.9719 3 21 3.87479 21 6.5C21 9.12521 21.0111 10 17.5 10C13.9889 10 14 9.12521 14 6.5Z" stroke="#009A4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3 17.5C3 14.8748 3.02811 14 6.5 14C9.97189 14 10 14.8748 10 17.5C10 20.1252 10.0111 21 6.5 21C2.98893 21 3 20.1252 3 17.5Z" stroke="#009A4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path fill-rule="evenodd" clip-rule="evenodd" d="M14 17.5C14 14.8748 14.0281 14 17.5 14C20.9719 14 21 14.8748 21 17.5C21 20.1252 21.0111 21 17.5 21C13.9889 21 14 20.1252 14 17.5Z" stroke="#009A4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                            </svg>                        Tambah Bagian</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                    </div>
                                    `
        }
        function generateCard(i) {
                return `

                <div class="card card-soal" data-id="${i}" id="card-soal[${i}]">
                            <div class="d-flex justify-content-center align-items-center drag-icon" id="drag-icon[${i}]">
                                        <svg width="25px" height="20px" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M1.5 5.5C1.5 4.94772 1.94772 4.5 2.5 4.5C3.05228 4.5 3.5 4.94772 3.5 5.5C3.5 6.05228 3.05228 6.5 2.5 6.5C1.94772 6.5 1.5 6.05228 1.5 5.5ZM6.5 5.5C6.5 4.94772 6.94772 4.5 7.5 4.5C8.05228 4.5 8.5 4.94772 8.5 5.5C8.5 6.05228 8.05228 6.5 7.5 6.5C6.94772 6.5 6.5 6.05228 6.5 5.5ZM11.5 5.5C11.5 4.94772 11.9477 4.5 12.5 4.5C13.0523 4.5 13.5 4.94772 13.5 5.5C13.5 6.05228 13.0523 6.5 12.5 6.5C11.9477 6.5 11.5 6.05228 11.5 5.5ZM1.5 9.5C1.5 8.94772 1.94772 8.5 2.5 8.5C3.05228 8.5 3.5 8.94772 3.5 9.5C3.5 10.0523 3.05228 10.5 2.5 10.5C1.94772 10.5 1.5 10.0523 1.5 9.5ZM6.5 9.5C6.5 8.94772 6.94772 8.5 7.5 8.5C8.05228 8.5 8.5 8.94772 8.5 9.5C8.5 10.0523 8.05228 10.5 7.5 10.5C6.94772 10.5 6.5 10.0523 6.5 9.5ZM11.5 9.5C11.5 8.94772 11.9477 8.5 12.5 8.5C13.0523 8.5 13.5 8.94772 13.5 9.5C13.5 10.0523 13.0523 10.5 12.5 10.5C11.9477 10.5 11.5 10.0523 11.5 9.5Z" fill="#d1d2d1"></path> </g></svg>  
                                         </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-sm-10">
                                                <label class="form-label text-black">Pertanyaan <span class="text-danger">*</span></label>
                                                    <textarea class="form-control pertanyaan-textarea" name="pertanyaan" placeholder="Isi Pertanyaan" id="pertanyaan[${i}]"></textarea>
                                            </div>
                                           
                                            <div class="col-sm-2 col-lg-2 selectTypeJawaban_div" id="selectTypeJawaban_div[${i}]">
                                                <select class="form-select type-jawaban-select" aria-label="Actions" id="selectTypeJawaban[${i}]">
                                                    <option value="shortanswer_type" class="shortanswer" id="shortanswer_type[${i}]" data-input="shortanswer_input[${i}]" data-image='<svg width="18px" height="18px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M3 10H21M3 14H12" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>'>
                                                    Jawaban Singkat                        
                                                    </option>
                                                    <option value="paragraph_type" class="paragraph" id="paragraph_type[${i}]" data-input="paragraph_input[${i}]" data-image='<svg width="15px" height="15px" viewBox="0 0 24 28" version="1.1" xmlns="http://www.w3.org/2000/svg" 
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
                                                    <option value="singlechoice_type" class="singlechoice" id="singlechoice_type[${i}]"  data-input="singlechoice_div[${i}]" data-input="paragraph_input"data-image='<svg xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none">                                <circle cx="12" cy="12" r="7.5" stroke="currentColor"></circle>                            </svg>                        '>
                                                    Pilihan Ganda (Radio Button)
                                                    </option>
                                                    <option value="checkbox_type" class="checkbox" id="checkbox_type[${i}]" data-input="checkbox_div[${i}]" data-image='<i class="fa-solid fa-check"></i> '>
                                                    Kotak Centang (Checkbox)
                                                    </option>
                                                    <option value="multipleinput_type" class="multipleinput" id="multipleinput_type[${i}]" data-input="multipleinput_div[${i}]" data-image='<svg width="18px" height="18px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000" stroke-width="0.00024000000000000003"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M21.07 10.3L15.07 4.29996C14.93 4.15996 14.74 4.07996 14.54 4.07996H3C2.59 4.07996 2.25 4.41996 2.25 4.82996V12.71C2.25 12.91 2.33 13.1 2.47 13.24L8.47 19.23C8.91 19.67 9.49 19.91 10.11 19.91C10.73 19.91 11.32 19.67 11.75 19.23L11.97 19.01C12.01 19.09 12.05 19.17 12.12 19.23C12.57 19.68 13.17 19.91 13.76 19.91C14.35 19.91 14.95 19.68 15.41 19.23L21.06 13.58C21.96 12.68 21.96 11.21 21.06 10.3H21.07ZM10.7 18.17C10.54 18.33 10.34 18.41 10.12 18.41C9.9 18.41 9.69 18.32 9.54 18.17L3.75 12.4V5.57996H10.57L16.35 11.36C16.67 11.68 16.67 12.2 16.35 12.52L10.7 18.17ZM20.01 12.52L14.36 18.17C14.04 18.49 13.51 18.49 13.19 18.17C13.12 18.1 13.05 18.06 12.96 18.02L17.4 13.58C18.3 12.67 18.3 11.2 17.4 10.3L12.68 5.57996H14.22L20 11.36C20.32 11.68 20.32 12.2 20 12.52H20.01ZM8.25 8.49996C8.25 9.18996 7.69 9.74996 7 9.74996C6.31 9.74996 5.75 9.18996 5.75 8.49996C5.75 7.80996 6.31 7.24996 7 7.24996C7.69 7.24996 8.25 7.80996 8.25 8.49996Z" fill="#000000"></path> </g></svg>'>
                                                    Multiple Input 
                                                    </option>
                                                    <option value="dropdown_type" class="checkbox" id="dropdown_type[${i}]" data-input="dropdown_div[${i}]" data-image='<svg width="18px" height="18px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M8 6.00067L21 6.00139M8 12.0007L21 12.0015M8 18.0007L21 18.0015M3.5 6H3.51M3.5 12H3.51M3.5 18H3.51M4 6C4 6.27614 3.77614 6.5 3.5 6.5C3.22386 6.5 3 6.27614 3 6C3 5.72386 3.22386 5.5 3.5 5.5C3.77614 5.5 4 5.72386 4 6ZM4 12C4 12.2761 3.77614 12.5 3.5 12.5C3.22386 12.5 3 12.2761 3 12C3 11.7239 3.22386 11.5 3.5 11.5C3.77614 11.5 4 11.7239 4 12ZM4 18C4 18.2761 3.77614 18.5 3.5 18.5C3.22386 18.5 3 18.2761 3 18C3 17.7239 3.22386 17.5 3.5 17.5C3.77614 17.5 4 17.7239 4 18Z" stroke="#000000" stroke-width="1.224" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>'>
                                                    List Pilihan (Dropdown)
                                                    </option>
                                                    <option  value="gridcolumn_type" class="gridcolumn" id="gridcolumn_type[${i}]" data-input="gridcolumn_div[${i}]" data-image='<svg width="18px" height="18px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M6.75 3C3.88235 3 3 3.88235 3 6.75C3 9.61765 3.88235 10.5 6.75 10.5C9.61765 10.5 10.5 9.61765 10.5 6.75C10.5 3.88235 9.61765 3 6.75 3Z" stroke="#000000" stroke-width="1.152" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M6.75 13.5C3.88235 13.5 3 14.3824 3 17.25C3 20.1176 3.88235 21 6.75 21C9.61765 21 10.5 20.1176 10.5 17.25C10.5 14.3824 9.61765 13.5 6.75 13.5Z" stroke="#000000" stroke-width="1.152" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M17.25 13.5C14.3824 13.5 13.5 14.3824 13.5 17.25C13.5 20.1176 14.3824 21 17.25 21C20.1176 21 21 20.1176 21 17.25C21 14.3824 20.1176 13.5 17.25 13.5Z" stroke="#000000" stroke-width="1.152" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M17.25 3C14.3824 3 13.5 3.88235 13.5 6.75C13.5 9.61765 14.3824 10.5 17.25 10.5C20.1176 10.5 21 9.61765 21 6.75C21 3.88235 20.1176 3 17.25 3Z" stroke="#000000" stroke-width="1.152" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>'>
                                                    Petak Pilihan Ganda
                                                    </option>
                                                    <option  value="skala_type" class="skala" id="skala_type[${i}]" data-input="scala_div[${i}]" data-image=' <svg width="18px" height="18px" viewBox="0 -6 16 16" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>navigation / 14 - navigation, aligned, dots, more, horizontal, three dots, option icon</title> <g id="Free-Icons" stroke-width="0.00016" fill="none" fill-rule="evenodd"> <g transform="translate(-1119.000000, -756.000000)" fill="#000000" fill-rule="nonzero" id="Group"> <g transform="translate(1115.000000, 746.000000)" id="Shape"> <path d="M6,10 C4.8954305,10 4,10.8954305 4,12 C4,13.1045695 4.8954305,14 6,14 C7.1045695,14 8,13.1045695 8,12 C8,10.8954305 7.1045695,10 6,10 Z"> </path> <path d="M12,10 C10.8954305,10 10,10.8954305 10,12 C10,13.1045695 10.8954305,14 12,14 C13.1045695,14 14,13.1045695 14,12 C14,10.8954305 13.1045695,10 12,10 Z"> </path> <path d="M18,10 C16.8954305,10 16,10.8954305 16,12 C16,13.1045695 16.8954305,14 18,14 C19.1045695,14 20,13.1045695 20,12 C20,10.8954305 19.1045695,10 18,10 Z"> </path> </g> </g> </g> </g></svg>'>
                                                    Skala Linier
                                                    </option>
                                                    <option value="date_type"  class="date" id="date_type[${i}]" data-input="date_input[${i}]" data-image='<svg width="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path d="M3.09277 9.40421H20.9167" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M16.442 13.3097H16.4512" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M12.0045 13.3097H12.0137" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M7.55818 13.3097H7.56744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M16.442 17.1962H16.4512" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M12.0045 17.1962H12.0137" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M7.55818 17.1962H7.56744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M16.0433 2V5.29078" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M7.96515 2V5.29078" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.2383 3.5791H7.77096C4.83427 3.5791 3 5.21504 3 8.22213V17.2718C3 20.3261 4.83427 21.9999 7.77096 21.9999H16.229C19.175 21.9999 21 20.3545 21 17.3474V8.22213C21.0092 5.21504 19.1842 3.5791 16.2383 3.5791Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                            </svg>                        '>
                                                    Tanggal
                                                    </option>
                                                    <option value="time_type" class="time" id="time_type[${i}]" data-input="time_input[${i}]" data-image='<svg width="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path fill-rule="evenodd" clip-rule="evenodd" d="M21.25 12.0005C21.25 17.1095 17.109 21.2505 12 21.2505C6.891 21.2505 2.75 17.1095 2.75 12.0005C2.75 6.89149 6.891 2.75049 12 2.75049C17.109 2.75049 21.25 6.89149 21.25 12.0005Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M15.4316 14.9429L11.6616 12.6939V7.84692" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                            </svg>                        '>
                                                    Waktu
                                                    </option>
                                                     <option value="datetime_type"  class="datetime" id="datetime_type[${i}]" data-input="datetime_input[${i}]" data-image='<svg width="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path d="M3.09277 9.40421H20.9167" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M16.442 13.3097H16.4512" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M12.0045 13.3097H12.0137" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M7.55818 13.3097H7.56744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M16.442 17.1962H16.4512" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M12.0045 17.1962H12.0137" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M7.55818 17.1962H7.56744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M16.0433 2V5.29078" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M7.96515 2V5.29078" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.2383 3.5791H7.77096C4.83427 3.5791 3 5.21504 3 8.22213V17.2718C3 20.3261 4.83427 21.9999 7.77096 21.9999H16.229C19.175 21.9999 21 20.3545 21 17.3474V8.22213C21.0092 5.21504 19.1842 3.5791 16.2383 3.5791Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                            </svg>                        '>
                                                    Tanggal dan Waktu
                                                    </option>
                                                    <option value="fileupload_type"  class="fileupload" id="fileupload_type[${i}]" data-input="fileupload_input[${i}]" data-image='<svg width="18px" height="18px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M11.2798 22H7.00977C5.9489 22 4.93148 21.5785 4.18134 20.8284C3.43119 20.0782 3.00977 19.0609 3.00977 18V14.89C3.00977 11.4713 4.36781 8.19273 6.78516 5.77539C9.2025 3.35805 12.4811 2 15.8998 2H17.0098C18.0706 2 19.0881 2.42142 19.8382 3.17157C20.5883 3.92172 21.0098 4.93913 21.0098 6V11.4399" stroke="#000000" stroke-width="1.008" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M3 15.06C3 9.9 8.50004 14.0599 11.73 10.8199C14.96 7.57995 10.83 2 15.98 2" stroke="#000000" stroke-width="1.008" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M18.1895 23V15" stroke="#000000" stroke-width="1.008" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M15.1895 18L18.1895 15" stroke="#000000" stroke-width="1.008" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M21.1895 18L18.1895 15" stroke="#000000" stroke-width="1.008" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>'>
                                                    Upload File
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                   
                                        <div class="row">
                                            <div class="col-lg-10">
                                                <label class="form-label text-black">Jawaban <span class="text-danger">*</span></label>
                                                <div class="form-group inputtype" id="shortanswer_input[${i}]">
                                                    <input type="text" class="form-control" placeholder="Teks jawaban singkat" readonly>
                                                </div>
                                                <div class="form-group inputtype" id="paragraph_input[${i}]">
                                                    <textarea class="form-control" readonly placeholder="Paragraf"></textarea>
                                                </div>
                                                <div class="form-group inputtype radio-option-div" id="singlechoice_div[${i}]">
                                                    <div class="form-check radio-option" id="option">
                                                        <div class="d-flex align-items-center">
                                                            <input class="form-check-input" type="radio">
                                                            <div class="row align-items-center px-3">
                                                                <div class="col-3 px-1">
                                                                    <input type="text" class="form-control" placeholder="Kode">
                                                                </div>
                                                                <div class="col-5 px-1">
                                                                    <input type="text" class="form-control" placeholder="Pilihan">
                                                                </div>
                                                                <div class="col-3 px-1">
                                                                    <input type="text" class="form-control" placeholder="Nilai">
                                                                </div>
                                                                <div class="col-1 px-1 d-flex align-items-center justify-content-between">
                                                                    <div class="add-radio-option px-1"> 
                                                                        <svg  width="20px" height="20px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>plus-circle</title> <desc>Created with Sketch Beta.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"> <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-464.000000, -1087.000000)" fill="#009A4B"> <path d="M480,1117 C472.268,1117 466,1110.73 466,1103 C466,1095.27 472.268,1089 480,1089 C487.732,1089 494,1095.27 494,1103 C494,1110.73 487.732,1117 480,1117 L480,1117 Z M480,1087 C471.163,1087 464,1094.16 464,1103 C464,1111.84 471.163,1119 480,1119 C488.837,1119 496,1111.84 496,1103 C496,1094.16 488.837,1087 480,1087 L480,1087 Z M486,1102 L481,1102 L481,1097 C481,1096.45 480.553,1096 480,1096 C479.447,1096 479,1096.45 479,1097 L479,1102 L474,1102 C473.447,1102 473,1102.45 473,1103 C473,1103.55 473.447,1104 474,1104 L479,1104 L479,1109 C479,1109.55 479.447,1110 480,1110 C480.553,1110 481,1109.55 481,1109 L481,1104 L486,1104 C486.553,1104 487,1103.55 487,1103 C487,1102.45 486.553,1102 486,1102 L486,1102 Z" id="plus-circle" sketch:type="MSShapeGroup"> </path> </g> </g> </g></svg>
                                                                    </div>
                                                                    <div  class="delete-radio-option">  
                                                                        <svg width="20px" height="20px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>cross-circle</title> <desc>Created with Sketch Beta.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"> <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-568.000000, -1087.000000)" fill="#009A4B"> <path d="M584,1117 C576.268,1117 570,1110.73 570,1103 C570,1095.27 576.268,1089 584,1089 C591.732,1089 598,1095.27 598,1103 C598,1110.73 591.732,1117 584,1117 L584,1117 Z M584,1087 C575.163,1087 568,1094.16 568,1103 C568,1111.84 575.163,1119 584,1119 C592.837,1119 600,1111.84 600,1103 C600,1094.16 592.837,1087 584,1087 L584,1087 Z M589.717,1097.28 C589.323,1096.89 588.686,1096.89 588.292,1097.28 L583.994,1101.58 L579.758,1097.34 C579.367,1096.95 578.733,1096.95 578.344,1097.34 C577.953,1097.73 577.953,1098.37 578.344,1098.76 L582.58,1102.99 L578.314,1107.26 C577.921,1107.65 577.921,1108.29 578.314,1108.69 C578.708,1109.08 579.346,1109.08 579.74,1108.69 L584.006,1104.42 L588.242,1108.66 C588.633,1109.05 589.267,1109.05 589.657,1108.66 C590.048,1108.27 590.048,1107.63 589.657,1107.24 L585.42,1103.01 L589.717,1098.71 C590.11,1098.31 590.11,1097.68 589.717,1097.28 L589.717,1097.28 Z" id="cross-circle" sketch:type="MSShapeGroup"> </path> </g> </g> </g></svg>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group inputtype checkbox-option-div" id="checkbox_div[${i}]">
                                                    <div class="form-check checkbox-option" id="checkbox">
                                                        <div class="d-flex align-items-center">
                                                            <input class="form-check-input" type="checkbox">
                                                            <div class="row align-items-center px-3">
                                                                <div class="col-3 px-1">
                                                                    <input type="text" class="form-control" placeholder="Kode">
                                                                </div>
                                                                <div class="col-5 px-1">
                                                                    <input type="text" class="form-control" placeholder="Pilihan">
                                                                </div>
                                                                <div class="col-3 px-1">
                                                                    <input type="text" class="form-control" placeholder="Nilai">
                                                                </div>
                                                                <div class="col-1 px-1 d-flex align-items-center justify-content-between">
                                                                    <div class="add-checkbox-option px-1"> <svg  width="20px" height="20px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>plus-circle</title> <desc>Created with Sketch Beta.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"> <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-464.000000, -1087.000000)" fill="#009A4B"> <path d="M480,1117 C472.268,1117 466,1110.73 466,1103 C466,1095.27 472.268,1089 480,1089 C487.732,1089 494,1095.27 494,1103 C494,1110.73 487.732,1117 480,1117 L480,1117 Z M480,1087 C471.163,1087 464,1094.16 464,1103 C464,1111.84 471.163,1119 480,1119 C488.837,1119 496,1111.84 496,1103 C496,1094.16 488.837,1087 480,1087 L480,1087 Z M486,1102 L481,1102 L481,1097 C481,1096.45 480.553,1096 480,1096 C479.447,1096 479,1096.45 479,1097 L479,1102 L474,1102 C473.447,1102 473,1102.45 473,1103 C473,1103.55 473.447,1104 474,1104 L479,1104 L479,1109 C479,1109.55 479.447,1110 480,1110 C480.553,1110 481,1109.55 481,1109 L481,1104 L486,1104 C486.553,1104 487,1103.55 487,1103 C487,1102.45 486.553,1102 486,1102 L486,1102 Z" id="plus-circle" sketch:type="MSShapeGroup"> </path> </g> </g> </g></svg>
                                                                    </div>
                                                                    <div  class="delete-checkbox-option">  <svg width="20px" height="20px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>cross-circle</title> <desc>Created with Sketch Beta.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"> <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-568.000000, -1087.000000)" fill="#009A4B"> <path d="M584,1117 C576.268,1117 570,1110.73 570,1103 C570,1095.27 576.268,1089 584,1089 C591.732,1089 598,1095.27 598,1103 C598,1110.73 591.732,1117 584,1117 L584,1117 Z M584,1087 C575.163,1087 568,1094.16 568,1103 C568,1111.84 575.163,1119 584,1119 C592.837,1119 600,1111.84 600,1103 C600,1094.16 592.837,1087 584,1087 L584,1087 Z M589.717,1097.28 C589.323,1096.89 588.686,1096.89 588.292,1097.28 L583.994,1101.58 L579.758,1097.34 C579.367,1096.95 578.733,1096.95 578.344,1097.34 C577.953,1097.73 577.953,1098.37 578.344,1098.76 L582.58,1102.99 L578.314,1107.26 C577.921,1107.65 577.921,1108.29 578.314,1108.69 C578.708,1109.08 579.346,1109.08 579.74,1108.69 L584.006,1104.42 L588.242,1108.66 C588.633,1109.05 589.267,1109.05 589.657,1108.66 C590.048,1108.27 590.048,1107.63 589.657,1107.24 L585.42,1103.01 L589.717,1098.71 C590.11,1098.31 590.11,1097.68 589.717,1097.28 L589.717,1097.28 Z" id="cross-circle" sketch:type="MSShapeGroup"> </path> </g> </g> </g></svg>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group inputtype" id="scala_div[${i}]">
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
                                                <div class="form-group inputtype"  id="date_input[${i}]">
                                                    <input type="date" class="form-control">
                                                </div>
                                                <div class="form-group inputtype" id="time_input[${i}]">
                                                   
                                                    <input type="time" class="form-control" >
                                                </div>
                                                <div class="form-group inputtype"  id="datetime_input[${i}]">
                                                    <input type="datetime-local" class="form-control">
                                                </div>
                                                <div class="form-group inputtype"  id="fileupload_input[${i}]">
                                                    <input class="form-control" type="file">
                                                </div>
                                                <div class="form-group inputtype multipleinput" id="multipleinput_div[${i}]">
                                                    <input type="text" class="form-control" id="multipleinput_input[${i}]"  placeholder="Multiple Input">
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="d-flex float-end">
                                                    <a class="mx-1 delete_card"  type="button"  id="delete_card[${i}]">
                                                        <svg width="21" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                              
                                                        <path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826" stroke="#009A4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                
                                                        <path d="M20.708 6.23975H3.75" stroke="#009A4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                              
                                                        <path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973" stroke="#009A4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                          
                                                        </svg>     
                                                    </a> 
                                                    <a class="mx-2 duplicate_card" type="button" id="duplicate_card[${i}]">                  
                                                        <svg width="20px" height="20px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#009A4B" stroke="#009A4B"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>duplicate</title> <desc>Created with Sketch Beta.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"> <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-204.000000, -931.000000)" fill="#009A4B"> <path d="M234,951 C234,952.104 233.104,953 232,953 L216,953 C214.896,953 214,952.104 214,951 L214,935 C214,933.896 214.896,933 216,933 L232,933 C233.104,933 234,933.896 234,935 L234,951 L234,951 Z M232,931 L216,931 C213.791,931 212,932.791 212,935 L212,951 C212,953.209 213.791,955 216,955 L232,955 C234.209,955 236,953.209 236,951 L236,935 C236,932.791 234.209,931 232,931 L232,931 Z M226,959 C226,960.104 225.104,961 224,961 L208,961 C206.896,961 206,960.104 206,959 L206,943 C206,941.896 206.896,941 208,941 L210,941 L210,939 L208,939 C205.791,939 204,940.791 204,943 L204,959 C204,961.209 205.791,963 208,963 L224,963 C226.209,963 228,961.209 228,959 L228,957 L226,957 L226,959 L226,959 Z" id="duplicate" sketch:type="MSShapeGroup"> </path> </g> </g> </g></svg>                        
                                                    </a>
                                                    <hr class="hr-vertial">
                                                    <div class="form-check form-switch mx-2">
                                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                                                        <label class="form-check-label text-black" for="flexSwitchCheckDefault">Wajib Diisi</label>
                                                    </div>
                                                    <div class="dropup mx-2 more_dropdown">
                                                        <a class="px-2" type="button" id="dropdownMenu[${i}]" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span class="fa-solid fa-ellipsis-vertical" style="color: #009a4b;"></span>
                                                        </a>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu[${i}]" role="menu">
                                                            <li><a class="dropdown-item add_heading" id="add_heading[${i}]" type="button"><svg fill="#009a4b" width="20px" height="20px" viewBox="0 0 24.00 24.00" xmlns="http://www.w3.org/2000/svg" stroke="#009a4b" stroke-width="0.00024000000000000003"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M17,11 L17,6 L15.5,6 C15.2238576,6 15,5.77614237 15,5.5 C15,5.22385763 15.2238576,5 15.5,5 L19.5,5 C19.7761424,5 20,5.22385763 20,5.5 C20,5.77614237 19.7761424,6 19.5,6 L18,6 L18,18 L19.5,18 C19.7761424,18 20,18.2238576 20,18.5 C20,18.7761424 19.7761424,19 19.5,19 L15.5,19 C15.2238576,19 15,18.7761424 15,18.5 C15,18.2238576 15.2238576,18 15.5,18 L17,18 L17,12 L7,12 L7,18 L8.5,18 C8.77614237,18 9,18.2238576 9,18.5 C9,18.7761424 8.77614237,19 8.5,19 L4.5,19 C4.22385763,19 4,18.7761424 4,18.5 C4,18.2238576 4.22385763,18 4.5,18 L6,18 L6,6 L4.5,6 C4.22385763,6 4,5.77614237 4,5.5 C4,5.22385763 4.22385763,5 4.5,5 L8.5,5 C8.77614237,5 9,5.22385763 9,5.5 C9,5.77614237 8.77614237,6 8.5,6 L7,6 L7,11 L17,11 Z"></path> </g></svg> Tambah Judul</a></li>
                                                            <li><a class="dropdown-item add_pertanyaan" id="add_pertanyaan[${i}]" type="button"><svg width="18px" height="18px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000" stroke-width="0.00024000000000000003"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2.75C6.89137 2.75 2.75 6.89137 2.75 12C2.75 17.1086 6.89137 21.25 12 21.25C17.1086 21.25 21.25 17.1086 21.25 12C21.25 6.89137 17.1086 2.75 12 2.75ZM1.25 12C1.25 6.06294 6.06294 1.25 12 1.25C17.9371 1.25 22.75 6.06294 22.75 12C22.75 17.9371 17.9371 22.75 12 22.75C6.06294 22.75 1.25 17.9371 1.25 12ZM12 7.75C11.3787 7.75 10.875 8.25368 10.875 8.875C10.875 9.28921 10.5392 9.625 10.125 9.625C9.71079 9.625 9.375 9.28921 9.375 8.875C9.375 7.42525 10.5503 6.25 12 6.25C13.4497 6.25 14.625 7.42525 14.625 8.875C14.625 9.83834 14.1056 10.6796 13.3353 11.1354C13.1385 11.2518 12.9761 11.3789 12.8703 11.5036C12.7675 11.6246 12.75 11.7036 12.75 11.75V13C12.75 13.4142 12.4142 13.75 12 13.75C11.5858 13.75 11.25 13.4142 11.25 13V11.75C11.25 11.2441 11.4715 10.8336 11.7266 10.533C11.9786 10.236 12.2929 10.0092 12.5715 9.84439C12.9044 9.64739 13.125 9.28655 13.125 8.875C13.125 8.25368 12.6213 7.75 12 7.75ZM12 17C12.5523 17 13 16.5523 13 16C13 15.4477 12.5523 15 12 15C11.4477 15 11 15.4477 11 16C11 16.5523 11.4477 17 12 17Z" fill="#009A4B"></path> </g></svg>  Tambah Pertanyaan</a></li>
                                                            <li><a class="dropdown-item add_bagian" id="add_bagian[${i}]" type="button"><svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3 6.5C3 3.87479 3.02811 3 6.5 3C9.97189 3 10 3.87479 10 6.5C10 9.12521 10.0111 10 6.5 10C2.98893 10 3 9.12521 3 6.5Z" stroke="#009A4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path fill-rule="evenodd" clip-rule="evenodd" d="M14 6.5C14 3.87479 14.0281 3 17.5 3C20.9719 3 21 3.87479 21 6.5C21 9.12521 21.0111 10 17.5 10C13.9889 10 14 9.12521 14 6.5Z" stroke="#009A4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3 17.5C3 14.8748 3.02811 14 6.5 14C9.97189 14 10 14.8748 10 17.5C10 20.1252 10.0111 21 6.5 21C2.98893 21 3 20.1252 3 17.5Z" stroke="#009A4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path fill-rule="evenodd" clip-rule="evenodd" d="M14 17.5C14 14.8748 14.0281 14 17.5 14C20.9719 14 21 14.8748 21 17.5C21 20.1252 21.0111 21 17.5 21C13.9889 21 14 20.1252 14 17.5Z" stroke="#009A4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                            </svg>                        Tambah Bagian</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            </div>
                       
                
                        </div>  
                `;
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
 
   
 </script>
 
    