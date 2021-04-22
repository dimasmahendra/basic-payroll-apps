@php
	$title = "Angsuran Koperasi";
	$breadcrumbs[] = [
		"label" => "Daftar", "url" => "#"
	];
    $breadcrumbs[] = [
		"label" => "Detail", "url" => "#"
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
                <h4 class="card-title">Daftar Detail Angsuran Koperasi</h4>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @include('components/table', [
                'data' => $angsuran,
                'headers' => [
                    'karyawan_nik' => "NIK Karyawan",
                    'karyawan_nama' => "Nama Karyawan",
                    'debet' => "Debet",
                    'kredit' => "Kredit",
                    'tanggal_angsuran' => "Tanggal Angsuran Terakhir",
                ],
                "values" => [
                    "karyawan_nik" => function($data){
                        return $data->karyawan->nik_karyawan;
                    },
                    "karyawan_nama" => function($data){
                        return $data->karyawan->nama_lengkap;
                    },
                    "debet" => function($data){
                        if ($data->mutasi == 'debet') {
                            return number_format($data->saldo, 0, ',', '.');
                        } else {
                            return '-';
                        }
                    },
                    "kredit" => function($data){
                        if ($data->mutasi == 'kredit') {
                            return number_format($data->saldo, 0, ',', '.');
                        } else {
                            return '-';
                        }
                    },
                    "tanggal_angsuran" => function($data){
                        return date('d M Y', strtotime($data->tanggal_angsuran));
                    },
                ], 
            ])
        </div>
    </div>
</div>
@endsection

@section('css')

@endsection

@section('js')

@endsection