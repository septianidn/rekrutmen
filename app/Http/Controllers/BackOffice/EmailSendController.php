<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mime\Email;
use App\Mail\MailExample;

use App\Models\EmailBox;
use App\Helpers\AuthHelper;
use Spatie\Permission\Models\Role;
use App\Http\Requests\EmailSendRequest;
use App\Mail\EmailFormat;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BlastingEmailExport;
use App\Imports\BlastingEmailImport;
use App\Imports\EmailFormFileImport;
use App\Models\EmailTemplate;
use App\Jobs\SendMailJob;

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

        $templateOptions = EmailTemplate::all() ?? null;
        
         if (request()->ajax()) {
             return view('backoffice.email.send.form', compact('templateOptions'))->render();
         }
     
         return view('backoffice.email.send.form', compact('templateOptions'));
     }
 
     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     //Email Send 
     // TODO: send email | mailtrap
     public function store(EmailSendRequest $request)
     {

  
        if ($request->tipe == 'single') {
           
            $subject = $request->input('subjek');
            $content = $request->input('isi');
            $templateId = $request->input('template_id') ?? '1';
            $tipe = $request->tipe;

            $recipients = json_decode($request->input('tujuan'), true);
            $recipientEmails = array_column($recipients, 'value');

            foreach ($recipientEmails as $recipientEmail) {

                    $id = $this->saveData($recipientEmail, $subject, $content,$tipe, 'pending',now(), $templateId);
                    dispatch(new SendMailJob($recipientEmail, $subject, $content, $id));
            }
        }
        else if ([$request->tipe == 'email_from_file']){

            $subject = $request->input('subjek');
            $content = $request->input('isi');
            $templateId = $request->input('template_id') ?? '1';
            $tipe = $request->tipe;
          
            $file = $request->file('email_from_file')->store('public/import');
            $import = (new EmailFormFileImport( $subject, $content, $templateId))->queue($file);

 
         }
        else if ([$request->tipe == 'blasting']){

          
           $file = $request->file('blasting_file');
           $import = new BlastingEmailImport;
           $data = Excel::toArray($import, $file);


        }
        return redirect()->route('backoffice.outbox.index')->withSuccess(__('Email sedang proses dikirim',['name' => __('outbox.store')]));
      
    }

    
    private function saveData($recipientEmail, $subject, $content, $type, $status, $sentAt, $templateId)
    {
        if($templateId == null) {
           $templateId = 1;
        }
        $create = EmailBox::create([
            'tujuan' => $recipientEmail,
            'subjek' => $subject,
            'isi' => $content,
            'tipe' => $type,
            'status' => $status,
            'tanggal_kirim' => $sentAt,
            'template_id' => $templateId

        ]);
    
        return $create->id;
    }
  
}
