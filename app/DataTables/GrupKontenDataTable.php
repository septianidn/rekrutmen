<?php

namespace App\DataTables;

use App\Models\GrupKonten;
use App\Models\Jenjang;
use App\Models\Prodi;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class GrupKontenDataTable extends DataTable
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
            ->addColumn('id', function () use (&$index) {
                return $index++;
            })
            ->editColumn('statusTerbit.status_terbit', function ($query) {
                $status = 'primary';
                switch ($query->statusTerbit->status_terbit) {
                    case 'Published':
                        $status = 'primary';
                        break;
                    case 'Not Published':
                        $status = 'danger';
                        break;
                    case 'Draft':
                        $status = 'dark';
                        break;
                }
                return '<span class="text-capitalize badge bg-'.$status.'">'.$query->statusTerbit->status_terbit.'</span>';
            })
            
            ->addColumn('action', function ($data) {
                return view('backoffice.konten.grupkonten.action', compact('data'));
            })
            ->filterColumn('nama_grup', function($query, $keyword) {
                $sql = "nama_grup LIKE  ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('alias_url', function($query, $keyword) {
                $sql = "alias_url LIKE  ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('deskripsi', function($query, $keyword) {
                $sql = "deskripsi LIKE  ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('published', function($query, $keyword) {
                $sql = "published LIKE  ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->rawColumns(['action','statusTerbit.status_terbit']);
           
      
            
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Prodi $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = GrupKonten::query()->with('statusTerbit');
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
                    ->dom('<"row align-items-center"<"col-md-2" l><"col-md-6" B><"col-md-4"f>><"table-responsive my-3" rt><"row align-items-center"<"col-md-6" i><"col-md-6" p>><"clear">')
                    ->headerCallback('function(thead, data, start, end, display){
                        $(thead).find("th").addClass("text-center");
                    }')
                    ->parameters([
                        "processing" => true,
                        "autoWidth" => false,
                        "serverSide" => true,
                        "initComplete" => 'function () {
                            this.api().columns([1,2,3]).every(function () {
                                var column = this;
                                var input = $(\'<input type="text" class="form-control form-control-sm" placeholder="Cari" />\');
                            
                                $(input).appendTo($(column.footer()).empty())
                                .on(\'keyup\', function () {
                                    column.search($(this).val(), false, false, true).draw();
                                });

                                $(\'.datatable tfoot tr\').appendTo(\'.datatable thead\');
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
            ['data' => 'id', 'name' => 'id', 'title' => 'No',  'searchable' => true, 'class' => 'text-center'],
            ['data' => 'nama_grup', 'name' => 'nama_grup', 'title' => 'Nama Grup', 'searchable' => true,],
            ['data' => 'alias_url', 'name' => 'alias_url', 'title' => 'Alias URL', 'searchable' => true,],
            ['data' => 'deskripsi', 'name' => 'deskripsi', 'title' => 'Deskripsi', 'searchable' => true,],
            ['data' => 'statusTerbit.status_terbit', 'name' => 'statusTerbit.status_terbit', 'title' => 'Status Publish', 'render' => null,  'orderable' => true, 'searchable' => true,],
            Column::computed('action')
                  ->exportable(true)
                  ->printable(true)
                  ->searchable(true)
                  ->width(100)
                  ->addClass('text-center hide-search'),
        ];
    }

}
