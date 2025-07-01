<!DOCTYPE html>
<html>

<head>
    <title>Permintaan Tindakan Perbaikan dan Pencegahan</title>
    <style>
        @page {
            margin: 20mm;
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

        /* --- HEADER --- */
        .header-table {
            border: 2px solid #000;
            margin-bottom: 15px;
        }

        .header-table>tbody>tr>td {
            vertical-align: top;
            padding: 0;
            border-left: 2px solid #000;
        }

        .header-logo-cell {
            width: 15%;
            padding: 5px;
            text-align: center;
            border-left: none;
        }

        .logo {
            margin-top: 4px;
            width: 60px;
            height: auto;
            margin-bottom: 4px;
        }

        .header-title-cell {
            font-family: Arial, sans-serif;
            width: 55%;
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            padding: 10px;
            line-height: 1.4;
            vertical-align: middle;
            display: table-cell;
            justify-content: center;
            align-items: center;
        }

        .header-info-wrapper {
            width: 30%;
        }

        .info-header-table td {
            border: none;
            border-bottom: 2px solid #000;
            font-size: 10pt;
            padding: 5px 8px;
        }

        .info-header-table tr:last-child td {
            border-bottom: none;
        }

        .info-header-table td:first-child {
            font-weight: bold;
            width: 1%;
            white-space: nowrap;
        }

        /* --- INFO PENERIMA --- */
        .recipient-table {
            margin-bottom: 5px;
        }

        .recipient-table td {
            padding: 1.5px 2px;
            border: none;
        }

        /* --- TABEL KONTEN UTAMA --- */
        .content-table {
            border: 1px solid #000;
        }

        .content-table td {
            border: 1px solid #000;
            padding: 5px 8px;
            vertical-align: top;
        }

        /* Menghapus min-height yang salah dan hanya menyisakan untuk TTD */
        .signature-area {
            height: 60px;
            /* Memberi ruang vertikal untuk TTD */
        }
    </style>
</head>

<body>

    @foreach ($laporanTemuan as $index => $temuan)
        <div class="page-container">
            <table class="header-table">
                <tr>
                    <td class="header-logo-cell">
                        <img src="{{ public_path('logo.png') }}" alt="Logo" class="logo"><br>
                        <span class="bold">SPMI</span>
                    </td>
                    <td class="header-title-cell">
                        PROSEDUR AKADEMIK<br>
                        PERMINTAAN TINDAKAN PERBAIKAN DAN PENCEGAHAN
                    </td>
                    <td class="header-info-wrapper">
                        <table class="info-header-table">
                            <tr>
                                <td>No.</td>
                                <td>: FPAK.2.04.L.1</td>
                            </tr>
                            <tr>
                                <td>Revisi</td>
                                <td>: 3</td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td>: 21.12.2017</td>
                            </tr>
                            <tr>
                                <td>Halaman</td>
                                <td>: {{ $loop->iteration }}/{{ $loop->count }}</td>
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
                    <td style="width: 120px;">:
                        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('DD MMMM Y') }}</td>
                </tr>
                <tr>
                    <td>Jur/Bag/Unit</td>
                    <td colspan="3">: {{ $audit['unitKerja']['nama_unit_kerja'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Dari</td>
                    <td class="bold">: Kepala P4M</td>
                    <td style="width: 50px; text-align:right;">Halaman</td>
                    <td style="width: 120px;">: {{ $loop->iteration }}/{{ $loop->count }}</td>
                </tr>
            </table>

            <table class="content-table">
                <tr>
                    <td style="width:50%;"><span class="bold">Standar</span>:
                        {{ $temuan['kriteria']['nama_kriteria'] ?? 'LKPS C.4.4' }}</td>
                    <td style="width:50%;"><span class="bold">Prosedur/Proses</span>:
                        {{ $temuan['kriteria']['standar_nasional'] ?? 'SDM' }}</td>
                </tr>

                <tr>
                    <td colspan="2">
                        <span class="bold">Hasil Temuan Ketidaksesuaian:</span> <em>(diisi oleh auditor)</em>
                        <br>
                        {{ $temuan['uraian_temuan'] ?? 'Berdasarkan audit internal ditemukan bahwa Jumlah dosen yang mengikuti peningkatan kompetensi (sertifikasi atau pelatihan Data Science?) belum jelas datanya, hal ini tidak memenuhi target LKPS C.4.4. sebesar 50% dosen.' }}
                    </td>
                </tr>

                <tr>
                    <td><span class="bold">Kategori Temuan   :       {{ $temuan['kategori_temuan'] ?? 'AOC' }}</span></td>
                    <td><span class="bold">Tanggal Perbaikan</span>:
                        {{ \Carbon\Carbon::parse($audit->jadwal_audit)->addDays(14)->locale('id')->isoFormat('D MMMM Y') }}
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
                        1. {{ $audit['auditee1']['nama'] ?? '-' }}
                        2. {{ $audit['auditee2']['nama'] ?? '-' }}
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
                        <span class="bold">Tanda Tangan Auditee:<br>Tanggal:</span>
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
                    <td><span class="bold">Hasil Verifikasi</span>: Sesuai/Tidak Sesuai *)</td>
                    <td>
                        <span class="bold">Rekomendasi</span>: (jika hasil verifikasi "Tidak Sesuai")
                        <br>
                        {{ $temuan['response_tilik']['evaluasi_tindakan_perbaikan'] ?? '' }}
                    </td>
                </tr>

                <tr>
                    <td class="signature-area" style="border-right: none;">
                        <span class="bold">Tanda Tangan Auditor:</span><br>
                        <span class="bold">Tanggal:</span>
                    </td>
                    <td class="signature-area" style="border-left: none;">
                        <span class="bold">Tanda Tangan Auditee:</span><br>
                        <span class="bold">Tanggal:</span>
                    </td>
                </tr>

                <tr>
                    <td class="signature-area" style="border-right: none;">
                        <span class="bold">Kepala P4M</span>: {{ $audit['kepalaP4M']['nama'] ?? 'Sindung HWS' }}<br>
                        <span class="bold">Tanggal:</span>
                    </td>
                    <td class="signature-area" style="border-left: none;">
                        <span class="bold">Tanda Tangan</span>
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
