<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        Account::updateOrCreate(
            ['nomor_rekening' => '1234567890'],
            [
                'nama_bank'    => 'Bank Nagari',
                'nama_pemilik' => 'Pusat Karir Universitas Andalas',
                'is_active'    => true,
            ],
        );
    }
}
