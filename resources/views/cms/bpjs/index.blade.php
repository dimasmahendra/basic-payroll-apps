@php
    $title = "BPJS";
    $breadcrumbs[] = [
            "label" => "Master Data", "url" => route('jabatan')
        ];
    $breadcrumbs[] = [
            "label" => "BPJS", "url" => "#"
        ];
@endphp

@extends('layouts.cms', [
    "title" => $title,
    "breadcrumbs" => $breadcrumbs
])

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Master Data BPJS</h4>
    </div>
    <div class="card-body">
        <form id="form-simpan-jabatan" method="POST" action="{{ route('bpjs.store') }}">
            {{ csrf_field() }}
            <div class="col-md-3">
                <div class="form-group">
                    <label>UMK <span class="text-warning">*</span></label> 
                    <input type="text" class="form-control currency" id="nilaiumk" name="nilaiumk" value="{{ $setting['nilaiumk'] }}" required/>
                </div>
            </div>
            <div class="col-md-8 row">
                <div class="col-md-3">
                    <label>BPJS KESEHATAN <span class="text-warning">*</span></label> 
                    <div class="form-group">
                        <input type="text" class="form-control" id="persen-kesehatan" name="persen_kesehatan" value="{{ $setting['persen_kesehatan'] }}" required/>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group" style="margin-top: 26px">
                        <input type="text" class="form-control" id="nilai-kesehatan" name="bpjs_kesehatan" value="{{ $setting['bpjs_kesehatan'] }}" readonly/>
                    </div>
                </div>
            </div>
            <div class="col-md-8 row">
                <div class="col-md-3">
                    <label>BPJS KETENAGAKERJAAN <span class="text-warning">*</span></label> 
                    <div class="form-group">
                        <input type="text" class="form-control" id="persen-tenagakerja" name="persen_tenaga" value="{{ $setting['persen_tenaga'] }}" required/>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group" style="margin-top: 26px">
                        <input type="text" class="form-control" id="nilai-tenagakerja" name="bpjs_tenagakerja" value="{{ $setting['bpjs_tenagakerja'] }}" readonly/>
                    </div>
                </div>
            </div>
            <div class="col-md-8 row">
                <div class="col-md-3">
                    <label>BPJS ORANG TUA <span class="text-warning">*</span></label> 
                    <div class="form-group">
                        <input type="text" class="form-control" id="persen-orangtua" name="persen_orangtua" value="{{ $setting['persen_orangtua'] }}" required/>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group" style="margin-top: 26px">
                        <input type="text" class="form-control" id="nilai-orangtua" name="bpjs_orangtua" value="{{ $setting['bpjs_orangtua'] }}" readonly/>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('css-plugins')

@endpush

@push('js-plugins')
    <script>
        $(document).on('change', '#nilaiumk', function() {
            var nilai = parseFloat($(this).val().replace(/\./g, ""));
            var persenkesehatan = parseFloat($("#persen-kesehatan").val());
            var persentenagakerja = parseFloat($("#persen-tenagakerja").val());
            var persenorangtua = parseFloat($("#persen-orangtua").val());

            if (persenkesehatan) {
                var totalkesehatan = (persenkesehatan / 100) * nilai;
                $("#nilai-kesehatan").val(totalkesehatan);
            }

            if (persentenagakerja) {
                var totaltenagakerja = (persentenagakerja / 100) * nilai;
                $("#nilai-tenagakerja").val(totaltenagakerja);
            }

            if (persenorangtua) {
                var totalorangtua = (persenorangtua / 100) * nilai;
                $("#nilai-orangtua").val(totalorangtua);
            }
        });

        $(document).on('change', '#persen-kesehatan', function() {
            var nilai = parseFloat($("#nilaiumk").val().replace(/\./g, ""));
            var persenkesehatan = parseFloat($(this).val());

            var totalkesehatan = (persenkesehatan / 100) * nilai;
            $("#nilai-kesehatan").val(totalkesehatan);
        });

        $(document).on('change', '#persen-tenagakerja', function() {
            var nilai = parseFloat($("#nilaiumk").val().replace(/\./g, ""));
            var persentenagakerja = parseFloat($(this).val());

            var totaltenagakerja = (persentenagakerja / 100) * nilai;
            $("#nilai-tenagakerja").val(totaltenagakerja);
        });

        $(document).on('change', '#persen-orangtua', function() {
            var nilai = parseFloat($("#nilaiumk").val().replace(/\./g, ""));
            var persenorangtua = parseFloat($(this).val());

            var totalorangtua = (persenorangtua / 100) * nilai;
            $("#nilai-orangtua").val(totalorangtua);
        });
    </script>
@endpush