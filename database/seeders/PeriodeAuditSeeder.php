<?php

namespace Database\Seeders;

use App\Models\PeriodeAudit;
use Illuminate\Database\Seeder;

class PeriodeAuditSeeder extends Seeder
{
    public function run(): void
    {
        $periodes = [
            [
                'nama_periode' => 'AMI 2023',
                'tanggal_mulai' => '2023-10-15',
                'tanggal_berakhir' => '2023-11-03',
                'status' => 'Berakhir',
            ],
            [
                'nama_periode' => 'AMI 2024',
                'tanggal_mulai' => '2024-10-21',
                'tanggal_berakhir' => '2024-11-08',
                'status' => 'Berakhir',
            ],
            [
                'nama_periode' => 'AMI 2025',
                'tanggal_mulai' => '2025-10-20',
                'tanggal_berakhir' => '2025-11-07',
                'status' => 'Sedang Berjalan',
            ],
        ];

        foreach ($periodes as $periode) {
            PeriodeAudit::create($periode);
        }
    }
}
