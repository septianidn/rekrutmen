<?php

namespace Database\Seeders;

use App\Models\Proses;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProsesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proses = [
            [
                'nama_proses' => 'Tes Administrasi',
                
            ],
            [
                'nama_proses' => 'Ujian SKD',
                
            ],
            [
                'nama_proses' => 'Ujian TPS',
                
            ],
            [
                'nama_proses' => 'Wawancara awal',
                
            ],
            [
                'nama_proses' => 'Magang',
                
            ],
            [
                'nama_proses' => 'Wawancara Final',
                
            ],
        ];

        foreach ($proses as $key => $value) {
            $step = Proses::create($value);
        }
    }
}
