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
                <h4 class="card-title">History Gaji Harian - Periode Penggajian Karyawan Harian</h4>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="col-md-12 pt-2">
            <div class="table-responsive">
                <table id="generate-datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Periode</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>
                                    <a href="{{ route('history-harian.detail', ['awal' => date('Y-m-d', strtotime($item->periode_awal)), 'akhir' => date('Y-m-d', strtotime($item->periode_akhir))]) }}">
                                        <div class="d-flex justify-content-between">
                                            <p class="text-underline">{{ date('d F Y', strtotime($item->periode_awal)) }} - {{ date('d F Y', strtotime($item->periode_akhir)) }}</p>
                                            Info Generate :
                                            @if (!empty($item->user))
                                                {{ $item->user->name }} / {{ $item->user->email }}, 
                                            @endif
                                            Tanggal {{ date('d F Y', strtotime($item->created_at)) }}
                                        </div>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('history-harian.remove', ['awal' => date('Y-m-d', strtotime($item->periode_awal)), 'akhir' => date('Y-m-d', strtotime($item->periode_akhir))]) }}">
                                        <button type="button" class="btn btn-sm btn-primary">
                                            Hapus
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css-plugins')

@endpush

@push('js-plugins')
<script>
    $('#generate-datatable').dataTable( {
        "ordering": false,
        "bLengthChange" : false,
        "searching": false,
    });
</script>
@endpush