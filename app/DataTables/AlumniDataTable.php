<?php

namespace App\DataTables;

use App\Models\Alumni;
use App\Models\Fakultas;
use App\Models\Jenjang;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AlumniDataTable extends DataTable
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
                return view('backoffice.alumni.action', compact('data'));
            })
            
            ->filterColumn('nama', function($query, $keyword) {
                $sql = "nama LIKE ?";
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
        $model = Alumni::query()->with(['fakultasProdi.fakultas', 'fakultasProdi.prodi', 'fakultasProdi.jenjang']);
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
            ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama', 'searchable' => true,],
            ['data' => 'nim', 'name' => 'nama', 'title' => 'NIM', 'searchable' => true,],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email', 'searchable' => true,],
            ['data' => 'nama_fakultas', 'name' => 'nama_fakultas', 'title' => 'Fakultas', 'searchable' => true,],
            ['data' => 'nama_prodi', 'name' => 'nama_prodi', 'title' => 'Prodi', 'searchable' => true,],
            ['data' => 'nama_jenjang', 'name' => 'nama_jenjang', 'title' => 'Jenjang', 'searchable' => true,],
            ['data' => 'thn_keluar', 'name' => 'nama', 'title' => 'Tahun Keluar', 'searchable' => true,],
            ['data' => 'thn_masuk', 'name' => 'thn_masuk', 'title' => 'Tahun Masuk', 'searchable' => true,],

            Column::computed('action')
                  ->exportable(true)
                  ->printable(true)
                  ->searchable(true)
                  ->width(100)
                  ->addClass('text-center hide-search'),
        ];
    }

}
