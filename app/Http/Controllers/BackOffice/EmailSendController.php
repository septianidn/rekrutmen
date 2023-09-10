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

        if ($request->tipe == 'single') {
           
            $subject = $request->input('subjek');
            $content = $request->input('isi');
            $recipients = json_decode($request->input('tujuan'), true);
    
            $recipientEmails = array_column($recipients, 'value');

            foreach ($recipientEmails as $recipientEmail) {
                try {
                    // Send email using the Mailable
                    Mail::to($recipientEmail)->send(new EmailFormat($subject, $content));
                    $this->saveData($recipientEmail, $subject, $content, $request->tipe, 'SUCCESS', now());
                } catch (\Exception $e) {
                    $this->saveData($recipientEmail, $subject, $content, $request->tipe, 'FAILED', now());
                }
            }
        }
        else if ([$request->tipe == 'blasting']){

          
           $file = $request->file('blasting_file');
           $import = new BlastingEmailImport;
           $data = Excel::toArray($import, $file);
   
          
           $emailColumn = collect($data[0])->pluck('email');

           dd($emailColumn);
        }
        else{
            return redirect()->route('send.create')->withErrors(__('message.emailsend_msg_error_type',['name' => __('send.store')]));
        }
        
        return redirect()->route('outbox.index')->withSuccess(__('message.emailsend_msg_added',['name' => __('outbox.store')]));
    }
 
     private function saveData($recipientEmail, $subject, $content, $type, $status, $sentAt)
     {
         
         EmailBox::create([
             'tujuan' => $recipientEmail,
             'subjek' => $subject,
             'isi' => $content,
             'tipe' => $type,
             'status' => $status,
             'tanggal_kirim' => $sentAt,

         ]);

       
     
     }
}
