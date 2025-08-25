<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $superAdmin = Admin::create([
            'name' => 'super-admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12341234'),
            'role_id' => 1
        ]);
        
    }
}
