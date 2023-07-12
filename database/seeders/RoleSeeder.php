<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'ADMIN']);
        $general = Role::create(['name' => 'GENERAL']);

        Permission::create(['name' => 'dashboard'])->syncRoles([$admin, $general]);

        Permission::create(['name' => 'projects.index'])->syncRoles([$admin, $general]);
        Permission::create(['name' => 'projects.create'])->assignRole($admin);
        Permission::create(['name' => 'projects.edit'])->assignRole($admin);
        Permission::create(['name' => 'projects.destroy'])->assignRole($admin);

        Permission::create(['name' => 'users'])->assignRole($admin);

        Permission::create(['name' => 'task.index'])->syncRoles([$admin, $general]);
    }
}
