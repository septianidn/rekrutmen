<?php

namespace App\Http\Controllers\BackOffice;

use App\DataTables\KontenDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\AuthHelper;
use App\Http\Requests\KontenRequest;
use App\Models\Konten;

class KontenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(KontenDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title',['form' => trans('konten.title')] );
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
    
        $headerAction = '<a href="'.route('backoffice.kelola.create').'" class="btn btn-sm btn-primary" role="button">Tambah Konten</a>';

        return $dataTable->render('global.datatable', compact('pageTitle','auth_user','assets', 'headerAction'));
    }

    public function create(Request $request)
    {
       
        if (request()->ajax()) {
            return view('backoffice.konten.konten.form')->render();
        }
    
        return view('backoffice.konten.konten.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KontenRequest $request)
    {        
       
    
       $konten = Konten::create($request->all());

       return redirect()->route('backoffice.kelola.index')->withSuccess(__('message.konten_msg_added',['name' => __('kelola.store')]));
    }

    public function edit(Request $request, $id)
    {
        $data = Konten::findOrFail($id);

        return view('backoffice.konten.konten.form', compact('data','id'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(KontenRequest $request, $id)
    {
        // dd($request->all());
        $konten = Konten::findOrFail($id);

        $konten->fill($request->all())->update();


        if(auth()->check()){
            return redirect()->route('backoffice.kelola.index')->withSuccess(__('message.konten_msg_updated',['name' => __('Update Konten')]));
        }
        return redirect()->back()->withSuccess(__('message.konten_msg_updated',['name' => 'Data Konten']));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $konten = Konten::findOrFail($id);
        $status = 'errors';
        $message= __('global-message.delete_form', ['form' => __('konten.title')]);

        if($konten!='') {
            $konten->delete();
            $status = 'success';
            $message= __('global-message.delete_form', ['form' => __('konten.title')]);
        }

        if(request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status,$message);

    }
}
