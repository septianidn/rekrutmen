<?php

namespace Database\Seeders;

use App\Models\Posisi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BidangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bidang = [
            [
                'nama_posisi' => 'Manager',
                
            ],
            [
                'nama_posisi' => 'Senior Developer',
                
            ],
            [
                'nama_posisi' => 'Junior Developer',
                
            ],
            [
                'nama_posisi' => 'Kasir',
                
            ],
            [
                'nama_posisi' => 'Kurir',
                
            ],
            [
                'nama_posisi' => 'Operator',
                
            ],
        ];

        foreach ($bidang as $key => $value) {
            $posisi = Posisi::create($value);
        }
    }
}
