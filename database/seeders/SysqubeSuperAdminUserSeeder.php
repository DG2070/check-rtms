<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SysqubeSuperAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Sysqube',
            'email' => 'admin@sysqube.com',
            'password' => bcrypt('secret!@#123')
        ]);

        $role = Role::where("name", "Sysqube-Super-Admin")->first();
        $user->assignRole([$role->id]);
    }
}