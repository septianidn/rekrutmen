<?php

namespace App\DataTables;

use App\Models\DataPedia;
use App\Models\DataPediaDetail;
use App\Models\Jenjang;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DataPediaDetailDataTable extends DataTable
{

    protected $id_datapedia;

    public function setIdData($id_datapedia)
    {
        $this->id_datapedia = $id_datapedia;
    }

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
                $id_datapedia= $this->id_datapedia;
                return view('backoffice.datamaster.datapedia.detail.action', compact('data', 'id_datapedia'));
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
                $carbonDate = Carbon::parse($query->created_at);
                $formattedDate = $carbonDate->format('j F Y');
                return $formattedDate;
            })
            ->editColumn('updated_at', function($query) {
                return date('d M Y',strtotime($query->updated_at));
            })
            ->filterColumn('label', function($query, $keyword) {
                $sql = "label LIKE ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('value', function($query, $keyword) {
                $sql = "value LIKE ?";
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
        $model = DataPediaDetail::query()->where('data_pedia_id', $this->id_datapedia);
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
            ['data' =>'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'No', 'orderable'=> false, 'searchable'=> false ],
            ['data' => 'value', 'name' => 'value', 'title' => 'Data Velue', 'searchable' => true,],
            ['data' => 'label', 'name' => 'label', 'title' => 'Data Label', 'searchable' => true,],
            ['data' => 'publish', 'name' => 'publish', 'title' => 'Publish', 'searchable' => true,],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created At', 'searchable' => true,],
            ['data' => 'updated_at', 'name' => 'updated_at', 'title' => 'Updated At', 'searchable' => true,],
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->searchable(false)
                  ->width(100)
                  ->addClass('text-center hide-search'),
        ];
    }

}
