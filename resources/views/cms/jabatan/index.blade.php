@php
	$title = "Jabatan";
	$breadcrumbs[] = [
		"label" => "Master Data", "url" => "#"
	];
    $breadcrumbs[] = [
		"label" => "Jabatan", "url" => "#"
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
                <h4 class="card-title">Daftar Jabatan</h4>
            </div>
            <div class="col-auto">
                <a class="btn btn-outline-success waves-effect waves-light d-inline-block" href="{{ route('jabatan.create') }}">
                    <i class="mdi mdi-plus-circle-outline mr-2"></i>Tambah Data
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @include('components/table', [
                'data' => $jabatan,
                'headers' => [
                    'nama' => "Nama Jabatan"
                ],
                "actions" => [
                    "edit" => [
                        "url" => "jabatan.edit",
                        "type" => "url",
                        "button" => "info",
                        "attribute" => [
                            'icon' => 'las la-pen'
                        ]
                    ],
                    "delete" => [
                        "url" => "jabatan.destroy",
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