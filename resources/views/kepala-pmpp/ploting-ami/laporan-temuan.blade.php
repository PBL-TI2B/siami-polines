<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Audit Mutu Internal</title>
    <style>
        /* General body styling */
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            margin: 20px;
            background-color: #fff;
        }

        /* Header Table Styling */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .header-table td {
            border: 1px solid #000;
            padding: 2px 8px;
            vertical-align: middle;
        }

        .header-logo-cell {
            width: 100px;
            text-align: center;
        }

        .header-logo {
            width: 60px;
            height: auto;
            margin-bottom: 4px;
        }

        .header-spmi {
            font-weight: bold;
            font-size: 12px;
            display: block;
        }

        .header-title-cell {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            line-height: 1.2;
        }
        
        .header-subtitle-cell {
            font-size: 15px;
        }

        .header-info-cell {
            font-size: 11pt;
            padding: 4px 8px;
        }
        
        .header-info-cell .label {
            display: inline-block;
            width: 60px;
        }

        /* Main Title */
        .laporan-title {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            margin: 15px 0 15px 0;
            text-decoration: underline;
        }

        /* Information Table Styling */
        .laporan-info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 11pt;
        }

        .laporan-info-table td {
            padding: 1px 4px;
            vertical-align: top;
        }

        .laporan-info-label {
            width: 110px;
        }
        
        .laporan-info-colon {
            width: 10px;
        }

        /* Main Content Table Styling */
        .laporan-main-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt; /* Adjusted for more content */
            margin-top: 10px;
        }

        .laporan-main-table th, .laporan-main-table td {
            border: 1px solid #000;
            padding: 4px;
            vertical-align: top;
            text-align: left;
        }

        .laporan-main-table th {
            text-align: center;
            font-weight: bold;
            background-color: #EFEFEF;
        }

        .laporan-main-table .kriteria-row td {
            font-weight: bold;
            background-color: #FFFFCC;
        }

        .laporan-main-table .center-align {
            text-align: center;
        }
        
        .laporan-main-table .standar-col {
             white-space: nowrap;
        }

        /* Footer Definitions Styling */
        .footer-definitions {
            margin-top: 20px;
            font-size: 9.5pt;
            text-align: left;
            line-height: 1.4;
        }

        .footer-definitions p {
            margin: 2px 0;
        }

        .footer-definitions b {
            font-size: 10pt;
        }

    </style>
</head>
<body>

<!-- Header Section -->
<table class="header-table">
    <tr>
        <td class="header-logo-cell" rowspan="2">
            <!-- LOGO DIUBAH DI SINI -->
            <img src="{{ asset('public/logo.png') }}" alt="Logo Polines" class="header-logo">
            <span class="header-spmi">SPMI</span>
        </td>
        <td class="header-title-cell" rowspan="2">
            FORMULIR PROSEDUR AKADEMIK<br>
            <span class="header-subtitle-cell">LAPORAN AUDIT MUTU INTERNAL</span>
        </td>
        <td class="header-info-cell">
            <span class="label">No.</span>: FPAK.2.01.L.4
        </td>
    </tr>
    <tr>
        <td class="header-info-cell">
            <span class="label">Revisi</span>: 3
        </td>
    </tr>
     <tr>
        <td colspan="2" style="border:none; border-right:1px solid #000;"></td>
        <td class="header-info-cell">
            <span class="label">Tanggal</span>: 21.12.2017
        </td>
    </tr>
    <tr>
       <td colspan="2" style="border:none; border-right:1px solid #000;"></td>
        <td class="header-info-cell">
            <span class="label">Halaman</span>: 1/1
        </td>
    </tr>
</table>


<div class="laporan-title">LAPORAN AUDIT MUTU INTERNAL</div>

<!-- Information Section with Dummy Data -->
<table class="laporan-info-table">
    <tr>
        <td class="laporan-info-label">Jur./Bag./Unit</td>
        <td class="laporan-info-colon">:</td>
        <td>D3 Informatika</td>
        <td class="laporan-info-label" style="width: 120px;">Tanggal</td>
        <td class="laporan-info-colon">:</td>
        <td>2 November 2022</td>
    </tr>
    <tr>
        <td class="laporan-info-label">Prodi/Sub</td>
        <td class="laporan-info-colon">:</td>
        <td>-</td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td class="laporan-info-label">Auditee</td>
        <td class="laporan-info-colon">:</td>
        <td>1. Idhawati Hestiningsih</td>
        <td class="laporan-info-label" style="width: 120px;">Tanda Tangan</td>
        <td class="laporan-info-colon">:</td>
        <td>1. __________________</td>
    </tr>
    <tr>
        <td class="laporan-info-label">Auditor</td>
        <td class="laporan-info-colon">:</td>
        <td>
            1. Suryani Sri Lestari<br>
            2. Marliyati
        </td>
        <td></td>
        <td class="laporan-info-colon">:</td>
        <td>
            1. __________________<br>

            2. __________________
        </td>
    </tr>
</table>

<!-- Main Content Table with Dummy Data -->
<table class="laporan-main-table">
    <thead>
        <tr>
            <th style="width:4%;">No.</th>
            <th style="width:15%;">Standar</th>
            <th style="width:41%;">Uraian Temuan</th>
            <th style="width:15%;">Kategori Temuan<br>NC/AOC/OFI</th>
            <th style="width:25%;">Saran Perbaikan</th>
        </tr>
    </thead>
    <tbody>
        <!-- Contoh Grup Kriteria 1 -->
        <tr class="kriteria-row">
            <td colspan="5">Kriteria 1</td>
        </tr>
        <tr>
            <td class="center-align">1</td>
            <td class="standar-col">LKPS C.1.4</td>
            <td>Dokumen mekanisme dan keterlibatan pemangku kepentingan dalam penyusunan VMTS belum ditunjukkan.</td>
            <td class="center-align">AOC</td>
            <td>Lengkapi dokumen pendukung.</td>
        </tr>
         <tr>
            <td class="center-align">2</td>
            <td class="standar-col">LKPS C.1.4</td>
            <td>Survei pemahaman VMTS oleh seluruh pemangku kepentingan belum dilakukan.</td>
            <td class="center-align">NC</td>
            <td>Segera laksanakan survei pemahaman VMTS.</td>
        </tr>

        <!-- Contoh Grup Kriteria 4 -->
        <tr class="kriteria-row">
            <td colspan="5">Kriteria 4</td>
        </tr>
        <tr>
            <td class="center-align">3</td>
            <td class="standar-col">LKPS C.4.4</td>
            <td>Pemenuhan Dosen dengan kualifikasi S3 baru 9% dari target 30%.</td>
            <td class="center-align">OFI</td>
            <td>Perlu peran Institusi untuk memotivasi dosen studi lanjut.</td>
        </tr>
    </tbody>
</table>

<!-- Footer Definitions -->
<div class="footer-definitions">
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
