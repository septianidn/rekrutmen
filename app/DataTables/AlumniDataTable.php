<?php

namespace App\DataTables;

use App\Models\Alumni;
use App\Models\Fakultas;
use App\Models\Jenjang;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;


class AlumniDataTable extends DataTable
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
            ->addColumn('no', function () use (&$index) {
                return $index++;
            })
            ->addColumn('action', function ($data) {
                return view('backoffice.alumni.action', compact('data'));
            })
            
            ->filterColumn('nama', function($query, $keyword) {
                $sql = "nama LIKE ?";
                return $query->whereRaw($sql, ["%{$keyword}%"]);
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
        $model = Alumni::query()->with(['prodi', 'prodi.jenjang', 'prodi.fakultas']);
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
                    ->dom('<"row align-items-center"<"col-md-2 px-4"f><"col-md-10 px-4 text-right" B>><"row align-items-center"<"col-md-12 px-4 py-4" <"show-hide-columns">> > <"table-responsive my-3" rt><"row align-items-center"<"col-md-2" l><"col-md-8 text-right float-end-datatables" i><"col-md-2" p>><"clear">')
                    ->buttons(
                        Button::make('reload')->addClass('btn btn-primary btn-icon')->text('<span><i class="fa fa-trash"></i>&nbsp Deleted Selected</span>')->action('javascript:customFunction()', 'Custom Button Tooltip'),

                        Button::make('csv')->addClass('btn btn-primary btn-icon')->text('<span><i class="fa fa-file-csv"></i>&nbsp Download CSV</span>'),
                        Button::make('pdf')->addClass('btn btn-primary btn-icon')->text('<span><i class="fa fa-file-pdf"></i>&nbsp Download PDF</span>'),
                        Button::make('print')->addClass('btn btn-primary btn-icon')->text('<span><i class="fa fa-print"></i>&nbsp Print</span>'),
                        Button::make('reload')->addClass('btn btn-primary btn-icon')->text('<span><i class="fa fa-refresh"></i>&nbsp Reload</span>'),
                      
                    )
                    ->headerCallback('function(thead, data, start, end, display){
                        $(thead).find("th").addClass("text-center");
                    }')
                    
                    ->parameters([
                        "processing" => true,
                        "autoWidth" => true,
                        "serverSide" => true,
                       
                        "initComplete" => 'function () {
                            var table = this;
                        
                            // Menambahkan kotak pencarian kolom
                            table.api().columns([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17]).every(function () {
                                var column = this;
                                var title = $(column.header()).text();
                                var input = $(\'<input type="text" class="form-control form-control-sm" placeholder="\' + title + \'"/>\');
                        
                                $(input).appendTo($(column.footer()).empty())
                                    .on(\'keyup\', function () {
                                        column.search($(this).val(), false, false, true).draw();
                                    });
                            });
                            var columnHeaders = [];

                            this.api().columns().every(function() {
                                var headerText = this.header().textContent;
                                columnHeaders.push(headerText);
                            });

                            console.log(columnHeaders);

                            // Membuat pilihan Select2 dari nama kolom
                            var columnSelector = $(\'<select class="select2" multiple="multiple" style="width: 100%;"></select>\');
                        
                            columnHeaders.forEach(function (headerText,index ) {
                                table.api().column(index).visible(false);
                                if(index !== 0){
                                    columnSelector.append(\'<option value="\' + index + \'">\' + headerText + \'</option>\');
                                }
                            });
                        

                            columnSelector.appendTo($(\'div.show-hide-columns\'));
             
                            var initialSelectedIndexes = [0,1,2,3,5,6,7,8,13,14,18,19];
                            columnSelector.val(initialSelectedIndexes).trigger("change");

                            var initialSelectedIndexesInit = [0,1,2,3,19];

                            columnSelector.on("select2:unselecting", function (e) {
                                var deselectedValue = e.params.args.data.id;
                                if (initialSelectedIndexesInit.includes(parseInt(deselectedValue))) {
                                    e.preventDefault(); 
                                }
                            });

                            initialSelectedIndexes.forEach(function (columnIndex) {
                                table.api().column(columnIndex).visible(true);
                            });
                            
                            columnSelector.on(\'change\', function () {
                                var selectedColumns = $(this).val();
                                var columns = table.api().columns().indexes().toArray();
                                table.api().columns(columns).visible(false);

                                selectedColumns.forEach(function (columnIndex) {
                                    table.api().column(columnIndex).visible(true);
                                });
                            });
                        
                            // Inisialisasi Select2
                            columnSelector.select2( {
                                theme: "bootstrap-5",
                                  multiple: true
                            } );

                        
                        }'
                        
                    ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    //TODO: JUST SHOW COLUMN KEBUTUHAN TC 
    //TODO: ADD FITUR SHOW AND HIDE HEAD OF COLUNM USING THEME PRO
    protected function getColumns()
    {
        return [
            [
               
                'orderable'      => false,
                'searchable'     => false,
                'exportable'     => false,
                'printable'      => false,

                'width'          => '3px',
                'title' => '',
                'defaultContent' => '<input type="checkbox" />',
            ],
            
            ['data' => 'no', 'name' => 'no', 'title' => 'No',  'searchable' => true, 'class' => 'text-center'],
            ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama', 'searchable' => true,],
            ['data' => 'nim', 'name' => 'nama', 'title' => 'NIM', 'searchable' => true,],
            ['data' => 'tanggal_lahir', 'name' => 'tanggal_lahir', 'title' => 'Tanggal Lahir', 'searchable' => true,],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email', 'searchable' => true,],
            ['data' => 'prodi.fakultas.nama_fakultas', 'name' => 'prodi.fakultas.nama_fakultas', 'title' => 'Fakultas', 'searchable' => true],
            ['data' => 'prodi.nama_prodi', 'name' => 'prodi.nama_prodi', 'title' => 'Prodi', 'searchable' => true,],
            ['data' => 'prodi.jenjang.nama_jenjang', 'name' => 'prodi.jenjang.nama_jenjang', 'title' => 'Jenjang', 'searchable' => true,],
            ['data' => 'thn_masuk', 'name' => 'thn_masuk', 'title' => 'Tahun Masuk', 'searchable' => true,],
            ['data' => 'thn_lulus', 'name' => 'nama', 'title' => 'Tahun Lulus', 'searchable' => true,],
            ['data' => 'pin', 'name' => 'pin', 'title' => 'PIN', 'searchable' => true,],
            ['data' => 'tipe_masuk', 'name' => 'tipe_masuk', 'title' => 'Tipe Masuk', 'searchable' => true,],
            ['data' => 'nomor_handphone', 'name' => 'nomor_handphone', 'title' => 'Nomor Handphone', 'searchable' => true,],
            ['data' => 'periode_wisuda', 'name' => 'periode_wisuda', 'title' => 'Periode Wisuda', 'searchable' => true,],
            ['data' => 'npwp', 'name' => 'npwp', 'title' => 'NPWP', 'searchable' => true,],
            ['data' => 'nik', 'name' => 'nik', 'title' => 'NIK', 'searchable' => true,],
            ['data' => 'judul_tesis', 'name' => 'judul_tesis', 'title' => 'Judul Tesis', 'searchable' => true,],
            ['data' => 'status_tc', 'name' => 'status_tc', 'title' => 'Status TC', 'searchable' => true,],
            Column::computed('action')
                  ->exportable(true)
                  ->printable(true)
                  ->searchable(true)
                  ->width(100)
                  ->addClass('text-center hide-search'),
           
        ];
    }

}
