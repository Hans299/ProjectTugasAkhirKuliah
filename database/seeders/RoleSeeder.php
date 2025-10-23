<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use app\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name'=>'superadmin']);
        Role::create(['name'=>'pustakawam']);
        Role::create(['name'=>'laboran']);
        Role::create(['name'=>'siswa']);
        
    }
}
