@php
	$title = "Gaji Bulanan";
    $breadcrumbs[] = [
		"label" => "Gaji Bulanan", "url" => "#"
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
                <h4 class="card-title">History Gaji Bulanan</h4>
            </div>
        </div>
    </div>
    <div class="card-body">
        <label>Periode Penggajian Karyawan Bulanan</label> 
        <div class="col-md-12 pt-2">
            @foreach ($data as $key => $item)
                <a href="{{ route('history-bulanan.detail', ['awal' => date('Y-m-d', strtotime($item->periode_awal)), 'akhir' => date('Y-m-d', strtotime($item->periode_akhir))]) }}">
                    <div class="d-flex justify-content-between">
                        <p class="text-underline">{{ date('d F Y', strtotime($item->periode_awal)) }} - {{ date('d F Y', strtotime($item->periode_akhir)) }}</p>
                        Info Generate :
                        @if (!empty($item->user))
                             {{ $item->user->name }} / {{ $item->user->email }}, 
                        @endif
                        Tanggal {{ date('d F Y', strtotime($item->created_at)) }}
                    </div>
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