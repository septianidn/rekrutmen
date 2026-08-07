<?php

namespace Database\Seeders;

use App\Models\Posisi;
use Illuminate\Database\Seeder;

class PosisiSeeder extends Seeder
{
    /**
     * Katalog dasar posisi. Idempoten (firstOrCreate) sehingga aman
     * dijalankan ulang dan tidak menggandakan baris yang sudah ada.
     */
    public function run(): void
    {
        $posisi = [
            'Manager',
            'Supervisor',
            'Staff Administrasi',
            'Kasir',
            'Kurir',
            'Operator',
            'Operator Produksi',
            'Customer Service',
            'Marketing',
            'Sales',
            'Akuntan',
            'Software Engineer',
            'Junior Developer',
            'Senior Developer',
            'UI/UX Designer',
            'Data Analyst',
            'Human Resource',
            'Barista',
            'Teknisi',
        ];

        foreach ($posisi as $nama) {
            Posisi::firstOrCreate(['nama_posisi' => $nama]);
        }
    }
}
