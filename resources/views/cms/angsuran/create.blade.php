@php
    $title = "Angsuran";
    $breadcrumbs[] = [
            "label" => "Daftar", "url" => url()->previous()
        ];
    $breadcrumbs[] = [
            "label" => "Tambah", "url" => "#"
        ];
@endphp

@extends('layouts.cms', [
    "title" => $title,
    "breadcrumbs" => $breadcrumbs
])

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Tambah Angsuran</h4>
    </div>
    <div class="card-body">
        <form id="form-simpan-angsuran" method="POST" action="{{ route('angsuran.store') }}">
            {{ csrf_field() }}
            <div class="row col-md-10">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Jenis Angsuran <span class="text-warning">*</span></label> 
                        <select class="form-control" name="jenis_angsuran" required>
                            <option value="kantor">Kantor</option>
                            <option value="koperasi">Koperasi</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Tanggal<span class="text-warning">*</span></label> 
                    <input type="text" class="form-control" id="tanggal-angsuran" name="tanggal_angsuran" required/>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>NIK Karyawan <span class="text-warning">*</span></label>
                    <select class="form-control" id="nik-karyawan" name="karyawan_id"></select>
                </div>
            </div>
            <div class="row col-md-10">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Mutasi <span class="text-warning">*</span></label> 
                        <select class="form-control" name="mutasi" required>
                            <option value="debet">Debet</option>
                            <option value="kredit">Kredit</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Keterangan <span class="text-warning">*</span></label> 
                    <textarea name="keterangan" id="keterangan" class="form-control" rows="10"></textarea>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Nominal <span class="text-warning">*</span></label> 
                    <input type="text" class="form-control currency" id="nominal" name="nominal" required/>
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
        $(document).ready(function() {
            $("#nik-karyawan").select2({            
                placeholder: 'Cari Nomor NIK',
                templateResult: formatNoBa,
                ajax: {
                    cache: true,
                    url: `/internal-api/data/karyawan`,
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        var query = {
                        search: params.term,
                        page: params.page || 1
                        }
                        return query;
                    },
                    processResults: function (data) {
                        console.log(data)
                        return {
                        results: data.map(e => {
                            return {
                                id: e.id,
                                text: e.nik_karyawan + ' - ' + e.nama_lengkap, 
                                nama_lengkap: e.nama_lengkap, 
                            }
                        })
                        };
                    },
                }            
            })
        });
        $("#tanggal-angsuran").daterangepicker({
            locale: {
                format: 'DD/MM/YYYY',
            },
            singleDatePicker: true,
        });
        function formatNoBa(data) {
            if (data.loading) {
                return data.text
            }
            return $(`<span data-namalengkap='${data.nama_lengkap}'>${data.text}</span>`)
        }
    </script>
@endpush