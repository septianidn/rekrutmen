@if (isset($pertanyaan['pertanyaan_grid_option']) &&
        is_array($pertanyaan['pertanyaan_grid_option']) &&
        count($pertanyaan['pertanyaan_grid_option']) > 0)
    <div class="form-group inputtype" id="gridcolumn_div[{{ $key }}][{{ $keyP }}]">
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

            @foreach ($pertanyaan['pertanyaan_grid_option'] as $keyG => $pertanyaanGeneralOptionG)
                <div class="row">

                    <div class="col-lg-1 col-md-2 col-sm-2 py-3 text-center grid-number-container"
                        id="grid-number-container[{{ $key }}][{{ $keyP }}]">
                        <div class="row my-2 align-items-center grid-number-div" data-row-number="{{ $keyG + 1 }}"
                            id="grid-number-div[{{ $key }}][{{ $keyP }}][{{ $keyG }}]">
                            <p class="text-center grid-number">
                                1 </p>
                        </div>
                        {{-- <div class="row my-2 align-items-center grid-number-div"
                    id="grid-number-div[{{ $key }}][{{ $keyP }}][{{ $keyG }}] data-row-number="{{ $keyG + 1 }}">
                    <p
                        class="text-center grid-number">
                        2 </p>
                </div> --}}
                    </div>
                    @if ($pertanyaanGeneralOptionG['tipe_grid'] == 'row')
                        <div class="col-lg-5 col-md-5 col-sm-5 grid-row-container"
                            id="grid-row-container[{{ $key }}][{{ $keyP }}]">




                            <div class="row my-2 grid-row"
                                id="grid-row[{{ $key }}][{{ $keyP }}][{{ $keyG }}]">
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <input type="text" class="form-control grid-row-input-value"
                                            id="grid-row-input-value[{{ $key }}][{{ $keyP }}][1]"
                                            placeholder="Kode Baris 2" value="{{ $pertanyaanGeneralOptionG['value'] }}"
                                            name="data[{{ $key }}][pertanyaan][{{ $keyP }}][pertanyaan_grid_option][2][value]">

                                        <input type="text" class="form-control grid-row-input"
                                            id="grid-row-input[{{ $key }}][{{ $keyP }}][1]"
                                            placeholder="Pertanyaan Baris 2" value="K"
                                            name="data[{{ $key }}][pertanyaan][{{ $keyP }}][pertanyaan_grid_option][2][label]">
                                        <input type="hidden" value="row"
                                            name="data[{{ $key }}][pertanyaan][{{ $keyP }}][pertanyaan_grid_option][2][tipe_grid]">
                                        <input type="hidden" value="2"
                                            name="data[{{ $key }}][pertanyaan][{{ $keyP }}][pertanyaan_grid_option][2][urutan]">

                                        <span class="input-group-text grid-delete-row"
                                            id="grid-delete-row[{{ $key }}][{{ $keyP }}][1]">
                                            <svg width="24px" height="24px" viewBox="0 -0.5 25 25" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0">
                                                </g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                </g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <path
                                                        d="M6.96967 16.4697C6.67678 16.7626 6.67678 17.2374 6.96967 17.5303C7.26256 17.8232 7.73744 17.8232 8.03033 17.5303L6.96967 16.4697ZM13.0303 12.5303C13.3232 12.2374 13.3232 11.7626 13.0303 11.4697C12.7374 11.1768 12.2626 11.1768 11.9697 11.4697L13.0303 12.5303ZM11.9697 11.4697C11.6768 11.7626 11.6768 12.2374 11.9697 12.5303C12.2626 12.8232 12.7374 12.8232 13.0303 12.5303L11.9697 11.4697ZM18.0303 7.53033C18.3232 7.23744 18.3232 6.76256 18.0303 6.46967C17.7374 6.17678 17.2626 6.17678 16.9697 6.46967L18.0303 7.53033ZM13.0303 11.4697C12.7374 11.1768 12.2626 11.1768 11.9697 11.4697C11.6768 11.7626 11.6768 12.2374 11.9697 12.5303L13.0303 11.4697ZM16.9697 17.5303C17.2626 17.8232 17.7374 17.8232 18.0303 17.5303C18.3232 17.2374 18.3232 16.7626 18.0303 16.4697L16.9697 17.5303ZM11.9697 12.5303C12.2626 12.8232 12.7374 12.8232 13.0303 12.5303C13.3232 12.2374 13.3232 11.7626 13.0303 11.4697L11.9697 12.5303ZM8.03033 6.46967C7.73744 6.17678 7.26256 6.17678 6.96967 6.46967C6.67678 6.76256 6.67678 7.23744 6.96967 7.53033L8.03033 6.46967ZM8.03033 17.5303L13.0303 12.5303L11.9697 11.4697L6.96967 16.4697L8.03033 17.5303ZM13.0303 12.5303L18.0303 7.53033L16.9697 6.46967L11.9697 11.4697L13.0303 12.5303ZM11.9697 12.5303L16.9697 17.5303L18.0303 16.4697L13.0303 11.4697L11.9697 12.5303ZM13.0303 11.4697L8.03033 6.46967L6.96967 7.53033L11.9697 12.5303L13.0303 11.4697Z"
                                                        fill="#000000">
                                                    </path>
                                                </g>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endif
                    @if ($pertanyaanGeneralOptionG['tipe_grid'] == 'column')
                        <div class="col-lg-5 col-md-5 col-sm-5 grid-column-container"
                            id="grid-column-container[{{ $key }}][{{ $keyP }}]">

                            <div class="row my-2 grid-column"
                                id="grid-column[{{ $key }}][{{ $keyP }}][1]">
                                <div class="col-lg-12">
                                    <div class="input-group ">
                                        <input type="text" class="form-control grid-column-input"
                                            id="grid-column-input[{{ $key }}][{{ $keyP }}][1]"
                                            placeholder="Jawaban Kolom 2"
                                            name="data[{{ $key }}][pertanyaan][{{ $keyP }}][pertanyaan_grid_option][3][label]">
                                        <input type="text" class="form-control grid-column-input-value"
                                            id="grid-column-input-value[{{ $key }}][{{ $keyP }}][1]"
                                            placeholder="Nilai Kolom 2"
                                            name="data[{{ $key }}][pertanyaan][{{ $keyP }}][pertanyaan_grid_option][3][value]">
                                        <input type="hidden" value="column"
                                            name="data[{{ $key }}][pertanyaan][{{ $keyP }}][pertanyaan_grid_option][3][tipe_grid]">
                                        <input type="hidden" value="2"
                                            name="data[{{ $key }}][pertanyaan][{{ $keyP }}][pertanyaan_grid_option][3][urutan]">
                                        <span class="input-group-text grid-delete-column"
                                            id="grid-delete-column[{{ $key }}][{{ $keyP }}][1]">
                                            <svg width="24px" height="24px" viewBox="0 -0.5 25 25" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0">
                                                </g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                </g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <path
                                                        d="M6.96967 16.4697C6.67678 16.7626 6.67678 17.2374 6.96967 17.5303C7.26256 17.8232 7.73744 17.8232 8.03033 17.5303L6.96967 16.4697ZM13.0303 12.5303C13.3232 12.2374 13.3232 11.7626 13.0303 11.4697C12.7374 11.1768 12.2626 11.1768 11.9697 11.4697L13.0303 12.5303ZM11.9697 11.4697C11.6768 11.7626 11.6768 12.2374 11.9697 12.5303C12.2626 12.8232 12.7374 12.8232 13.0303 12.5303L11.9697 11.4697ZM18.0303 7.53033C18.3232 7.23744 18.3232 6.76256 18.0303 6.46967C17.7374 6.17678 17.2626 6.17678 16.9697 6.46967L18.0303 7.53033ZM13.0303 11.4697C12.7374 11.1768 12.2626 11.1768 11.9697 11.4697C11.6768 11.7626 11.6768 12.2374 11.9697 12.5303L13.0303 11.4697ZM16.9697 17.5303C17.2626 17.8232 17.7374 17.8232 18.0303 17.5303C18.3232 17.2374 18.3232 16.7626 18.0303 16.4697L16.9697 17.5303ZM11.9697 12.5303C12.2626 12.8232 12.7374 12.8232 13.0303 12.5303C13.3232 12.2374 13.3232 11.7626 13.0303 11.4697L11.9697 12.5303ZM8.03033 6.46967C7.73744 6.17678 7.26256 6.17678 6.96967 6.46967C6.67678 6.76256 6.67678 7.23744 6.96967 7.53033L8.03033 6.46967ZM8.03033 17.5303L13.0303 12.5303L11.9697 11.4697L6.96967 16.4697L8.03033 17.5303ZM13.0303 12.5303L18.0303 7.53033L16.9697 6.46967L11.9697 11.4697L13.0303 12.5303ZM11.9697 12.5303L16.9697 17.5303L18.0303 16.4697L13.0303 11.4697L11.9697 12.5303ZM13.0303 11.4697L8.03033 6.46967L6.96967 7.53033L11.9697 12.5303L13.0303 11.4697Z"
                                                        fill="#000000">
                                                    </path>
                                                </g>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-lg-1 col-md-2 col-sm-2 py-3 ">

                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-5 py-2 ">
                        <a class="btn btn-primary btn-sm grid-add-row-button" type="button"
                            id="grid-add-row-button[{{ $key }}][{{ $keyP }}]">
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
                        <a class="btn btn-primary btn-sm grid-add-column-button" type="button"
                            id="grid-add-column-button[{{ $key }}][{{ $keyP }}]">
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
            @endforeach
        </div>
    </div>
@endif
