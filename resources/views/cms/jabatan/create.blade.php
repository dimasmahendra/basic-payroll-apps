@php
    $title = "Jabatan";
    $breadcrumbs[] = [
            "label" => "Master Data", "url" => route('jabatan')
        ];
    $breadcrumbs[] = [
            "label" => "Jabatan", "url" => "#"
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
        <h4 class="card-title">Tambah Jabatan</h4>
    </div>
    <div class="card-body">
        <form id="form-simpan-jabatan" method="POST" action="{{ route('jabatan.store') }}">
            {{ csrf_field() }}
            <div class="col-md-3">
                <div class="form-group">
                    <label>Nama Jabatan <span class="text-warning">*</span></label> 
                    <input type="text" class="form-control" id="nama-jabatan" name="nama" required/>
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
    
@endpush