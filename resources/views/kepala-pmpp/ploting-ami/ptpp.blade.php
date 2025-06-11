<!DOCTYPE html>
<html>
<head>
    <title>Form PTPP</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 5px; }
    </style>
</head>
<body>
    <h2>Formulir Permintaan Tindakan Perbaikan dan Pencegahan (PTPP)</h2>

    <p><strong>Unit Kerja:</strong> {{ $audit->unit_kerja }}</p>
    <p><strong>Auditor 1:</strong> {{ $audit->auditor1->name ?? '-' }}</p>
    <p><strong>Auditor 2:</strong> {{ $audit->auditor2->name ?? '-' }}</p>
    <p><strong>Auditee:</strong> {{ $audit->auditee->name ?? '-' }}</p>
    <p><strong>Periode:</strong> {{ $audit->periode->nama ?? '-' }}</p>

    <h3>Temuan Audit:</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Deskripsi Temuan</th>
                <th>Kategori</th>
            </tr>
        </thead>
        <tbody>
            @foreach($audit->temuan ?? [] as $index => $temuan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $temuan->deskripsi }}</td>
                    <td>{{ $temuan->kategori }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top: 40px;">Tanggal Cetak: {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
</body>
</html>
