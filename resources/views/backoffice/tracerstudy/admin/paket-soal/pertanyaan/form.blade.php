<x-app-layout :assets="$assets ?? []">
    <?php
    $datapediaOptions = App\Models\DataPedia::all() ?? null;
    $id = $id ?? null;
    ?>
    <div>
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="card" data-aos="fade-down" data-aos-delay="900">
                    <div class="d-flex justify-content-between align-items-center p-4">
                        <h4 class="card-title">Form Soal</h4>
                        <div class="d-flex ">
                            <div style="margin-right: 10px;">
                                <button type=" button" class="btn btn-m btn-primary">Lihat Form</button>
                            </div>
                            <button type="submit" class="btn btn-m btn-primary">Simpan Form</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <form method="POST" action="">
            @csrf
            <div class="fieldset-wizard-slider">
                <div id="page-container" class="fieldset-wizard-container">

                </div>

                <div class="d-flex justify-content-end my-4 page-navigation-container">
                    <button type="button" name="delete"
                        class="btn btn-danger btn-sm delete-and-previous action-button-previous me-1" value="Previous">
                        Hapus Halaman</button>
                    <div class="page-navigation"></div>
                    <button type="button" name="add" class="btn btn-primary btn-sm add-and-next action-button"
                        value="Next" ">Tambah Halaman</button>
            </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script src="https://kit.fontawesome.com/243e6ffe26.js" crossorigin="anonymous"></script>

<script>
    /* 
        PAGE LISTENER 
    */


    $(document).ready(function() {


        let currentPage = 1;
        const maxPages = 10;

        showFirstPage();


        function showPage(page) {

            hideOrShowAddandDelete();
            const container = $(".fieldset-wizard-container");
            const width = container.width();
            container.css("transform", `translateX(-${(page - 1) * width}px)`);
            $(`#page-navigation\\[${page}\\]`).addClass("active");
            inputPageTitle();
        }



        function addPage(activeElementNavPageId) {
            const pageCount = $('.fieldset-wizard').length;
            if (pageCount < maxPages) {
                // Menghapus kelas "active" dari fieldset saat ini
                $(`#page\\[${activeElementNavPageId}\\]`).removeClass("active");
                $(`#page\\[${activeElementNavPageId}\\]`).addClass("padding-10");

                const addToPageId = parseInt(activeElementNavPageId) + 1;
                const newPage = generatePage(addToPageId);
                const fieldSetBefore = $(`#page\\[${activeElementNavPageId}\\]`);
                const fieldSetAfter = $(`#page\\[${addToPageId}\\]`);

                if (fieldSetAfter.length > 0) {
                    fieldSetAfter.before(newPage);

                } else {
                    fieldSetBefore.after(newPage);

                }
                const cardContainer = $(`#card_container\\[${addToPageId}\\]`)
                const pageNavigation = $(".page-navigation");
                pageNavigation.html(generatePageNavigation());
                cardContainer.append(generateCard(addToPageId, 0));
                initializeCard();
                showPage(addToPageId);

            }
        }

        function hideOrShowAddandDelete() {
            const pageCount = $('.fieldset-wizard').length;
            console.log("PAGE:" + pageCount + "d" + maxPages);
            if (parseInt(pageCount) === currentPage) {
                $(".delete-and-previous").hide();
            } else if (parseInt(pageCount) === maxPages) {
                $(".add-and-next").hide();
                $(".delete-and-previous").show();
            } else {
                $(".delete-and-previous").show();
                $(".add-and-next").show();
            }
        }

        var toastMixin = Swal.mixin({
            toast: true,
            icon: 'success',
            title: 'General Title',
            animation: false,
            position: 'top-right',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        function deletePage(pageToDeleteId) {
            if (pageToDeleteId > 1) {
                const pageToDeleteElement = $(`#page\\[${pageToDeleteId}\\]`);
                pageToDeleteElement.remove();
                const pageNavigation = $(".page-navigation");
                pageNavigation.html(generatePageNavigation());
                showPage(parseInt(pageToDeleteId) - 1);
                toastMixin.fire({
                    animation: true,
                    title: 'Halaman Terhapus',
                });
            }
        }

        function getActiveElementId() {
            const activeNavPage = $('.navigation-page');
            let activeElementNavPage;

            activeNavPage.each(function() {
                if ($(this).hasClass('active')) {
                    activeElementNavPage = $(this).attr('id');
                    return false;
                }
            });

            if (activeElementNavPage !== null) {
                activeElementNavPageId = activeElementNavPage.match(/\d+/)[0];
            }
            return activeElementNavPageId ?? null;
        }

        $(document).on('click', '.add-and-next', function() {
            const activeElementNavPageIdToAdd = getActiveElementId();
            if (activeElementNavPageIdToAdd !== null) {
                addPage(activeElementNavPageIdToAdd);
                resetIndexPage();
            }
        });

        $(document).on('click', '.delete-and-previous', function() {

            const activeElementNavPageIdToDelete = getActiveElementId();
            if (activeElementNavPageIdToDelete !== null) {
                console.log(activeElementNavPageIdToDelete);
                const pageNameValue = $(`#nama_halaman\\[${activeElementNavPageIdToDelete}\\]`).val();
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-danger mx-2',
                        cancelButton: 'btn btn-success',
                        popup: 'rounded'
                    },
                    buttonsStyling: false,
                    showClass: {
                        popup: 'animate__animated animate__zoomIn animate__faster',

                    },
                    hideClass: {
                        popup: 'animate__animated animate__zoomOut animate__faster',

                    }
                })
                swalWithBootstrapButtons.fire({
                    title: `Hapus Halaman ${pageNameValue}?`,
                    text: "Anda tidak akan dapat mengembalikan halaman ini!!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                }).then(function(result) {
                    if (result.isConfirmed) {
                        deletePage(activeElementNavPageIdToDelete);
                    }
                });

            }
        });


        $(document).on('click', '.navigation-page', function() {
            $('.navigation-page').removeClass('active');
            const pageToNavigate = parseInt($(this).text());

            showPage(pageToNavigate);
            $(this).addClass('active');
        });

        function resetIndexPage() {
            const pageElements = $('.fieldset-wizard');

            pageElements.each(function(index) {
                $(this).attr('id', `page[${index + 1}]`);
                $(this).find('input[id^="nama_halaman\\["]').attr('id', `nama_halaman[${index + 1}]`);
                $(this).find('.card_container[id^="card_container\\["]').attr('id',
                    `card_container[${index + 1}]`);
            });

        }
        // Fungsi untuk menghasilkan kode HTML untuk halaman
        function generatePageNavigation() {
            let navigationHTML = "";
            const pageCount = $('.fieldset-wizard').length;

            for (let i = 1; i <= pageCount; i++) {
                navigationHTML +=
                    `<button type="button" name="page" class="btn btn-light btn-sm navigation-page action-button-number-page me-1" id="page-navigation[${i}]" value="Number Page">${i}</button>`;
            }
            return navigationHTML;
        }

        function generatePage(page) {
            return ` <fieldset class="fieldset-wizard" id="page[${page}]">
            <div class="form-card text-start">
                <div class="row">
                    <input type="text" class="h3 px-2  mx-2 mb-4 dynamic-input" id="nama_halaman[${page}]" value="Halaman ${page}" style="transition: width 0.2s;">
                    <div class="col-sm-12 col-lg-12 card_container" id="card_container[${page}]">
                      
                    </div>
                </div>
            </div>
        </fieldset>`;
        }

        function showFirstPage() {
            const firstPage = generatePage(currentPage);
            const pageContainer = $("#page-container");
            pageContainer.append(firstPage);
            const pageNavigation = $(".page-navigation");
            pageNavigation.html(generatePageNavigation());
            const cardContainer = $(`#card_container\\[${currentPage}\\]`)
            cardContainer.append(generateCard(currentPage, 0));
            initializeCard();
            showPage(currentPage);

        }

        function inputPageTitle() {
            const dynamicInputs = $(".dynamic-input");

            dynamicInputs.each(function(index) {
                const inputValue = $(this).val().trim();
                if (inputValue === "") {
                    $(this).val("Halaman " + (index + 1));
                }

                $(this).on("blur", function() {
                    const blurredValue = $(this).val().trim();
                    if (blurredValue === "") {
                        $(this).val("Halaman " + (index + 1));
                        this.style.width = "auto";
                    }
                });

                $(this).on("input", function() {
                    resizeInput.call(this);
                });

                resizeInput.call($(this)[0]);

                function resizeInput() {
                    $(this).css("width", this.value.length + "ch");
                }

            });
        }



    });

    /* 
        CARD LISTENER 
    */


    function initializeCard() {

        checkBoxListener();
        radioBoxListener();
        gridColumnListener();
        listenerCard();

    }

    function gridColumnListener() {


        let row = 1;
        let column = 1;
        $(document).off('click', '.grid-add-row-button');
        $(document).on('click', '.grid-add-row-button', function() {

            const id = $(this).attr('id');
            console.log(id)
            const matches = id.match(/\[(\d+)\]\[(\d+)\]/);

            if (matches) {

                const pageIndexs = parseInt(matches[1]);
                const cardIndexs = parseInt(matches[2]);

                var newRowNumber = $(
                    `#grid-row-container\\[${pageIndexs}\\]\\[${cardIndexs}\\] .grid-row`
                ).length + 1;


                const newElementRow = generateGridElementRow(pageIndexs, cardIndexs, row + 1);
                row++;
                const newElementNumber = generateGridElementNumber(newRowNumber)
                console.log(newElementNumber);

                $(`#grid-row-container\\[${pageIndexs}\\]\\[${cardIndexs}\\]`).append(newElementRow);
                $(`#grid-number-container\\[${pageIndexs}\\]\\[${cardIndexs}\\]`).append(newElementNumber);

                updateRowNumbers(pageIndexs, cardIndexs);
                updateNumbers(pageIndexs, cardIndexs);
            }


        });

        function generateGridElementRow(pageIndexs, cardIndexs, gridRowIndexs) {
            return ` <div class="row my-2 grid-row"  id="grid-row[${pageIndexs}][${cardIndexs}][${gridRowIndexs}]">
                                        <div class="col-lg-12">
                                            <div class="input-group">
                                                <input type="text" class="form-control grid-row-input" id="grid-row-input[${pageIndexs}][${cardIndexs}][${gridRowIndexs}]"
                                                    placeholder="Label Baris 2">
                                                <input type="text" class="form-control grid-row-input-value"  id="grid-row-input-value[${pageIndexs}][${cardIndexs}][${gridRowIndexs}]"
                                                    placeholder="Nilai Baris 2">
                                                <span class="input-group-text grid-delete-row" id="grid-delete-row[${pageIndexs}][${cardIndexs}][${gridRowIndexs}]" >
                                                    <svg width="24px" height="24px" viewBox="0 -0.5 25 25"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                            stroke-linejoin="round"></g>
                                                        <g id="SVGRepo_iconCarrier">
                                                            <path
                                                                d="M6.96967 16.4697C6.67678 16.7626 6.67678 17.2374 6.96967 17.5303C7.26256 17.8232 7.73744 17.8232 8.03033 17.5303L6.96967 16.4697ZM13.0303 12.5303C13.3232 12.2374 13.3232 11.7626 13.0303 11.4697C12.7374 11.1768 12.2626 11.1768 11.9697 11.4697L13.0303 12.5303ZM11.9697 11.4697C11.6768 11.7626 11.6768 12.2374 11.9697 12.5303C12.2626 12.8232 12.7374 12.8232 13.0303 12.5303L11.9697 11.4697ZM18.0303 7.53033C18.3232 7.23744 18.3232 6.76256 18.0303 6.46967C17.7374 6.17678 17.2626 6.17678 16.9697 6.46967L18.0303 7.53033ZM13.0303 11.4697C12.7374 11.1768 12.2626 11.1768 11.9697 11.4697C11.6768 11.7626 11.6768 12.2374 11.9697 12.5303L13.0303 11.4697ZM16.9697 17.5303C17.2626 17.8232 17.7374 17.8232 18.0303 17.5303C18.3232 17.2374 18.3232 16.7626 18.0303 16.4697L16.9697 17.5303ZM11.9697 12.5303C12.2626 12.8232 12.7374 12.8232 13.0303 12.5303C13.3232 12.2374 13.3232 11.7626 13.0303 11.4697L11.9697 12.5303ZM8.03033 6.46967C7.73744 6.17678 7.26256 6.17678 6.96967 6.46967C6.67678 6.76256 6.67678 7.23744 6.96967 7.53033L8.03033 6.46967ZM8.03033 17.5303L13.0303 12.5303L11.9697 11.4697L6.96967 16.4697L8.03033 17.5303ZM13.0303 12.5303L18.0303 7.53033L16.9697 6.46967L11.9697 11.4697L13.0303 12.5303ZM11.9697 12.5303L16.9697 17.5303L18.0303 16.4697L13.0303 11.4697L11.9697 12.5303ZM13.0303 11.4697L8.03033 6.46967L6.96967 7.53033L11.9697 12.5303L13.0303 11.4697Z"
                                                                fill="#000000"></path>
                                                        </g>
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                    </div>`
        }

        function generateGridElementNumber(pageIndexs, cardIndexs, gridRowIndexs, newRowNumber) {
            return `  <div class="row my-2 align-items-center grid-number-div" data-row-number="${newRowNumber}" id="grid-number-div[${pageIndexs}][${cardIndexs}][${gridRowIndexs}]">
                                        <p class="text-center grid-number"> ${newRowNumber} </p>
                                    </div>`
        }



        $(document).off('click', '.grid-add-column-button');
        $(document).on('click', '.grid-add-column-button', function() {
            const id = $(this).attr('id');
            console.log(id)
            const matches = id.match(/\[(\d+)\]\[(\d+)\]/);
            if (matches) {

                const pageIndexs = parseInt(matches[1]);
                const cardIndexs = parseInt(matches[2]);
                const newElementColumn = generateGridElementColumn(pageIndexs, cardIndexs, column + 1);
                column++;
                $(`#grid-column-container\\[${pageIndexs}\\]\\[${cardIndexs}\\]`).append(newElementColumn);
                updateColumnNumbers(pageIndexs, cardIndexs);
            }

        });

        function generateGridElementColumn(pageIndexs, cardIndexs, gridColumnIndexs) {
            return ` <div class="row my-2 grid-column"  id="grid-column[${pageIndexs}][${cardIndexs}][1]">
                                        <div class="col-lg-12">
                                            <div class="input-group ">
                                                <input type="text" class="form-control grid-column-input"  id="grid-column-input[${pageIndexs}][${cardIndexs}][${gridColumnIndexs}]"
                                                    placeholder="Label Kolom 2">
                                                <input type="text" class="form-control grid-column-input-value"  id="grid-column-input-value[${pageIndexs}][${cardIndexs}][${gridColumnIndexs}]"
                                                    placeholder="Nilai Kolom 2">
                                                <span class="input-group-text grid-delete-column" id="grid-delete-column[${pageIndexs}][${cardIndexs}][${gridColumnIndexs}]">
                                                    <svg width="24px" height="24px" viewBox="0 -0.5 25 25"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                            stroke-linejoin="round"></g>
                                                        <g id="SVGRepo_iconCarrier">
                                                            <path
                                                                d="M6.96967 16.4697C6.67678 16.7626 6.67678 17.2374 6.96967 17.5303C7.26256 17.8232 7.73744 17.8232 8.03033 17.5303L6.96967 16.4697ZM13.0303 12.5303C13.3232 12.2374 13.3232 11.7626 13.0303 11.4697C12.7374 11.1768 12.2626 11.1768 11.9697 11.4697L13.0303 12.5303ZM11.9697 11.4697C11.6768 11.7626 11.6768 12.2374 11.9697 12.5303C12.2626 12.8232 12.7374 12.8232 13.0303 12.5303L11.9697 11.4697ZM18.0303 7.53033C18.3232 7.23744 18.3232 6.76256 18.0303 6.46967C17.7374 6.17678 17.2626 6.17678 16.9697 6.46967L18.0303 7.53033ZM13.0303 11.4697C12.7374 11.1768 12.2626 11.1768 11.9697 11.4697C11.6768 11.7626 11.6768 12.2374 11.9697 12.5303L13.0303 11.4697ZM16.9697 17.5303C17.2626 17.8232 17.7374 17.8232 18.0303 17.5303C18.3232 17.2374 18.3232 16.7626 18.0303 16.4697L16.9697 17.5303ZM11.9697 12.5303C12.2626 12.8232 12.7374 12.8232 13.0303 12.5303C13.3232 12.2374 13.3232 11.7626 13.0303 11.4697L11.9697 12.5303ZM8.03033 6.46967C7.73744 6.17678 7.26256 6.17678 6.96967 6.46967C6.67678 6.76256 6.67678 7.23744 6.96967 7.53033L8.03033 6.46967ZM8.03033 17.5303L13.0303 12.5303L11.9697 11.4697L6.96967 16.4697L8.03033 17.5303ZM13.0303 12.5303L18.0303 7.53033L16.9697 6.46967L11.9697 11.4697L13.0303 12.5303ZM11.9697 12.5303L16.9697 17.5303L18.0303 16.4697L13.0303 11.4697L11.9697 12.5303ZM13.0303 11.4697L8.03033 6.46967L6.96967 7.53033L11.9697 12.5303L13.0303 11.4697Z"
                                                                fill="#000000"></path>
                                                        </g>
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
            `;
        }


        $(document).off('click', '.grid-delete-row');
        $(document).on('click', '.grid-delete-row', function() {
            var rowContainer = $(this).closest('.grid-row');
            var rowIndex = $('.grid-row').index(rowContainer); // Menghitung indeks baris
            rowContainer.remove();
            $('.grid-number-container').find('.grid-number-div').eq(rowIndex).remove();

            updateRowNumbers();
            updateNumbers();
        });

        $(document).off('click', '.grid-delete-column');
        $(document).on('click', '.grid-delete-column', function() {
            $(this).closest('.grid-column').remove();
            updateColumnNumbers();

        });


        function updateRowNumbers(pageIndexs, cardIndexs) {
            $(`#grid-row-container\\[${pageIndexs}\\]\\[${cardIndexs}\\] .grid-row`).each(function(index) {
                var rowNumber = index + 1;
                $(this).find(".grid-row-input").attr("placeholder", "Label Baris " + (index + 1));
                $(this).find(".grid-row-input-value").attr("placeholder", "Nilai Baris " + (index + 1));

            });
        }

        function updateNumbers(pageIndexs, cardIndexs) {
            $(`#grid-number-container\\[${pageIndexs}\\]\\[${cardIndexs}\\] .grid-number-div`).each(function(index) {
                var rowNumber = index + 1;
                $(this).find(".grid-number").text(index + 1);

            });
        }


        function updateColumnNumbers(pageIndexs, cardIndexs) {
            $(`#grid-column-container\\[${pageIndexs}\\]\\[${cardIndexs}\\] .grid-column`).each(function(index) {
                var columnNumber = index + 1;
                $(this).find(".grid-column-input").attr("placeholder", "Label Kolom " + columnNumber);
                $(this).find(".grid-column-input-value").attr("placeholder", "Nilai Kolom " +
                    columnNumber);

            });
        }

    }


    //RANGE LISTENER
    function rangeListener() {
        $(document).on('change', '.range-start', function() {
            var startValue = parseInt($(this).val());
            console.log(startValue);
            $(".input-group-text.range-label-start").text(startValue);
            labelRangeCounter()
        });

        $(document).on('change', '.range-end', function() {
            labelRangeCounter()
        });

        function labelRangeCounter() {
            var startValue = parseInt($(".range-start").val());
            var endValue = parseInt($(".range-end").val());
            console.log(startValue + endValue);

            var labelRangeContainer = $('.range-label-container'); // Ganti dengan kelas yang sesuai
            labelRangeContainer.find('.range-label-group').remove(); // Hapus elemen sebelumnya
            if (startValue == 0) {
                counterStartValue = 1;
            }
            if (startValue == 1) {
                counterStartValue = 2

            }
            for (var i = counterStartValue; i <= endValue; i++) {
                var labelRange = ` <div class="input-group range-label-group">
    <span class="input-group-text">${i}</span>
    <input type="text" class="form-control" placeholder="Label (Opsional)">
    </div>`;

                labelRangeContainer.append(labelRange);
            }
        }

    }

    function checkBoxListener() {

        $(document).off('click', '.add-checkbox-option');
        $(document).on('click', '.add-checkbox-option', function() {

            console.log("HII AKU DITEKAN")
            const id = $(this).attr('id');
            console.log(id)
            const matches = id.match(/\[(\d+)\]\[(\d+)\]\[(\d+)\]/);

            if (matches) {
                const pageIndexs = parseInt(matches[1]);
                const cardIndexs = parseInt(matches[2]);
                const checkBoxIndexs = parseInt(matches[3]);

                addCheckBox(pageIndexs, cardIndexs, checkBoxIndexs, $(this))
            }
        });

        $(document).off('click', '.delete-checkbox-option');
        $(document).on('click', '.delete-checkbox-option', function() {
            const id = $(this).attr('id');
            const matches = id.match(/\[(\d+)\]\[(\d+)\]\[(\d+)\]/);

            if (matches) {
                const pageIndexs = parseInt(matches[1]);
                const cardIndexs = parseInt(matches[2]);
                const checkBoxIndexs = parseInt(matches[3]);
                console.log("PAGE" + pageIndexs, cardIndexs, checkBoxIndexs);
                //ADD
                deleteCheckBox(pageIndexs, cardIndexs, checkBoxIndexs, $(this))
            }
        });
        checkBoxAdditionalListener();
    }

    function checkBoxAdditionalListener() {
        $(document).on('change', '.mutiplechoice-addition', function() {
            const id = $(this).attr('id');
            const matches = id.match(/\[(\d+)\]\[(\d+)\]\[(\d+)\]/);

            if (!matches) return;

            const [pageIndexs, cardIndexs, checkBoxIndexs] = matches.slice(1).map(Number);
            const visibility = this.checked ? 'visible' : 'hidden';

            $(`#mutiplechoice-addition-text\\[${pageIndexs}\\]\\[${cardIndexs}\\]\\[${checkBoxIndexs}\\]`).css(
                'visibility', visibility);
        });
    }

    function deleteCheckBox(pageIndexs, cardIndexs, checkBoxIndexs, checkBoxElement) {
        if (checkBoxIndexs > 0) {
            const checkBoxToDelete = $(
                `#mutiple_option_div\\[${pageIndexs}\\]\\[${cardIndexs}\\]\\[${checkBoxIndexs}\\]`);
            checkBoxToDelete.remove();
            resetIndexCheckBox(pageIndexs, cardIndexs);
        }
    }

    function addCheckBox(pageIndexs, cardIndexs, checkBoxIndexs, checkBoxElement) {
        if (checkBoxIndexs < 30) {
            const newElementCheckBox = generateCheckBox(pageIndexs, cardIndexs, checkBoxIndexs + 1);
            const checkBoxBefore = $(
                `#mutiple_option_div\\[${pageIndexs}\\]\\[${cardIndexs}\\]\\[${checkBoxIndexs}\\]`);
            const checkBoxAfter = $(
                `#mutiple_option_div\\[${pageIndexs}\\]\\[${cardIndexs}\\]\\[${checkBoxIndexs + 1}\\]`);
            if (checkBoxAfter.length > 0) {
                checkBoxAfter.before(newElementCheckBox);
            } else {
                checkBoxBefore.after(newElementCheckBox);
            }
            resetIndexCheckBox(pageIndexs, cardIndexs);
        }
    }

    function generateCheckBox(indexPage, indexCard, indexCheckBoxOption) {
        return `   <div class="checkbox-option mutiple_option_div" id="mutiple_option_div[${indexPage}][${indexCard}][${indexCheckBoxOption}]">
                            <div class="d-flex align-items-center">
                                <div class="px-2">
                                <input class="form-check-input" type="checkbox">
                            </div>
                                <div class="row no-gutters">
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Kode">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Pilihan">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Nilai">
                                    </div>
                                    <div class="col d-flex align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input mutiplechoice-addition " type="checkbox"
                                                id="mutiplechoice-addition[${indexPage}][${indexCard}][${indexCheckBoxOption}]">
                                            <label class="form-check-label" for="mutiplechoice-addition">
                                                Text Tambahan
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                            <input class="form-control mutiplechoice-addition-text" type="text"
                                                id="mutiplechoice-addition-text[${indexPage}][${indexCard}][${indexCheckBoxOption}]" placeholder="Kode Text Tambahan">
                                        </div>
                                    <div class="col d-flex align-items-center">
                                        <a class="btn btn-danger btn-sm  mx-1 delete-checkbox-option" id="delete-checkbox-option[${indexPage}][${indexCard}][${indexCheckBoxOption}]"  type="button">
                                            Hapus
                                        </a>
                                        <a class="btn btn-success btn-sm add-checkbox-option" id="add-checkbox-option[${indexPage}][${indexCard}][${indexCheckBoxOption}]" type="button">
                                            Tambah
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>`;
    }

    function resetIndexCheckBox(pageIndexs, cardIndexs) {

        const checkBoxElements = $(`[id^="mutiple_option_div[${pageIndexs}][${cardIndexs}]"]`);
        const pattern = /\[(\d+)\]\[(\d+)\]\[(\d+)\]/;

        checkBoxElements.each(function(index) {
            const thisCheckBoxElements = $(this);
            const matches = thisCheckBoxElements.attr('id').match(pattern);
            const pageIndex = matches[1];
            const cardIndex = matches[2];
            const checkBoxIndex = index;

            thisCheckBoxElements.attr('id', `mutiple_option_div[${pageIndex}][${cardIndex}][${index}]`);

            $(this).find("[id]").each(function() {
                const id = $(this).attr("id");
                if (matches) {
                    const newIdCheckBox = id.replace(/\[(\d+)\]\[(\d+)\]\[(\d+)\]/,
                        `[${pageIndex}][${cardIndex}][${checkBoxIndex}]`);
                    $(this).attr('id', `${newIdCheckBox}`);
                }
            });

        });
    }

    function initializeSelect2InfluenceQuestion() {
        $('.singlechoice-influence-hide').each(function() {
            const selectElementHide = $(this);
            if (selectElementHide.hasClass('select2-hidden-accessible')) {
                // Destroy the Select2 instance
                selectElementHide.select2('destroy');
            }

            selectElementHide.select2({
                theme: 'bootstrap-5',
                placeholder: $(this).data('placeholder'),
                minimumResultsForSearch: Infinity,
                templateResult: formatState,
                templateSelection: formatState
            });
        });

        $('.singlechoice-influence-show').each(function() {
            const selectElementShow = $(this);
            if (selectElementShow.hasClass('select2-hidden-accessible')) {
                // Destroy the Select2 instance
                selectElementShow.select2('destroy');
            }

            selectElementShow.select2({
                theme: 'bootstrap-5',
                placeholder: $(this).data('placeholder'),
                minimumResultsForSearch: Infinity,
                templateResult: formatState,
                templateSelection: formatState
            });
        });
    }
    //PILIHAN GANDA LISTENER
    function radioBoxListener() {

        $(document).off('click', '.add-radio-option');
        $(document).on('click', '.add-radio-option', function() {

            const id = $(this).attr('id');
            const matches = id.match(/\[(\d+)\]\[(\d+)\]\[(\d+)\]/);

            if (matches) {
                const pageIndexs = parseInt(matches[1]);
                const cardIndexs = parseInt(matches[2]);
                const radioIndexs = parseInt(matches[3]);
                console.log("PAGE" + pageIndexs, cardIndexs, radioIndexs);
                //ADD
                addRadioBox(pageIndexs, cardIndexs, radioIndexs, $(this))
            }

        });

        $(document).off('click', '.delete-radio-option');
        $(document).on('click', '.delete-radio-option', function() {
            const id = $(this).attr('id');
            const matches = id.match(/\[(\d+)\]\[(\d+)\]\[(\d+)\]/);
            if (matches) {
                const pageIndexs = parseInt(matches[1]);
                const cardIndexs = parseInt(matches[2]);
                const radioIndexs = parseInt(matches[3]);
                deleteRadioBox(pageIndexs, cardIndexs, radioIndexs, $(this));
            }
        });

        radioBoxAdditionalListener();
        initializeSelect2InfluenceQuestion();

    }

    function deleteRadioBox(pageIndexs, cardIndexs, radioIndexs, radioBoxElement) {
        if (radioIndexs > 0) {
            const radioBoxToDelete = $(
                `#singlechoice_option_div\\[${pageIndexs}\\]\\[${cardIndexs}\\]\\[${radioIndexs}\\]`);
            radioBoxToDelete.remove();
            resetIndexRadioBox(pageIndexs, cardIndexs);
        }
    }

    function addRadioBox(pageIndexs, cardIndexs, radioIndexs, radioBoxElement) {
        if (radioIndexs < 30) {
            const newElementRadioBox = generateRadioBox(pageIndexs, cardIndexs, radioIndexs + 1);
            const radioBefore = $(`#singlechoice_option_div\\[${pageIndexs}\\]\\[${cardIndexs}\\]\\[${radioIndexs}\\]`);
            const radioAfter = $(
                `#singlechoice_option_div\\[${pageIndexs}\\]\\[${cardIndexs}\\]\\[${radioIndexs + 1}\\]`);
            if (radioAfter.length > 0) {
                radioAfter.before(newElementRadioBox);
            } else {
                radioBefore.after(newElementRadioBox);
            }
            resetIndexRadioBox(pageIndexs, cardIndexs);
        }
    }

    function resetIndexRadioBox(pageIndexs, cardIndexs) {

        const radioBoxElements = $(`[id^="singlechoice_option_div[${pageIndexs}][${cardIndexs}]"]`);
        const pattern = /\[(\d+)\]\[(\d+)\]\[(\d+)\]/;

        radioBoxElements.each(function(index) {
            const thisRadioBoxElements = $(this);
            const matches = thisRadioBoxElements.attr('id').match(pattern);
            const pageIndex = matches[1];
            const cardIndex = matches[2];
            const radioIndex = index;

            thisRadioBoxElements.attr('id', `singlechoice_option_div[${pageIndex}][${cardIndex}][${index}]`);

            $(this).find("[id]").each(function() {
                const id = $(this).attr("id");
                if (matches) {
                    const newIdRadioBox = id.replace(/\[(\d+)\]\[(\d+)\]\[(\d+)\]/,
                        `[${pageIndex}][${cardIndex}][${radioIndex}]`);
                    $(this).attr('id', `${newIdRadioBox}`);
                }
            });

        });
        radioBoxListener();
    }

    function generateRadioBox(indexPage, indexCard, indexRadioOption) {
        return `       <div class="radio-option singlechoice_option_div" id="singlechoice_option_div[${indexPage}][${indexCard}][${indexRadioOption}]">
                            <div class="d-flex align-items-center">
                                <div class="px-2">
                                    <input class="form-check-input" type="radio">
                                </div>
                                <div class="row no-gutters">
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Kode">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Pilihan">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Nilai">
                                    </div>
                                    <div class="col d-flex align-items-center">
                                                <div class="form-check">
                                                    <input class="form-check-input singlechoice-addition " type="checkbox"
                                                        id="singlechoice-addition[${indexPage}][${indexCard}][${indexRadioOption}]">
                                                    <label class="form-check-label" for="singlechoice-addition">
                                                        Text Tambahan
                                                    </label>
                                                </div>
                                            </div>
                                    <div class="col">
                                        <input class="form-control singlechoice-addition-text" type="text"
                                        id="singlechoice-addition-text[${indexPage}][${indexCard}][${indexRadioOption}]" placeholder="Kode Text Tambahan">
                                    </div>
                                  
                                    <div class="col d-flex align-items-center">
                                        <div class="align-items-center">
                                            <a class="btn btn-secondary btn-sm mx-1 collapsed" data-bs-toggle="collapse" href="#collapse[${indexPage}][${indexCard}][${indexRadioOption}]" role="button" aria-expanded="false" aria-controls="collapseExample">
                                             Lainnya
                                            </a>
                                        </div>
                                        <a class="btn btn-danger btn-sm mx-1 delete-radio-option" id="delete-radio-option[${indexPage}][${indexCard}][${indexRadioOption}]" type="button">
                                            Hapus
                                        </a>
                                        <a class="btn btn-success btn-sm add-radio-option" id="add-radio-option[${indexPage}][${indexCard}][${indexRadioOption}]" type="button">
                                            Tambah
                                        </a>
                                    </div>
                                  
                                </div>
                               
                            </div>
                            <div class="row mt-2 mb-2">
                                <div class="col">
                                    <div class="collapse" id="collapse[${indexPage}][${indexCard}][${indexRadioOption}]">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="input-group" style="padding-left:30px;" >
                                                    <div class="input-group-text text-black">Tampilkan Pertanyaan &nbsp; &nbsp;&nbsp;&nbsp;</div>
                                                    <select class="form-select singlechoice-influence-show" id="singlechoice-influence-show[${indexPage}][${indexCard}][${indexRadioOption}]" data-placeholder="Tampilkan Pertanyaan" multiple="multiple">
                                                       
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <div class="input-group" style="padding-left:30px;">
                                                    <div class="input-group-text text-black">Sembunyikan Pertanyaan</div>
                                                    <select class="form-select singlechoice-influence-hide" id="singlechoice-influence-hide[${indexPage}][${indexCard}][${indexRadioOption}]" data-placeholder="Sembunyikan Pertanyaan" multiple="multiple">
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>`
    }

    function radioBoxAdditionalListener() {
        $(document).on('change', '.singlechoice-addition', function() {
            const id = $(this).attr('id');
            const matches = id.match(/\[(\d+)\]\[(\d+)\]\[(\d+)\]/);

            if (!matches) return;

            const [pageIndexs, cardIndexs, radioIndexs] = matches.slice(1).map(Number);
            const visibility = this.checked ? 'visible' : 'hidden';

            $(`#singlechoice-addition-text\\[${pageIndexs}\\]\\[${cardIndexs}\\]\\[${radioIndexs}\\]`).css(
                'visibility', visibility);
        });
    }


    //END RADIO BOX LISTENER

    function dragCard() {
        new Sortable(document.getElementById('card_container'), {
            handle: '.drag-icon', // handle's class
            animation: 150,
            onEnd: function(evt) {
                resetIndexCard(pageIndexs);

            },
        });


    }



    function listenerCard() {


        $(document).off('click', '.card-soal');
        $(document).on('click', '.card-soal', function() {
            $(this).addClass("active").siblings().removeClass("active");
        });

        $(document).off('click', '.add_pertanyaan');
        $(document).on('click', '.add_pertanyaan', function() {

            const id = $(this).attr('id');
            const matches = id.match(/\[(\d+)\]\[(\d+)\]/);
            if (matches) {
                const pageIndexs = parseInt(matches[1]);
                const cardIndexs = parseInt(matches[2]);
                console.log("PAGE" + pageIndexs);
                addCard(pageIndexs, cardIndexs, $(this));
            }
        });

        $(document).off('click', '.add_heading');
        $(document).on('click', '.add_heading', function() {

            const id = $(this).attr('id');
            const matches = id.match(/\[(\d+)\]\[(\d+)\]/);

            if (matches) {
                const pageIndexs = parseInt(matches[1]);
                const cardIndexs = parseInt(matches[2]);
                addHeading(pageIndexs, cardIndexs, $(this));
            }

        });


        $(document).off('click', '.duplicate_card');
        $(document).on('click', '.duplicate_card', function() {

            const id = $(this).attr('id');
            const matches = id.match(/\[(\d+)\]\[(\d+)\]/);

            if (matches) {
                const pageIndexs = parseInt(matches[1]);
                const cardIndexs = parseInt(matches[2]);
                duplicateCard(pageIndexs, cardIndexs, $(this));
            }


        });

        $(document).off('click', '.delete_card');
        $(document).on('click', '.delete_card', function() {
            const id = $(this).attr('id');
            const matches = id.match(/\[(\d+)\]\[(\d+)\]/);

            if (matches) {
                const pageIndexs = parseInt(matches[1]);
                const cardIndexs = parseInt(matches[2]);
                deleteCard(pageIndexs, cardIndexs, $(this));
            }

        })

        initializeTinymce();
        initializeSelect2();
        initializeSelect2InfluenceQuestion();
        // initializeTagify();

    }

    function initializeTagify() {
        const multipleInputs = document.querySelectorAll("input[id^=multipleinput_input\\[]");
        const initialWords = ["Jawaban A", "Jawaban B", "dll"];
        multipleInputs.forEach(function(inputElement) {
            const index = inputElement.id.match(/\[(\d+)\]/)[1];


            const tagify = new Tagify(inputElement, {
                readonly: true

            });

            tagify.addTags(initialWords.join(","));
        });
    }



    function initializeTinymce() {
        // tinymce.editors = [];
        tinymce.remove()
        const textareaPertanyaan = document.querySelectorAll("textarea[id^=pertanyaan");
        textareaPertanyaan.forEach(function(textarea) {
            const id = textarea.id;
            const matches = id.match(/\[(\d+)\]\[(\d+)\]/);
            const pageIndexs = parseInt(matches[1]);
            const cardIndexs = parseInt(matches[2]);
            tinymce.init({
                mode: "specific_textareas",
                editor_selector: "mceEditor",
                selector: `textarea#pertanyaan\\[${pageIndexs}\\]\\[${cardIndexs}\\]`,
                branding: false,
                plugins: 'autolink link image lists preview code wordcount table',
                toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | ' +
                    'numlist bullist | link image',
                menubar: 'file edit view insert format tools table',
                image_title: true,
                automatic_uploads: true,
                file_picker_types: 'image',
                setup: function(ed) {
                    ed.on("click", function() {
                        const cardSoal = $(
                                `#pertanyaan\\[${pageIndexs}\\]\\[${cardIndexs}\\]`
                            )
                            .closest('.card-soal');
                        cardSoal.addClass("active").siblings().removeClass(
                            "active");
                    });
                }
            });
        });

    }



    function initializeSelect2() {
        // Loop through each .type-jawaban-select element
        var cardId = "";
        var selectElement = "";

        $('.type-jawaban-select').each(function() {
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
            toggleInputs(selectElement);
            (function(selectElement) {
                selectElement.on('change', function() {
                    toggleInputs(selectElement);

                });
            })(selectElement);



        });
    }



    function toggleInputs(selectElement) {
        const selectedType = selectElement.closest('.card-body').find('.type-jawaban-select');
        const selectedElement = selectedType.find('option:selected');
        const dataInput = selectedElement.attr('data-input');

        const selectedTypeValidation = selectElement.closest('.card-body').find('.type-jawaban-select');
        const selectedElementValidation = selectedType.find('option:selected');
        const dataValidation = selectedElementValidation.attr('data-validation');

        const inputElements = selectElement.closest('.card-body').find(`.form-group.inputtype`);
        const inputTypeDivs = selectElement.closest('.card-body').find(`.shortanswer-validation-div`);


        inputElements.each(function() {
            const inputElement = $(this);
            const inputId = inputElement.attr('id');
            console.log(inputId + dataInput)
            if (inputId === dataInput) {
                inputElement.show();
            } else {
                inputElement.hide();
            }
        });

        inputTypeDivs.each(function() {
            const inputTypeDiv = $(this);
            const divId = inputTypeDiv.attr('id');
            if (divId === dataValidation) {
                inputTypeDiv.show();
            } else {
                inputTypeDiv.hide();
            }
        });
        console.log("-----------")
    }

    //TODO: CHECK RESET INDEX AGAIN WRONGGG!!
    function resetIndexCard(pageIndexs) {

        const cardElements = $(`[id^="card-soal[${pageIndexs}]"]`);
        console.log("PIW");
        console.log(pageIndexs);
        const pattern = /\[(\d+)\]\[(\d+)\]/;

        cardElements.each(function(index) {
            console.log($(this) + index);
            const thisCardELements = $(this);
            const matches = thisCardELements.attr('id').match(pattern);
            const pageIndex = matches[1];
            const cardIndex = index;

            const iframeElement = $(this).find('iframe');
            if (iframeElement) {
                iframeElement.attr('id', `pertanyaann[${pageIndex}][${cardIndex}]_ifr`);
                console.log(iframeElement.attr('id'))
            }

            thisCardELements.attr('id', `card-soal[${pageIndex}][${cardIndex}]`);
            thisCardELements.attr('data-id', cardIndex);
            thisCardELements.attr('data-page', pageIndex);
            thisCardELements.attr('data-select2-id',
                `selectTypeJawaban_div[${pageIndex}][${cardIndex}]`);

            $(this).find("[id], [data-card], [data-input], [data-validation]").each(function() {
                const id = $(this).attr("id");
                const dataInput = $(this).attr("data-input");
                const dataValidation = $(this).attr("data-validation");
                const dataCard = $(this).attr("data-card");

                if (matches) {
                    const newIdCard = id.replace(/\[(\d+)\]\[(\d+)]/,
                        `[${pageIndex}][${cardIndex}]`);
                    $(this).attr('id', `${newIdCard}`);
                }
                if (dataInput && matches) {
                    const newDataInputCard = dataInput.replace(/\[(\d+)\]\[(\d+)]/,
                        `[${pageIndex}][${cardIndex}]`);
                    $(this).attr('data-input', newDataInputCard);
                }
                if (dataValidation && matches) {
                    const newDataInputVCard = dataValidation.replace(/\[(\d+)\]\[(\d+)]/,
                        `[${pageIndex}][${cardIndex}]`);
                    $(this).attr('data-validation', newDataInputVCard);
                }
                if (dataCard && matches) {
                    const newDataInputCard = dataCard.replace(/\[(\d+)\]\[(\d+)]/,
                        `[${pageIndex}][${cardIndex}]`);
                    $(this).attr('data-card', newDataInputCard);
                }
            });
        });

        listenerCard();

    }

    //TODO:CHECK AGAIN
    function addCard(pageIndexs, cardIndexs, cardSelector) {
        const addCard = generateCard(pageIndexs, cardIndexs + 1);
        const cardBefore = $(`#card-soal\\[${pageIndexs}\\]\\[${cardIndexs}\\]`);
        const cardAfter = $(`#card-soal\\[${pageIndexs}\\]\\[${cardIndexs + 1}\\]`);

        if (cardAfter.length > 0) {
            cardAfter.before(addCard);

        } else {
            cardBefore.after(addCard);


        }
        resetIndexCard(pageIndexs);
    }

    function addHeading(pageIndexs, cardIndexs, cardSelector) {
        const addHeading = generateHeading(pageIndexs, cardIndexs + 1);
        const cardBeforeHeading = $(`#card-soal\\[${pageIndexs}\\]\\[${cardIndexs}\\]`);
        const cardAfterHeading = $(`#card-soal\\[${pageIndexs}\\]\\[${cardIndexs + 1}\\]`);

        if (cardAfterHeading.length > 0) {
            cardBeforeHeading.after(addHeading);
        } else {
            cardBeforeHeading.after(addHeading);
        }
        resetIndexCard(pageIndexs);
    };

    function duplicateCard(pageIndexs, cardIndexs, cardSelector) {

        //TODO FIX THE SELECT2
        const cardToDuplicate = $(`#card-soal\\[${pageIndexs}\\]\\[${cardIndexs}\\]`);
        const clonedCard = cardToDuplicate.clone();
        cardToDuplicate.after(clonedCard);

        resetIndexCard(pageIndexs);
    }


    function deleteCard(pageIndexs, cardIndexs, cardSelector) {

        const elements = document.querySelectorAll(`[id^="card-soal\\[${pageIndexs}\\]"]`);
        const count = elements.length;
        if (count > 1) {
            const cardToDelete = $(`#card-soal\\[${pageIndexs}\\]\\[${cardIndexs}\\]`);
            cardToDelete.remove();
            resetIndexCard(pageIndexs);
        } else {
            toastMixin.fire({
                icon: 'error',
                animation: true,
                title: 'Sisakan Minimal 1 Pertanyaan Perhalaman!',
            });
        }

    }

    function generateHeading(indexPage, indexCard) {
        return `<div class="card card-soal" data-page="${indexPage}" data-id="${indexCard}" id="card-soal[${indexPage}][${indexCard}]">
        <div class="d-flex justify-content-center align-items-center drag-icon" id="drag-icon[${indexPage}][${indexCard}]">
            <svg width="25px" height="20px" viewBox="0 0 15 15" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M1.5 5.5C1.5 4.94772 1.94772 4.5 2.5 4.5C3.05228 4.5 3.5 4.94772 3.5 5.5C3.5 6.05228 3.05228 6.5 2.5 6.5C1.94772 6.5 1.5 6.05228 1.5 5.5ZM6.5 5.5C6.5 4.94772 6.94772 4.5 7.5 4.5C8.05228 4.5 8.5 4.94772 8.5 5.5C8.5 6.05228 8.05228 6.5 7.5 6.5C6.94772 6.5 6.5 6.05228 6.5 5.5ZM11.5 5.5C11.5 4.94772 11.9477 4.5 12.5 4.5C13.0523 4.5 13.5 4.94772 13.5 5.5C13.5 6.05228 13.0523 6.5 12.5 6.5C11.9477 6.5 11.5 6.05228 11.5 5.5ZM1.5 9.5C1.5 8.94772 1.94772 8.5 2.5 8.5C3.05228 8.5 3.5 8.94772 3.5 9.5C3.5 10.0523 3.05228 10.5 2.5 10.5C1.94772 10.5 1.5 10.0523 1.5 9.5ZM6.5 9.5C6.5 8.94772 6.94772 8.5 7.5 8.5C8.05228 8.5 8.5 8.94772 8.5 9.5C8.5 10.0523 8.05228 10.5 7.5 10.5C6.94772 10.5 6.5 10.0523 6.5 9.5ZM11.5 9.5C11.5 8.94772 11.9477 8.5 12.5 8.5C13.0523 8.5 13.5 8.94772 13.5 9.5C13.5 10.0523 13.0523 10.5 12.5 10.5C11.9477 10.5 11.5 10.0523 11.5 9.5Z"
                        fill="#d1d2d1"></path>
                </g>
            </svg>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-12">
                    <label class="form-label text-black">Judul</label>
                    <input class="form-control" name="judul" placeholder="Isi Judul" id="judul[${indexPage}][${indexCard}]">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex float-end">
                        <a class="mx-1 delete_card" type="button" id="delete_card[${indexPage}][${indexCard}]">
                            <svg width="21" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826"
                                    stroke="#009A4B" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path d="M20.708 6.23975H3.75" stroke="#009A4B" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                <path
                                    d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973"
                                    stroke="#009A4B" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </svg>
                        </a>
                        <a class="mx-2 duplicate_card" type="button" id="duplicate_card[${indexPage}][${indexCard}]">
                            <svg width="20px" height="20px" viewBox="0 0 32 32" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#009A4B"
                                stroke="#009A4B">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <title>duplicate</title>
                                    <desc>Created with Sketch Beta.</desc>
                                    <defs> </defs>
                                    <g id="Page-1" stroke="none" stroke-width="1" fill="none"
                                        fill-rule="evenodd" sketch:type="MSPage">
                                        <g id="Icon-Set" sketch:type="MSLayerGroup"
                                            transform="translate(-204.000000, -931.000000)" fill="#009A4B">
                                            <path
                                                d="M234,951 C234,952.104 233.104,953 232,953 L216,953 C214.896,953 214,952.104 214,951 L214,935 C214,933.896 214.896,933 216,933 L232,933 C233.104,933 234,933.896 234,935 L234,951 L234,951 Z M232,931 L216,931 C213.791,931 212,932.791 212,935 L212,951 C212,953.209 213.791,955 216,955 L232,955 C234.209,955 236,953.209 236,951 L236,935 C236,932.791 234.209,931 232,931 L232,931 Z M226,959 C226,960.104 225.104,961 224,961 L208,961 C206.896,961 206,960.104 206,959 L206,943 C206,941.896 206.896,941 208,941 L210,941 L210,939 L208,939 C205.791,939 204,940.791 204,943 L204,959 C204,961.209 205.791,963 208,963 L224,963 C226.209,963 228,961.209 228,959 L228,957 L226,957 L226,959 L226,959 Z"
                                                id="duplicate" sketch:type="MSShapeGroup"> </path>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </a>
                        <div class="dropup mx-2 more_dropdown[${indexPage}][${indexCard}]">
                            <a class="px-2" type="button" id="dropdownMenu[${indexPage}][${indexCard}]" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <span class="fa-solid fa-ellipsis-vertical" style="color: #009a4b;"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a class="dropdown-item add_heading" id="add_heading[${indexPage}][${indexCard}]" type="button"><svg
                                            fill="#009a4b" width="20px" height="20px" viewBox="0 0 24.00 24.00"
                                            xmlns="http://www.w3.org/2000/svg" stroke="#009a4b"
                                            stroke-width="0.00024000000000000003">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path
                                                    d="M17,11 L17,6 L15.5,6 C15.2238576,6 15,5.77614237 15,5.5 C15,5.22385763 15.2238576,5 15.5,5 L19.5,5 C19.7761424,5 20,5.22385763 20,5.5 C20,5.77614237 19.7761424,6 19.5,6 L18,6 L18,18 L19.5,18 C19.7761424,18 20,18.2238576 20,18.5 C20,18.7761424 19.7761424,19 19.5,19 L15.5,19 C15.2238576,19 15,18.7761424 15,18.5 C15,18.2238576 15.2238576,18 15.5,18 L17,18 L17,12 L7,12 L7,18 L8.5,18 C8.77614237,18 9,18.2238576 9,18.5 C9,18.7761424 8.77614237,19 8.5,19 L4.5,19 C4.22385763,19 4,18.7761424 4,18.5 C4,18.2238576 4.22385763,18 4.5,18 L6,18 L6,6 L4.5,6 C4.22385763,6 4,5.77614237 4,5.5 C4,5.22385763 4.22385763,5 4.5,5 L8.5,5 C8.77614237,5 9,5.22385763 9,5.5 C9,5.77614237 8.77614237,6 8.5,6 L7,6 L7,11 L17,11 Z">
                                                </path>
                                            </g>
                                        </svg> Tambah Judul</a></li>
                                <li><a class="dropdown-item add_pertanyaan" id="add_pertanyaan[${indexPage}][${indexCard}]"
                                        type="button"><svg width="18px" height="18px" viewBox="0 0 24 24"
                                            fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000"
                                            stroke-width="0.00024000000000000003">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M12 2.75C6.89137 2.75 2.75 6.89137 2.75 12C2.75 17.1086 6.89137 21.25 12 21.25C17.1086 21.25 21.25 17.1086 21.25 12C21.25 6.89137 17.1086 2.75 12 2.75ZM1.25 12C1.25 6.06294 6.06294 1.25 12 1.25C17.9371 1.25 22.75 6.06294 22.75 12C22.75 17.9371 17.9371 22.75 12 22.75C6.06294 22.75 1.25 17.9371 1.25 12ZM12 7.75C11.3787 7.75 10.875 8.25368 10.875 8.875C10.875 9.28921 10.5392 9.625 10.125 9.625C9.71079 9.625 9.375 9.28921 9.375 8.875C9.375 7.42525 10.5503 6.25 12 6.25C13.4497 6.25 14.625 7.42525 14.625 8.875C14.625 9.83834 14.1056 10.6796 13.3353 11.1354C13.1385 11.2518 12.9761 11.3789 12.8703 11.5036C12.7675 11.6246 12.75 11.7036 12.75 11.75V13C12.75 13.4142 12.4142 13.75 12 13.75C11.5858 13.75 11.25 13.4142 11.25 13V11.75C11.25 11.2441 11.4715 10.8336 11.7266 10.533C11.9786 10.236 12.2929 10.0092 12.5715 9.84439C12.9044 9.64739 13.125 9.28655 13.125 8.875C13.125 8.25368 12.6213 7.75 12 7.75ZM12 17C12.5523 17 13 16.5523 13 16C13 15.4477 12.5523 15 12 15C11.4477 15 11 15.4477 11 16C11 16.5523 11.4477 17 12 17Z"
                                                    fill="#009A4B"></path>
                                            </g>
                                        </svg> Tambah Pertanyaan</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    `
    }

    function generateCard(indexPage, indexCard) {
        return `

    <div class="card card-soal" data-aos="fade-down" data-page="${indexPage}" data-aos-delay="500" data-id="${indexCard}" id="card-soal[${indexPage}][${indexCard}]">
        <div class="d-flex justify-content-center align-items-center drag-icon" id="drag-icon[${indexPage}][${indexCard}]">
            <svg width="25px" height="20px" viewBox="0 0 15 15" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M1.5 5.5C1.5 4.94772 1.94772 4.5 2.5 4.5C3.05228 4.5 3.5 4.94772 3.5 5.5C3.5 6.05228 3.05228 6.5 2.5 6.5C1.94772 6.5 1.5 6.05228 1.5 5.5ZM6.5 5.5C6.5 4.94772 6.94772 4.5 7.5 4.5C8.05228 4.5 8.5 4.94772 8.5 5.5C8.5 6.05228 8.05228 6.5 7.5 6.5C6.94772 6.5 6.5 6.05228 6.5 5.5ZM11.5 5.5C11.5 4.94772 11.9477 4.5 12.5 4.5C13.0523 4.5 13.5 4.94772 13.5 5.5C13.5 6.05228 13.0523 6.5 12.5 6.5C11.9477 6.5 11.5 6.05228 11.5 5.5ZM1.5 9.5C1.5 8.94772 1.94772 8.5 2.5 8.5C3.05228 8.5 3.5 8.94772 3.5 9.5C3.5 10.0523 3.05228 10.5 2.5 10.5C1.94772 10.5 1.5 10.0523 1.5 9.5ZM6.5 9.5C6.5 8.94772 6.94772 8.5 7.5 8.5C8.05228 8.5 8.5 8.94772 8.5 9.5C8.5 10.0523 8.05228 10.5 7.5 10.5C6.94772 10.5 6.5 10.0523 6.5 9.5ZM11.5 9.5C11.5 8.94772 11.9477 8.5 12.5 8.5C13.0523 8.5 13.5 8.94772 13.5 9.5C13.5 10.0523 13.0523 10.5 12.5 10.5C11.9477 10.5 11.5 10.0523 11.5 9.5Z"
                        fill="#d1d2d1"></path>
                </g>
            </svg>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="form-group col-sm-10">
                    <label class="form-label text-black">Pertanyaan <span class="text-danger">*</span></label>
                    <textarea class="form-control pertanyaan-textarea" name="pertanyaan" placeholder="Isi Pertanyaan"
                        id="pertanyaan[${indexPage}][${indexCard}]"></textarea>
                </div>

                <div class="col-sm-2 col-lg-2">
                    <div class="form-group">
                        <label class="form-label text-black">Kode Pertanyaan <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Kode">
                    </div>

                    <div class="selectTypeJawaban_div" id="selectTypeJawaban_div[${indexPage}][${indexCard}]">
                        <label class="form-label text-black">Tipe Pertanyaan<span class="text-danger">*</span></label>
                        <select class="form-select type-jawaban-select" aria-label="Actions"
                            id="selectTypeJawaban[${indexPage}][${indexCard}]">
                            <option value="shortanswer_type" class="shortanswer" id="shortanswer_type[${indexPage}][${indexCard}]"
                                data-input="shortanswer_input[${indexPage}][${indexCard}]"
                                data-validation="shortanswer_validation_div[${indexPage}][${indexCard}]"
                                data-image='<svg width="18px" height="18px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M3 10H21M3 14H12" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>'>
                                Jawaban Singkat
                            </option>
                            <option value="paragraph_type" class="paragraph" id="paragraph_type[${indexPage}][${indexCard}]"
                                data-input="paragraph_input[${indexPage}][${indexCard}]"
                                data-image='<svg width="15px" height="15px" viewBox="0 0 24 28" version="1.1" xmlns="http://www.w3.org/2000/svg" 
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
                            <option value="singlechoice_type" class="singlechoice" id="singlechoice_type[${indexPage}][${indexCard}]"
                                data-input="singlechoice_div[${indexPage}][${indexCard}]"
                                data-input="paragraph_input"data-image='<svg xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none">                                <circle cx="12" cy="12" r="7.5" stroke="currentColor"></circle>                            </svg>                        '>
                                Pilihan Ganda (Radio Button)
                            </option>
                            <option value="checkbox_type" class="checkbox" id="checkbox_type[${indexPage}][${indexCard}]"
                                data-input="checkbox_div[${indexPage}][${indexCard}]"
                                data-image='<svg width="18px" height="18px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4.56499 12.4068C4.29258 12.0947 3.81879 12.0626 3.50676 12.335C3.19472 12.6074 3.1626 13.0812 3.43501 13.3932L4.56499 12.4068ZM7.14286 16.5L6.57787 16.9932C6.7203 17.1564 6.92629 17.25 7.14286 17.25C7.35942 17.25 7.56542 17.1564 7.70784 16.9932L7.14286 16.5ZM15.565 7.99324C15.8374 7.68121 15.8053 7.20742 15.4932 6.93501C15.1812 6.6626 14.7074 6.69472 14.435 7.00676L15.565 7.99324ZM10.5064 11.5068C10.234 11.8188 10.2662 12.2926 10.5782 12.565C10.8902 12.8374 11.364 12.8053 11.6364 12.4932L10.5064 11.5068ZM9.67213 14.7432C9.94454 14.4312 9.91242 13.9574 9.60039 13.685C9.28835 13.4126 8.81457 13.4447 8.54215 13.7568L9.67213 14.7432ZM3.43501 13.3932L6.57787 16.9932L7.70784 16.0068L4.56499 12.4068L3.43501 13.3932ZM7.70784 16.9932L9.67213 14.7432L8.54215 13.7568L6.57787 16.0068L7.70784 16.9932ZM11.6364 12.4932L13.6007 10.2432L12.4707 9.25676L10.5064 11.5068L11.6364 12.4932ZM13.6007 10.2432L15.565 7.99324L14.435 7.00676L12.4707 9.25676L13.6007 10.2432Z" fill="#000000"></path> <path d="M20.0002 7.5625L15.7144 12.0625M11.0002 16L11.4286 16.5625L13.5715 14.3125" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>'>
                                Kotak Centang (Checkbox)
                            </option>
                            <option value="dropdown_type" class="checkbox" id="dropdown_type[${indexPage}][${indexCard}]"
                                data-input="dropdown_div[${indexPage}][${indexCard}]"
                                data-image='<svg width="18px" height="18px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M8 6.00067L21 6.00139M8 12.0007L21 12.0015M8 18.0007L21 18.0015M3.5 6H3.51M3.5 12H3.51M3.5 18H3.51M4 6C4 6.27614 3.77614 6.5 3.5 6.5C3.22386 6.5 3 6.27614 3 6C3 5.72386 3.22386 5.5 3.5 5.5C3.77614 5.5 4 5.72386 4 6ZM4 12C4 12.2761 3.77614 12.5 3.5 12.5C3.22386 12.5 3 12.2761 3 12C3 11.7239 3.22386 11.5 3.5 11.5C3.77614 11.5 4 11.7239 4 12ZM4 18C4 18.2761 3.77614 18.5 3.5 18.5C3.22386 18.5 3 18.2761 3 18C3 17.7239 3.22386 17.5 3.5 17.5C3.77614 17.5 4 17.7239 4 18Z" stroke="#000000" stroke-width="1.224" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>'>
                                List Pilihan (Dropdown)
                            </option>
                            <option value="gridcolumn_type" class="gridcolumn" id="gridcolumn_type[${indexPage}][${indexCard}]"
                                data-input="gridcolumn_div[${indexPage}][${indexCard}]"
                                data-image='<svg width="18px" height="18px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M6.75 3C3.88235 3 3 3.88235 3 6.75C3 9.61765 3.88235 10.5 6.75 10.5C9.61765 10.5 10.5 9.61765 10.5 6.75C10.5 3.88235 9.61765 3 6.75 3Z" stroke="#000000" stroke-width="1.152" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M6.75 13.5C3.88235 13.5 3 14.3824 3 17.25C3 20.1176 3.88235 21 6.75 21C9.61765 21 10.5 20.1176 10.5 17.25C10.5 14.3824 9.61765 13.5 6.75 13.5Z" stroke="#000000" stroke-width="1.152" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M17.25 13.5C14.3824 13.5 13.5 14.3824 13.5 17.25C13.5 20.1176 14.3824 21 17.25 21C20.1176 21 21 20.1176 21 17.25C21 14.3824 20.1176 13.5 17.25 13.5Z" stroke="#000000" stroke-width="1.152" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M17.25 3C14.3824 3 13.5 3.88235 13.5 6.75C13.5 9.61765 14.3824 10.5 17.25 10.5C20.1176 10.5 21 9.61765 21 6.75C21 3.88235 20.1176 3 17.25 3Z" stroke="#000000" stroke-width="1.152" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>'>
                                Petak Pilihan Ganda
                            </option>
                            <option value="zona" class="skala" id="zona[${indexPage}][${indexCard}]" data-input="zona_div[${indexPage}][${indexCard}]"
                                data-image='<svg width="18px" height="18px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12.5 7.04148C12.3374 7.0142 12.1704 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13C13.6569 13 15 11.6569 15 10C15 9.82964 14.9858 9.6626 14.9585 9.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"></path> <path d="M5 15.2161C4.35254 13.5622 4 11.8013 4 10.1433C4 5.64588 7.58172 2 12 2C16.4183 2 20 5.64588 20 10.1433C20 14.6055 17.4467 19.8124 13.4629 21.6744C12.5343 22.1085 11.4657 22.1085 10.5371 21.6744C9.26474 21.0797 8.13831 20.1439 7.19438 19" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"></path> </g></svg>'>
                                Zona
                            </option>
                            <option value="date_type" class="date" id="date_type[${indexPage}][${indexCard}]"
                                data-input="date_input[${indexPage}][${indexCard}]"
                                data-image='<svg width="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path d="M3.09277 9.40421H20.9167" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M16.442 13.3097H16.4512" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M12.0045 13.3097H12.0137" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M7.55818 13.3097H7.56744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M16.442 17.1962H16.4512" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M12.0045 17.1962H12.0137" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M7.55818 17.1962H7.56744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M16.0433 2V5.29078" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M7.96515 2V5.29078" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.2383 3.5791H7.77096C4.83427 3.5791 3 5.21504 3 8.22213V17.2718C3 20.3261 4.83427 21.9999 7.77096 21.9999H16.229C19.175 21.9999 21 20.3545 21 17.3474V8.22213C21.0092 5.21504 19.1842 3.5791 16.2383 3.5791Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                            </svg>                        '>
                                Tanggal
                            </option>
                            <option value="time_type" class="time" id="time_type[${indexPage}][${indexCard}]"
                                data-input="time_input[${indexPage}][${indexCard}]"
                                data-image='<svg width="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path fill-rule="evenodd" clip-rule="evenodd" d="M21.25 12.0005C21.25 17.1095 17.109 21.2505 12 21.2505C6.891 21.2505 2.75 17.1095 2.75 12.0005C2.75 6.89149 6.891 2.75049 12 2.75049C17.109 2.75049 21.25 6.89149 21.25 12.0005Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M15.4316 14.9429L11.6616 12.6939V7.84692" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                            </svg>                        '>
                                Waktu
                            </option>
                            <option value="datetime_type" class="datetime" id="datetime_type[${indexPage}][${indexCard}]"
                                data-input="datetime_input[${indexPage}][${indexCard}]"
                                data-image='<svg width="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path d="M3.09277 9.40421H20.9167" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M16.442 13.3097H16.4512" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M12.0045 13.3097H12.0137" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M7.55818 13.3097H7.56744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M16.442 17.1962H16.4512" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M12.0045 17.1962H12.0137" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M7.55818 17.1962H7.56744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M16.0433 2V5.29078" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path d="M7.96515 2V5.29078" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.2383 3.5791H7.77096C4.83427 3.5791 3 5.21504 3 8.22213V17.2718C3 20.3261 4.83427 21.9999 7.77096 21.9999H16.229C19.175 21.9999 21 20.3545 21 17.3474V8.22213C21.0092 5.21504 19.1842 3.5791 16.2383 3.5791Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                            </svg>                        '>
                                Tanggal dan Waktu
                            </option>

                        </select>
                        <div class="form-group inputtype shortanswer-validation-div"
                            id="shortanswer_validation_div[${indexPage}][${indexCard}]">
                            <div class="form-group mt-4" id="shortanswer_input_type_div[${indexPage}][${indexCard}]">
                                <p class="mt-2"> Silahkan isi validasi disini <span class="text-danger">*</span>
                                </p>
                                <label class="form-label text-black">Tipe Validasi</label>
                                <select class="form-select type-validation-select"
                                    id="shortanswer-type-validation[${indexPage}][${indexCard}]">
                                    <option value="none">Tidak Ada</option>
                                    <option value="email">Email</option>
                                    <option value="phone">Nomor Handphone</option>
                                    <option value="url">URL</option>
                                    <option value="number">Angka Saja</option>
                                    <option value="letters">Huruf Saja</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-6 form-group" id="shortanswer-input-max-div[${indexPage}][${indexCard}]">
                                    <label class="form-label  text-black">Max Karakter</label>
                                    <input type="number" class="form-control" placeholder="256"
                                        id="shortanswer-input-max[${indexPage}][${indexCard}]">
                                </div>
                                <div class="col-6 form-group" id="shortanswer-input-min-div[${indexPage}][${indexCard}]">
                                    <label class="form-label  text-black">Min Karakter</label>
                                    <input type="number" class="form-control" placeholder="-"
                                        id="shortanswer-input-min[${indexPage}][${indexCard}]">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-10">
                    <label class="form-label text-black">Jawaban</label>

                    <div class="form-group inputtype" id="shortanswer_input[${indexPage}][${indexCard}]" data-card="${indexCard}">
                        <input type="text" class="form-control" placeholder="Teks jawaban singkat" readonly>
                    </div>

                    <div class="form-group inputtype" id="paragraph_input[${indexPage}][${indexCard}]">
                        <textarea class="form-control" readonly placeholder="Paragraf"></textarea>
                    </div>

                    <div class="form-group inputtype radio-option-div" id="singlechoice_div[${indexPage}][${indexCard}]">
                        <p> Silahkan isi opsi pilihan ganda dibawah ini <span class="text-danger">*</span> </p>
                        <div class="radio-option singlechoice_option_div" id="singlechoice_option_div[${indexPage}][${indexCard}][0]">
                            <div class="d-flex align-items-center">
                                <div class="px-2">
                                    <input class="form-check-input" type="radio">
                                </div>
                                <div class="row no-gutters">
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Kode">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Pilihan">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Nilai">
                                    </div>
                                    <div class="col d-flex align-items-center">
                                                <div class="form-check">
                                                    <input class="form-check-input singlechoice-addition " type="checkbox"
                                                        id="singlechoice-addition[${indexPage}][${indexCard}][0]">
                                                    <label class="form-check-label" for="singlechoice-addition">
                                                        Text Tambahan
                                                    </label>
                                                </div>
                                            </div>
                                    <div class="col">
                                        <input class="form-control singlechoice-addition-text" type="text"
                                        id="singlechoice-addition-text[${indexPage}][${indexCard}][0]" placeholder="Kode Text Tambahan">
                                    </div>
                                  
                                    <div class="col d-flex align-items-center">
                                        <div class="align-items-center">
                                            <a class="btn btn-secondary btn-sm mx-1 collapsed" data-bs-toggle="collapse" href="#collapse[${indexPage}][${indexCard}][0]" role="button" aria-expanded="false" aria-controls="collapseExample">
                                             Lainnya
                                            </a>
                                        </div>
                                        <a class="btn btn-danger btn-sm mx-1 delete-radio-option" id="delete-radio-option[${indexPage}][${indexCard}][0]" type="button">
                                            Hapus
                                        </a>
                                        <a class="btn btn-success btn-sm add-radio-option" id="add-radio-option[${indexPage}][${indexCard}][0]" type="button">
                                            Tambah
                                        </a>
                                    </div>
                                  
                                </div>
                               
                            </div>
                            <div class="row mt-2 mb-2">
                                <div class="col">
                                    <div class="collapse" id="collapse[${indexPage}][${indexCard}][0]">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="input-group" style="padding-left:30px;" >
                                                    <div class="input-group-text text-black">Tampilkan Pertanyaan &nbsp; &nbsp;&nbsp;&nbsp;</div>
                                                    <select class="form-select singlechoice-influence-show" id="singlechoice-influence-show[${indexPage}][${indexCard}][0]" data-placeholder="Tampilkan Pertanyaan" multiple="multiple">
                                                       
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <div class="input-group" style="padding-left:30px;">
                                                    <div class="input-group-text text-black">Sembunyikan Pertanyaan</div>
                                                    <select class="form-select singlechoice-influence-hide" id="singlechoice-influence-hide[${indexPage}][${indexCard}][0]" data-placeholder="Sembunyikan Pertanyaan" multiple="multiple">
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="form-group inputtype checkbox-option-div" id="checkbox_div[${indexPage}][${indexCard}]">
                        <p> Silahkan isi opsi pilihan kotak centang (checkbox) dibawah ini <span
                                class="text-danger">*</span> </p>
                        <div class="checkbox-option mutiple_option_div" id="mutiple_option_div[${indexPage}][${indexCard}][0]">
                            <div class="d-flex align-items-center">
                                <div class="px-2">
                                <input class="form-check-input" type="checkbox">
                            </div>
                                <div class="row no-gutters">
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Kode">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Pilihan">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Nilai">
                                    </div>
                                    <div class="col d-flex align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input mutiplechoice-addition " type="checkbox"
                                                id="mutiplechoice-addition[${indexPage}][${indexCard}][0]">
                                            <label class="form-check-label" for="mutiplechoice-addition">
                                                Text Tambahan
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                            <input class="form-control mutiplechoice-addition-text" type="text"
                                                id="mutiplechoice-addition-text[${indexPage}][${indexCard}][0]" placeholder="Kode Text Tambahan">
                                        </div>
                                    <div class="col d-flex align-items-center">
                                        <a class="btn btn-danger btn-sm  mx-1 delete-checkbox-option" id="delete-checkbox-option[${indexPage}][${indexCard}][0]"  type="button">
                                            Hapus
                                        </a>
                                        <a class="btn btn-success btn-sm add-checkbox-option" id="add-checkbox-option[${indexPage}][${indexCard}][0]" type="button">
                                            Tambah
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group inputtype" id="zona_div[${indexPage}][${indexCard}]">
                        <p>Silahkan isi inputan zona dibawah ini <span class="text-danger">*</span> </p>
                        <div class="row ">
                            <div class="col-lg-4">
                                <input type="text" class="form-control" placeholder="Kode Provinsi" id="zona_prov_code[${indexPage}][${indexCard}]">
                            </div>
                            <div class="col-lg-4">
                                <select class="form-select" aria-label="Actions">
                                    <option value="Provinsi">Provinsi</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2 ">
                            <div class="col-lg-4">
                                <input type="text" class="form-control" placeholder="Kode Kota/Kabupaten" id="zona_kab_code[${indexPage}][${indexCard}]">
                            </div>
                            <div class="col-lg-4">
                                <select class="form-select" aria-label="Actions">
                                    <option value="Kabupaten">Kabupaten</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group inputtype" id="gridcolumn_div[${indexPage}][${indexCard}]">
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
                                <div class="col-lg-1 col-md-2 col-sm-2 py-3 text-center grid-number-container" id="grid-number-container[${indexPage}][${indexCard}]">
                                    <div class="row my-2 align-items-center grid-number-div" data-row-number="1" id="grid-number-div[${indexPage}][${indexCard}][0]">
                                        <p class="text-center grid-number"> 1 </p>
                                    </div>
                                    <div class="row my-2 align-items-center grid-number-div" id="grid-number-div[${indexPage}][${indexCard}][1] data-row-number="2">
                                        <p class="text-center grid-number"> 2 </p>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-5 col-sm-5 grid-row-container" id="grid-row-container[${indexPage}][${indexCard}]">
                                    <div class="row my-2 grid-row" id="grid-row[${indexPage}][${indexCard}][0]">
                                        <div class="col-lg-12">
                                            <div class="input-group">
                                                <input type="text" class="form-control grid-row-input" id="grid-row-input[${indexPage}][${indexCard}][0]"
                                                    placeholder="Label Baris 1">
                                                <input type="text" class="form-control grid-row-input-value" id="grid-row-input-value[${indexPage}][${indexCard}][0]"
                                                    placeholder="Nilai Baris 1">
                                                <span class="input-group-text">
                                                    <svg width="24px" height="24px" viewBox="0 -0.5 25 25"
                                                        fill="none" </svg>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row my-2 grid-row"  id="grid-row[${indexPage}][${indexCard}][1]">
                                        <div class="col-lg-12">
                                            <div class="input-group">
                                                <input type="text" class="form-control grid-row-input" id="grid-row-input[${indexPage}][${indexCard}][1]"
                                                    placeholder="Label Baris 2">
                                                <input type="text" class="form-control grid-row-input-value"  id="grid-row-input-value[${indexPage}][${indexCard}][1]"
                                                    placeholder="Nilai Baris 2">
                                                <span class="input-group-text grid-delete-row" id="grid-delete-row[${indexPage}][${indexCard}][1]" >
                                                    <svg width="24px" height="24px" viewBox="0 -0.5 25 25"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                            stroke-linejoin="round"></g>
                                                        <g id="SVGRepo_iconCarrier">
                                                            <path
                                                                d="M6.96967 16.4697C6.67678 16.7626 6.67678 17.2374 6.96967 17.5303C7.26256 17.8232 7.73744 17.8232 8.03033 17.5303L6.96967 16.4697ZM13.0303 12.5303C13.3232 12.2374 13.3232 11.7626 13.0303 11.4697C12.7374 11.1768 12.2626 11.1768 11.9697 11.4697L13.0303 12.5303ZM11.9697 11.4697C11.6768 11.7626 11.6768 12.2374 11.9697 12.5303C12.2626 12.8232 12.7374 12.8232 13.0303 12.5303L11.9697 11.4697ZM18.0303 7.53033C18.3232 7.23744 18.3232 6.76256 18.0303 6.46967C17.7374 6.17678 17.2626 6.17678 16.9697 6.46967L18.0303 7.53033ZM13.0303 11.4697C12.7374 11.1768 12.2626 11.1768 11.9697 11.4697C11.6768 11.7626 11.6768 12.2374 11.9697 12.5303L13.0303 11.4697ZM16.9697 17.5303C17.2626 17.8232 17.7374 17.8232 18.0303 17.5303C18.3232 17.2374 18.3232 16.7626 18.0303 16.4697L16.9697 17.5303ZM11.9697 12.5303C12.2626 12.8232 12.7374 12.8232 13.0303 12.5303C13.3232 12.2374 13.3232 11.7626 13.0303 11.4697L11.9697 12.5303ZM8.03033 6.46967C7.73744 6.17678 7.26256 6.17678 6.96967 6.46967C6.67678 6.76256 6.67678 7.23744 6.96967 7.53033L8.03033 6.46967ZM8.03033 17.5303L13.0303 12.5303L11.9697 11.4697L6.96967 16.4697L8.03033 17.5303ZM13.0303 12.5303L18.0303 7.53033L16.9697 6.46967L11.9697 11.4697L13.0303 12.5303ZM11.9697 12.5303L16.9697 17.5303L18.0303 16.4697L13.0303 11.4697L11.9697 12.5303ZM13.0303 11.4697L8.03033 6.46967L6.96967 7.53033L11.9697 12.5303L13.0303 11.4697Z"
                                                                fill="#000000"></path>
                                                        </g>
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-5 col-sm-5 grid-column-container" id="grid-column-container[${indexPage}][${indexCard}]">
                                    <div class="row my-2 grid-column"  id="grid-column[${indexPage}][${indexCard}][0]">
                                        <div class="col-lg-12">
                                            <div class="input-group">
                                                <input type="text" class="form-control grid-column-input"  id="grid-column-input[${indexPage}][${indexCard}][0]"
                                                    placeholder="Label Kolom 1">
                                                <input type="text" class="form-control grid-column-input-value" id="grid-column-input-value[${indexPage}][${indexCard}][0]"
                                                    placeholder="Nilai Kolom 1">
                                                <span class="input-group-text">
                                                    <svg width="24px" height="24px" viewBox="0 -0.5 25 25"
                                                        fill="none" </svg>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row my-2 grid-column"  id="grid-column[${indexPage}][${indexCard}][1]">
                                        <div class="col-lg-12">
                                            <div class="input-group ">
                                                <input type="text" class="form-control grid-column-input"  id="grid-column-input[${indexPage}][${indexCard}][1]"
                                                    placeholder="Label Kolom 2">
                                                <input type="text" class="form-control grid-column-input-value"  id="grid-column-input-value[${indexPage}][${indexCard}][1]"
                                                    placeholder="Nilai Kolom 2">
                                                <span class="input-group-text grid-delete-column" id="grid-delete-column[${indexPage}][${indexCard}][1]">
                                                    <svg width="24px" height="24px" viewBox="0 -0.5 25 25"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                            stroke-linejoin="round"></g>
                                                        <g id="SVGRepo_iconCarrier">
                                                            <path
                                                                d="M6.96967 16.4697C6.67678 16.7626 6.67678 17.2374 6.96967 17.5303C7.26256 17.8232 7.73744 17.8232 8.03033 17.5303L6.96967 16.4697ZM13.0303 12.5303C13.3232 12.2374 13.3232 11.7626 13.0303 11.4697C12.7374 11.1768 12.2626 11.1768 11.9697 11.4697L13.0303 12.5303ZM11.9697 11.4697C11.6768 11.7626 11.6768 12.2374 11.9697 12.5303C12.2626 12.8232 12.7374 12.8232 13.0303 12.5303L11.9697 11.4697ZM18.0303 7.53033C18.3232 7.23744 18.3232 6.76256 18.0303 6.46967C17.7374 6.17678 17.2626 6.17678 16.9697 6.46967L18.0303 7.53033ZM13.0303 11.4697C12.7374 11.1768 12.2626 11.1768 11.9697 11.4697C11.6768 11.7626 11.6768 12.2374 11.9697 12.5303L13.0303 11.4697ZM16.9697 17.5303C17.2626 17.8232 17.7374 17.8232 18.0303 17.5303C18.3232 17.2374 18.3232 16.7626 18.0303 16.4697L16.9697 17.5303ZM11.9697 12.5303C12.2626 12.8232 12.7374 12.8232 13.0303 12.5303C13.3232 12.2374 13.3232 11.7626 13.0303 11.4697L11.9697 12.5303ZM8.03033 6.46967C7.73744 6.17678 7.26256 6.17678 6.96967 6.46967C6.67678 6.76256 6.67678 7.23744 6.96967 7.53033L8.03033 6.46967ZM8.03033 17.5303L13.0303 12.5303L11.9697 11.4697L6.96967 16.4697L8.03033 17.5303ZM13.0303 12.5303L18.0303 7.53033L16.9697 6.46967L11.9697 11.4697L13.0303 12.5303ZM11.9697 12.5303L16.9697 17.5303L18.0303 16.4697L13.0303 11.4697L11.9697 12.5303ZM13.0303 11.4697L8.03033 6.46967L6.96967 7.53033L11.9697 12.5303L13.0303 11.4697Z"
                                                                fill="#000000"></path>
                                                        </g>
                                                    </svg>
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
                                    <a class="btn btn-primary btn-sm grid-add-row-button" type="button" id="grid-add-row-button[${indexPage}][${indexCard}]">
                                        <i class="btn-inner">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </i>
                                        <span>Tambah Baris</span>
                                    </a>
                                </div>
                                <div class="col-lg-5 col-md-5 col-sm-5 py-2">
                                    <a class="btn btn-primary btn-sm grid-add-column-button" type="button" id="grid-add-column-button[${indexPage}][${indexCard}]">
                                        <i class="btn-inner">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </i>
                                        <span>Tambah Kolom</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group inputtype" id="dropdown_div[${indexPage}][${indexCard}]">
                        <p> Silahkan pilih data pedia yang akan ditampilkan dibawah ini <span
                                class="text-danger">*</span> </p>
                        <select class="form-select">
                            <option value="">Pilih Data</option>
                            @foreach ($datapediaOptions as $datapediaOption)
                                <option value="{{ $datapediaOption->id }}">{{ $datapediaOption->nama_data }}</option>
                            @endforeach
                        </select>
                        <p class="input-information ml-1">Untuk melihat data pedia klik <a
                                href="{{ route('datapedia.index') }}">disini</a></p>
                    </div>
                    <div class="form-group inputtype" id="date_input[${indexPage}][${indexCard}]">
                        <input type="date" class="form-control">
                    </div>
                    <div class="form-group inputtype" id="time_input[${indexPage}][${indexCard}]">
                        <input type="time" class="form-control">
                    </div>
                    <div class="form-group inputtype" id="datetime_input[${indexPage}][${indexCard}]">
                        <input type="datetime-local" class="form-control">
                    </div>

                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex float-end">
                        <a class="mx-1 delete_card" type="button" id="delete_card[${indexPage}][${indexCard}]">
                            <svg width="21" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826"
                                    stroke="#009A4B" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path d="M20.708 6.23975H3.75" stroke="#009A4B" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                <path
                                    d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973"
                                    stroke="#009A4B" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </svg>
                        </a>
                        <a class="mx-2 duplicate_card" type="button" id="duplicate_card[${indexPage}][${indexCard}]">
                            <svg width="20px" height="20px" viewBox="0 0 32 32" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#009A4B"
                                stroke="#009A4B">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <title>duplicate</title>
                                    <desc>Created with Sketch Beta.</desc>
                                    <defs> </defs>
                                    <g id="Page-1" stroke="none" stroke-width="1" fill="none"
                                        fill-rule="evenodd" sketch:type="MSPage">
                                        <g id="Icon-Set" sketch:type="MSLayerGroup"
                                            transform="translate(-204.000000, -931.000000)" fill="#009A4B">
                                            <path
                                                d="M234,951 C234,952.104 233.104,953 232,953 L216,953 C214.896,953 214,952.104 214,951 L214,935 C214,933.896 214.896,933 216,933 L232,933 C233.104,933 234,933.896 234,935 L234,951 L234,951 Z M232,931 L216,931 C213.791,931 212,932.791 212,935 L212,951 C212,953.209 213.791,955 216,955 L232,955 C234.209,955 236,953.209 236,951 L236,935 C236,932.791 234.209,931 232,931 L232,931 Z M226,959 C226,960.104 225.104,961 224,961 L208,961 C206.896,961 206,960.104 206,959 L206,943 C206,941.896 206.896,941 208,941 L210,941 L210,939 L208,939 C205.791,939 204,940.791 204,943 L204,959 C204,961.209 205.791,963 208,963 L224,963 C226.209,963 228,961.209 228,959 L228,957 L226,957 L226,959 L226,959 Z"
                                                id="duplicate" sketch:type="MSShapeGroup"> </path>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </a>
                        <hr class="hr-vertial">
                        <div class="form-check form-switch mx-2">
                            <input class="form-check-input" type="checkbox" id="wajibdiisi[${indexPage}][${indexCard}]">
                            <label class="form-check-label text-black">Wajib
                                Diisi</label>
                        </div>
                        <div class="dropup mx-2 more_dropdown">
                            <a class="px-2" type="button" id="dropdownMenu[${indexPage}][${indexCard}]" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <span class="fa-solid fa-ellipsis-vertical" style="color: #009a4b;"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a class="dropdown-item add_heading" id="add_heading[${indexPage}][${indexCard}]" type="button"><svg
                                            fill="#009a4b" width="20px" height="20px" viewBox="0 0 24.00 24.00"
                                            xmlns="http://www.w3.org/2000/svg" stroke="#009a4b"
                                            stroke-width="0.00024000000000000003">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path
                                                    d="M17,11 L17,6 L15.5,6 C15.2238576,6 15,5.77614237 15,5.5 C15,5.22385763 15.2238576,5 15.5,5 L19.5,5 C19.7761424,5 20,5.22385763 20,5.5 C20,5.77614237 19.7761424,6 19.5,6 L18,6 L18,18 L19.5,18 C19.7761424,18 20,18.2238576 20,18.5 C20,18.7761424 19.7761424,19 19.5,19 L15.5,19 C15.2238576,19 15,18.7761424 15,18.5 C15,18.2238576 15.2238576,18 15.5,18 L17,18 L17,12 L7,12 L7,18 L8.5,18 C8.77614237,18 9,18.2238576 9,18.5 C9,18.7761424 8.77614237,19 8.5,19 L4.5,19 C4.22385763,19 4,18.7761424 4,18.5 C4,18.2238576 4.22385763,18 4.5,18 L6,18 L6,6 L4.5,6 C4.22385763,6 4,5.77614237 4,5.5 C4,5.22385763 4.22385763,5 4.5,5 L8.5,5 C8.77614237,5 9,5.22385763 9,5.5 C9,5.77614237 8.77614237,6 8.5,6 L7,6 L7,11 L17,11 Z">
                                                </path>
                                            </g>
                                        </svg> Tambah Judul</a></li>
                                <li><a class="dropdown-item add_pertanyaan" id="add_pertanyaan[${indexPage}][${indexCard}]"
                                        type="button"><svg width="18px" height="18px" viewBox="0 0 24 24"
                                            fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000"
                                            stroke-width="0.00024000000000000003">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M12 2.75C6.89137 2.75 2.75 6.89137 2.75 12C2.75 17.1086 6.89137 21.25 12 21.25C17.1086 21.25 21.25 17.1086 21.25 12C21.25 6.89137 17.1086 2.75 12 2.75ZM1.25 12C1.25 6.06294 6.06294 1.25 12 1.25C17.9371 1.25 22.75 6.06294 22.75 12C22.75 17.9371 17.9371 22.75 12 22.75C6.06294 22.75 1.25 17.9371 1.25 12ZM12 7.75C11.3787 7.75 10.875 8.25368 10.875 8.875C10.875 9.28921 10.5392 9.625 10.125 9.625C9.71079 9.625 9.375 9.28921 9.375 8.875C9.375 7.42525 10.5503 6.25 12 6.25C13.4497 6.25 14.625 7.42525 14.625 8.875C14.625 9.83834 14.1056 10.6796 13.3353 11.1354C13.1385 11.2518 12.9761 11.3789 12.8703 11.5036C12.7675 11.6246 12.75 11.7036 12.75 11.75V13C12.75 13.4142 12.4142 13.75 12 13.75C11.5858 13.75 11.25 13.4142 11.25 13V11.75C11.25 11.2441 11.4715 10.8336 11.7266 10.533C11.9786 10.236 12.2929 10.0092 12.5715 9.84439C12.9044 9.64739 13.125 9.28655 13.125 8.875C13.125 8.25368 12.6213 7.75 12 7.75ZM12 17C12.5523 17 13 16.5523 13 16C13 15.4477 12.5523 15 12 15C11.4477 15 11 15.4477 11 16C11 16.5523 11.4477 17 12 17Z"
                                                    fill="#009A4B"></path>
                                            </g>
                                        </svg> Tambah Pertanyaan</a></li>
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
