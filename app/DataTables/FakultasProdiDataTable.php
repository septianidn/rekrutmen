<?php

namespace App\DataTables;

use App\Models\FakultasProdi;
use App\Models\Jenjang;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class FakultasProdiDataTable extends DataTable
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
            ->editColumn('fakultas.nama_fakultas', function($query) {
                return $query->fakultas->nama_fakultas ?? '-';
            })
            ->editColumn('prodi.nama_prodi', function($query) {
                return $query->prodi->nama_prodi ?? '-';
            })
            ->editColumn('jenjang.nama_jenjang', function($query) {
                return $query->jenjang->nama_jenjang ?? '-';
            })
            ->addColumn('action', function ($data) {
                return view('backoffice.datamaster.fakultasprodi.action', compact('data'));
            })
            ->filterColumn('nama_prodi', function($query, $keyword) {
                $sql = "nama_prodi LIKE ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('kode_prodi', function($query, $keyword) {
                $sql = "nama_fakultas LIKE ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            
            ->filterColumn('kode_prodi', function($query, $keyword) {
                $sql = "nama_fakultas LIKE ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('nama_jenjang', function($query, $keyword) {
                $sql = "nama_jenjang LIKE ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            });
            
           
            
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Fakultas $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = FakultasProdi::query()->with(['fakultas', 'prodi', 'jenjang']);
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
                            this.api().columns([1, 2, 3, 4, 5]).every(function () {
                                var column = this;
                                var title = $(column.header()).text();
    
                                var input = $(\'<input type="text" class="form-control form-control-sm" placeholder="Cari \' + title + \'"/>\');
    
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
            ['data' => 'id', 'name' => 'id', 'title' => 'No',  'searchable' => true, 'class' => 'text-center'],
            ['data' => 'fakultas.nama_fakultas', 'name' => 'fakultas.nama_fakultas', 'title' => 'Fakultas', 'searchable' => true,],
            ['data' => 'prodi.nama_prodi', 'name' => 'prodi.nama_prodi', 'title' => 'Prodi', 'searchable' => true,],
            ['data' => 'prodi.kode_prodi', 'name' => 'prodi.kode_prodi', 'title' => 'Kode Prodi', 'searchable' => true,],
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
