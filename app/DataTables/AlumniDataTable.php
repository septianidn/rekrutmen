<?php

namespace App\DataTables;

use App\Models\Alumni;
use App\Models\Fakultas;
use App\Models\Jenjang;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Rap2hpoutre\FastExcel\FastExcel;

class AlumniDataTable extends DataTable
{

    protected array $actions = ['csv', 'pdf', 'excel', 'print', 'reload', 'deleteSelected', 'blastingEmail','myCustomAction'];
 
       /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $index = 1;
        return datatables()
           ->eloquent($query)
            ->addColumn('no', function () use (&$index) {
                return $index++;
            })
            ->addColumn('checkbox', function ($query) {
                return '<input type="checkbox" name="alumni[]" class="alumni_checkbox" value="' . $query->nim . '"/>';
            })
            
            ->addColumn('action', function ($data) {
                return view('backoffice.alumni.action', compact('data'));
            })
            ->editColumn('pin', function ($query) {
                if ($query->pin !== null) {
                    return $query->pin;
                } else {
                    return '-';
                }
            })
            ->editColumn('nomor_handphone', function ($query) {
                if ($query->nomor_handphone !== null) {
                    return '+62' . $query->nomor_handphone;
                } else {
                    return '-';
                }
            })
            ->editColumn('periode_wisuda', function ($query) {
                $periode = '1';
                switch ($query->periode_wisuda) {
                    case '1':
                        $periode = 'I';
                        break;
                    case '2':
                        $periode = 'II';
                        break;
                    case '3':
                        $periode = 'III';
                        break;
                    case '4':
                        $periode = 'IV';
                        break;
                    case '5':
                        $periode = 'V';
                        break;
                    case '6':
                        $periode = 'VI';
                        break;
                    default:
                        $periode = "-";
                }
                return '<p>Wisuda '.$periode.'</p>';
            })
            ->editColumn('sent_pin', function ($query) {
                $img = "" ;
                if ($query->sent_pin == 1) {
                    $img = '<svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4 12.6111L8.92308 17.5L20 6.5" stroke="#009A4B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>';
                } else  {
                    $img = '<svg width="32px" height="32px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M6.99486 7.00636C6.60433 7.39689 6.60433 8.03005 6.99486 8.42058L10.58 12.0057L6.99486 15.5909C6.60433 15.9814 6.60433 16.6146 6.99486 17.0051C7.38538 17.3956 8.01855 17.3956 8.40907 17.0051L11.9942 13.4199L15.5794 17.0051C15.9699 17.3956 16.6031 17.3956 16.9936 17.0051C17.3841 16.6146 17.3841 15.9814 16.9936 15.5909L13.4084 12.0057L16.9936 8.42059C17.3841 8.03007 17.3841 7.3969 16.9936 7.00638C16.603 6.61585 15.9699 6.61585 15.5794 7.00638L11.9942 10.5915L8.40907 7.00636C8.01855 6.61584 7.38538 6.61584 6.99486 7.00636Z" fill="#eb1414"></path> </g></svg>';
                }
                return '<span>  '.$img .'</span>';
            })
            ->rawColumns(['action', 'checkbox', 'sent_pin','periode_wisuda'])
            ->filterColumn('nama', function($query, $keyword) {
                $sql = "nama LIKE ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            });
            
    }
    protected bool $fastExcel = true;
  
    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Fakultas $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = Alumni::query()->with(['prodi', 'prodi.jenjang', 'prodi.fakultas']);
        return $this->applyScopes($model);
    }

  
    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('dataTable')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('<"row align-items-center"<"col-md-2 px-4"f><"col-md-10 px-4 text-right" B>><"row align-items-center"<"col-md-12 px-4 py-4" <"show-hide-columns">> > <"table-responsive my-3" rt><"row align-items-center"<"col-md-2" l><"col-md-8 text-right float-end-datatables" i><"col-md-2" p>><"clear">')
                   
                    ->headerCallback('function(thead, data, start, end, display){
                        $(thead).find("th").addClass("text-center");
                    }')
                    
                    ->parameters([
                        "processing" => true,
                        "autoWidth" => false,
                        "serverSide" => true,
                        'buttons' => [
                            ['custom'=>'deleteSelected', 'className' => 'btn btn-outline-danger btn-icon', 'text' => '<span><i class="fa fa-trash"></i>&nbsp Deleted Selected</span>' ,
                            'action' => 'function() {
                                var selectedIds = [];
                                var swalWithBootstrapButtons = Swal.mixin({
                                    customClass: {
                                        confirmButton: "btn btn-danger mx-2",
                                        cancelButton: "btn btn-success",
                                        popup: "rounded"
                                    },
                                    buttonsStyling: false,
                                    showClass: {
                                        popup: "animate__animated animate__zoomIn animate__faster",
                
                                    },
                                    hideClass: {
                                        popup: "animate__animated animate__zoomOut animate__faster",
                
                                    }
                                })
                                const csrfToken = document.querySelector("meta[name=\'csrf-token\']").getAttribute("content");
                               
                                $("input.alumni_checkbox:checked").each(function() {
                                    selectedIds.push($(this).val());
                                });
                                if(selectedIds.length == 0){
                                    toastMixin.fire({
                                        icon: "error",
                                        animation: true,
                                        title: "Pilih Minimal 1 Data!",
                                    });
                                }
                                else if(selectedIds.length > 0){
        
                                    swalWithBootstrapButtons.fire({
                                        title: `Hapus Data?`,
                                        text: "Anda tidak akan dapat mengembalikan ini!!",
                                        icon: "question",
                                        showCancelButton: true,
                                        confirmButtonText: "Ya, hapus!",
                                        cancelButtonText: "Batal",
                                    }).then(function(result) {
                                        if (result.isConfirmed) {
                                            $.ajax({
                                                method: "GET",
                                                headers: { "X-CSRF-TOKEN": csrfToken },
                                                contentType: "application/json",
                                                url: "' . route("deleted-selected-alumni") . '",
                                                data: { selectedIds: selectedIds },
                                                success: function(response) {
                                                    $("#dataTable").DataTable().ajax.reload();
                                                },
                                                error: function(data) {
                                                    console.error(data.responseJSON);
                                                  
                                                }
                                            });
                                        }
                                    });
                                   
                                }
                        
                               
                            }'],

                            ['custom'=>'blastingEmail', 'className' => 'btn btn-outline-success btn-icon blastingEmail', 'text' => '<span><i class="fa fa-envelope"></i>&nbsp Blasting TS</span>' ,
                            'attr' => 'data-bs-toggle="tooltip" data-modal-form="form" data-icon="person_add" data-app-title="Tambah Data" data-placement="top" title="Tambah Data',
                            'action' => 'function() {
                                var selectedIdBlasting = [];     
                                const csrfToken = document.querySelector("meta[name=\'csrf-token\']").getAttribute("content");
                                $("input.alumni_checkbox:checked").each(function() {
                                    selectedIdBlasting.push($(this).val());
                                });
                                if(selectedIdBlasting.length == 0){
                                    toastMixin.fire({
                                        icon: "error",
                                        animation: true,
                                        title: "Pilih Minimal 1 Data!",
                                    });
                                } 
                                else if(selectedIdBlasting.length > 0){
                                    $.ajax({
                                        method: "GET",
                                        headers: { "X-CSRF-TOKEN": csrfToken },
                                        contentType: "application/json",
                                        url: "' . route("blastingts.create") . '",
                                        data: { selectedIdBlasting: selectedIdBlasting },
                                        success: function(response) {
                                          
                                            $("#formModal input, #formModal select, #formModal textarea").prop("disabled", false);
                                                    var html = response.data;
                                                    $(".main_form").html(html);
                                                    $("#formTitle").empty().append("Blasting Email Pengisian");
                                                    $(".modal-dialog").addClass("modal-extra-large modal-lg");
                                                    $("#formModal").modal("show");

                                        },
                                        error: function(data) {
                                            console.error(data.responseJSON);
                                          
                                        }
                                    });
                                   
                                }          
                               
                            }'],
                            ['custom'=>'importData', 'className' => 'btn btn-outline-success btn-icon importData', 'text' => '<i class="fa-solid fa-file-import"></i>&nbspImport',
                            'attr' => [
                                'data-bs-toggle' => 'tooltip',
                                'data-modal-form' => 'form',
                                'data-icon' => 'person_add',
                                'data--href' => route('importdatabasealumni.create'),
                                'data-app-title' => 'Tambah Data',
                                'data-placement' => 'top',
                                'title' => 'Tambah Data'
                                ]
                            ],
                            [
                                "extend" => "csv",
                                "className" => "btn btn-outline-success btn-icon csv-export",
                                "text" => '<span><i class="fa fa-file-csv"></i>&nbsp CSV</span>',
                             
                            ],
                            [
                                "extend" => "excel",
                                "className" => "btn btn-outline-success btn-icon ",
                                "text" => '<span><i class="fa fa-file-csv"></i>&nbsp Excel</span>',
                             
                            ],
                            [
                                "extend" => "pdf",
                                "className" => "btn btn-outline-success btn-icon",
                                "text" => '<span><i class="fa fa-file-pdf"></i>&nbsp PDF</span>',
                              
                               
                            ],
                            [
                                "extend" => "print",
                                "className" => "btn btn-outline-success btn-icon",
                            ],
                            ['extend'=>'reload', 'className' => 'btn btn-outline-success btn-icon', 'text' => '<span><i class="fa fa-refresh"></i>&nbsp Reload</span>'],
                          
                        ],
                       
                        "initComplete" => 'function () {
                        
                            var table = this;
                            var toastMixin = Swal.mixin({
                                        toast: true,
                                        icon: "success",
                                        title: "General Title",
                                        animation: false,
                                        position: "top-right",
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: true,
                                        didOpen: (toast) => {
                                            toast.addEventListener("mouseenter", Swal.stopTimer)
                                            toast.addEventListener("mouseleave", Swal.resumeTimer)
                                        }
                            });
                  
                            $("#select-all-checkbox").change(function () {
                                var isChecked = $(this).is(":checked");
                                $(".alumni_checkbox").prop("checked", isChecked);
                            });
                    
                       
                            $(".row-checkbox").change(function () {
                                var allChecked = $(".alumni_checkbox:checked").length === $(".alumni_checkbox").length;
                                $("#select-all-checkbox").prop("checked", allChecked);
                            });

                           

                            // Menambahkan kotak pencarian kolom
                            table.api().columns([2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17]).every(function () {
                                var column = this;
                                var title = $(column.header()).text();
                                var input = $(\'<input type="text" class="form-control form-control-sm" placeholder="\' + title + \'"/>\');
                        
                                $(input).appendTo($(column.footer()).empty())
                                    .on(\'keyup\', function () {
                                        column.search($(this).val(), false, false, true).draw();
                                    });
                            });
                            var columnHeaders = [];

                            this.api().columns().every(function() {
                                var headerText = this.header().textContent;
                                columnHeaders.push(headerText);
                            });

                            console.log(columnHeaders);

                            // Membuat pilihan Select2 dari nama kolom
                            var columnSelector = $(\'<select class="select2" multiple="multiple" style="width: 100%;"></select>\');
                        
                            columnHeaders.forEach(function (headerText,index ) {
                                table.api().column(index).visible(false);
                                if(index !== 0 && index !== 1 ){
                                    columnSelector.append(\'<option value="\' + index + \'">\' + headerText + \'</option>\');
                                }
                            });
                        

                            columnSelector.appendTo($(\'div.show-hide-columns\'));
             
                            var initialSelectedIndexes = [0,1,2,3,5,6,7,8,9,10,13,14,18,19,20];
                            columnSelector.val(initialSelectedIndexes).trigger("change");

                            var initialSelectedIndexesInit = [0,1,2,3,4,5,6,7,8,9,10,20];

                            columnSelector.on("select2:unselecting", function (e) {
                                var deselectedValue = e.params.args.data.id;
                                if (initialSelectedIndexesInit.includes(parseInt(deselectedValue))) {
                                    e.preventDefault(); 
                                }
                            });

                            initialSelectedIndexes.forEach(function (columnIndex) {
                                table.api().column(0).visible(true);
                                table.api().column(1).visible(true);
                                table.api().column(columnIndex).visible(true);
                            });
                            
                            columnSelector.on(\'change\', function () {
                                var selectedColumns = $(this).val();
                                var columns = table.api().columns().indexes().toArray();
                                table.api().columns(columns).visible(false);

                                selectedColumns.forEach(function (columnIndex) {
                                    table.api().column(0).visible(true);
                                    table.api().column(1).visible(true);
                                    table.api().column(columnIndex).visible(true);
                                });
                            });
                        
                            // Inisialisasi Select2
                            columnSelector.select2( {
                                theme: "bootstrap-5",
                                  multiple: true
                            } );


                            
                            
                        }'
                        
                    ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    //TODO: JUST SHOW COLUMN KEBUTUHAN TC 
    //TODO: ADD FITUR SHOW AND HIDE HEAD OF COLUNM USING THEME PRO
    protected function getColumns()
    {
        return [
            [
                'data'           => 'checkbox',
                'name'           => 'checkbox',
                'title'          => '<input type="checkbox" id="select-all-checkbox">',
                'orderable'      => false,
                'searchable'     => false,
                'exportable'     => false,
                'printable'      => false,
                'width'          => '3px',
            ],
            
            ['data' => 'no', 'name' => 'no', 'title' => 'No',  'searchable' => true, 'class' => 'text-center',   'exportable' => false],
            ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama', 'searchable' => true],
            ['data' => 'nim', 'name' => 'nama', 'title' => 'NIM', 'searchable' => true],
            ['data' => 'tanggal_lahir', 'name' => 'tanggal_lahir', 'title' => 'Tanggal Lahir', 'searchable' => true],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email', 'searchable' => true],
            ['data' => 'prodi.fakultas.nama_fakultas', 'name' => 'prodi.fakultas.nama_fakultas', 'title' => 'Fakultas', 'searchable' => true],
            ['data' => 'prodi.nama_prodi', 'name' => 'prodi.nama_prodi', 'title' => 'Prodi', 'searchable' => true,],
            ['data' => 'prodi.jenjang.nama_jenjang', 'name' => 'prodi.jenjang.nama_jenjang', 'title' => 'Jenjang', 'searchable' => true],
            ['data' => 'thn_masuk', 'name' => 'thn_masuk', 'title' => 'Tahun Masuk', 'searchable' => true],
            ['data' => 'thn_lulus', 'name' => 'nama', 'title' => 'Tahun Lulus', 'searchable' => true],
            ['data' => 'pin', 'name' => 'pin', 'title' => 'PIN', 'searchable' => true],
            ['data' => 'tipe_masuk', 'name' => 'tipe_masuk', 'title' => 'Tipe Masuk', 'searchable' => true],
            ['data' => 'nomor_handphone', 'name' => 'nomor_handphone', 'title' => 'Nomor Handphone', 'searchable' => true],
            ['data' => 'periode_wisuda', 'name' => 'periode_wisuda', 'title' => 'Periode Wisuda', 'searchable' => true,  'render' => null],
            ['data' => 'npwp', 'name' => 'npwp', 'title' => 'NPWP', 'searchable' => true],
            ['data' => 'nik', 'name' => 'nik', 'title' => 'NIK', 'searchable' => true],
            ['data' => 'judul_tesis', 'name' => 'judul_tesis', 'title' => 'Judul Tesis', 'searchable' => true , 'printable' => false],
            ['data' => 'status_tc', 'name' => 'status_tc', 'title' => 'Status TC', 'searchable' => true,  'exportable' => false, 'printable' => false],
            ['data' => 'sent_pin', 'name' => 'sent_pin', 'title' => 'Status Kirim PIN', 'searchable' => true,  'render' => null, 'exportable' => false, 'class'=>'text-center' , 'printable' => false],
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->searchable(false)
                  ->orderable(false)
                  ->width(100)
                  ->addClass('text-center hide-search'),
           
        ];
    }

}
