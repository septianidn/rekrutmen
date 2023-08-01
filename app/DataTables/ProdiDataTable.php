<?php

namespace App\DataTables;

use App\Models\Jenjang;
use App\Models\Prodi;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProdiDataTable extends DataTable
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
            ->addColumn('action', function ($data) {
                return view('backoffice.datamaster.prodi.action', compact('data'));
            })
            ->filterColumn('kode_prodi', function($query, $keyword) {
                $sql = "kode_prodi LIKE  ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('nama_prodi', function($query, $keyword) {
                $sql = "nama_prodi LIKE  ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('nama_jenjang', function($query, $keyword) {
                $sql = "nama_jenjang LIKE ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('nama_fakultas', function($query, $keyword) {
                $sql = "nama_fakultas LIKE ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            });
      
            
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Prodi $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = Prodi::query()->with(['fakultas', 'jenjang']);;
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
            ['data' => 'kode_prodi', 'name' => 'kode_prodi', 'title' => 'Kode Prodi', 'searchable' => true,],
            ['data' => 'nama_prodi', 'name' => 'nama_prodi', 'title' => 'Nama Prodi', 'searchable' => true,],
            ['data' => 'fakultas.nama_fakultas', 'name' => 'fakultas.nama_fakultas', 'title' => 'Fakultas', 'searchable' => true,],
            ['data' => 'jenjang.nama_jenjang', 'name' => 'jenjang.nama_jenjang', 'title' => 'Jenjang', 'searchable' => true,],
            Column::computed('action')
                  ->exportable(true)
                  ->printable(true)
                  ->searchable(true)
                  ->width(100)
                  ->addClass('text-center hide-search'),
        ];
    }

}
