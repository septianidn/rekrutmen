<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionTableSeeder::class,
            RoleTableSeeder::class,
            UserTableSeeder::class,
        ]);

        // Create 6 additional users with different user types
        User::factory(6)->create()->each(function ($user) {
            // Check user_type and assign corresponding role
            if ($user->user_type === 'admin') {
                $user->assignRole('admin');
            } elseif ($user->user_type === 'konselor') {
                $user->assignRole('konselor');
            } elseif ($user->user_type === 'mahasiswa') {
                $user->assignRole('mahasiswa');
            }

            //TODO: TAMBAHIN AJA ROLE YG LAIN
        });
    }
}
