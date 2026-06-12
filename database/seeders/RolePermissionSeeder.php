<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            "Access All Project",
            "Set Target",
            "Target Report",
            "Progress Input",
            "Physical Progress",
            "Progress Report",
            "PME Review",
            "PME Final Report",
            "Access Internal Projects",
            "Access All Internal Projects",
        ];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission],
                ['guard_name' => "web"],
            );
        }

        $role4 = Role::create(['name' => 'Sysqube-Super-Admin']);
        $role4 = Role::create(['name' => 'Super-Admin']);
        $role3 = Role::create(['name' => 'Department-Head']);
        $role3 = Role::create(['name' => 'Department-User']);
        $role3 = Role::create(['name' => 'ED']);
    }
}