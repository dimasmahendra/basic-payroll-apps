@php
	$title = "History";
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
                <h4 class="card-title">History</h4>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @include('components/table', [
                'data' => $data,
                'headers' => [
                    'name' => "Name",
                    'nilai' => "Nilai",
                    'tipe' => "Tipe",
                    'keterangan' => "Keterangan",
                    'updated_by' => "PIC",
                ],
                "values" => [
                    "updated_by" => function($data){
                        return $data->user->name;
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