<?php

namespace App\DataTables;

use App\Models\Jenjang;
use App\Models\KabupatenKota;
use App\Models\Provinsi;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class KabKotaDataTable extends DataTable
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
          
            ->addColumn('action', function ($data) {
                return view('backoffice.datamaster.zona.kabkota.action', compact('data'));
            })
            
            ->filterColumn('provinsi.nama_provinsi', function($query, $keyword) {
                $sql = "nama_provinsi LIKE ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            });
            
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = KabupatenKota::query()->with(['provinsi']);
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
                     
                   )
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
            ['data' =>'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'No', 'orderable'=> false, 'searchable'=> false ],
            ['data' => 'kode_kabupaten_kota', 'name' => 'kode_kabupaten_kota', 'title' => 'Kode Kabupaten Kota', 'searchable' => true],
            ['data' => 'nama_kabupaten_kota', 'name' => 'nama_kabupaten_kota', 'title' => 'Nama Kabupaten Kota', 'searchable' => true],
            ['data' => 'provinsi.kode_provinsi', 'name' => 'provinsi.kode_provinsi', 'title' => 'Kode Provinsi', 'searchable' => true],
            ['data' => 'provinsi.nama_provinsi', 'name' => 'provinsi.nama_provinsi', 'title' => 'Nama Provinsi', 'searchable' => true],
        
            Column::computed('action')
                  ->exportable(true)
                  ->printable(true)
                  ->searchable(true)
                  ->width(100)
                  ->addClass('text-center hide-search'),
        ];
    }

}
