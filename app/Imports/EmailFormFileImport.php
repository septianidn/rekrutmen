<?php

namespace App\Imports;

use App\Jobs\SendMailJob;
use App\Models\EmailBox;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RemembersChunkOffset;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class EmailFormFileImport implements ToModel, WithHeadingRow, SkipsOnFailure, ShouldQueue, WithChunkReading, WithBatchInserts
{
    use Importable, SkipsFailures, RemembersRowNumber, RemembersChunkOffset;

  
    protected $subject;
    protected $content;
    protected $templateId;
    /**
     * Create a new job instance.
     */
    public function __construct($subject,$content, $templateId)
    {
        $this->subject = $subject;
        $this->content = $content;
        $this->templateId = $templateId;
    }


    public function model(array $row)
    {
        $currentRowNumber = $this->getRowNumber();
    
        $chunkOffset = $this->getChunkOffset();
    
        $email = $row['email'];
    
        if (!empty($email)) {
            $emailSend = new EmailBox([
                'tujuan' => $email,
                'subjek' => $this->subject,
                'isi' => $this->content,
                'status' => 'pending',
                'tanggal_kirim' => now(),
                'tipe' => 'blasting',
                'template_id' => $this->templateId
            ]);
    
            $emailSend->save();
            dispatch(new SendMailJob($email, $this->subject, $this->content, $emailSend->id));
        }
    }
    

    public function rules(): array
    {
        return [
           'tujuan' => 'required|email',
        ];
    
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }


}
