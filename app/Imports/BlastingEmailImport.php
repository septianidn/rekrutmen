<?php

namespace App\Imports;

use App\Models\EmailBox;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BlastingEmailImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new EmailBox([
            'tujuan' => $row['email'], 
        ]);
    }
}
