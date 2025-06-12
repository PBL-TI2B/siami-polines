@php
    // Contoh sederhana, silakan sesuaikan dengan kebutuhan data laporan temuan
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Temuan</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h1>Laporan Temuan Audit</h1>
    <table>
        <tr>
            <th>Unit Kerja</th>
            <td>{{ $audit->unitKerja->nama_unit_kerja ?? '-' }}</td>
        </tr>
        <tr>
            <th>Periode</th>
            <td>{{ $audit->periode->nama_periode ?? '-' }}</td>
        </tr>
        <tr>
            <th>Auditor 1</th>
            <td>{{ $audit->auditor1->nama ?? '-' }}</td>
        </tr>
        <tr>
            <th>Auditor 2</th>
            <td>{{ $audit->auditor2->nama ?? '-' }}</td>
        </tr>
        <tr>
            <th>Auditee 1</th>
            <td>{{ $audit->auditee1->nama ?? '-' }}</td>
        </tr>
        <tr>
            <th>Auditee 2</th>
            <td>{{ $audit->auditee2->nama ?? '-' }}</td>
        </tr>
        <tr>
            <th>Waktu Audit</th>
            <td>{{ $audit->jadwal_audit ? \Carbon\Carbon::parse($audit->jadwal_audit)->format('d F Y') : '-' }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>Laporan Temuan</td>
        </tr>
    </table>
    <h2 style="margin-top:30px;">Temuan Audit</h2>
    <p>Silakan tambahkan detail temuan audit di sini.</p>
</body>
</html>
