<?php

namespace Database\Seeders;

use App\Models\Jenjang;
use Illuminate\Database\Seeder;

class JenjangSeeder extends Seeder
{
    /**
     * Katalog dasar jenjang pendidikan. Idempoten (firstOrCreate).
     */
    public function run(): void
    {
        foreach (['SD', 'SMP', 'SMA', 'SMK', 'D3', 'D4', 'S1', 'S2', 'S3'] as $nama) {
            Jenjang::firstOrCreate(['nama_jenjang' => $nama]);
        }
    }
}
