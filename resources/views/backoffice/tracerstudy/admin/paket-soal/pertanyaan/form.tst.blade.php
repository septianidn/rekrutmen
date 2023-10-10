<div class="card card-soal" data-id="0" id="card-soal[0]">
    <div class="d-flex justify-content-center align-items-center drag-icon" id="drag-icon[0]">
        <svg width="25px" height="20px" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M1.5 5.5C1.5 4.94772 1.94772 4.5 2.5 4.5C3.05228 4.5 3.5 4.94772 3.5 5.5C3.5 6.05228 3.05228 6.5 2.5 6.5C1.94772 6.5 1.5 6.05228 1.5 5.5ZM6.5 5.5C6.5 4.94772 6.94772 4.5 7.5 4.5C8.05228 4.5 8.5 4.94772 8.5 5.5C8.5 6.05228 8.05228 6.5 7.5 6.5C6.94772 6.5 6.5 6.05228 6.5 5.5ZM11.5 5.5C11.5 4.94772 11.9477 4.5 12.5 4.5C13.0523 4.5 13.5 4.94772 13.5 5.5C13.5 6.05228 13.0523 6.5 12.5 6.5C11.9477 6.5 11.5 6.05228 11.5 5.5ZM1.5 9.5C1.5 8.94772 1.94772 8.5 2.5 8.5C3.05228 8.5 3.5 8.94772 3.5 9.5C3.5 10.0523 3.05228 10.5 2.5 10.5C1.94772 10.5 1.5 10.0523 1.5 9.5ZM6.5 9.5C6.5 8.94772 6.94772 8.5 7.5 8.5C8.05228 8.5 8.5 8.94772 8.5 9.5C8.5 10.0523 8.05228 10.5 7.5 10.5C6.94772 10.5 6.5 10.0523 6.5 9.5ZM11.5 9.5C11.5 8.94772 11.9477 8.5 12.5 8.5C13.0523 8.5 13.5 8.94772 13.5 9.5C13.5 10.0523 13.0523 10.5 12.5 10.5C11.9477 10.5 11.5 10.0523 11.5 9.5Z" fill="#d1d2d1"></path> </g></svg>  
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group col-sm-10">
                <label class="form-label text-black">Pertanyaan <span class="text-danger">*</span></label>
                    <textarea class="form-control pertanyaan-textarea" name="pertanyaan" placeholder="Isi Pertanyaan" id="pertanyaan[0]"></textarea>
            </div>
           
            <div class="col-sm-2 col-lg-2 selectTypeJawaban_div" id="selectTypeJawaban_div[0]">
                <select class="form-select type-jawaban-select" aria-label="Actions" id="selectTypeJawaban[0]">
                    <option value="shortanswer_type" class="shortanswer" id="shortanswer_type[0]" data-input="shortanswer_input[0]" data-image='<svg width="18px" height="18px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 10H21M3 14H12" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>'>
                    Jawaban Singkat                        
                    </option>
                    <option value="paragraph_type" class="paragraph" id="paragraph_type[0]" data-input="paragraph_input[0]" data-image='<svg width="15px" height="15px" viewBox="0 0 24 28" version="1.1" xmlns="http://www.w3.org/2000/svg" 
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
                    <option value="singlechoice_type" class="singlechoice" id="singlechoice_type[0]"  data-input="singlechoice_div[0]" data-input="paragraph_input"data-image='<svg xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none">                                <circle cx="12" cy="12" r="7.5" stroke="currentColor"></circle>                            </svg>                        '>
                    Pilihan Ganda (Radio Button)
                    </option>
                    <option value="checkbox_type" class="checkbox" id="checkbox_type[0]" data-input="checkbox_div[0]" data-image='<svg width="18px" height="18px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4.56499 12.4068C4.29258 12.0947 3.81879 12.0626 3.50676 12.335C3.19472 12.6074 3.1626 13.0812 3.43501 13.3932L4.56499 12.4068ZM7.14286 16.5L6.57787 16.9932C6.7203 17.1564 6.92629 17.25 7.14286 17.25C7.35942 17.25 7.56542 17.1564 7.70784 16.9932L7.14286 16.5ZM15.565 7.99324C15.8374 7.68121 15.8053 7.20742 15.4932 6.93501C15.1812 6.6626 14.7074 6.69472 14.435 7.00676L15.565 7.99324ZM10.5064 11.5068C10.234 11.8188 10.2662 12.2926 10.5782 12.565C10.8902 12.8374 11.364 12.8053 11.6364 12.4932L10.5064 11.5068ZM9.67213 14.7432C9.94454 14.4312 9.91242 13.9574 9.60039 13.685C9.28835 13.4126 8.81457 13.4447 8.54215 13.7568L9.67213 14.7432ZM3.43501 13.3932L6.57787 16.9932L7.70784 16.0068L4.56499 12.4068L3.43501 13.3932ZM7.70784 16.9932L9.67213 14.7432L8.54215 13.7568L6.57787 16.0068L7.70784 16.9932ZM11.6364 12.4932L13.6007 10.2432L12.4707 9.25676L10.5064 11.5068L11.6364 12.4932ZM13.6007 10.2432L15.565 7.99324L14.435 7.00676L12.4707 9.25676L13.6007 10.2432Z" fill="#000000"></path> <path d="M20.0002 7.5625L15.7144 12.0625M11.0002 16L11.4286 16.5625L13.5715 14.3125" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>'>
                    Kotak Centang (Checkbox)
                    </option>
                    <option value="multipleinput_type" class="multipleinput" id="multipleinput_type[0]" data-input="multipleinput_div[0]" data-image='<svg width="18px" height="18px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000" stroke-width="0.00024000000000000003"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M21.07 10.3L15.07 4.29996C14.93 4.15996 14.74 4.07996 14.54 4.07996H3C2.59 4.07996 2.25 4.41996 2.25 4.82996V12.71C2.25 12.91 2.33 13.1 2.47 13.24L8.47 19.23C8.91 19.67 9.49 19.91 10.11 19.91C10.73 19.91 11.32 19.67 11.75 19.23L11.97 19.01C12.01 19.09 12.05 19.17 12.12 19.23C12.57 19.68 13.17 19.91 13.76 19.91C14.35 19.91 14.95 19.68 15.41 19.23L21.06 13.58C21.96 12.68 21.96 11.21 21.06 10.3H21.07ZM10.7 18.17C10.54 18.33 10.34 18.41 10.12 18.41C9.9 18.41 9.69 18.32 9.54 18.17L3.75 12.4V5.57996H10.57L16.35 11.36C16.67 11.68 16.67 12.2 16.35 12.52L10.7 18.17ZM20.01 12.52L14.36 18.17C14.04 18.49 13.51 18.49 13.19 18.17C13.12 18.1 13.05 18.06 12.96 18.02L17.4 13.58C18.3 12.67 18.3 11.2 17.4 10.3L12.68 5.57996H14.22L20 11.36C20.32 11.68 20.32 12.2 20 12.52H20.01ZM8.25 8.49996C8.25 9.18996 7.69 9.74996 7 9.74996C6.31 9.74996 5.75 9.18996 5.75 8.49996C5.75 7.80996 6.31 7.24996 7 7.24996C7.69 7.24996 8.25 7.80996 8.25 8.49996Z" fill="#000000"></path> </g></svg>'>
                    Multiple Input 
                    </option>
                    <option value="dropdown_type" class="checkbox" id="dropdown_type[0]" data-input="dropdown_div[0]" data-image='<svg width="18px" height="18px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M8 6.00067L21 6.00139M8 12.0007L21 12.0015M8 18.0007L21 18.0015M3.5 6H3.51M3.5 12H3.51M3.5 18H3.51M4 6C4 6.27614 3.77614 6.5 3.5 6.5C3.22386 6.5 3 6.27614 3 6C3 5.72386 3.22386 5.5 3.5 5.5C3.77614 5.5 4 5.72386 4 6ZM4 12C4 12.2761 3.77614 12.5 3.5 12.5C3.22386 12.5 3 12.2761 3 12C3 11.7239 3.22386 11.5 3.5 11.5C3.77614 11.5 4 11.7239 4 12ZM4 18C4 18.2761 3.77614 18.5 3.5 18.5C3.22386 18.5 3 18.2761 3 18C3 17.7239 3.22386 17.5 3.5 17.5C3.77614 17.5 4 17.7239 4 18Z" stroke="#000000" stroke-width="1.224" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>'>
                    List Pilihan (Dropdown)
                    </option>
                    <option  value="gridcolumn_type" class="gridcolumn" id="gridcolumn_type[0]" data-input="gridcolumn_div[0]" data-image='<svg width="18px" height="18px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M6.75 3C3.88235 3 3 3.88235 3 6.75C3 9.61765 3.88235 10.5 6.75 10.5C9.61765 10.5 10.5 9.61765 10.5 6.75C10.5 3.88235 9.61765 3 6.75 3Z" stroke="#000000" stroke-width="1.152" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M6.75 13.5C3.88235 13.5 3 14.3824 3 17.25C3 20.1176 3.88235 21 6.75 21C9.61765 21 10.5 20.1176 10.5 17.25C10.5 14.3824 9.61765 13.5 6.75 13.5Z" stroke="#000000" stroke-width="1.152" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M17.25 13.5C14.3824 13.5 13.5 14.3824 13.5 17.25C13.5 20.1176 14.3824 21 17.25 21C20.1176 21 21 20.1176 21 17.25C21 14.3824 20.1176 13.5 17.25 13.5Z" stroke="#000000" stroke-width="1.152" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M17.25 3C14.3824 3 13.5 3.88235 13.5 6.75C13.5 9.61765 14.3824 10.5 17.25 10.5C20.1176 10.5 21 9.61765 21 6.75C21 3.88235 20.1176 3 17.25 3Z" stroke="#000000" stroke-width="1.152" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>'>
                    Petak Pilihan Ganda
                    </option>
                    <option  value="skala_type" class="skala" id="skala_type[0]" data-input="scala_div[0]" data-image=' <svg width="18px" height="18px" viewBox="0 -6 16 16" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>navigation / 14 - navigation, aligned, dots, more, horizontal, three dots, option icon</title> <g id="Free-Icons" stroke-width="0.00016" fill="none" fill-rule="evenodd"> <g transform="translate(-1119.000000, -756.000000)" fill="#000000" fill-rule="nonzero" id="Group"> <g transform="translate(1115.000000, 746.000000)" id="Shape"> <path d="M6,10 C4.8954305,10 4,10.8954305 4,12 C4,13.1045695 4.8954305,14 6,14 C7.1045695,14 8,13.1045695 8,12 C8,10.8954305 7.1045695,10 6,10 Z"> </path> <path d="M12,10 C10.8954305,10 10,10.8954305 10,12 C10,13.1045695 10.8954305,14 12,14 C13.1045695,14 14,13.1045695 14,12 C14,10.8954305 13.1045695,10 12,10 Z"> </path> <path d="M18,10 C16.8954305,10 16,10.8954305 16,12 C16,13.1045695 16.8954305,14 18,14 C19.1045695,14 20,13.1045695 20,12 C20,10.8954305 19.1045695,10 18,10 Z"> </path> </g> </g> </g> </g></svg>'>
                    Skala Linier
                    </option>
                    <option value="date_type"  class="date" id="date_type[0]" data-input="date_input[0]" data-image='<svg width="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path d="M3.09277 9.40421H20.9167" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M16.442 13.3097H16.4512" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M12.0045 13.3097H12.0137" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M7.55818 13.3097H7.56744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M16.442 17.1962H16.4512" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M12.0045 17.1962H12.0137" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M7.55818 17.1962H7.56744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M16.0433 2V5.29078" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M7.96515 2V5.29078" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.2383 3.5791H7.77096C4.83427 3.5791 3 5.21504 3 8.22213V17.2718C3 20.3261 4.83427 21.9999 7.77096 21.9999H16.229C19.175 21.9999 21 20.3545 21 17.3474V8.22213C21.0092 5.21504 19.1842 3.5791 16.2383 3.5791Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                            </svg>                        '>
                    Tanggal
                    </option>
                    <option value="time_type" class="time" id="time_type[0]" data-input="time_input[0]" data-image='<svg width="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path fill-rule="evenodd" clip-rule="evenodd" d="M21.25 12.0005C21.25 17.1095 17.109 21.2505 12 21.2505C6.891 21.2505 2.75 17.1095 2.75 12.0005C2.75 6.89149 6.891 2.75049 12 2.75049C17.109 2.75049 21.25 6.89149 21.25 12.0005Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M15.4316 14.9429L11.6616 12.6939V7.84692" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                            </svg>                        '>
                    Waktu
                    </option>
                     <option value="datetime_type"  class="datetime" id="datetime_type[0]" data-input="datetime_input[0]" data-image='<svg width="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path d="M3.09277 9.40421H20.9167" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M16.442 13.3097H16.4512" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M12.0045 13.3097H12.0137" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M7.55818 13.3097H7.56744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M16.442 17.1962H16.4512" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M12.0045 17.1962H12.0137" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M7.55818 17.1962H7.56744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M16.0433 2V5.29078" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M7.96515 2V5.29078" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.2383 3.5791H7.77096C4.83427 3.5791 3 5.21504 3 8.22213V17.2718C3 20.3261 4.83427 21.9999 7.77096 21.9999H16.229C19.175 21.9999 21 20.3545 21 17.3474V8.22213C21.0092 5.21504 19.1842 3.5791 16.2383 3.5791Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                            </svg>                        '>
                    Tanggal dan Waktu
                    </option>
                    <option value="fileupload_type"  class="fileupload" id="fileupload_type[0]" data-input="fileupload_input[0]" data-image='<svg width="18px" height="18px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M11.2798 22H7.00977C5.9489 22 4.93148 21.5785 4.18134 20.8284C3.43119 20.0782 3.00977 19.0609 3.00977 18V14.89C3.00977 11.4713 4.36781 8.19273 6.78516 5.77539C9.2025 3.35805 12.4811 2 15.8998 2H17.0098C18.0706 2 19.0881 2.42142 19.8382 3.17157C20.5883 3.92172 21.0098 4.93913 21.0098 6V11.4399" stroke="#000000" stroke-width="1.008" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M3 15.06C3 9.9 8.50004 14.0599 11.73 10.8199C14.96 7.57995 10.83 2 15.98 2" stroke="#000000" stroke-width="1.008" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M18.1895 23V15" stroke="#000000" stroke-width="1.008" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M15.1895 18L18.1895 15" stroke="#000000" stroke-width="1.008" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M21.1895 18L18.1895 15" stroke="#000000" stroke-width="1.008" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>'>
                    Upload File
                    </option>
                </select>
            </div>
        </div>
   
        <div class="row">
            <div class="col-lg-10">
                <label class="form-label text-black">Jawaban</label>
                <div class="form-group inputtype" id="shortanswer_input[0]">
                    <input type="text" class="form-control" placeholder="Teks jawaban singkat" readonly>
                </div>
                <div class="form-group inputtype" id="paragraph_input[0]">
                    <textarea class="form-control" readonly placeholder="Paragraf"></textarea>
                </div>
                <div class="form-group inputtype radio-option-div" id="singlechoice_div[0]">
                    <p> Silahkan isi opsi pilihan ganda dibawah ini <span class="text-danger">*</span> </p>
                    <div class="radio-option" id="option">
                        <div class="d-flex align-items-center">
                            <input class="form-check-input" type="radio">
                            <div class="row align-items-center">
                                <div class="col-3">
                                    <input type="text" class="form-control" placeholder="Kode">
                                </div>
                                <div class="col-4 ">
                                    <input type="text" class="form-control" placeholder="Pilihan">
                                </div>
                                <div class="col-3 ">
                                    <input type="text" class="form-control" placeholder="Nilai">
                                </div>
                                <div class="col-2 d-flex align-items-center ">
                                    <a class="btn btn-danger btn-sm  mx-1" type="button">
                                       
                                       Hapus
                                   </a>
                                   <a class="btn btn-success btn-sm add-radio-option" type="button">
                                      Tambah
                                   </a>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group inputtype checkbox-option-div" id="checkbox_div[0]">
                    <p> Silahkan isi opsi pilihan kotak centang (checkbox) dibawah ini  <span class="text-danger">*</span> </p>
                    <div class="checkbox-option" id="checkbox">
                        <div class="d-flex align-items-center">
                            <input class="form-check-input" type="checkbox">
                            <div class="row align-items-center">
                                <div class="col-lg-3">
                                    <input type="text" class="form-control" placeholder="Kode">
                                </div>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" placeholder="Pilihan">
                                </div>
                                <div class="col-lg-3">
                                    <input type="text" class="form-control" placeholder="Nilai">
                                </div>
                                <div class="col-lg-2 d-flex align-items-center">
                                    <a class="btn btn-danger btn-sm  mx-1" type="button">
                                       
                                        Hapus
                                    </a>
                                    <a class="btn btn-success btn-sm add-checkbox-option" type="button">
                                       Tambah
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group inputtype" id="scala_div[0]">
                    <p>Silahkan isi range dibawah ini <span class="text-danger">*</span> </p>
                    <div class="d-flex justify-content-between w-50">
                        <select class="form-select range-start">
                            <option value="0" selected >0</option>
                            <option value="1">1</option>
                        </select>
                        <p class="px-4  my-auto">Sampai</p>
                        <select class="form-select range-end">
                            <option value=""disabled selected>Pilih Range</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                    </div>
                    <div class="w-50 mt-4 range-label-container">
                        <div class="input-group">
                            <span class="input-group-text range-label-start">0</span>
                            <input type="text" class="form-control" id="range-label-start" placeholder="Label (Opsional)">
                        </div>                                                    
                    </div>

                   
                </div>
                <div class="form-group inputtype" id="gridcolumn_div[0]">
                    <p> Silahkan isi opsi pilihan dibawah ini <span class="text-danger">*</span> </p>    
                    <div class="mx-3">                                           
                    <div class="row">
                        <div class="col-lg-1 col-md-2 col-sm-2 py-3 bg-grey text-center">
                            No
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 py-3 bg-grey text-center">
                            Baris
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 py-3 bg-grey text-center">
                            Kolom
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-1 col-md-2 col-sm-2 py-3 text-center grid-number-container">
                            <div class="row my-2 align-items-center grid-number-div" data-row-number="1">
                                <p class="text-center grid-number"> 1 </p>
                            </div>
                            <div class="row my-2 align-items-center grid-number-div" data-row-number="2">
                                <p class="text-center grid-number"> 2 </p>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 grid-row-container">
                            <div class="row my-2 grid-row">
                                <div class="col-lg-12">
                                    <div class="input-group" >
                                        <input type="text" class="form-control grid-row-input" placeholder="Baris 1">
                                       
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row my-2 grid-row">
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <input type="text" class="form-control grid-row-input" placeholder="Baris 2">
                                        <span class="input-group-text grid-delete-row">
                                            <svg width="24px" height="24px" viewBox="0 -0.5 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M6.96967 16.4697C6.67678 16.7626 6.67678 17.2374 6.96967 17.5303C7.26256 17.8232 7.73744 17.8232 8.03033 17.5303L6.96967 16.4697ZM13.0303 12.5303C13.3232 12.2374 13.3232 11.7626 13.0303 11.4697C12.7374 11.1768 12.2626 11.1768 11.9697 11.4697L13.0303 12.5303ZM11.9697 11.4697C11.6768 11.7626 11.6768 12.2374 11.9697 12.5303C12.2626 12.8232 12.7374 12.8232 13.0303 12.5303L11.9697 11.4697ZM18.0303 7.53033C18.3232 7.23744 18.3232 6.76256 18.0303 6.46967C17.7374 6.17678 17.2626 6.17678 16.9697 6.46967L18.0303 7.53033ZM13.0303 11.4697C12.7374 11.1768 12.2626 11.1768 11.9697 11.4697C11.6768 11.7626 11.6768 12.2374 11.9697 12.5303L13.0303 11.4697ZM16.9697 17.5303C17.2626 17.8232 17.7374 17.8232 18.0303 17.5303C18.3232 17.2374 18.3232 16.7626 18.0303 16.4697L16.9697 17.5303ZM11.9697 12.5303C12.2626 12.8232 12.7374 12.8232 13.0303 12.5303C13.3232 12.2374 13.3232 11.7626 13.0303 11.4697L11.9697 12.5303ZM8.03033 6.46967C7.73744 6.17678 7.26256 6.17678 6.96967 6.46967C6.67678 6.76256 6.67678 7.23744 6.96967 7.53033L8.03033 6.46967ZM8.03033 17.5303L13.0303 12.5303L11.9697 11.4697L6.96967 16.4697L8.03033 17.5303ZM13.0303 12.5303L18.0303 7.53033L16.9697 6.46967L11.9697 11.4697L13.0303 12.5303ZM11.9697 12.5303L16.9697 17.5303L18.0303 16.4697L13.0303 11.4697L11.9697 12.5303ZM13.0303 11.4697L8.03033 6.46967L6.96967 7.53033L11.9697 12.5303L13.0303 11.4697Z" fill="#000000"></path> </g></svg>                   
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 grid-column-container">
                            <div class="row my-2 grid-column">
                                <div class="col-lg-12">
                                    <div class="input-group ">
                                        <input type="text" class="form-control grid-column-input" placeholder="Kolom 1">
                                       
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row my-2 grid-column">
                                <div class="col-lg-12">
                                    <div class="input-group ">
                                        <input type="text" class="form-control  grid-column-input" placeholder="Kolom 2">
                                        <span class="input-group-text grid-delete-column">
                                            <svg width="24px" height="24px" viewBox="0 -0.5 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M6.96967 16.4697C6.67678 16.7626 6.67678 17.2374 6.96967 17.5303C7.26256 17.8232 7.73744 17.8232 8.03033 17.5303L6.96967 16.4697ZM13.0303 12.5303C13.3232 12.2374 13.3232 11.7626 13.0303 11.4697C12.7374 11.1768 12.2626 11.1768 11.9697 11.4697L13.0303 12.5303ZM11.9697 11.4697C11.6768 11.7626 11.6768 12.2374 11.9697 12.5303C12.2626 12.8232 12.7374 12.8232 13.0303 12.5303L11.9697 11.4697ZM18.0303 7.53033C18.3232 7.23744 18.3232 6.76256 18.0303 6.46967C17.7374 6.17678 17.2626 6.17678 16.9697 6.46967L18.0303 7.53033ZM13.0303 11.4697C12.7374 11.1768 12.2626 11.1768 11.9697 11.4697C11.6768 11.7626 11.6768 12.2374 11.9697 12.5303L13.0303 11.4697ZM16.9697 17.5303C17.2626 17.8232 17.7374 17.8232 18.0303 17.5303C18.3232 17.2374 18.3232 16.7626 18.0303 16.4697L16.9697 17.5303ZM11.9697 12.5303C12.2626 12.8232 12.7374 12.8232 13.0303 12.5303C13.3232 12.2374 13.3232 11.7626 13.0303 11.4697L11.9697 12.5303ZM8.03033 6.46967C7.73744 6.17678 7.26256 6.17678 6.96967 6.46967C6.67678 6.76256 6.67678 7.23744 6.96967 7.53033L8.03033 6.46967ZM8.03033 17.5303L13.0303 12.5303L11.9697 11.4697L6.96967 16.4697L8.03033 17.5303ZM13.0303 12.5303L18.0303 7.53033L16.9697 6.46967L11.9697 11.4697L13.0303 12.5303ZM11.9697 12.5303L16.9697 17.5303L18.0303 16.4697L13.0303 11.4697L11.9697 12.5303ZM13.0303 11.4697L8.03033 6.46967L6.96967 7.53033L11.9697 12.5303L13.0303 11.4697Z" fill="#000000"></path> </g></svg>                   
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-1 col-md-2 col-sm-2 py-3 ">
                            
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 py-2 ">
                            <a  class="btn btn-primary btn-sm grid-add-row-button" type="button"  > 
                                <i class="btn-inner">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </i> 
                                <span>Tambah Baris</span>
                            </a>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 py-2">
                            <a class="btn btn-primary btn-sm grid-add-column-button" type="button"  > 
                                <i class="btn-inner">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </i> 
                                <span>Tambah Kolom</span>
                            </a>
                        </div>
                    </div>
                </div>
                </div>
                <div class="form-group inputtype"  id="dropdown_div[0]">
                    <p> Silahkan pilih data pedia yang akan ditampilkan dibawah ini <span class="text-danger">*</span> </p>
                    <select class="form-select">
                        <option value="">Pilih Data</option>
                        @foreach ($datapediaOptions as $datapediaOption)
                            <option value="{{ $datapediaOption->id }}">{{ $datapediaOption->nama_data }}</option>
                        @endforeach
                    </select>
                    <p class="input-information ml-1">Untuk melihat data pedia klik <a href="{{ route('datapedia.index') }}" >disini</a></p>                                          
                </div>
                <div class="form-group inputtype"  id="date_input[0]">
                    <input type="date" class="form-control">
                </div>
                <div class="form-group inputtype" id="time_input[0]">         
                    <input type="time" class="form-control" >
                </div>
                <div class="form-group inputtype"  id="datetime_input[0]">
                    <input type="datetime-local" class="form-control">
                </div>
                <div class="form-group inputtype"  id="fileupload_input[0]">
                    <input class="form-control" type="file">
                </div>
                <div class="form-group inputtype multipleinput" id="multipleinput_div[0]">
                    <input type="text" class="form-control" id="multipleinput_input[0]"  placeholder="Multiple Input">
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex float-end">
                    <a class="mx-1 delete_card"  type="button"  id="delete_card[0]">
                        <svg width="21" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                              
                        <path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826" stroke="#009A4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                
                        <path d="M20.708 6.23975H3.75" stroke="#009A4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                              
                        <path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973" stroke="#009A4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                          
                        </svg>     
                    </a> 
                    <a class="mx-2 duplicate_card" type="button" id="duplicate_card[0]">                  
                        <svg width="20px" height="20px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#009A4B" stroke="#009A4B"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>duplicate</title> <desc>Created with Sketch Beta.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"> <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-204.000000, -931.000000)" fill="#009A4B"> <path d="M234,951 C234,952.104 233.104,953 232,953 L216,953 C214.896,953 214,952.104 214,951 L214,935 C214,933.896 214.896,933 216,933 L232,933 C233.104,933 234,933.896 234,935 L234,951 L234,951 Z M232,931 L216,931 C213.791,931 212,932.791 212,935 L212,951 C212,953.209 213.791,955 216,955 L232,955 C234.209,955 236,953.209 236,951 L236,935 C236,932.791 234.209,931 232,931 L232,931 Z M226,959 C226,960.104 225.104,961 224,961 L208,961 C206.896,961 206,960.104 206,959 L206,943 C206,941.896 206.896,941 208,941 L210,941 L210,939 L208,939 C205.791,939 204,940.791 204,943 L204,959 C204,961.209 205.791,963 208,963 L224,963 C226.209,963 228,961.209 228,959 L228,957 L226,957 L226,959 L226,959 Z" id="duplicate" sketch:type="MSShapeGroup"> </path> </g> </g> </g></svg>                        
                    </a>
                    <hr class="hr-vertial">
                    <div class="form-check form-switch mx-2">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                        <label class="form-check-label text-black" for="flexSwitchCheckDefault">Wajib Diisi</label>
                    </div>
                    <div class="dropup mx-2 more_dropdown">
                        <a class="px-2" type="button" id="dropdownMenu[0]" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="fa-solid fa-ellipsis-vertical" style="color: #009a4b;"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu[0]" role="menu">
                            <li><a class="dropdown-item add_heading" id="add_heading[0]" type="button"><svg fill="#009a4b" width="20px" height="20px" viewBox="0 0 24.00 24.00" xmlns="http://www.w3.org/2000/svg" stroke="#009a4b" stroke-width="0.00024000000000000003"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M17,11 L17,6 L15.5,6 C15.2238576,6 15,5.77614237 15,5.5 C15,5.22385763 15.2238576,5 15.5,5 L19.5,5 C19.7761424,5 20,5.22385763 20,5.5 C20,5.77614237 19.7761424,6 19.5,6 L18,6 L18,18 L19.5,18 C19.7761424,18 20,18.2238576 20,18.5 C20,18.7761424 19.7761424,19 19.5,19 L15.5,19 C15.2238576,19 15,18.7761424 15,18.5 C15,18.2238576 15.2238576,18 15.5,18 L17,18 L17,12 L7,12 L7,18 L8.5,18 C8.77614237,18 9,18.2238576 9,18.5 C9,18.7761424 8.77614237,19 8.5,19 L4.5,19 C4.22385763,19 4,18.7761424 4,18.5 C4,18.2238576 4.22385763,18 4.5,18 L6,18 L6,6 L4.5,6 C4.22385763,6 4,5.77614237 4,5.5 C4,5.22385763 4.22385763,5 4.5,5 L8.5,5 C8.77614237,5 9,5.22385763 9,5.5 C9,5.77614237 8.77614237,6 8.5,6 L7,6 L7,11 L17,11 Z"></path> </g></svg> Tambah Judul</a></li>
                            <li><a class="dropdown-item add_pertanyaan" id="add_pertanyaan[0]" type="button"><svg width="18px" height="18px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000" stroke-width="0.00024000000000000003"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2.75C6.89137 2.75 2.75 6.89137 2.75 12C2.75 17.1086 6.89137 21.25 12 21.25C17.1086 21.25 21.25 17.1086 21.25 12C21.25 6.89137 17.1086 2.75 12 2.75ZM1.25 12C1.25 6.06294 6.06294 1.25 12 1.25C17.9371 1.25 22.75 6.06294 22.75 12C22.75 17.9371 17.9371 22.75 12 22.75C6.06294 22.75 1.25 17.9371 1.25 12ZM12 7.75C11.3787 7.75 10.875 8.25368 10.875 8.875C10.875 9.28921 10.5392 9.625 10.125 9.625C9.71079 9.625 9.375 9.28921 9.375 8.875C9.375 7.42525 10.5503 6.25 12 6.25C13.4497 6.25 14.625 7.42525 14.625 8.875C14.625 9.83834 14.1056 10.6796 13.3353 11.1354C13.1385 11.2518 12.9761 11.3789 12.8703 11.5036C12.7675 11.6246 12.75 11.7036 12.75 11.75V13C12.75 13.4142 12.4142 13.75 12 13.75C11.5858 13.75 11.25 13.4142 11.25 13V11.75C11.25 11.2441 11.4715 10.8336 11.7266 10.533C11.9786 10.236 12.2929 10.0092 12.5715 9.84439C12.9044 9.64739 13.125 9.28655 13.125 8.875C13.125 8.25368 12.6213 7.75 12 7.75ZM12 17C12.5523 17 13 16.5523 13 16C13 15.4477 12.5523 15 12 15C11.4477 15 11 15.4477 11 16C11 16.5523 11.4477 17 12 17Z" fill="#009A4B"></path> </g></svg>  Tambah Pertanyaan</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
</div>
</div>  