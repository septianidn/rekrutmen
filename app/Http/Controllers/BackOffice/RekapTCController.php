<?php

namespace App\Http\Controllers\BackOffice;

use App\DataTables\AlumniDataTable;
use App\DataTables\RekapTCDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Helpers\AuthHelper;
use App\Http\Requests\AlumniRequest;
use App\Models\Alumni;

class RekapTCController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RekapTCDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title',['form' => trans('rekaptc.title')] );
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        return $dataTable->render('global.datatable', compact('pageTitle','auth_user','assets'));
    }

    public function show($id)
    {
       
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Alumni::findOrFail($id);
        $status = 'errors';
        $message= __('global-message.delete_form', ['form' => __('rekaptc.title')]);

        if($user!='') {
            $user->delete();
            $status = 'success';
            $message= __('global-message.delete_form', ['form' => __('rekaptc.title')]);
        }

        if(request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status,$message);

    }
}
