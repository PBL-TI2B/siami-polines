<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kriteria')->insert([
            ['kriteria_id' => 1, 'nama_kriteria' => 'Visi, Misi, Tujuan, Strategi'],
            ['kriteria_id' => 2, 'nama_kriteria' => 'Tata kelola, Tata pamong, dan Kerjasama'],
            ['kriteria_id' => 4, 'nama_kriteria' => ''],
            ['kriteria_id' => 5, 'nama_kriteria' => ''],
            ['kriteria_id' => 6, 'nama_kriteria' => 'Kurikulum dan Pembelajaran'],
            ['kriteria_id' => 7, 'nama_kriteria' => 'Penelitian'],
            ['kriteria_id' => 8, 'nama_kriteria' => ''],
            ['kriteria_id' => 9, 'nama_kriteria' => 'Luaran Tridharma'],
        ]);
    }
}
