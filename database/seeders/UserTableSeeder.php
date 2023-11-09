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
                'last_name' => 'UPT',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'street_addr' => 'Jl. Abscsa',
                'phone_number' => '829249233223',
                'email_verified_at' => now(),
                'user_type' => 'admin',
                'status' => 'active',
            ],
            [
                'first_name' => 'Konselor',
                'last_name' => 'UPT',
                'email' => 'konselor@example.com',
                'password' => bcrypt('password'),
                'street_addr' => 'Jl. Konselor',
                'phone_number' => '89438484556',
                'email_verified_at' => now(),
                'user_type' => 'konselor',
                'status' => 'active',
            ],
            [
                'first_name' => 'Mahasiswa',
                'last_name' => 'Unand',
                'email' => 'mahasiswa@example.com',
                'password' => bcrypt('password'),
                'street_addr' => 'Jl. Mahasiswa',
                'phone_number' => '894384838386',
                'email_verified_at' => now(),
                'user_type' => 'mahasiswa',
                'status' => 'active',
            ],
        ];
        foreach ($users as $key => $value) {
            $user = User::create($value);
            $user->assignRole($value['user_type']);
        }
    }
}
