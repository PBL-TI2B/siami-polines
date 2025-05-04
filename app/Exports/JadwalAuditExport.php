<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class JadwalAuditExport implements FromCollection, WithStyles, WithEvents, ShouldAutoSize
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function styles(Worksheet $sheet)
    {
        // Judul di baris 1
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', 'JADWAL AUDIT');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Header di baris 2
        $headers = [
            'Unit Kerja',
            'Waktu Audit',
            'Auditee 1',
            'Auditee 2',
            'Auditor 1',
            'Auditor 2',
            'Status',
        ];
        $sheet->fromArray($headers, null, 'A2', true);

        $sheet->getStyle('A2:G2')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFF']],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center', 'wrapText' => true],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['argb' => 'FF0E5C84'], // Kuning
            ],
        ]);
        $sheet->getRowDimension(2)->setRowHeight(25);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Freeze heading row (row 2)
                $sheet->freezePane('A3');

                // Geser data ke baris ke-3 (karena A1 = judul, A2 = header)
                $startRow = 3;
                foreach ($this->data as $index => $row) {
                    $sheet->fromArray(array_values((array)$row), null, 'A' . ($startRow + $index));
                }

                // Border semua isi
                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle("A2:G{$highestRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);
            },
        ];
    }
}
