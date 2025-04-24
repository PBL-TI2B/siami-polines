<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'role_id' => 1,
            'unit_kerja_id' => 1,
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123456'), // menggunakan hash
            'nama' => 'admin',
            'nip' => '1234567890', // pastikan unik
        ]);

    }
}
