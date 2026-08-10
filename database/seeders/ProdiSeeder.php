<?php

namespace Database\Seeders;

use App\Models\Fakultas;
use App\Models\Jenjang;
use App\Models\Prodi;
use Illuminate\Database\Seeder;

class ProdiSeeder extends Seeder
{
    /**
     * Contoh minimal prodi (Fakultas Teknologi Informasi, jenjang S1).
     * `kode_prodi` = kode manual (contoh mengikuti kode DIKTI); idempoten.
     * Lengkapi / samakan dengan data modul Tracer Study belakangan.
     */
    public function run(): void
    {
        $fakultasId = Fakultas::where('nama_fakultas', 'Fakultas Teknologi Informasi')->value('fakultas_id');
        $jenjangS1 = Jenjang::where('nama_jenjang', 'S1')->value('jenjang_id');

        if (! $fakultasId || ! $jenjangS1) {
            return; // master fakultas/jenjang belum siap
        }

        $prodi = [
            ['kode_prodi' => 57201, 'nama_prodi' => 'Sistem Informasi'],
            ['kode_prodi' => 55201, 'nama_prodi' => 'Informatika'],
            ['kode_prodi' => 56201, 'nama_prodi' => 'Teknik Komputer'],
        ];

        foreach ($prodi as $p) {
            Prodi::firstOrCreate(
                ['kode_prodi' => $p['kode_prodi']],
                [
                    'nama_prodi' => $p['nama_prodi'],
                    'fakultas_id' => $fakultasId,
                    'jenjang_id' => $jenjangS1,
                ]
            );
        }
    }
}
