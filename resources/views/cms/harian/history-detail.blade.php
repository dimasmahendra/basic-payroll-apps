@php
	$title = "Gaji Mingguan";
    $breadcrumbs[] = [
		"label" => "Gaji", "url" => "#"
	];
	$breadcrumbs[] = [
		"label" => "Mingguan", "url" => "#"
	];
    $breadcrumbs[] = [
		"label" => "Generate", "url" => "#"
	];
@endphp

@extends('layouts.cms', [
	"title" => $title,
	"breadcrumbs" => $breadcrumbs
])

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="card-title">Daftar Gaji Mingguan Karyawan</h4>
                <p class="text-muted mb-0">Periode : {{ $periode }}</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('history-harian.pdf', ['awal' => $awal, 'akhir' => $akhir]) }}">
                    <button class="btn btn-info me-1 float-end">Download</button>
                </a>
                <a href="{{ route('generate.export', ['awal' => $awal, 'akhir' => $akhir]) }}" download>
                    <button class="btn btn-warning me-1 float-end">Export</button>
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="generate-datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama Karyawan</th>
                        @foreach ($komponen as $item)
                            <th>{{ $item->label }}</th>
                        @endforeach
                        <th>Angsuran Koperasi</th>
                        <th>Angsuran Kantor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($karyawan as $key => $item) 
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $item['nik_karyawan'] }}</td>
                            <td>{{ $item['nama_lengkap'] }}</td>
                            <td>{{ number_format($item['upah_pokok'], 0, ',', '.') }}</td>
                            <td>{{ number_format($item['tunjangan_makan'], 0, ',', '.') }}</td>
                            <td>{{ number_format($item['tunjangan_stkr'], 0, ',', '.') }}</td>
                            <td>{{ number_format($item['tunjangan_prh'], 0, ',', '.') }}</td>
                            <td>{{ number_format($item['bonus_masuk'], 0, ',', '.') }}</td>
                            <td>{{ number_format($item['upah_lembur'], 0, ',', '.') }}</td>
                            <td>{{ number_format($item['bpjs_kesehatan'], 0, ',', '.') }}</td>
                            <td>{{ number_format($item['bpjs_tenagakerja'], 0, ',', '.') }}</td>
                            <td>{{ number_format($item['bpjs_orangtua'], 0, ',', '.') }}</td>
                            <td>{{ number_format($item['iuran_wajib'], 0, ',', '.') }}</td>
                            <td>{{ number_format($item['angsuran_koperasi'], 0, ',', '.') }}</td>
                            <td>{{ number_format($item['angsuran_kantor'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('css')

@endsection

@section('js')
<script>
    $('#generate-datatable').dataTable( {
        "ordering": false,
        "bLengthChange" : false
    });
</script>
@endsection