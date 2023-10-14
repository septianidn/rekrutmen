<div class="radio-option singlechoice_option_div" id="singlechoice_option_div[${indexPage}][${indexCard}][${indexRadioOption}]">
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
                        Input Text Tambahan
                    </label>
                </div>
            </div>
            <div class="col-2">
                <input class="form-control singlechoice-addition-text" type="text"
                    id="singlechoice-addition-text[${indexPage}][${indexCard}][${indexRadioOption}]" placeholder="Kode Text Tambahan">
            </div>
            <div class="col d-flex align-items-center">
                <a class="btn btn-danger btn-sm mx-1  delete-radio-option" id="delete-radio-option[${indexPage}][${indexCard}][${indexRadioOption}]" type="button">
                    Hapus
                </a>
                <a class="btn btn-success btn-sm add-radio-option" id="add-radio-option[${indexPage}][${indexCard}][${indexRadioOption}]" type="button">
                    Tambah
                </a>
            </div>
        </div>
    </div>
</div>