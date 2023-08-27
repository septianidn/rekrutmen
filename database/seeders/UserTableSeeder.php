<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role as ModelsRole;

class UserTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'street_addr' => 'Jl. Abscsa',
                'phone_number' => '+12398190255',
                'email_verified_at' => now(),
                'role_id' => 1,
                'status_id' => 1,
            ], 
        ];
        foreach ($users as $key => $value) {
            $user = User::create($value);
            $nameRole = ModelsRole::find($value['role_id']);
            $user->assignRole($nameRole->name);
        }
    }
}
