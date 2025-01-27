<!DOCTYPE html>
<html lang="en">
<head>
    <title>PDF</title>
    <style type="text/css">
        @page { 
            margin: 60px 60px 60px 60px; 
        }
        body {
            font-size: 12px;
        }
        div.columns       { 
            width: 100%;
        }
        div.columns > .item   { 
            width: 30%;
            float: left;
            padding: 15px;
        }
        div.grey          { background-color: #cccccc; }
        div.red           { background-color: #e14e32; }
        div.clear         { 
            clear: botd;
        }
        .otder-pages{
            page-break-before: always;
        }
        table {
            width: 100%;
        }
        td {
            padding-top: 2px;
            padding-right: 2px;
            padding-bottom: 2px;
            padding-left: 2px;
            text-align: left;
        }

        td.text-inline {
            padding-top: 2px;
            padding-right: 20px;
            padding-bottom: 2px;
            padding-left: 2px;
            text-align: left;
        }
        table.personal-info {
            width: 100%;
            border-bottom: 1px solid black;
        }
        .text-right {
            text-align: right;
        }

        .angsuran-ke {
            display: inline;
            float: right;
        }
    </style>
</head>
<body>
    @foreach ($data->chunk(3) as $key => $item)
        <div class="columns">
            @foreach ($item as $item)
                <div class="item">
                    <div class="kop-header">
                        SLIP GAJI BULANAN<br>
                        CV "SETI-AJI" SURAKARTA<br>
                        Tanggal : {{ date('d F Y', strtotime($awal)) }}
                    </div>
                    <hr>
                    <table class="personal-info">
                        <tr>
                            <td>NIK</td>
                            <td>{{ $item['nik_karyawan'] }}</td>
                        </tr>
                        <tr>
                            <td>Nama Karyawan</td>
                            <td>{{ $item['nama_lengkap'] }}</td>
                        </tr>
                        <tr>
                            <td>Masuk Kerja</td>
                            <td>{{ $item['masuk_kerja'] }}</td>
                        </tr>
                        <tr>
                            <td>Jam Lembur 1</td>
                            <td>{{ $item['total_lembur_1'] }}</td>
                        </tr>
                        <tr>
                            <td>Jam Lembur 2</td>
                            <td>{{ $item['total_lembur_2'] }}</td>
                        </tr>
                    </table>
                    <table>                   
                        <tr>
                            <td>Upah Pokok</td>
                            <td>{{ number_format($item['upah_pokok'], 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Tunj. T. Makan</td>
                            <td>{{ number_format($item['tunjangan_makan'], 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Tunj. Stkr</td>
                            <td>{{ number_format($item['tunjangan_stkr'], 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Tunj. Prh</td>
                            <td>{{ number_format($item['tunjangan_prh'], 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Tunj. Phg</td>
                            <td>{{ number_format($item['tunjangan_phg'], 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Upah Lembur</td>
                            <td>{{ number_format($item['upah_lembur'], 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Total Gaji</td>
                            <td class="text-right">{{ number_format($item['total_gaji'], 2, ',', '.') }}</td>
                        </tr>                        
                        <tr>
                            <td>Pot. BPJS Kes</td>
                            <td>{{ number_format($item['bpjs_kesehatan'], 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Pot. BPJS Ket</td>
                            <td>{{ number_format($item['bpjs_tenagakerja'], 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Pot. BPJS Orang Tua</td>
                            <td>{{ number_format($item['bpjs_orangtua'], 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Iuran Wjb Kop</td>
                            <td>{{ number_format($item['iuran_wajib'], 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Potongan Absen</td>
                            <td>{{ number_format($item['potongan_absen'], 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="text-inline">Angsuran Koperasi - Ke : {{ $item['angsuran_ke_koperasi'] }}</td>
                            <td>{{ number_format($item['angsuran_koperasi'], 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="text-inline">Angsuran Kantor - Ke : {{ $item['angsuran_ke_kantor'] }}</td>
                            <td>{{ number_format($item['angsuran_kantor'], 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Sisa Gaji</td>
                            <td class="text-right">{{ number_format(($item['total_gaji'] - $item['total_potongan'] - $item['angsuran_kantor'] - $item['angsuran_koperasi']), 2, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
            @endforeach
        </div>
        <div class="clear otder-pages"></div>
    @endforeach
</body>
</html>
