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
           ->addIndexColumn()
            
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
                    ->dom('<"row align-items-center"<"col-md-2 px-4"f><"col-md-10 px-4 text-right" B>> <"table-responsive my-3" rt><"row align-items-center"<"col-md-2" l><"col-md-8 text-right float-end-datatables" i><"col-md-2" p>><"clear">')
                    ->buttons(
                        Button::make('csv')->addClass('btn btn-primary btn-icon')->text('<span><i class="fa fa-file-csv"></i>&nbsp Download CSV</span>'),
                        Button::make('pdf')->addClass('btn btn-primary btn-icon')->text('<span><i class="fa fa-file-pdf"></i>&nbsp Download PDF</span>'),
                        Button::make('print')->addClass('btn btn-primary btn-icon')->text('<span><i class="fa fa-print"></i>&nbsp Print</span>'),
                        Button::make('reload')->addClass('btn btn-primary btn-icon')->text('<span><i class="fa fa-refresh"></i>&nbsp Reload</span>'),
                      
                    )  ->headerCallback('function(thead, data, start, end, display){
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
            ['data' =>'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'No', 'orderable'=> false, 'searchable'=> false ],
            ['data' => 'paket_soal.nama_paket', 'name' => 'paket_soal.nama_paket', 'title' => 'Tracer Study', 'searchable' => true,],
            ['data' => 'deskripsi', 'name' => 'pertanyaan', 'title' => 'Deskripsi', 'searchable' => true , 'class' => 'text-center'],
            ['data' => 'lokasi_laporan_link', 'name' => 'lokasi_laporan_link', 'title' => 'Laporan', 'searchable' => false , 'class' => 'text-center'],
            ['data' => 'published', 'name' => 'published', 'title' => 'Publish', 'searchable' => true,]
            ,
                 Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                  ->width(100)
                  ->addClass('text-center hide-search'),
        ];
    }

}
