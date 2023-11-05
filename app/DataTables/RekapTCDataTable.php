<?php

namespace App\DataTables;

use App\Models\Alumni;
use App\Models\Fakultas;
use App\Models\Jenjang;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class RekapTCDataTable extends DataTable
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
            ->addColumn('datajawaban', 'backoffice.tracerstudy.rekap.jawaban')
            ->addColumn('action', 'backoffice.tracerstudy.rekap.action')
            
            ->filterColumn('nama', function($query, $keyword) {
                $sql = "nama LIKE ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->rawColumns(['action','datajawaban']);
            
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Fakultas $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = Alumni::query()->with(['prodi', 'prodi.jenjang', 'prodi.fakultas']);
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
                            this.api().columns([1, 2, 3, 4, 5,6,7,8]).every(function () {
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
            ['data' =>'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'No', 'orderable'=> false, 'searchable'=> false ],
            ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama', 'searchable' => true,],
            ['data' => 'nim', 'name' => 'nama', 'title' => 'NIM', 'searchable' => true,],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email', 'searchable' => true,],
            ['data' => 'prodi.fakultas.nama_fakultas', 'name' => 'prodi.fakultas.nama_fakultas', 'title' => 'Fakultas', 'searchable' => true],
            ['data' => 'prodi.nama_prodi', 'name' => 'prodi.nama_prodi', 'title' => 'Prodi', 'searchable' => true,],
            ['data' => 'prodi.jenjang.nama_jenjang', 'name' => 'prodi.jenjang.nama_jenjang', 'title' => 'Jenjang', 'searchable' => true,],
            ['data' => 'thn_masuk', 'name' => 'thn_masuk', 'title' => 'Tahun Masuk', 'searchable' => true,],
            ['data' => 'thn_lulus', 'name' => 'nama', 'title' => 'Tahun Lulus', 'searchable' => true,],
            ['data' => 'datajawaban', 'name' => 'data_jawaban', 'title' => 'Jawaban', 'searchable' => true , 'class' => 'text-center hide-search'],
            
            Column::computed('action')
                  ->exportable(true)
                  ->printable(true)
                  ->searchable(true)
                  ->width(100)
                  ->addClass('text-center hide-search'),
        ];
    }

}
