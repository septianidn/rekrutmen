<?php

namespace App\DataTables;

use App\Models\Alumni;
use App\Models\Fakultas;
use App\Models\HalamanPertanyaan;
use App\Models\Jenjang;
use App\Models\PaketSoal;
use App\Models\Pertanyaan;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PaketSoalDataTable extends DataTable
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
            ->editColumn('publish', function ($query) {
                $status = 'primary';
                switch ($query->publish) {
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
            ->addColumn('jumlah_pertanyaan', function ($query) {
                $jumlah_pertanyaan = $query->halamanPertanyaan->sum(function ($halamanPertanyaan) {
                    return $halamanPertanyaan->pertanyaan->count();
                });
            
                if( $jumlah_pertanyaan == 0 ){
                    return '<a href="' . route("pertanyaan.create", $query->id) . '" class="">' . $jumlah_pertanyaan . '</a>';
     
                }
                else{
                    return '<a href="' . route("pertanyaan.edit", $query->id) . '" class="">' . $jumlah_pertanyaan . '</a>';
     
                }
                })
            
            ->addColumn('menerima_usulan', function ($data) {
                return view('backoffice.tracerstudy.admin.paket-soal.menerima_usulan', compact('data'));
            })
            ->addColumn('action', 'backoffice.tracerstudy.admin.paket-soal.action')
            
            ->filterColumn('nama_paket', function($query, $keyword) {
                $sql = "nama_paket LIKE ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->rawColumns(['action','jumlah_pertanyaan', 'publish', 'menerima_usulan']);
            
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Fakultas $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = PaketSoal::query()->with(['halamanPertanyaan.pertanyaan']);
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
                            this.api().columns([1, 2, 3, 4, 5,8,9,10]).every(function () {
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
            ['data' => 'nama_paket', 'name' => 'nama_paket', 'title' => 'Nama Kuesioner', 'searchable' => true,],
            ['data' => 'alias_url', 'name' => 'alias_url', 'title' => 'Alias URL', 'searchable' => true,],
            ['data' => 'tgl_tayang', 'name' => 'tgl_tayang', 'title' => 'Tanggal Tayang', 'searchable' => true,],
            ['data' => 'tgl_selesai_tayang', 'name' => 'tgl_selesai_tayang', 'title' => 'Tanggal Selesai Tayang', 'searchable' => true,],
            ['data' => 'tahun_pelaksanaan', 'name' => 'tahun_pelaksanaan', 'title' => 'Tahun Pelaksanaan', 'searchable' => true,],
            ['data' => 'untuk_lulusan', 'name' => 'untuk_lulusan', 'title' => 'Untuk Lulusan', 'searchable' => true,],
            ['data' => 'jumlah_pertanyaan', 'name' => 'jumlah_pertanyaan', 'title' => 'Jumlah Pertanyaan', 'searchable' => true , 'class' => 'text-center'],
             //TODO USULAN PERTANYAAN
            ['data' => 'publish', 'name' => 'publish', 'title' => 'Publish', 'searchable' => true,],
            Column::computed('menerima_usulan')
                    ->width(100)
                    ->addClass('text-center')
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
