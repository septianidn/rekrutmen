<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('userProfile.country', function($query) {
                return $query->userProfile->country ?? '-';
            })
            ->editColumn('userProfile.company_name', function($query) {
                return $query->userProfile->company_name ?? '-';
            })
            ->editColumn('status', function($query) {
                $status = 'warning';
                switch ($query->status) {
                    case 'active':
                        $status = 'primary';
                        break;
                    case 'inactive':
                        $status = 'danger';
                        break;
                    case 'banned':
                        $status = 'dark';
                        break;
                }
                return '<span class="text-capitalize badge bg-'.$status.'">'.$query->status.'</span>';
            })
            ->editColumn('created_at', function($query) {
                return date('Y/m/d',strtotime($query->created_at));
            })
            ->filterColumn('full_name', function($query, $keyword) {
                $sql = "CONCAT(users.first_name,' ',users.last_name)  like ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('userProfile.company_name', function($query, $keyword) {
                return $query->orWhereHas('userProfile', function($q) use($keyword) {
                    $q->where('company_name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('userProfile.country', function($query, $keyword) {
                return $query->orWhereHas('userProfile', function($q) use($keyword) {
                    $q->where('country', 'like', "%{$keyword}%");
                });
            })
            ->addColumn('action', 'users.action')
            ->rawColumns(['action','status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = User::query()->with('userProfile');
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
                    ->dom('<"row align-items-center"<"col-md-2" l><"col-md-6" B><"col-md-4"f>><"table-responsive my-3" rt><"row align-items-center" <"col-md-6" i><"col-md-6" p>><"clear">')
                    ->headerCallback('function(thead, data, start, end, display){
                        $(thead).find("th").addClass("text-center");
                    }')
                    ->parameters([
                        "processing" => true,
                        "autoWidth" => false,
                        "serverSide" => true,
                        "initComplete" => 'function () {
                            this.api().columns([0,1,2,3,4,6,7]).every(function () {
                                var column = this;
                                var input = $(\'<input type="text" class="form-control form-control-sm" placeholder="Cari" />\');
                            
                                $(input).appendTo($(column.footer()).empty())
                                .on(\'keyup\', function () {
                                    column.search($(this).val(), false, false, true).draw();
                                });

                                $(\'.datatable tfoot tr\').appendTo(\'.datatable thead\');
                            });
                           
                            this.api().columns([5]).every(function () {
                                var column = this;
                                var select = $(\'<select class="form-control form-control-sm"><option value="">All</option><option value="active">Active</option><option value="inactive">Inactive</option><option value="banned">Banned</option></select>\')
                                    .appendTo($(column.footer()).empty())
                                    .on(\'change\', function () {
                                        var val = $.fn.dataTable.util.escapeRegex(
                                            $(this).val()
                                        );
                    
                                        column
                                            .search(val ? \'^\' + val + \'$\' : \'\', true, false)
                                            .draw();
                                    });
                            });
                        }',
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
            ['data' => 'id', 'name' => 'id', 'title' => 'id',  'searchable' => true, 'class' => 'text-center'],
            ['data' => 'full_name', 'name' => 'full_name', 'title' => 'Nama', 'orderable' => false,  'searchable' => true,],
            ['data' => 'phone_number', 'name' => 'phone_number', 'title' => 'Phone Number',  'searchable' => true,],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email',  'searchable' => true,],
            ['data' => 'userProfile.country', 'name' => 'userProfile.country', 'title' => 'Country'],
            [
                'data' => 'status',
                'name' => 'status',
                'title' => 'Status',
                'render' => null,
                'orderable' => true,
                'searchable' => true,
            ],
            ['data' => 'userProfile.company_name', 'name' => 'userProfile.company_name', 'title' => 'Company'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Join Date'],
            Column::computed('action')
                  ->exportable(true)
                  ->printable(true)
                  ->searchable(true)
                  ->width(100)
                  ->addClass('text-center hide-search'),
        ];
    }

}
