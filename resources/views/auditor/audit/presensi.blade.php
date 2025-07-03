
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Hadir Pelaksanaan Audit Mutu Internal</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            background-color: #fff;
            color: #000;
            padding: 1cm;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
        .header-title {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            line-height: 1.5;
            text-decoration: underline;
            margin-bottom: 3em;
            margin-top: 0.5em;
        }
        .info-table {
            border: none;
            border-collapse: collapse;
            margin-bottom: 1.5em;
            font-size: 12pt;
            width: auto;
        }
        .info-table td {
            padding: 2px 4px 2px 0;
            vertical-align: top;
        }
        .info-table td:first-child {
            width: 100px;
            font-weight: 500;
        }
        .main-table {
            width: 100%;
            border: 2px solid #222;
            border-collapse: collapse;
            margin-bottom: 2em;
        }
        .main-table th, .main-table td {
            border: 1px solid #222;
            padding: 10px 8px;
            font-size: 12pt;
        }
        .main-table th {
            text-align: center;
            font-weight: bold;
            background: #f3f4f6;
            letter-spacing: 1px;
        }
        .main-table td {
            min-height: 60px;
            height: 60px;
            vertical-align: middle;
        }
        .main-table td:first-child {
            text-align: center;
            width: 40px;
        }
        .main-table td:nth-child(3),
        .main-table td:nth-child(5) {
            width: 120px;
            text-align: center;
        }
        /* Responsive for print */
        @media print {
            body { padding: 0.5cm; }
            .container { max-width: 100%; }
            .main-table th, .main-table td { font-size: 11pt; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-title">
            DAFTAR HADIR PELAKSANAAN AUDIT MUTU INTERNAL<br>
            POLITEKNIK NEGERI SEMARANG
        </div>
        <table class="info-table">
            <tbody>
                <tr>
                    <td>Hari</td>
                    <td>: {{ \Carbon\Carbon::parse($audit['jadwal_audit'])->translatedFormat('l') }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>
                        : 
                        @if(!empty($audit['jadwal_audit']))
                            {{ \Carbon\Carbon::parse($audit['jadwal_audit'])->translatedFormat('d F Y') }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Unit Kerja</td>
                    <td>: {{ $audit['unitKerja']['nama_unit_kerja'] }}</td>
                </tr>
            </tbody>
        </table>
        <table class="main-table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>AUDITOR</th>
                    <th>TANDA TANGAN</th>
                    <th>AUDITEE</th>
                    <th>TANDA TANGAN</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>{{ data_get($audit, 'auditor1.nama', '-') }}</td>
                    <td></td>
                    <td>{{ data_get($audit, 'auditee1.nama', '-') }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>{{ data_get($audit, 'auditor2.nama', '-') }}</td>
                    <td></td>
                    <td>{{ data_get($audit, 'auditee2.nama', '-') }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <div style="margin-top: 2em; font-size: 11pt; color: #555;">
            <em>Catatan: Silakan tanda tangan pada kolom yang tersedia saat pelaksanaan audit.</em>
        </div>
    </div>
</body>
</html>