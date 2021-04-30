@php
	$title = "Gaji Harian";
    $breadcrumbs[] = [
		"label" => "Gaji", "url" => "#"
	];
	$breadcrumbs[] = [
		"label" => "Harian", "url" => "#"
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
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        @foreach ($komponen as $item)
                            <th>{{ $item->label }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($karyawan as $key => $item)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            @foreach ($item->komponenkaryawan as $komponenkaryawan)
                                <td>
                                    {{ $komponenkaryawan->komponen_nilai }}
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

@endsection