<?php

namespace App\DataTables;

use App\Models\Alumni;
use App\Models\Fakultas;
use App\Models\HalamanPertanyaan;
use App\Models\Jenjang;
use App\Models\PaketSoal;
use App\Models\Pertanyaan;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PaketSoalDataTable extends DataTable
{
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
           ->addIndexColumn()
            ->editColumn('published', function ($query) {
                $status = 'primary';
                switch ($query->published) {
                    case 1:
                        $status = 'primary';
                        $text = 'Published';
                        break;
                    case 0:
                        $status = 'danger';
                        $text = 'Not Published';
                        break;
                }
                return '<span class="text-capitalize badge bg-'.$status.'">'.$text.'</span>';
            })
            ->addColumn('checkbox', function ($query) {
                return '<input type="checkbox" name="paket_soal_id[]" class="paketsoal-checkbox" value="' . $query->id . '"/>';
            })
            
            ->editColumn('alias_url', function ($query) {
                return '<a href="' . route('kuesioner.tracerstudy-login.create', $query->alias_url) . '" target="_blank" class="">' . "/" . $query->alias_url . '</a>';

                })
            
            ->addColumn('jumlah_pertanyaan', function ($query) {
                $jumlah_pertanyaan = $query->halamanPertanyaan->sum(function ($halamanPertanyaan) {
                    return $halamanPertanyaan->pertanyaan->count();
                });
            
                if( $jumlah_pertanyaan == 0 ){
                    return '<a href="' . route("backoffice.pertanyaan.create", $query->id) . '" class="">' . $jumlah_pertanyaan . '</a>';
     
                }
                else{
                    return '<a href="' . route("backoffice.pertanyaan.edit", $query->id) . '" class="">' . $jumlah_pertanyaan . '</a>';
    
                }
                })
            
            ->addColumn('menerima_usulan', function ($query) {
                return view('backoffice.tracerstudy.admin.paket-soal.menerima_usulan', compact('query'));
            })
            ->addColumn('action', 'backoffice.tracerstudy.admin.paket-soal.action')
            
            ->filterColumn('nama_paket', function($query, $keyword) {
                $sql = "nama_paket LIKE ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->rawColumns(['action','checkbox','jumlah_pertanyaan', 'published', 'menerima_usulan','alias_url']);
            
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Fakultas $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = PaketSoal::query()->with(['halamanPertanyaan.pertanyaan']);
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
                               
                                $("input.paketsoal-checkbox:checked").each(function() {
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
                                                url: "' . route("backoffice.deleted-selected-paketsoal") . '",
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
                            this.api().columns([1, 2, 3, 4, 5,8,9,10]).every(function () {
                                var column = this;
                                var title = $(column.header()).text();
    
                                var input = $(\'<input type="text" class="form-control form-control-sm" placeholder="\' + title + \'"/>\');
    
                                $(input).appendTo($(column.footer()).empty())
                                .on(\'keyup\', function () {
                                    column.search($(this).val(), false, false, true).draw();
                                });
                            });
                        }'
                    ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
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
            ['data' =>'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'No', 'orderable'=> false, 'searchable'=> false ],
            ['data' => 'nama_paket', 'name' => 'nama_paket', 'title' => 'Nama Kuesioner', 'searchable' => true,],
            ['data' => 'alias_url', 'name' => 'alias_url', 'title' => 'Alias URL', 'searchable' => true,],
            ['data' => 'tgl_tayang', 'name' => 'tgl_tayang', 'title' => 'Tanggal Tayang', 'searchable' => true,],
            ['data' => 'tgl_selesai_tayang', 'name' => 'tgl_selesai_tayang', 'title' => 'Tanggal Selesai Tayang', 'searchable' => true,],
            ['data' => 'tahun_pelaksanaan', 'name' => 'tahun_pelaksanaan', 'title' => 'Tahun Pelaksanaan', 'searchable' => true,],
            ['data' => 'untuk_lulusan', 'name' => 'untuk_lulusan', 'title' => 'Untuk Lulusan', 'searchable' => true,],
            ['data' => 'jumlah_pertanyaan', 'name' => 'jumlah_pertanyaan', 'title' => 'Jumlah Pertanyaan', 'searchable' => true , 'class' => 'text-center'],
             //TODO USULAN PERTANYAAN
            ['data' => 'published', 'name' => 'published', 'title' => 'Status Tayang', 'searchable' => true],
            Column::computed('menerima_usulan')
                    ->width(100)
                    ->addClass('text-center')
            ,
                 Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                  ->width(100)
                  ->addClass('text-center hide-search'),
        ];
    }

}
