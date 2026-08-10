<?php

namespace Database\Seeders;

use App\Models\Fakultas;
use Illuminate\Database\Seeder;

class FakultasSeeder extends Seeder
{
    /**
     * Contoh minimal fakultas Universitas Andalas (idempoten).
     * Lengkapi daftar penuh belakangan / samakan dengan data modul Tracer Study.
     */
    public function run(): void
    {
        $fakultas = [
            'Fakultas Teknologi Informasi',
            'Fakultas Teknik',
            'Fakultas Ekonomi dan Bisnis',
        ];

        foreach ($fakultas as $nama) {
            Fakultas::firstOrCreate(['nama_fakultas' => $nama]);
        }
    }
}
