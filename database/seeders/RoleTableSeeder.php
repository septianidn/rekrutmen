<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'admin',
                'title' => 'Admin',
                'status' => 1,
                'permissions' => ['role','role-add', 'role-list', 'permission', 'permission-add', 'permission-list']
            ],
            [
                'name' => 'konselor',
                'title' => 'Konselor',
                'status' => 1,
                'permissions' => []
            ],
            [
                'name' => 'mahasiswa',
                'title' => 'Mahasiswa',
                'status' => 1,
                'permissions' => []
            ],
            [
                'name' => 'employer',
                'title' => 'Employer',
                'status' => 1,
                'permissions' => []
            ]
        ];

        foreach ($roles as $key => $value) {
            $permission = $value['permissions'];
            unset($value['permissions']);
            $role = Role::create($value);
            $role->givePermissionTo($permission);
        }
    }
}
