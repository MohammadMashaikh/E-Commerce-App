<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'manage-products']);
        Permission::create(['name' => 'view-products']);
        Permission::create(['name' => 'manage-orders']);
        Permission::create(['name' => 'view-orders']);
        Permission::create(['name' => 'manage-users']);
        Permission::create(['name' => 'view-users']);
        Permission::create(['name' => 'manage-roles']);
        Permission::create(['name' => 'view-roles']);
    }
}
