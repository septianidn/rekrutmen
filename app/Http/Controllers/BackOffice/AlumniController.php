<?php

namespace App\Http\Controllers\BackOffice;

use App\DataTables\AlumniDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Helpers\AuthHelper;
use App\Http\Requests\AlumniRequest;
use App\Models\Alumni;
use App\Models\EmailTemplate;
use App\Models\PaketSoal;
use Rap2hpoutre\FastExcel\Facades\FastExcel;

class AlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AlumniDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title',['form' => trans('alumni.title')] );
        $auth_alumni = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a data--href="' . route('backoffice.databasealumni.create') . '" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-modal-form="form" data-icon="person_add" data-app-title="Tambah Data" data-placement="top" title="Tambah Data">Tambah Alumni</a>';
        return $dataTable->render('global.datatable', compact('pageTitle','auth_alumni','assets', 'headerAction'));
    }

    public function create(Request $request)
    {
       
        $view = view('backoffice.alumni.form')->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AlumniRequest $request)
    {
    
       $response = ['success' => [], 'error' => []];
       $alumni = Alumni::create($request->all());

       if (!$alumni) {
            $response['error'][] = 'Gagal menyimpan data alumni: ' . $alumni;
        }


       if (empty($response['error'])) {
        return response()->json(['success' => $response['success']]);
        } else {
            return response()->json(['error' => $response['error']]);
        }
    }


    public function edit(Request $request, $id)
    {
       
        $data = Alumni::find($id);
        $view = view('backoffice.alumni.form',  compact('request', 'data', 'id'))->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AlumniRequest $request, $nim)
    {
        $response = ['success' => [], 'error' => []];
        $alumni = Alumni::where('nim', $nim)->firstOrFail();
        $alumni->fill($request->all())->update();


        if (!$alumni) {
            $response['error'][] = 'Gagal menyimpan data alumni: ' . $alumni;
        }


       if (empty($response['error'])) {
            return response()->json(['success' => $response['success']]);
        } else {
            return response()->json(['error' => $response['error']]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($nim)
    {
        $alumni = Alumni::findOrFail($nim);
        $status = 'errors';
        $message= __('global-message.delete_form', ['form' => __('alumni.title')]);

        if($alumni!='') {
            $alumni->delete();
            $status = 'success';
            $message= __('global-message.delete_form', ['form' => __('alumni.title')]);
        }

        if(request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status,$message);

    }

    public function deletedSelected(Request $request)
    {
        if(request()->ajax()){
        $selectedIds = $request->input('selectedIds');

        $alumni =  Alumni::whereIn('nim', $selectedIds);
        $status = 'errors';
        $message= __('global-message.delete_form', ['form' => __('alumni.title')]);

        if($alumni!='') {
            $alumni->delete();
            $status = 'success';
            $message= __('global-message.delete_form', ['form' => __('alumni.title')]);
            
        }
        return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        
        }


    }

    public function blastingtsCreate(Request $request){

        $paketSoalOption = PaketSoal::all()->pluck('nama_paket', 'id');
        $templateEmailOption = EmailTemplate::all()->pluck('nama_template','id');
        $selectedIdBlasting = $request->input('selectedIdBlasting');

        $data = $request->all();
        $view = view('backoffice.alumni.blasting.form', compact('selectedIdBlasting','paketSoalOption','templateEmailOption'))->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
    }


    public function blastingtsStore(Request $request){

      
    }


    public function import(Request $request){

        $data = $request->all();
        $view = view('backoffice.alumni.import.form')->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
    }

    
    public function importStore(Request $request){

      
    }

    public function exportCSV(Request $request){


    $data = Alumni::select('*')->except('judul_tesis')->get();

    $filename = 'exported_data_' . now()->format('YmdHis') . '.csv';


    (new FastExcel($data))->export($filename);

    return response()->download($filename, $filename);

    }



}
