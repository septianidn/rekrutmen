<?php

namespace App\Http\Controllers\BackOffice;

use App\DataTables\EmailTemplateDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EmailTemplate;
use App\Helpers\AuthHelper;
use Spatie\Permission\Models\Role;
use App\Http\Requests\EmailTemplateRequest;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(EmailTemplateDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title',['form' => trans('emailtemplate.title')] );
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="'.route('backoffice.template.create').'" class="btn btn-sm btn-primary" role="button">Tambah Template</a>';
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
            return view('backoffice.email.template.form')->render();
        }
    
        return view('backoffice.email.template.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmailTemplateRequest $request)
    {
        
       $emailtemplate = EmailTemplate::create($request->all());

       return redirect()->route('backoffice.template.index')->withSuccess(__('message.emailtemplate_msg_added',['name' => __('template.store')]));
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
        $data = EmailTemplate::findOrFail($id);

        return view('backoffice.email.template.form', compact('data','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmailTemplateRequest $request, $id)
    {
        // dd($request->all());
        $emailtemplate = EmailTemplate::findOrFail($id);

        $emailtemplate->fill($request->all())->update();


        if(auth()->check()){
            return redirect()->route('backoffice.template.index')->withSuccess(__('message.emailtemplate_msg_updated',['name' => __('Update Template Email')]));
        }
        return redirect()->back()->withSuccess(__('message.emailtemplate_msg_updated',['name' => 'My Profile']));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $emailtemplate = EmailTemplate::findOrFail($id);
        $status = 'errors';
        $message= __('global-message.delete_form', ['form' => __('emailtemplate.title')]);

        if($emailtemplate!='') {
            $emailtemplate->delete();
            $status = 'success';
            $message= __('global-message.delete_form', ['form' => __('emailtemplate.title')]);
        }

        if(request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status,$message);

    }
}
