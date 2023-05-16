@php
    $title = "Jam Lembur";
    $breadcrumbs[] = [
            "label" => "Master Data", "url" => route('jam-lembur')
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
        <h4 class="card-title">Master Data Jam Lembur</h4>
    </div>
    <div class="card-body">
        <form id="form-simpan-jabatan" method="POST" action="{{ route('jam-lembur.store') }}">
            {{ csrf_field() }}
            <div class="col-md-3">
                <div class="form-group">
                    <label>Jam Lembur 1 <span class="text-warning">*</span></label> 
                    <input type="text" class="form-control currency" id="jam_lembur1" name="jam_lembur1" value="{{ $setting['jam_lembur1'] }}" required/>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Jam Lembur 2 <span class="text-warning">*</span></label> 
                    <input type="text" class="form-control currency" id="jam_lembur1" name="jam_lembur2" value="{{ $setting['jam_lembur2'] }}" required/>
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