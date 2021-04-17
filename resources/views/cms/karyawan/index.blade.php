@php
	$title = "Karyawan";
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
                <h4 class="card-title">Daftar Karyawan</h4>
            </div>
            <div class="col-auto">
                <a class="btn btn-outline-success waves-effect waves-light d-inline-block" href="{{ route('karyawan.create') }}">
                    <i class="mdi mdi-plus-circle-outline mr-2"></i>Tambah Data
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @include('components/table', [
                'data' => $karyawan,
                'headers' => [
                    'nik_karyawan' => "NIK Karyawan",
                    'nama_lengkap' => "Nama Lengkap"
                ],
                "actions" => [
                    "edit" => [
                        "url" => "karyawan.edit",
                        "type" => "url",
                        "button" => "info",
                        "attribute" => [
                            'icon' => 'las la-pen'
                        ]
                    ],
                    "delete" => [
                        "url" => "karyawan.destroy",
                        "type" => "url",
                        "button" => "danger",
                        "attribute" => [
                            'icon' => 'las la-trash-alt'
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