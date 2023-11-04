<?php

namespace App\Jobs;

use App\Mail\EmailFormat;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use App\Models\EmailBox;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Mailer\Messenger\SendEmailMessage;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $send_mail;
    protected $subject;
    protected $content;
    protected $tipe;
    protected $sentAt;
    protected $templateId;
    protected $id;

    
    /**
     * Create a new job instance.
     */
    public function __construct($send_mail, $subject,$content, $id)
    {
        $this->send_mail = $send_mail;
        $this->subject = $subject;
        $this->content = $content;
        $this->id = $id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $email = new EmailFormat($this->subject, $this->content);
            Mail::to($this->send_mail)->send($email);

            $this->updateData($this->id, 'send');
        } catch (\Exception $e) {
            $this->updateData($this->id, 'failed');
            Log::error('Error sending email: ' . $e->getMessage());
        }
       
    }

    public function failed()
    {
        Log::alert('error in queue mail');
        

    }

  
    private function updateData($id, $status)
    {
     
        $emailBox = EmailBox::findOrFail($id);

        $emailBox->status = $status;

        $emailBox->save();
            
    }
}
