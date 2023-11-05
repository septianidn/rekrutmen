<?php

namespace App\DataTables;

use App\Models\Alumni;
use App\Models\EmailBox;
use App\Models\Fakultas;
use App\Models\Jenjang;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class EmailBoxDataTable extends DataTable
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
                 
            ->filterColumn('tujuan', function($query, $keyword) {
                $sql = "tujuan LIKE ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
             
            ->filterColumn('subjek', function($query, $keyword) {
                $sql = "subjek LIKE ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('isi', function($query, $keyword) {
                $sql = "isi LIKE ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('status', function($query, $keyword) {
                $sql = "status LIKE ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->orderColumn('id', function ($query) {
                $query->orderBy('id', 'DESC');
            })
            
            ->filterColumn('tanggal_kirim', function($query, $keyword) {
                $sql = "tanggal_kirim LIKE ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->addColumn('checkbox', function ($query) {
                return '<input type="checkbox" name="emailbox[]" class="emailbox_checkbox" value="' . $query->id . '"/>';
            })
            
            ->filterColumn('tipe', function($query, $keyword) {
                $sql = "tipe LIKE ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })

            ->editColumn('status', function ($query) {
                $status = 'failed';
                $text = "Failed";
                switch ($query->status) {
                    case "failed":
                        $text = 'Failed';
                        $status = 'danger';
                        break;
                    case "send":
                        $text = 'Send';
                        $status = 'primary';
                        break;
                    case "pending":
                        $text = 'Pending';
                        $status = 'warning';
                        break;
                }
                return '<span class="text-capitalize badge bg-'.$status.'">'.$text.'</span>';
            })
            ->editColumn('tipe', function ($query) {
                $tipe = 'single';
                $text = "single";
                switch ($query->tipe) {
                    case "single":
                        $text = 'Single';
                        $tipe = 'primary';
                        break;
                    case "blasting":
                        $text = 'Blasting';
                        $tipe = 'secondary';
                        break;
                                    }
                return '<span class="text-capitalize badge bg-'.$tipe.'">'.$text.'</span>';
            })
            ->addColumn('action', function ($data) {
                return view('backoffice.email.outbox.action', compact('data'));
            })
            ->rawColumns(['action', 'status', 'tipe', 'checkbox']);
           
            
            
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Fakultas $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = EmailBox::query();
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
                    ->dom('<"row align-items-center"<"col-md-2 px-4"f><"col-md-10 px-4 text-right" B>> <"table-responsive my-3" rt><"row align-items-center"<"col-md-2" l><"col-md-8 text-right float-end-datatables" i><"col-md-2" p>><"clear">')
               
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
                               
                                $("input.emailbox_checkbox:checked").each(function() {
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
                                                url: "' . route("backoffice.deleted-selected-emailbox") . '",
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
                                $(".emailbox_checkbox").prop("checked", isChecked);
                            });

                            this.api().columns([1,2,3,4,5]).every(function () {
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
            ['data' => 'tujuan', 'name' => 'tujuan', 'title' => 'Tujuan', 'searchable' => true,],
            ['data' => 'subjek', 'name' => 'subjek', 'title' => 'Subjek', 'searchable' => true,],
            ['data' => 'tanggal_kirim', 'name' => 'tanggal_kirim', 'title' => 'Tanggal Kirim', 'searchable' => true,],
            ['data' => 'tipe', 'name' => 'tipe', 'title' => 'Tipe', 'searchable' => true,],
            ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'searchable' => true,],
                 Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                  ->width(100)
                  ->addClass('text-center hide-search'),
        ];
    }

}
