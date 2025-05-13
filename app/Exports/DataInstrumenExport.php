<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Http;

class DataInstrumenExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        // Ambil data dari API
        $response = Http::get('http://127.0.0.1:5000/api/data-instrumen');
        $data = $response->json();

        if (!$data || !is_array($data)) {
            return [];
        }

        $rows = [];
        $rowNumber = 1;

        // Loop melalui setiap sasaran strategis
        foreach ($data as $sasaran) {
            $sasaranName = $sasaran['nama_sasaran'] ?? 'N/A';
            $isFirstRowForSasaran = true;

            // Hitung jumlah baris untuk rowspan (sama seperti di index.blade.php)
            $rowspanCount = 0;
            foreach ($sasaran['indikator_kinerja'] as $indikator) {
                $rowspanCount += count($indikator['aktivitas']);
            }

            // Loop melalui setiap indikator kinerja
            foreach ($sasaran['indikator_kinerja'] as $indikator) {
                $indikatorName = $indikator['isi_indikator_kinerja'] ?? 'N/A';
                $isFirstRowForIndikator = true;

                // Hitung rowspan untuk indikator kinerja
                $indikatorRowspan = count($indikator['aktivitas']);

                // Loop melalui setiap aktivitas
                foreach ($indikator['aktivitas'] as $aktivitas) {
                    $row = [];

                    // Kolom "No" hanya ditambahkan pada baris pertama sasaran
                    if ($isFirstRowForSasaran) {
                        $row[] = $rowNumber;
                    } else {
                        $row[] = ''; // Kosongkan untuk baris berikutnya
                    }

                    // Kolom "Sasaran Strategis" hanya ditambahkan pada baris pertama sasaran
                    if ($isFirstRowForSasaran) {
                        $row[] = $sasaranName;
                    } else {
                        $row[] = ''; // Kosongkan untuk baris berikutnya
                    }

                    // Kolom "Indikator Kinerja" hanya ditambahkan pada baris pertama indikator
                    if ($isFirstRowForIndikator) {
                        $row[] = $indikatorName;
                    } else {
                        $row[] = ''; // Kosongkan untuk baris berikutnya
                    }

                    // Kolom "Aktivitas", "Satuan", dan "Target" selalu diisi
                    $row[] = $aktivitas['nama_aktivitas'] ?? 'N/A';
                    $row[] = $aktivitas['satuan'] ?? 'N/A';
                    $row[] = $aktivitas['target'] ?? 0;

                    $rows[] = $row;

                    $isFirstRowForSasaran = false;
                    $isFirstRowForIndikator = false;
                }
            }

            $rowNumber++;
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'No',
            'Sasaran Strategis',
            'Indikator Kinerja',
            'Aktivitas',
            'Satuan',
            'Target',
        ];
    }
}