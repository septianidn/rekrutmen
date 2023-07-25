<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EmailBox;
use App\Helpers\AuthHelper;
use Spatie\Permission\Models\Role;
use App\Http\Requests\EmailSendRequest;

class EmailSendController extends Controller
{
   
   /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     //To Send Email Blade
     public function create()
     {
         if (request()->ajax()) {
             return view('backoffice.email.send.form')->render();
         }
     
         return view('backoffice.email.send.form');
     }
 
     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     //Email Send 
     // TODO send email | mailtrap
     public function store(EmailSendRequest $request)
     {
         
        $emailbox = EmailBox::create($request->all());
 
        return redirect()->route('emailbox.index')->withSuccess(__('message.emailtemplate_msg_added',['name' => __('emailbox.store')]));
     }
 
}
