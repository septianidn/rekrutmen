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
            ->addColumn('no', function () use (&$index) {
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
                            this.api().columns([1, 2, 3, 4, 5,6,7,8,9,10,11,12,13,14,15,16,17]).every(function () {
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
    //TODO: JUST SHOW COLUMN KEBUTUHAN TC 
    //TODO: ADD FITUR SHOW AND HIDE HEAD OF COLUNM USING THEME PRO
    protected function getColumns()
    {
        return [
            ['data' => 'no', 'name' => 'no', 'title' => 'No',  'searchable' => true, 'class' => 'text-center'],
            ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama', 'searchable' => true,],
            ['data' => 'nim', 'name' => 'nama', 'title' => 'NIM', 'searchable' => true,],
            ['data' => 'tanggal_lahir', 'name' => 'tanggal_lahir', 'title' => 'Tanggal Lahir', 'searchable' => true,],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email', 'searchable' => true,],
            ['data' => 'prodi.fakultas.nama_fakultas', 'name' => 'prodi.fakultas.nama_fakultas', 'title' => 'Fakultas', 'searchable' => true],
            ['data' => 'prodi.nama_prodi', 'name' => 'prodi.nama_prodi', 'title' => 'Prodi', 'searchable' => true,],
            ['data' => 'prodi.jenjang.nama_jenjang', 'name' => 'prodi.jenjang.nama_jenjang', 'title' => 'Jenjang', 'searchable' => true,],
            ['data' => 'thn_masuk', 'name' => 'thn_masuk', 'title' => 'Tahun Masuk', 'searchable' => true,],
            ['data' => 'thn_lulus', 'name' => 'nama', 'title' => 'Tahun Lulus', 'searchable' => true,],
            ['data' => 'pin', 'name' => 'pin', 'title' => 'PIN', 'searchable' => true,],
            ['data' => 'tipe_masuk', 'name' => 'tipe_masuk', 'title' => 'Tipe Masuk', 'searchable' => true,],
            ['data' => 'nomor_handphone', 'name' => 'nomor_handphone', 'title' => 'Nomor Handphone', 'searchable' => true,],
            ['data' => 'periode_wisuda', 'name' => 'periode_wisuda', 'title' => 'Periode Wisuda', 'searchable' => true,],
            ['data' => 'npwp', 'name' => 'npwp', 'title' => 'NPWP', 'searchable' => true,],
            ['data' => 'nik', 'name' => 'nik', 'title' => 'NIK', 'searchable' => true,],
            ['data' => 'judul_tesis', 'name' => 'judul_tesis', 'title' => 'Judul Tesis', 'searchable' => true,],
            ['data' => 'status_tc', 'name' => 'status_tc', 'title' => 'Status TC', 'searchable' => true,],



            Column::computed('action')
                  ->exportable(true)
                  ->printable(true)
                  ->searchable(true)
                  ->width(100)
                  ->addClass('text-center hide-search'),
        ];
    }

}
