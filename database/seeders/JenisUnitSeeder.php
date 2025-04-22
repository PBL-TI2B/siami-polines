<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jenis_units')->insert([
            ['jenis_unit_id' => 1, 'nama_jenis_unit' => 'UPT'],
            ['jenis_unit_id' => 2, 'nama_jenis_unit' => 'Jurusan'],
            ['jenis_unit_id' => 3, 'nama_jenis_unit' => 'Prodi'],
        ]);
    }
}
