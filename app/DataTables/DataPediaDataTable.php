<?php

namespace App\DataTables;

use App\Models\DataPedia;
use App\Models\Jenjang;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DataPediaDataTable extends DataTable
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
                return view('backoffice.datamaster.datapedia.action', compact('data'));
            })
            ->addColumn('jumlah_data', function ($data) {
                return '<a href="datapedia/detail/'.$data->id.'">'.$data->datapediadetail_count.'</a>';
            })
            ->editColumn('deskripsi_data', function ($query) {
                $text = $query->deskripsi_data;
                if($query->deskripsi_data == null | $query->deskripsi_data == '')
                {
                    $text = '-';
                }
                return '<span>'.$text.'</span>';
            })
            ->editColumn('published', function ($query) {
                $status = 'primary';
                $text = "Not Published";
                switch ($query->published) {
                    case 0:
                        $text = 'Not Published';
                        $status = 'danger';
                        break;
                    case 1:
                        $text = 'Published';
                        $status = 'primary';
                        break;
                }
                return '<span class="text-capitalize badge bg-'.$status.'">'.$text.'</span>';
            })
            ->editColumn('created_at', function($query) {
                return date('d M Y',strtotime($query->created_at));
            })
            ->editColumn('updated_at', function($query) {
                return date('d M Y',strtotime($query->updated_at));
            })
            ->filterColumn('nama_data', function($query, $keyword) {
                $sql = "nama_data LIKE ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('deskripsi_data', function($query, $keyword) {
                $sql = "deskripsi_data LIKE ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->rawColumns(['action','published', 'deskripsi_data', 'jumlah_data']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\DataPedia $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = DataPedia::query()->with('datapediadetail');
        $model->withCount('datapediadetail');
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
                   // ->headerCallback('function(thead, data, start, end, display){
                    //     $(thead).find("th").addClass("text-center");
                    // }')
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
            ['data' => 'nama_data', 'name' => 'nama_data', 'title' => 'Nama Data', 'searchable' => true,],
            ['data' => 'deskripsi_data', 'name' => 'deskripsi_data', 'title' => 'Deskripsi Data', 'searchable' => true,],
          
            ['data' => 'published', 'name' => 'published', 'title' => 'Status Tayang', 'searchable' => true,],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created At', 'searchable' => true,],
            ['data' => 'updated_at', 'name' => 'updated_at', 'title' => 'Updated At', 'searchable' => true,],
            ['data' => 'jumlah_data', 'name' => 'datapediadetail_count', 'title' => 'Jumlah Data', 'searchable' => true , 'class' => 'text-center'],
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->searchable(false)
                  ->width(100)
                  ->addClass('text-center hide-search'),
        ];
    }

}
