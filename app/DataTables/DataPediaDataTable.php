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
            ->addColumn('id', function () use (&$index) {
                return $index++;
            })
            ->addColumn('action', function ($data) {
                return view('backoffice.datamaster.datapedia.action', compact('data'));
            })
            ->editColumn('deskripsi_data', function ($query) {
                $text = $query->deskripsi_data;
                if($query->deskripsi_data == null | $query->deskripsi_data == '')
                {
                    $text = '-';
                }
                return '<span>'.$text.'</span>';
            })
            ->editColumn('publish', function ($query) {
                $status = 'primary';
                $text = "Not Published";
                switch ($query->publish) {
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
            ->rawColumns(['action','publish', 'deskripsi_data']);
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
            ['data' => 'id', 'name' => 'id', 'title' => 'No',  'searchable' => true, 'class' => 'text-center'],
            ['data' => 'nama_data', 'name' => 'nama_data', 'title' => 'Nama Data', 'searchable' => true,],
            ['data' => 'deskripsi_data', 'name' => 'deskripsi_data', 'title' => 'Deskripsi Data', 'searchable' => true,],
            ['data' => 'publish', 'name' => 'publish', 'title' => 'Publish', 'searchable' => true,],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created At', 'searchable' => true,],
            ['data' => 'updated_at', 'name' => 'updated_at', 'title' => 'Updated At', 'searchable' => true,],
            Column::computed('action')
                  ->exportable(true)
                  ->printable(true)
                  ->searchable(true)
                  ->width(100)
                  ->addClass('text-center hide-search'),
        ];
    }

}
