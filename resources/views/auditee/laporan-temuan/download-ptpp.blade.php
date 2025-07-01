<!DOCTYPE html>
<html>

<head>
    <title>Permintaan Tindakan Perbaikan dan Pencegahan</title>
    <style>
        @page {
            margin: 15mm;
            size: A4;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            color: #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .bold {
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }

        .header-table {
            border: 2px solid #000;
            margin-bottom: 15px;
            width: 100%;
            table-layout: fixed;
        }

        .header-table>tbody>tr>td {
            vertical-align: middle;
            padding: 0;
        }

        .header-logo-cell {
            width: 16%;
            padding: 5px;
            text-align: center;
            vertical-align: middle;
            border-right: 2px solid #000;
        }

        .logo {
            margin-top: 4px;
            width: 75px;
            height: auto;
            margin-bottom: 4px;
        }

        .header-title-cell {
            width: 55%;
            vertical-align: middle;
            border-right: 2px solid #000;
        }

        .header-info-wrapper {
            width: 30%;
            vertical-align: middle;
        }

        .info-header-table {
            width: 100%;
            height: auto;
        }

        .info-header-table td {
            border: none;
            border-bottom: 2px solid #000;
            font-size: 12pt;
            padding: 5px 8px;
            vertical-align: middle;
        }

        .info-header-table tr:last-child td {
            border-bottom: none;
        }

        .info-header-table td:first-child {
            width: 1%;
            white-space: nowrap;
            border-right: 2px solid #000;
        }

        .recipient-table {
            margin-bottom: 5px;
        }

        .recipient-table td {
            padding: 1.5px 2px;
            border: none;
        }

        .content-table {
            border: 1px solid #000;
        }

        .content-table td {
            border: 1px solid #000;
            padding: 5px 8px;
            vertical-align: top;
        }

        .signature-area {
            height: 60px;
        }
    </style>
</head>

<body>

    @foreach ($laporanTemuan as $index => $temuan)
    <div class="page-container">
        <table class="header-table">
            <tr>
                <td class="header-logo-cell">
                    <img src="{{ public_path('logo_white.png') }}" alt="Logo" class="logo"><br>
                    <span class="bold">SPMI</span>
                </td>
                <td class="header-title-cell">
                    <table style="width:100%; border-collapse:collapse;">
                        <tr>
                            <td
                                style="border-bottom:2px solid #000; text-align:center; font-weight:bold; font-size:14pt; padding:0;">
                                PROSEDUR AKADEMIK
                            </td>
                        </tr>
                        <tr>
                            <td
                                style="text-align:center; font-weight:bold; font-size:14pt; padding:16px; line-height: 1.4;">
                                PERMINTAAN TINDAKAN PERBAIKAN DAN PENCEGAHAN
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="header-info-wrapper">
                    <table class="info-header-table">
                        <tr class="bold">
                            <td>No.</td>
                            <td>FPAk.2.04.L.1</td>
                        </tr>
                        <tr>
                            <td>Revisi</td>
                            <td>3</td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>21.12.2017</td>
                        </tr>
                        <tr>
                            <td>Halaman</td>
                            <td> {{ $loop->iteration }} / {{ $loop->count }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table class="recipient-table" style="margin-top: 10px; margin-bottom: 10px;">
            <tr>
                <td style="width: 100px;">Kepada. Yth</td>
                <td>: {{ $audit['auditee1']['nama'] ?? '-' }}</td>
                <td style="width: 50px; text-align:right;">Tanggal</td>
                <td style="width: 120px;">: &nbsp;&nbsp;&nbsp;
                    {{ \Carbon\Carbon::now()->locale('id')->isoFormat('MMMM Y') }}</td>
            </tr>
            <tr>
                <td>Jur/Bag/Unit</td>
                <td colspan="3">: {{ $audit['unitKerja']['nama_unit_kerja'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>Dari</td>
                <td class="bold">: Kepala P4M</td>
                <td style="width: 50px; text-align:right;">Halaman</td>
                <td style="width: 120px;">: {{ $loop->iteration }} / {{ $loop->count }}</td>
            </tr>
        </table>

        <table class="content-table">
            <tr>
                <td style="width:50%;"><span class="bold">Standar:</span>
                    {{ $temuan['response_tilik']['standar_nasional'] ?? 'LKPS' }}</td>
                <td style="width:50%;"><span class="bold">Prosedur/Proses:</span>
                    {{ $temuan['kriteria']['nama_kriteria'] ?? 'Kriteria' }}</td>
            </tr>

            <tr>
                <td colspan="2">
                    <span class="bold" style="text-decoration: underline;">Hasil Temuan Ketidaksesuaian:</span> <em>(diisi oleh auditor)</em>
                    <br>
                    {{ $temuan['uraian_temuan'] ?? 'Berdasarkan audit internal ditemukan bahwa Jumlah dosen yang mengikuti peningkatan kompetensi (sertifikasi atau pelatihan Data Science?) belum jelas datanya, hal ini tidak memenuhi target LKPS C.4.4. sebesar 50% dosen.' }}
                </td>
            </tr>

            <tr>
                <td><span class="bold">Kategori Temuan : {{ $temuan['kategori_temuan'] ?? 'AOC' }}</span></td>
                <td><span class="bold">Tanggal Perbaikan :</span>
                    {{ \Carbon\Carbon::now()->locale('id')->isoFormat('DD MMMM Y') }}
                </td>
            </tr>

            <tr>
                <td>
                    <span class="bold">Auditor</span><br>
                    Nama: <br>
                    1. {{ $audit['auditor1']['nama'] ?? '-' }}<br>
                    2. {{ $audit['auditor2']['nama'] ?? '-' }}
                </td>
                <td>
                    <span class="bold">Auditee</span><br>
                    Nama: <br>
                    1. {{ $audit['auditee1']['nama'] ?? '-' }}<br>
                    2. {{ $audit['auditee2']['nama'] ?? '' }}
                </td>
            </tr>

            <tr>
                <td colspan="2" style="border-top: none; border-bottom: none;">
                    <span class="bold" style="text-decoration: underline;">Analisis Penyebab:</span> <em>(diisi
                        oleh auditee)</em>
                    <br>
                    {{ $temuan['response_tilik']['akar_penyebab_penunjang'] ?? '' }}
                </td>
            </tr>

            <tr>
                <td colspan="2" style="border-top: none; border-bottom: none;">
                    <span class="bold" style="text-decoration: underline;">Tindakan Perbaikan:</span> <em>(diisi
                        oleh auditee)</em>
                    <br>
                    {{ $temuan['response_tilik']['rencana_perbaikan_tindak_lanjut'] ?? '' }}
                </td>
            </tr>

            <tr>
                <td colspan="2" style="border-top: none; border-bottom: none;">
                    <span class="bold" style="text-decoration: underline;">Tindakan Pencegahan:</span> <em>(diisi
                        oleh auditee)</em>
                    <br>
                    {{ $temuan['response_tilik']['tindakan_pencegahan'] ?? '' }}
                </td>
            </tr>

            <tr>
                <td colspan="2" class="signature-area">
                    <span class="bold">Tanda Tangan Auditee:</span><br><span>Tanggal:</span>
                    <span style="display:inline-block; width: 150px;"></span>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <span class="bold">Pemeriksaan Hasil Tindakan Perbaikan (close out):</span> <em>(diisi oleh
                        auditor)</em>
                    <br>
                    {{ $temuan['saran_perbaikan'] ?? '' }}

                </td>
            </tr>

            <tr>
                <td><span class="bold">Hasil Verifikasi:</span> Sesuai/Tidak Sesuai *)</td>
                <td>
                    <span class="bold">Rekomendasi:</span> <em>jika hasil verifikasi <strong>"Tidak Sesuai",</strong></em> Diterbitkan PTPP ke ...........................<br> untuk perbaikan ulang.
                    <br>
                    {{ $temuan['response_tilik']['evaluasi_tindakan_perbaikan'] ?? '' }}
                </td>
            </tr>

            <tr>
                <td class="signature-area" style="border-right: none;">
                    <span class="bold">Tanda Tangan Auditor:</span><br>
                    <span>Tanggal:</span>
                </td>
                <td class="signature-area" style="border-left: none;">
                    <span class="bold">Tanda Tangan Auditee:</span><br>
                    <span>Tanggal:</span>
                </td>
            </tr>

            <tr>
                <td class="signature-area" style="border-right: none;">
                    <span class="bold">Kepala P4M:</span> {{ $audit['kepalaP4M']['nama'] ?? 'Sindung HWS' }}<br>
                    <span>Tanggal:</span>
                </td>
                <td class="signature-area" style="border-left: none;">
                    <span class="bold">Tanda Tangan:</span>
                </td>
            </tr>
        </table>
    </div>

    @if (!$loop->last)
    <div class="page-break"></div>
    @endif
    @endforeach

</body>

</html>
