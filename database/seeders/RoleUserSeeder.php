<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $SuperAdm = User::create([
            'name' => 'M. SALMAN AL-FARISI',
            'username' => 'salmanAlf',
            'password' => bcrypt('12345678'),
            'status' => 'ACTIV'
        ]);

        $SuperAdm->assignRole('SuperAdm');

        $BOD = User::create([
            'name' => '2 M. SALMAN AL-FARISI',
            'username' => 'salmanBOD',
            'password' => bcrypt('12345678'),
            'status' => 'ACTIV'
        ]);

        $BOD->assignRole('BOD');
    }
}
