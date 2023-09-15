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
        Permission::create(['name' => 'detailOrder-editor']);
        Permission::create(['name' => 'sow-editor']);
        Permission::create(['name' => 'riskIssue-editor']);
        Permission::create(['name' => 'timeline-editor']);
        Permission::create(['name' => 'mandays-editor']);
        Permission::create(['name' => 'documentation-editor']);
        Permission::create(['name' => 'highAndNotes-editor']);
    }
}
