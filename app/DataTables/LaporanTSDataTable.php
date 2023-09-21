<?php

namespace App\DataTables;

use App\Models\Alumni;
use App\Models\Fakultas;
use App\Models\Jenjang;
use App\Models\LaporanTS;
use App\Models\PaketSoal;
use App\Models\TemporaryFiles;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class LaporanTSDataTable extends DataTable
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
                return view('backoffice.konten.laporants.action', compact('data'));
            })
            ->addColumn('lokasi_laporan_link', function ($data) {

                $laporants = $data->getFirstMedia('laporants');
                return '<a href="' . $laporants->getUrl() . '" target="_blank">' . $laporants->file_name . '</a>';
            })
            
            ->filterColumn('paketSoal.nama_paket', function($query, $keyword) {
                $sql = "paketSoal.nama_paket LIKE ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->rawColumns(['action', 'published','lokasi_laporan_link']);
            
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\LaporanTS $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = LaporanTS::query()->with('paket_soal');
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
                            this.api().columns([1, 2, 3, 4]).every(function () {
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
            ['data' => 'id', 'name' => 'id', 'title' => 'No',  'searchable' => true, 'class' => 'text-center'],
            ['data' => 'paket_soal.nama_paket', 'name' => 'paket_soal.nama_paket', 'title' => 'Tracer Study', 'searchable' => true,],
            ['data' => 'deskripsi', 'name' => 'pertanyaan', 'title' => 'Deskripsi', 'searchable' => true , 'class' => 'text-center'],
            ['data' => 'lokasi_laporan_link', 'name' => 'lokasi_laporan_link', 'title' => 'Laporan', 'searchable' => false , 'class' => 'text-center'],
            ['data' => 'published', 'name' => 'published', 'title' => 'Publish', 'searchable' => true,]
            ,
            Column::computed('action')
                  ->exportable(true)
                  ->printable(true)
                  ->searchable(true)
                  ->width(100)
                  ->addClass('text-center hide-search'),
        ];
    }

}
