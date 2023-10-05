<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class permissionPM extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::findByName('Finance'); // Ganti dengan nama peran yang sesuai
        $permissions = ['top-editor']; // Ganti dengan nama izin yang sesuai

        $role->syncPermissions($permissions);
    }
}
