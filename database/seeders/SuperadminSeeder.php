<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SuperadminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadminRole = Role::where('name', 'superadmin')->first();
        $siswaRole = Role::where('name', 'siswa')->first();
        $pustakawanRole = Role::where('name', 'pustakawan')->first();
        $laboranRole = Role::where('name', 'laboran')->first();

        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@smpn6.com',
            'password' => Hash::make('superadmin'),
            'role_id' => $superadminRole->id,
            'kelas' => null,
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Pustakawan',
            'email' => 'pustakawan@smpn6.com',
            'password' => Hash::make('pustakawan'),
            'role_id' => $pustakawanRole->id,
            'kelas' => null,
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Laboran',
            'email' => 'laboran@smpn6.com',
            'password' => Hash::make('laboran'),
            'role_id' => $laboranRole->id,
            'kelas' => null,
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Siswa Contoh',
            'email' => 'siswacontoh@smpn6.com',
            'password' => Hash::make('siswacontoh'),
            'role_id' => $siswaRole->id,
            'kelas' => '10-A',
            'status' => 'active',
        ]);
    }
}
