<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
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
            ->addColumn('checkbox', function ($query) {
                if(Auth::user()->id !== $query->id){
                    return '<input type="checkbox" name="id[]" class="user_checkbox" value=' . $query->id . '/>';
                }
            })
            ->editColumn('status', function($query) {
                $status = 'warning';
                switch ($query->status) {
                    case 'active':
                        $status = 'primary';
                        break;
                    case 'banned':
                        $status = 'warning';
                        break;
                    case 'inactive':
                        $status = 'danger';
                        break;
                    case 'blocked':
                        $status = 'dark';
                        break;
                }
                return '<span class="text-capitalize badge bg-'.$status.'">'.$query->status.'</span>';
            })
            ->editColumn('phone_number', function($query) {
                if($query->phone_number != null){
                    return $query->phone_number;
                }
                else{
                    return '-';
                }
               
            })
            ->editColumn('created_at', function($query) {
                return date('Y/m/d',strtotime($query->created_at));
            })
            ->filterColumn('full_name', function($query, $keyword) {
                $sql = "CONCAT(users.first_name,' ',users.last_name)  like ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
           
          
            ->addColumn('action', 'users.action')
            ->rawColumns(['action','status', 'checkbox']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = User::query()->with(['adminprodi']);
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
                               
                                $("input.user_checkbox:checked").each(function() {
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
                                                url: "' . route("backoffice.deleted-selected-users") . '",
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
                            ['custom'=>'importData', 'className' => 'btn btn-outline-success btn-icon importData', 'text' => '<i class="fa-solid fa-file-import"></i>&nbspImport',
                            'attr' => [
                                'data-bs-toggle' => 'tooltip',
                                'data-modal-form' => 'form',
                                'data-icon' => 'person_add',
                                'data--href' => route('backoffice.importdatabasealumni.create'),
                                'data-app-title' => 'Import Data',
                                'data-placement' => 'top',
                                'title' => 'Import Data'
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
                                $(".user_checkbox").prop("checked", isChecked);
                            });
                    
                       
                            $(".row-checkbox").change(function () {
                                var allChecked = $(".user_checkbox:checked").length === $(".user_checkbox").length;
                                $("#select-all-checkbox").prop("checked", allChecked);
                            });

                          
                            this.api().columns([2,3,4,5,6,7,8]).every(function () {
                                var column = this;
                                var input = $(\'<input type="text" class="form-control form-control-sm" placeholder="Cari" />\');
                            
                                $(input).appendTo($(column.footer()).empty())
                                .on(\'keyup\', function () {
                                    column.search($(this).val(), false, false, true).draw();
                                });

                                $(\'.datatable tfoot tr\').appendTo(\'.datatable thead\');
                            });
                           
                            this.api().columns([5]).every(function () {
                                var column = this;
                                var select = $(\'<select class="form-control form-control-sm"><option value="">Semua</option><option value="active">Aktif<option value="pending">Pending</option><option value="blocked">Blocked</option></option><option value="inactive">Tidak Aktif</option></select>\')
                                    .appendTo($(column.footer()).empty())
                                    .on(\'change\', function () {
                                        var val = $.fn.dataTable.util.escapeRegex(
                                            $(this).val()
                                        );
                    
                                        column
                                            .search(val ? \'^\' + val + \'$\' : \'\', true, false)
                                            .draw();
                                    });
                            });

                            this.api().columns([6]).every(function () {
                                var column = this;
                                var select = $(\'<select class="form-control form-control-sm"><option value="">Semua</option><option value="admin">Admin</option><option value="adminprodi">Admin Prodi</option></select>\')
                                    .appendTo($(column.footer()).empty())
                                    .on(\'change\', function () {
                                        var val = $.fn.dataTable.util.escapeRegex(
                                            $(this).val()
                                        );
                    
                                        column
                                            .search(val ? \'^\' + val + \'$\' : \'\', true, false)
                                            .draw();
                                    });
                            });

                             // Show Hide Column
                            var columnHeaders = [];
                            this.api().columns().every(function() {
                                var headerText = this.header().textContent;
                                columnHeaders.push(headerText);
                            });
                          
                            var columnSelector = $(\'<select class="select2" multiple="multiple" style="width: 100%;"></select>\');
                            columnHeaders.forEach(function (headerText,index ) {
                                table.api().column(index).visible(false);
                                if(index !== 0 && index !== 1 ){
                                    columnSelector.append(\'<option value="\' + index + \'">\' + headerText + \'</option>\');
                                }
                            });
                        
                            columnSelector.appendTo($(\'div.show-hide-columns\'));
                            var initialSelectedIndexes = [0,1,2,3,5,6,7,8];
                            columnSelector.val(initialSelectedIndexes).trigger("change");

                            var initialSelectedIndexesInit = [0,1,5,6,7,8];

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
            ['data' => 'full_name', 'name' => 'full_name', 'title' => 'Nama Lengkap', 'orderable' => false,  'searchable' => true,],
          
            ['data' => 'email', 'name' => 'email', 'title' => 'Email',  'searchable' => true,],
            ['data' => 'phone_number', 'name' => 'phone_number', 'title' => 'No. Telp',  'searchable' => true,],
            [
                'data' => 'status',
                'name' => 'status',
                'title' => 'Status',
                'render' => null,
                'orderable' => true,
                'searchable' => true,
            ],
            ['data' => 'user_type', 'name' => 'user_type', 'title' => 'Tipe User'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Bergabung Pada'],
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->searchable(false)
                  ->width(100)
                  ->addClass('text-center hide-search'),
        ];
    }

}
