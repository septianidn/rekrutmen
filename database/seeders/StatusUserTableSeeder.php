<?php

namespace Database\Seeders;

use App\Models\StatusUser;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class StatusUserTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $status = [
            [
                'status' => 'active',   
            ],
            [
                'status' => 'pending',   
            ],
            [
                'status' => 'block',
            ],
            [
                'status' => 'inactive',
            ],
           
        ];

        foreach ($status as $value) {
            StatusUser::create($value);
        }
    }
}
