<?php

namespace App\Http\Controllers\BackOffice;

use App\DataTables\EmailBoxDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EmailBox;
use App\Helpers\AuthHelper;
use Spatie\Permission\Models\Role;
use App\Http\Requests\EmailSendRequest;

class EmailBoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     //Email Outbox List
    public function index(EmailBoxDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title',['form' => trans('emailbox.title')] );
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        return $dataTable->render('global.datatable', compact('pageTitle','auth_user','assets'));

        // return view('backoffice.email.outbox.v2.list');
    }

    public function show(Request $request, $id)
    {  
        $data = EmailBox::find($id);
        if (request()->ajax()) {
            return view('backoffice.email.outbox.form', compact('data'))->render();
        }
    
        return view('backoffice.email.outbox.form', compact('data'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //Delete OutBox ? 
    public function destroy($id)
    {
        $emailbox = EmailBox::findOrFail($id);
        $status = 'errors';
        $message= __('global-message.delete_form', ['form' => __('emailbox.title')]);

        if($emailbox!='') {
            $emailbox->delete();
            $status = 'success';
            $message= __('global-message.delete_form', ['form' => __('emailbox.title')]);
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

        $emailbox =  EmailBox::whereIn('id', $selectedIds);
        $status = 'errors';
        $message= __('global-message.delete_form', ['form' => __('paketsoal.title')]);

        if($emailbox!='') {
            $emailbox->delete();
            $status = 'success';
            $message= __('global-message.delete_form', ['form' => __('paketsoal.title')]);
            
        }
        return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        
        }


    }
}
