<?php

namespace Database\Seeders;

use App\Models\IndustriType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IndustriTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $industri = [
            [
                'nama_industri' => 'IT',
                
            ],
            [
                'nama_industri' => 'Pajak',
                
            ],
            [
                'nama_industri' => 'Ekonomi',
                
            ],
            [
                'nama_industri' => 'Tambang',
                
            ],
            [
                'nama_industri' => 'Ekspedisi',
                
            ],
            [
                'nama_industri' => 'Marketing',
                
            ],
        ];

        foreach ($industri as $key => $value) {
            $tipe = IndustriType::create($value);
        }
    }
}
