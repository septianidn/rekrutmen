<?php

namespace App\Http\Controllers\BackOffice;
use App\DataTables\PaketSoalDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\AuthHelper;
use App\Http\Requests\PaketSoalRequest;
use App\Models\PaketSoal;

class PaketSoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PaketSoalDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title',['form' => trans('paketsoal.title')] );
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="'.route('backoffice.paket-soal.create').'" class="btn btn-sm btn-primary" role="button">Tambah Paket Soal</a>';
        return $dataTable->render('global.datatable', compact('pageTitle','auth_user','assets', 'headerAction'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (request()->ajax()) {
            return view('backoffice.tracerstudy.admin.paket-soal.form')->render();
        }
    
        return view('backoffice.tracerstudy.admin.paket-soal.form')->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaketSoalRequest $request)
    {
        
       $paketsoal = PaketSoal::create($request->all());

       return redirect()->route('backoffice.paket-soal.index')->withSuccess(__('message.paketsoal_msg_added',['name' => __('paket-soal.store')]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
       /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = PaketSoal::findOrFail($id);

        return view('backoffice.tracerstudy.admin.paket-soal.form', compact('data','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PaketSoalRequest $request, $id)
    {
        // dd($request->all());
        $paketsoal = PaketSoal::findOrFail($id);

        $paketsoal->fill($request->all())->update();


        if(auth()->check()){
            return redirect()->route('backoffice.paket-soal.index')->withSuccess(__('message.paketsoal_msg_updated',['name' => __('Update Paket Soal')]));
        }
        return redirect()->back()->withSuccess(__('message.paketsoal_msg_updated',['name' => 'Paket Soal']));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paketsoal = PaketSoal::findOrFail($id);
        $status = 'errors';
        $message= __('global-message.delete_form', ['form' => __('paketsoal.title')]);

        if($paketsoal!='') {
            $paketsoal->delete();
            $status = 'success';
            $message= __('global-message.delete_form', ['form' => __('paketsoal.title')]);
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

        $paketsoal =  PaketSoal::whereIn('id', $selectedIds);
        $status = 'errors';
        $message= __('global-message.delete_form', ['form' => __('paketsoal.title')]);

        if($paketsoal!='') {
            $paketsoal->delete();
            $status = 'success';
            $message= __('global-message.delete_form', ['form' => __('paketsoal.title')]);
            
        }
        return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        
        }


    }
}
