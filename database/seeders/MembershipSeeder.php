<?php

namespace Database\Seeders;

use App\Models\Membership;
use Illuminate\Database\Seeder;

class MembershipSeeder extends Seeder
{
    public function run(): void
    {
        $tiers = [
            [
                'nama_membership' => 'Paket Lowongan',
                'harga' => 500000,
                'durasi_hari' => 365,
                'can_post_job' => true,
                'can_post_article' => false,
                'deskripsi' => 'Akses untuk memposting lowongan kerja selama 1 tahun.',
            ],
            [
                'nama_membership' => 'Paket Artikel',
                'harga' => 300000,
                'durasi_hari' => 365,
                'can_post_job' => false,
                'can_post_article' => true,
                'deskripsi' => 'Akses untuk memublikasikan artikel selama 1 tahun. Setiap artikel ditinjau oleh admin sebelum tayang.',
            ],
            [
                'nama_membership' => 'Paket Lengkap',
                'harga' => 700000,
                'durasi_hari' => 365,
                'can_post_job' => true,
                'can_post_article' => true,
                'deskripsi' => 'Akses penuh untuk memposting lowongan dan artikel selama 1 tahun.',
            ],
        ];

        foreach ($tiers as $tier) {
            Membership::updateOrCreate(
                ['nama_membership' => $tier['nama_membership']],
                $tier,
            );
        }
    }
}
