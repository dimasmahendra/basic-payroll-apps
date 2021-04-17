@php
    $title = "Karyawan";
    $breadcrumbs[] = [
            "label" => "Daftar", "url" => route('karyawan')
        ];
    $breadcrumbs[] = [
            "label" => "Edit", "url" => "#"
        ];
@endphp

@extends('layouts.cms', [
    "title" => $title,
    "breadcrumbs" => $breadcrumbs
])

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Edit Karyawan</h4>
    </div>
    <div class="card-body">
        <form id="form-simpan-nikah" method="POST" action="{{ route('karyawan.update', [$id]) }}">
            {{ csrf_field() }}
            @method('PUT')
            <div class="col-md-3">
                <div class="form-group">
                    <label>NIK Karyawan <span class="text-warning">*</span></label> 
                    <input type="text" class="form-control" id="nik-karyawan" name="nik_karyawan" value="{{ $karyawan->nik_karyawan }}" required/>
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <div class="custom-control custom-switch switch-success">
                        <input type="checkbox" class="custom-control-input" id="customSwitchSuccess" name="status" {{ ($karyawan->status == 1) ? 'checked' : '' }}> 
                        <label class="custom-control-label" for="customSwitchSuccess">Status Karyawan</label>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nama Lengkap <span class="text-warning">*</span></label> 
                    <input type="text" class="form-control" id="nama-lengkap" name="nama_lengkap" value="{{ $karyawan->nama_lengkap }}" required/>
                </div>
            </div>
            <div class="row col-md-10">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Tipe Gaji Karyawan <span class="text-warning">*</span></label> 
                        <select class="form-control" id="tipegaji" name="tipe" required>
                            <option value="mingguan" {{ ($karyawan->tipe == 'mingguan') ? 'selected' : '' }}>Mingguan</option>
                            <option value="bulanan" {{ ($karyawan->tipe == 'bulanan') ? 'selected' : '' }}>Bulanan</option>
                        </select>
                    </div>
                </div>
                <div class="container-waktugajian col-md-2">
                    @if ($karyawan->tipe == 'bulanan')
                        @include('cms.partial.bulanan')
                    @else
                        @include('cms.partial.mingguan')
                    @endif
                </div>
            </div>
            <div class="row col-md-8">
                @foreach ($komponen as $item)
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{ $item->label }}</label> 
                            <input type="text" class="form-control currency" name="{{ $item->id .'|'. $item->nama }}" value="{{ $item->komponen_nilai }}"/>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-success">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('css-plugins')

@endpush

@push('js-plugins')
    <script>
        $(document).on('change', '#tipegaji', function() {
            let tipe = $(this).val();
            $(".container-waktugajian").load('/partial-waktu-' + tipe);
        });
    </script>
@endpush