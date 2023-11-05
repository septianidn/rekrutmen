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
           ->addIndexColumn()
           
            ->editColumn('deskripsi', function($query) {
                if($query->deskripsi != null){
                    return $query->deskripsi;
                }
                else{
                    return '-';
                }
               
            })
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
            ->rawColumns(['action','published']);
           
      
            
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Prodi $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = GrupKonten::query();
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
                    ->buttons(
                        Button::make('csv')->addClass('btn btn-primary btn-icon')->text('<span><i class="fa fa-file-csv"></i>&nbsp Download CSV</span>'),
                       Button::make('pdf')->addClass('btn btn-primary btn-icon')->text('<span><i class="fa fa-file-pdf"></i>&nbsp Download PDF</span>'),
                       Button::make('print')->addClass('btn btn-primary btn-icon')->text('<span><i class="fa fa-print"></i>&nbsp Print</span>'),
                       Button::make('reload')->addClass('btn btn-primary btn-icon')->text('<span><i class="fa fa-refresh"></i>&nbsp Reload</span>'),
                     
                   )->headerCallback('function(thead, data, start, end, display){
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
            ['data' =>'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'No', 'orderable'=> false, 'searchable'=> false ],
            ['data' => 'nama_grup', 'name' => 'nama_grup', 'title' => 'Nama Grup', 'searchable' => true,],
            ['data' => 'alias_url', 'name' => 'alias_url', 'title' => 'Alias URL', 'searchable' => true,],
            ['data' => 'deskripsi', 'name' => 'deskripsi', 'title' => 'Deskripsi', 'searchable' => true,],
            ['data' => 'published', 'name' => 'published', 'title' => 'Status Publish', 'render' => null,  'orderable' => true, 'searchable' => true,],
                 Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                  ->width(100)
                  ->addClass('text-center hide-search'),
        ];
    }

}
