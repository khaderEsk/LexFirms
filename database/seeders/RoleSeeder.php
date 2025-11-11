<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = Role::create(['name' => 'superAdmin']); // Hande and fadi
        $adminRole = Role::create(['name' => 'admin']); // walaa
        $majorRole = Role::create(['name' => 'major']);
        $accountantRole = Role::create(['name' => 'accountant']);
        $lawyerRole = Role::create(['name' => 'lawyer']);
        $permissions = [
            'create-case',
            'edit-case',
            'view-case',
            'create-lawyer',
            'edit-lawyer',
            'view-lawyer',
            'block-lawyer',
            'create-client',
            'view-client'
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $superAdminRole->givePermissionTo($permissions);
        $adminRole->givePermissionTo([
            'create-lawyer',
            'edit-lawyer',
            'view-lawyer',
            'block-lawyer',
            'view-case',
            'view-client'
        ]);
        $majorRole->givePermissionTo([
            'create-case',
            'edit-case',
            'view-case',
            'view-lawyer',
            'create-client',
        ]);
        $accountantRole->givePermissionTo([
            'view-case',
            'view-lawyer',
        ]);
        $lawyerRole->givePermissionTo([
            'create-case',
            'edit-case',
            'view-client',
            'view-lawyer',
        ]);
    }
}
