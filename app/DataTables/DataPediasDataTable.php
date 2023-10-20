<?php

namespace App\DataTables;

use App\Models\DataPedia;
use App\Models\DataPediaS;
use App\Models\Jenjang;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DataPediasDataTable extends DataTable
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
                return view('backoffice.datamaster.datapedias.action', compact('data'));
            })
            ->editColumn('created_at', function($query) {
                return date('d M Y',strtotime($query->created_at));
            })
            ->editColumn('updated_at', function($query) {
                return date('d M Y',strtotime($query->updated_at));
            })
            ->filterColumn('value', function($query, $keyword) {
                $sql = "value LIKE ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('label', function($query, $keyword) {
                $sql = "label LIKE ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->rawColumns(['action','publish']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\DataPedia $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = DataPediaS::query();
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
                     
                   )// ->headerCallback('function(thead, data, start, end, display){
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
            ['data' => 'value', 'name' => 'value', 'title' => 'Value', 'searchable' => true,],
            ['data' => 'label', 'name' => 'label', 'title' => 'Label', 'searchable' => true,],
          
            ['data' => 'parent_id', 'name' => 'parent_id', 'title' => 'Parent', 'searchable' => true,],
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
