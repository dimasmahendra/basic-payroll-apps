@php
	$title = "Angsuran Kantor";
	$breadcrumbs[] = [
		"label" => "Daftar", "url" => "#"
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
                <h4 class="card-title">Daftar Angsuran Kantor</h4>
            </div>
            <div class="col-auto">
                <a class="btn btn-outline-success waves-effect waves-light d-inline-block" href="{{ route('angsuran.create') }}">
                    <i class="mdi mdi-plus-circle-outline mr-2"></i>Tambah Data
                </a>
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
                    'sisa_angsuran' => "Sisa Angsuran",
                    'updated_at' => "Tanggal Angsuran Terakhir",
                ],
                "values" => [
                        "karyawan_nik" => function($data){
                            return $data->karyawan->nik_karyawan;
                        },
                        "karyawan_nama" => function($data){
                            return $data->karyawan->nama_lengkap;
                        },
                        "sisa_angsuran" => function($data){
                            if ($data->sisa_angsuran < 0) {
                                echo '<span class="text-danger">' . number_format($data->sisa_angsuran, 0, ',', '.') . '<span>';
                            } else {
                                echo '<span class="text-success">' . number_format($data->sisa_angsuran, 0, ',', '.') . '<span>';
                            }
                        },
                    ],
                "actions" => [
                    "show" => [
                        "url" => "angsuran.show",
                        "url_params" => ["kantor", "karyawan_id"],
                        "type" => "url",
                        "button" => "info",
                        "attribute" => [
                            'icon' => 'las la-eye'
                        ]
                    ],
                ]
            ])
        </div>
    </div>
</div>
@endsection

@section('css')

@endsection

@section('js')

@endsection