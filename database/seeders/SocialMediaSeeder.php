<?php

namespace Database\Seeders;

use App\Models\SocialMedia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sosmed = [
            [
                'platform_social_media' => 'Facebook',
                
            ],
            [
                'platform_social_media' => 'Linked IN',
                
            ],
            [
                'platform_social_media' => 'Instagram',
                
            ],
            [
                'platform_social_media' => 'Twitter/X',
                
            ],
            [
                'platform_social_media' => 'Youtube',
                
            ],
            [
                'platform_social_media' => 'TikTok',
                
            ],
        ];

        foreach ($sosmed as $key => $value) {
            $socmed = SocialMedia::create($value);
        }
    }
}
