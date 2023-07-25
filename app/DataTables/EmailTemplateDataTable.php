<?php

namespace App\DataTables;

use App\Models\EmailTemplate;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class EmailTemplateDataTable extends DataTable
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
            ->filterColumn('nama_template', function($query, $keyword) {
                $sql = "nama_template LIKE ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('subjek_template', function($query, $keyword) {
                $sql = "subjek_template LIKE ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('isi_template', function($query, $keyword) {
                $sql = "isi_template LIKE ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->editColumn('created_at', function ($post) {
                return Carbon::parse($post->created_at)->format('j F Y');
            })
            ->editColumn('updated_at', function ($post) {
                return Carbon::parse($post->updated_at)->format('j F Y');
            })
            ->addColumn('action', function ($data) {
                return view('backoffice.email.template.action', compact('data'));
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
        $model = EmailTemplate::query();
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
                   
                    ->parameters([
                        "processing" => true,
                        "autoWidth" => false,
                        "serverSide" => true,
                        "initComplete" => 'function () {
                            this.api().columns([1,2,3,4,5]).every(function () {
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
            ['data' => 'nama_template', 'name' => 'nama_template', 'title' => 'Nama Template', 'searchable' => true,],
            ['data' => 'subjek_template', 'name' => 'subjek_template', 'title' => 'Subjek Template', 'searchable' => true,],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created Date', 'searchable' => true,],
            ['data' => 'updated_at', 'name' => 'updated_at', 'title' => 'Modified Date', 'searchable' => true,],
            Column::computed('action')
                  ->exportable(true)
                  ->printable(true)
                  ->searchable(true)
                  ->width(100)
                  ->addClass('text-center hide-search'),
        ];
    }

}
