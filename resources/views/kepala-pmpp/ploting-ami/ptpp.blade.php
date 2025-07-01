<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            margin: 20mm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 15px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .header-table td, .header-table th {
            border: 2px solid #444;
            padding: 0;
        }
        .header-logo-cell {
            width: 110px;
            text-align: center;
            vertical-align: middle;
            padding: 8px 0 4px 0;
        }
        .header-logo {
            width: 60px;
            height: 60px;
            object-fit: contain;
            margin-bottom: 4px;
        }
        .header-title-cell {
            text-align: center;
            font-weight: bold;
            font-size: 20px;
            letter-spacing: 1px;
            padding: 4px 0 2px 0;
        }
        .header-subtitle-cell {
            text-align: center;
            font-weight: bold;
            font-size: 19px;
            letter-spacing: 1px;
            padding: 2px 0 4px 0;
        }
        .header-info-label {
            width: 70px;
            font-weight: normal;
            padding-left: 8px;
        }
        .header-info-value {
            font-weight: bold;
            padding-right: 8px;
        }
        .laporan-info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 15px;
        }
        .laporan-info-table td {
            border: none;
            padding: 2px 8px;
        }
        .laporan-info-label {
            width: 160px;
        }
        .laporan-main-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 15px;
            margin-top: 10px;
        }
        .laporan-main-table th, .laporan-main-table td {
            border: 2px solid #222;
            padding: 6px 6px;
            vertical-align: top;
        }
        .laporan-main-table th {
            text-align: center;
            font-weight: bold;
            background: #f8f8f8;
        }
        .laporan-main-table .kriteria {
            font-weight: bold;
            color: #b38b00;
            background: #ffffe0;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

@foreach ($laporanTemuan as $index => $temuan)
    <!-- Header Table -->
    <table class="header-table">
        <tr>
            <td rowspan="4" class="header-logo-cell">
                <img src="{{ public_path('logo.png') }}" class="header-logo">
            </td>
            <td colspan="5" rowspan="4" class="header-title-cell">
                <strong>FORMULIR PROSEDUR AKADEMIK</strong><br>
                <strong>PERMINTAAN TINDAKAN PERBAIKAN DAN PENCEGAHAN</strong>
            </td>
            <td class="header-info-label"><strong>No FPM</strong></td>
            <td class="header-info-value">43.12</td>
        </tr>
        <tr>
            <td class="header-info-label"><strong>Revisi</strong></td>
            <td class="header-info-value">Revisi 1</td>
        </tr>
        <tr>
            <td class="header-info-label"><strong>Tanggal</strong></td>
            <td class="header-info-value">{{ now()->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td class="header-info-label"><strong>Halaman</strong></td>
            <td class="header-info-value">{{ $index + 1 }}/{{ count($laporanTemuan) }}</td>
        </tr>
    </table>

    <!-- Info Table -->
    <table class="laporan-info-table">
        <tr>
            <td class="laporan-info-label">Kepada Yth.</td>
            <td>: {{ $audit['auditee1']['nama'] }}</td>
            <td class="laporan-info-label">Tanggal</td>
            <td>: {{ now()->locale('id')->isoFormat('MMMM Y') }}</td>
        </tr>
        <tr>
            <td>Jur/Bag/Unit</td>
            <td>: {{ $audit['unitKerja']['nama_unit_kerja'] }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Dari</td>
            <td>: Kepala PPM/PP</td>
            <td>Halaman</td>
            <td>: {{ $index + 1 }}/{{ count($laporanTemuan) }}</td>
        </tr>
    </table>

    <!-- Main Table -->
    <table class="laporan-main-table">
        <tr>
            <td colspan="2" width="12.5%">Standar no</td>
            <td colspan="2" width="50%">: 
                {{ $temuan['response_tilik']['standar_nasional'] }}
            </td>
            <td colspan="2" width="12.5%">Prosedur/Proses</td>
            <td colspan="2">: {{ $temuan['kriteria']['nama_kriteria'] }}</td>
        </tr>
        <tr>
            <td colspan="8">Hasil Temuan Ketidaksesuaian:<br>{{ $temuan['uraian_temuan'] }}<br></td>
        </tr>
        <tr>
            <td colspan="2">Kategori Temuan</td>
            <td colspan="2">: {{ $temuan['kategori_temuan'] }}</td>
            <td colspan="2">Tanggal Perbaikan</td>
            <td colspan="2">: {{ now()->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td>Auditor</td>
            <td>Nama:</td>
            <td colspan="2">1. {{ optional($audit['auditor1'])['nama'] ?? '-' }} <br>2. {{ optional($audit['auditor2'])['nama'] ?? '-' }}</td>
            <td>Auditee</td>
            <td>Nama:</td>
            <td colspan="2">1. {{ optional($audit['auditee1'])['nama'] ?? '-' }} <br>2. {{ optional($audit['auditee2'])['nama'] ?? '-' }}</td>
        </tr>
        <tr>
            <td colspan="8">Analisa Penyebab:<br>{{ $temuan['response_tilik']['akar_penyebab_penunjang'] }}<br><br><br><br></td>
        </tr>
        <tr>
            <td colspan="8">Tindakan Perbaikan:<br>{{ $temuan['response_tilik']['rencana_perbaikan_tindak_lanjut'] }}<br></td>
        </tr>
        <tr>
            <td colspan="8">Tindakan Pencegahan:<br>{{ $temuan['response_tilik']['tindakan_pencegahan'] }}<br><br><br><br></td>
        </tr>
        <tr>
            <td colspan="2">Kategori Temuan</td>
            <td colspan="2">: {{ $temuan['kategori_temuan'] }}</td>
            <td colspan="2">Tanggal Perbaikan</td>
            <td colspan="2">: {{ now()->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td colspan="8">Pemeriksaan Hasil Tindakan Perbaikan (close out):<br>{{ $temuan['saran_perbaikan'] }}<br><br><br></td>
        </tr>
        <tr>
            <td colspan="2">Hasil Verifikasi</td>
            <td colspan="2">: Sesuai/Tidak Sesuai</td>
            <td colspan="2">Rekomendasi</td>
            <td colspan="2">{{ $audit['rtm'] }}</td>
        </tr>
        <tr>
            <td>Auditor</td>
            <td>Nama:</td>
            <td>1. {{ optional($audit['auditor1'])['nama'] ?? '-' }} <br>2. {{ optional($audit['auditor2'])['nama'] ?? '-' }}</td>
            <td>TT.......<br>TT........</td>
            <td>Auditee</td>
            <td>Nama:</td>
            <td>1. {{ optional($audit['auditee1'])['nama'] ?? '-' }} <br>2. {{ optional($audit['auditee2'])['nama'] ?? '-' }}</td>
            <td>TT.......<br>TT........</td>
        </tr>
    </table>

    <!-- Add page break except for the last item -->
    @if ($index < count($laporanTemuan) - 1)
        <div class="page-break"></div>
    @endif
@endforeach

</body>
</html>