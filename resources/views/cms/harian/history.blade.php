@php
	$title = "Gaji Harian";
    $breadcrumbs[] = [
		"label" => "Gaji Harian", "url" => "#"
	];
    $breadcrumbs[] = [
		"label" => "History", "url" => "#"
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
                <h4 class="card-title">History Gaji Harian</h4>
            </div>
        </div>
    </div>
    <div class="card-body">
        <label>Periode Penggajian Karyawan Harian</label> 
        <div class="col-md-12 pt-2">
            @foreach ($data as $key => $item)
                <a href="{{ route('history-harian.detail', ['awal' => $item, 'akhir' => $key]) }}">
                    <p class="text-underline">{{ date('d F Y', strtotime($item)) }} - {{ date('d F Y', strtotime($key)) }}</p>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('css-plugins')

@endpush

@push('js-plugins')

@endpush