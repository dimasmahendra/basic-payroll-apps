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
            padding: 2px;
            text-align: left;
        }
        th {
            padding: 2px;
            text-align: left;
        }
        table.personal-info {
            width: 100%;
            border-bottom: 1px solid black;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    @foreach ($data->chunk(3) as $key => $item)
        <div class="columns">
            @foreach ($item as $item)
                <div class="item">
                    <div class="kop-header">
                        SLIP GAJI MINGGUAN<br>
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
                            <td>{{ number_format($item['upah_pokok'], 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Tunj. T. Makan</td>
                            <td>{{ number_format($item['tunjangan_makan'], 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Tunj. Stkr</td>
                            <td>{{ number_format($item['tunjangan_stkr'], 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Tunj. Prh</td>
                            <td>{{ number_format($item['tunjangan_prh'], 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Bonus Masuk</td>
                            <td>{{ number_format($item['bonus_masuk'], 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Upah Lembur</td>
                            <td>{{ number_format($item['upah_lembur'], 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Total Gaji</td>
                            <td class="text-right">{{ number_format($item['total_gaji'], 0, ',', '.') }}</td>
                        </tr>                        
                        <tr>
                            <td>Pot. BPJS Kes</td>
                            <td>{{ number_format($item['bpjs_kesehatan'], 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Pot. BPJS Ket</td>
                            <td>{{ number_format($item['bpjs_tenagakerja'], 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Pot. BPJS Orang Tua</td>
                            <td>{{ number_format($item['bpjs_orangtua'], 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Iuran Wjb Kop.</td>
                            <td>{{ number_format($item['iuran_wajib'], 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Angsuran Koperasi</td>
                            <td>{{ number_format($item['angsuran_koperasi'], 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Angsuran Kantor</td>
                            <td>{{ number_format($item['angsuran_kantor'], 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Sisa Gaji</td>
                            <td class="text-right">{{ number_format(($item['total_gaji'] - $item['total_potongan']), 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
            @endforeach
        </div>
        <div class="clear otder-pages"></div>
    @endforeach
</body>
</html>
