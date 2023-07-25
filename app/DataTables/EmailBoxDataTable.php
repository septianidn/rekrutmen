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
            ->addColumn('id', function () use (&$index) {
                return $index++;
            })          
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

            
            ->filterColumn('tanggal_kirim', function($query, $keyword) {
                $sql = "tanggal_kirim LIKE ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            
            ->filterColumn('tipe', function($query, $keyword) {
                $sql = "tipe LIKE ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })

          
            ->addColumn('action', 'backoffice.email.outbox.action');
           
            
            
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
                    ->dom('<"row align-items-center"<"col-md-2" l><"col-md-6" B><"col-md-4"f>><"table-responsive my-3" rt><"row align-items-center"<"col-md-6" i><"col-md-6" p>><"clear">')
                    ->headerCallback('function(thead, data, start, end, display){
                        $(thead).find("th").addClass("text-center");
                    }')
                    ->parameters([
                        "processing" => true,
                        "autoWidth" => false,
                        "serverSide" => true,
                        "initComplete" => 'function () {
                            this.api().columns([1,2,3,4,5]).every(function () {
                                var column = this;
                                var input = $(\'<input type="text" class="form-control form-control-sm" placeholder="Cari" />\');
                            
                                $(input).appendTo($(column.footer()).empty())
                                .on(\'keyup\', function () {
                                    column.search($(this).val(), false, false, true).draw();
                                });

                                $(\'.datatable tfoot tr\').appendTo(\'.datatable thead\');
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
            ['data' => 'id', 'name' => 'id', 'title' => 'No',  'searchable' => true, 'class' => 'text-center'],
            ['data' => 'tujuan', 'name' => 'tujuan', 'title' => 'Tujuan', 'searchable' => true,],
            ['data' => 'subjek', 'name' => 'subjek', 'title' => 'Subjek', 'searchable' => true,],
            ['data' => 'isi', 'name' => 'isi', 'title' => 'Isi', 'searchable' => true,],
            ['data' => 'tanggal_kirim', 'name' => 'tanggal_kirim', 'title' => 'Tanggal Kirim', 'searchable' => true,],
            ['data' => 'tipe', 'name' => 'tipe', 'title' => 'Tipe', 'searchable' => true,],
            Column::computed('action')
                  ->exportable(true)
                  ->printable(true)
                  ->searchable(true)
                  ->width(100)
                  ->addClass('text-center hide-search'),
        ];
    }

}
