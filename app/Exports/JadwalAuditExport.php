<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JadwalAuditExport implements FromCollection, WithHeadings
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

    public function headings(): array
    {
        return [
            'Unit Kerja',
            'Waktu Audit',
            'Auditee 1',
            'Auditee 2',
            'Auditor 1',
            'Auditor 2',
            'Status',
        ];
    }
}