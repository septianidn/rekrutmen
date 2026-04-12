<?php

namespace Database\Seeders;

use App\Models\Proses;
use Illuminate\Database\Seeder;

class ProsesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proses = [
            ['nama_proses' => 'Tes Administrasi'],
            ['nama_proses' => 'Uji Kompetensi'],
            ['nama_proses' => 'Wawancara'],
            ['nama_proses' => 'Pengumuman'],
        ];

        foreach ($proses as $value) {
            Proses::updateOrCreate(
                ['nama_proses' => $value['nama_proses']],
                $value
            );
        }
    }
}
