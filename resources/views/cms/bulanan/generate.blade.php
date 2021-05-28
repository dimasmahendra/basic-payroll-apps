@php
	$title = "Gaji Bulanan";
    $breadcrumbs[] = [
		"label" => "Gaji", "url" => "#"
	];
	$breadcrumbs[] = [
		"label" => "Bulanan", "url" => "#"
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
                <h4 class="card-title">Daftar Gaji Bulanan Karyawan</h4>
                <p class="text-muted mb-0">Periode : {{ $periode }}</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('bulanan.export', ['awal' => $awal, 'akhir' => $akhir]) }}" download>
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
                            <td>{{ $item['karyawan']['nik_karyawan'] }}</td>
                            <td>{{ $item['karyawan']['nama_lengkap'] }}</td>                          
                            @foreach ($item['komponen'] as $komponenkaryawan)
                                <td>
                                    {{ number_format($komponenkaryawan['komponen_nilai'], 0, ',', '.') }}
                                </td>   
                            @endforeach
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