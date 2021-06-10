@php
	$title = "Gaji Bulanan";
    $breadcrumbs[] = [
		"label" => "Gaji", "url" => "#"
	];
	$breadcrumbs[] = [
		"label" => "Bulanan", "url" => "#"
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
                <h4 class="card-title">Perhitungan Gaji Bulanan Karyawan</h4>
                <p class="text-muted mb-0">Periode : {{ $periode }}</p>
            </div>
            <div class="col-auto">
                <button
                    class="btn btn-warning me-1 float-end" data-toggle="modal"
                    data-animation="bounce" data-target=".modal-export">Export
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="generate-datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama Karyawan</th>
                        @foreach ($komponen as $item)
                            <th>{{ $item->label }}</th>
                        @endforeach
                        <th>Angsuran Koperasi</th>
                        <th>Angsuran Kantor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($karyawan as $key => $item)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $item['karyawan']['nik_karyawan'] }}</td>
                            <td>{{ $item['karyawan']['nama_lengkap'] }}</td>                          
                            @foreach ($item['komponen'] as $komponenkaryawan)
                                <td>
                                    {{ number_format($komponenkaryawan['komponen_nilai'], 0, ',', '.') }}
                                </td>   
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!--  Modal content for the above example -->
<div class="modal fade modal-export" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Pilih Waktu Penggajian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form id="modal-waktu-penggajian" method="POST"
                action="{{ route('bulanan.export', ['awal' => $awal, 'akhir' => $akhir]) }}">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Waktu Penggajian</label>
                                <select name="tipe" id="tipe" class="form-control">
                                    <option value="awal">Awal</option>
                                    <option value="tengah">Tengah</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Lanjut</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection

@section('css')

@endsection

@section('js')
<script>
    $('#generate-datatable').dataTable( {
        "ordering": false,
        "bLengthChange" : false
    });
</script>
@endsection