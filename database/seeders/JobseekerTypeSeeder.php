<?php

namespace Database\Seeders;

use App\Models\JobseekerType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobseekerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobseeker = [
            [
                'jobseekerType' => 'Unand',
                
            ],
            [
                'jobseekerType' => 'Non-Unand',
                
            ],
            
        ];

        foreach ($jobseeker as $key => $value) {
            $tipe = JobseekerType::create($value);
        }
    }
}
