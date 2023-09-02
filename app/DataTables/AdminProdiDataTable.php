<?php

namespace App\DataTables;

use App\Models\adminprodi;
use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AdminProdiDataTable extends DataTable
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
          
            ->editColumn('phone_number', function($query) {
                if($query->phone_number != null){
                    return $query->phone_number;
                }
                else{
                    return '-';
                }
               
            })
            ->editColumn('updated_at', function($query) {
                return date('Y/m/d',strtotime($query->updated_at));
            })
            ->filterColumn('full_name', function($query, $keyword) {
                $sql = "CONCAT(first_name,' ',last_name)  like ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })           
            ->addColumn('no', function () use (&$index) {
                return $index++;
            })
            ->addColumn('action', 'backoffice.adminprodi.action')
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = User::query()->with(['adminprodi', 'adminprodi.prodi', 'adminprodi.prodi.jenjang', 'adminprodi.prodi.fakultas'])->where('user_type', 'adminprodi');
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
                    ->dom('<"row align-items-center"<"col-md-2" l><"col-md-6" B><"col-md-4"f>><"table-responsive my-3" rt><"row align-items-center" <"col-md-6" i><"col-md-6" p>><"clear">')
                    ->headerCallback('function(thead, data, start, end, display){
                        $(thead).find("th").addClass("text-center");
                    }')
                    ->parameters([
                        "processing" => true,
                        "autoWidth" => false,
                        "serverSide" => true,
                        "initComplete" => 'function () {
                            this.api().columns([1,2,3,4]).every(function () {
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
                                var select = $(\'<select class="form-control form-control-sm"><option value="">All</option><option value="active">Active</option><option value="inactive">Inactive</option><option value="banned">Banned</option></select>\')
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
                        }',
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
            ['data' => 'no', 'name' => 'no', 'title' => 'No',  'searchable' => true, 'orderable' => false, 'class' => 'text-center'],
            ['data' => 'full_name', 'name' => 'full_name', 'title' => 'Nama', 'orderable' => false,  'searchable' => true,],
            ['data' => 'phone_number', 'name' => 'phone_number', 'title' => 'No. Telp',  'searchable' => true,],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email',  'searchable' => true,],
            ['data' => 'adminprodi.prodi.nama_prodi', 'name' => 'adminprodi.prodi.nama_prodi', 'title' => 'Nama Prodi'],
            ['data' => 'adminprodi.prodi.fakultas.nama_fakultas', 'name' => 'adminprodi.prodi.fakultas.nama_fakultas', 'title' => 'Fakultas'],
            ['data' => 'adminprodi.prodi.jenjang.nama_jenjang', 'name' => 'adminprodi.prodi.jenjang.nama_jenjang', 'title' => 'Jenjang'],
            ['data' => 'updated_at', 'name' => 'updated_at', 'title' => 'Tanggal Ubah'],
            Column::computed('action')
                  ->exportable(true)
                  ->printable(true)
                  ->searchable(true)
                  ->width(100)
                  ->addClass('text-center hide-search'),
        ];
    }

}
