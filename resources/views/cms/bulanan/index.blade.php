@php
	$title = "Gaji Bulanan";
    $breadcrumbs[] = [
		"label" => "Gaji Bulanan", "url" => "#"
	];
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
                <h4 class="card-title">Gaji Bulanan</h4>
            </div>
        </div>
    </div>
    <div class="card-body">
        <label>Periode Penggajian Karyawan Bulanan</label> 
        <form method="POST" action="{{ route('generate.bulanan') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="text" class="form-control" id="tanggal-harian" name="periode_awal" required />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="text" class="form-control" id="tanggal-end" name="periode_akhir" readonly />
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <select name="waktu_penggajian" id="wkt-penggajian" class="form-control">
                            <option value="awal">Awal</option>
                            <option value="tengah">Tengah</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-success waves-effect waves-light d-inline-block">Generate</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('css-plugins')
<link href="/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
@endpush

@push('js-plugins')
<script src="/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script>
    $("#tanggal-harian").datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'dd/mm/yyyy',
    }).on('changeDate', function (selected) {
        var endDate = $(this).datepicker('getDate');
        var selectedMonth = endDate.getMonth();
        var selectedYear = endDate.getFullYear();
        var lastDate = new Date(selectedYear, selectedMonth + 1, 0);

        var final = new Date(endDate);
        if ($("#wkt-penggajian").val() == "awal") {
	        final.setDate(lastDate.getDate());
        }
        if ($("#wkt-penggajian").val() == "tengah") {
	        final.setDate(endDate.getDate() + 30);
        }
        
        $('#tanggal-end').val(moment(final).format("DD/MM/YYYY"));
    }).datepicker('setDate', 'now');
</script>
@endpush