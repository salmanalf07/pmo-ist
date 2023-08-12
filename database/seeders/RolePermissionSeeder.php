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
        Permission::create(['name' => 'bisa-lihat']);
        Permission::create(['name' => 'bisa-tambah']);
        Permission::create(['name' => 'bisa-ubah']);
        Permission::create(['name' => 'bisa-hapus']);


        Role::create(['name' => 'SuperAdm']);
        Role::create(['name' => 'Finance']);
        Role::create(['name' => 'BOD']);
        Role::create(['name' => 'PM']);
        Role::create(['name' => 'Sales']);
        Role::create(['name' => 'Sponsor']);

        $roleSuperAdm = Role::findByName('SuperAdm');
        $roleSuperAdm->givePermissionTo('bisa-lihat');
        $roleSuperAdm->givePermissionTo('bisa-tambah');
        $roleSuperAdm->givePermissionTo('bisa-ubah');
        $roleSuperAdm->givePermissionTo('bisa-hapus');

        $roleBOD = Role::findByName('BOD');
        $roleBOD->givePermissionTo('bisa-lihat');
    }
}
