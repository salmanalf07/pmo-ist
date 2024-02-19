<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionNames = ['customers-editor', 'departments-editor', 'divisions-editor', 'doctypes-editor', 'skilllevels-editor', 'solutions-editor', 'specializations-editor', 'roles-editor', 'users-editor', 'taxes'];

        foreach ($permissionNames as $name) {
            Permission::create(['name' => $name]);
        }
    }
}
