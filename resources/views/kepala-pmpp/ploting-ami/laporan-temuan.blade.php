<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Audit Mutu Internal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            margin: 20px;
            background-color: #fff;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }
        .header-table td, .header-table th {
            border: 1.5px solid #444;
            padding: 0;
        }
        .header-logo-cell {
            width: 90px;
            text-align: center;
            vertical-align: middle;
            padding: 6px 0 2px 0;
        }
        .header-logo {
            width: 60px;
            height: 60px;
            object-fit: contain;
            margin-bottom: 2px;
        }
        .header-spmi {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 2px;
            display: block;
        }
        .header-title-cell {
            text-align: center;
            font-weight: bold;
            font-size: 15px;
            letter-spacing: 1px;
            padding: 0;
            line-height: 1.2;
        }
        .header-title-main {
            font-size: 15px;
            font-weight: bold;
            padding-top: 8px;
        }
        .header-title-sub {
            font-size: 15px;
            font-weight: bold;
            padding-bottom: 8px;
        }
        .header-info-label {
            width: 65px;
            background: #fff;
            font-weight: normal;
            font-size: 11pt;
            padding: 3px 6px 3px 6px;
            border-right: 1.5px solid #444;
        }
        .header-info-value {
            width: 110px;
            font-weight: bold;
            font-size: 11pt;
            padding: 3px 10px 3px 6px;
        }
    </style>
</head>
<body>

<!-- HEADER -->
<table class="header-table">
    <tr>
        <!-- Logo -->
        <td class="header-logo-cell" rowspan="4">
            <img src="{{ public_path('logo.png') }}" alt="Logo Polines" class="header-logo"><br>
            <span class="header-spmi">SPMI</span>
        </td>
        <!-- Judul Tengah -->
        <td class="header-title-cell" rowspan="2" style="font-size:16px;">
            FORMULIR PROSEDUR AKADEMIK
        </td>
        <!-- Info Kanan -->
        <td class="header-info-label">No.</td>
        <td class="header-info-value">FPAK.2.01.L.4</td>
    </tr>
    <tr>
        <td class="header-info-label">Revisi</td>
        <td class="header-info-value">3</td>
    </tr>
    <tr>
        <td class="header-title-cell" rowspan="2" style="font-size:16px;">
            LAPORAN AUDIT MUTU INTERNAL
        </td>
        <td class="header-info-label">Tanggal</td>
        <td class="header-info-value">21.12.2017</td>
    </tr>
    <tr>
        <td class="header-info-label">Halaman</td>
        <td class="header-info-value">1/1</td>
    </tr>
</table>

<!-- Judul Laporan -->
<div style="text-align:center; font-weight:bold; font-size:14pt; margin: 15px 0 15px 0; text-decoration: underline;">
    LAPORAN AUDIT MUTU INTERNAL
</div>
<!-- Informasi Laporan -->
<table style="width:100%; border-collapse:collapse; margin-bottom:15px; font-size:11pt;">
    <tr>
        <td style="width:110px;">Jurusan/Prodi/Sub</td>
        <td style="width:10px;">:</td>
        <td>{{ $audit['unitKerja']['nama_unit_kerja'] ?? $audit['unit_kerja']['nama'] ?? '-' }}</td>
        <td style="width:120px;">Tanggal</td>
        <td style="width:10px;">:</td>
        <td>{{ $audit['jadwal_audit'] ?? '-' }}</td>
    </tr>
    <!-- <tr>
        <td>Prodi/Sub</td>
        <td>:</td>
        <td>{{ $audit['unitKerja']['nama_unit_kerja'] ?? '-' }}</td>
        <td></td>
        <td></td>
        <td></td>
    </tr> -->
    <tr>
        <td>Auditee</td>
        <td>:</td>
        <td>
            1. {{ $audit['auditee1']['nama'] ?? '-' }}<br>
            2. {{ $audit['auditee2']['nama'] ?? '-' }}
        </td>
        <td>Tanda Tangan</td>
        <td>:</td>
        <td>
            1. __________________<br>
            2. __________________
        </td>
    </tr>
    <tr>
        <td>Auditor</td>
        <td>:</td>
        <td>
            1. {{ $audit['auditor1']['nama'] ?? '-' }}<br>
            2. {{ $audit['auditor2']['nama'] ?? '-' }}
        </td>
        <td></td>
        <!-- <td>:</td>
        <td>
            1. __________________<br>
            2. __________________
        </td> -->
    </tr>
</table>

<!-- Tabel Temuan -->
<table style="width:100%; border-collapse:collapse; font-size:10pt; margin-top:10px;">
    <thead>
        <tr>
            <th style="width:4%; border:1px solid #000; padding:4px; background:#EFEFEF;">No.</th>
            <th style="width:15%; border:1px solid #000; padding:4px; background:#EFEFEF;">Standar</th>
            <th style="width:41%; border:1px solid #000; padding:4px; background:#EFEFEF;">Uraian Temuan</th>
            <th style="width:15%; border:1px solid #000; padding:4px; background:#EFEFEF;">Kategori Temuan<br>NC/AOC/OFI</th>
            <th style="width:25%; border:1px solid #000; padding:4px; background:#EFEFEF;">Saran Perbaikan</th>
        </tr>
    </thead>
    <tbody>
        @if(!empty($laporanTemuan) && isset($laporanTemuan['data']) && count($laporanTemuan['data']) > 0)
            {{-- Kelompokkan temuan berdasarkan kriteria_id --}}
            @php
                $groupedTemuan = collect($laporanTemuan['data'] ?? [])->groupBy('kriteria_id');
            @endphp
            @if($groupedTemuan->count() > 0)
                @foreach($groupedTemuan as $kriteriaId => $temuanGroup)
                    <tr style="font-weight:bold; background:#FFFFCC;">
                        <td colspan="5" style="border:1px solid #000; padding:4px;">
                            Kriteria {{ $temuanGroup->first()['kriteria_nama'] ?? $kriteriaId ?? '-' }}
                        </td>
                    </tr>
                    @foreach($temuanGroup as $i => $temuan)
                        <tr>
                            <td style="border:1px solid #000; padding:4px; text-align:center;">{{ $i+1 }}</td>
                            <td style="border:1px solid #000; padding:4px;">{{ $temuan['nama_kriteria'] ?? 'Kriteria' }}</td>
                            <td style="border:1px solid #000; padding:4px;">{{ $temuan['uraian_temuan'] ?? '-' }}</td>
                            <td style="border:1px solid #000; padding:4px; text-align:center;">{{ $temuan['kategori_temuan'] ?? '-' }}</td>
                            <td style="border:1px solid #000; padding:4px;">{{ $temuan['saran_perbaikan'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                @endforeach
            @else
                <tr>
                    <td colspan="5" style="border:1px solid #000; padding:4px; text-align:center;">Tidak ada data temuan.</td>
                </tr>
            @endif
        @else
            <tr>
                <td colspan="5" style="border:1px solid #000; padding:4px; text-align:center;">Tidak ada data temuan.</td>
            </tr>
        @endif
        
    </tbody>
</table>

<!-- Footer Definitions -->
<div style="margin-top:20px; font-size:9.5pt; text-align:left; line-height:1.4;">
    <p><b>NC (Non-Conformity)</b> adalah temuan yang bersifat ketidaksesuaian mayor, yaitu temuan-temuan yang memiliki dampak luas/kritikal terhadap persyaratan mutu produk/pelayanan dan persyaratan sistem manajemen mutu.</p>
    <p style="padding-left: 20px;">Contoh: Pelanggaran sistem secara total (sistem tidak dilaksanakan).</p>
    <p><b>AOC (Area of Concern)</b> adalah temuan yang bersifat ketidaksesuaian minor, yaitu temuan-temuan yang memiliki dampak kecil/terbatas terhadap persyaratan mutu produk/pelayanan dan persyaratan sistem manajemen mutu.</p>
    <p style="padding-left: 20px;">Contoh: ketidaksempurnaan dan ketidakkonsistenan dalam penerapan sistem.</p>
    <p><b>OFI (Opportunity for Improvement)</b> adalah temuan yang bukan merupakan ketidaksesuaian yang dimaksudkan untuk penyempurnaan-penyempurnaan.</p>
    <br>
    <p>** hanya diisi bila auditor dapat memastikan saran perbaikannya adalah efektif.</p>
</div>

</body>
</html>