@php
    $title = "Absensi";
    $breadcrumbs[] = ["label" => "Absensi", "url" => "#"];
@endphp

@extends('layouts.cms', [
    "title" => $title,
    "breadcrumbs" => $breadcrumbs,
])

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="card-title">Daftar Karyawan</h4>
            </div>
            <div class="col-auto">
                <button class="btn btn-outline-success waves-effect waves-light d-inline-block" id="simpan-absensi">
                    <i class="mdi mdi-plus-circle-outline mr-2"></i>Simpan Data
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form id="form-absensi" method="POST" action="{{ route('absensi.store') }}">
            {{ csrf_field() }}
            <div class="col-md-2">
                <div class="form-group">
                    <label>Tanggal Hadir<span class="text-warning">*</span></label> 
                    <input type="text" class="form-control tanggal-kehadiran" name="tanggal_kehadiran" required/>
                </div>
            </div>
            <div class="table-responsive" id="section-absensi">
                <table id="absensi-datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>Hadir</th>
                            <th>Nama Karyawan</th>
                            <th>Hitungan Hari</th>
                            <th>Jam Datang</th>
                            <th>Jam Lembur 1</th>
                            <th>Jam Lembur 2</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($karyawan as $key => $item)
                        <tr>
                            <td style="width: 5%">
                                <div class="custom-control custom-switch switch-success">
                                    <input type="checkbox" class="custom-control-input" id="customSwitches{{ $key+1 }}" name="status" {{ empty($item->hitungan_hari) ? '' : 'checked' }}> 
                                    <label class="custom-control-label" for="customSwitches{{ $key+1 }}"></label>
                                </div>
                            </td>
                            <td style="width: 20%">{{ $item->nama_lengkap }}</td>
                            <td style="width: 10%">
                                <select class="form-control nilai" name="hitungan_hari[{{ $item->id }}]" {{ isset($item->hitungan_hari) ? '' : 'disabled' }}>
                                    <option value="0.5" {{ (!empty($item->hitungan_hari) && $item->hitungan_hari == 0.5) ? 'selected' : '' }}>0.5</option>
                                    <option value="1" {{ (!empty($item->hitungan_hari) && $item->hitungan_hari == 1.0) ? 'selected' : '' }}>1</option>
                                    <option value="2" {{ (!empty($item->hitungan_hari) && $item->hitungan_hari == 2) ? 'selected' : '' }}>2</option>
                                </select>
                            </td>
                            <td style="width: 15%">
                                <input type="text" class="form-control jam-hadir" name="jam_hadir[{{ $item->id }}]" 
                                value="{{ $item->jam_hadir }}" 
                                {{ isset($item->hitungan_hari) ? '' : 'disabled' }}/>
                            </td>
                            <td style="width: 10%">
                                <input type="text" class="form-control jam-lembur-1" name="jam_lembur_1[{{ $item->id }}]" 
                                value="{{ empty($item->jam_lembur_1) ? '' : $item->jam_lembur_1 }}"
                                {{ isset($item->hitungan_hari) ? '' : 'disabled' }}/>
                            </td>
                            <td style="width: 10%">
                                <input type="text" class="form-control jam-lembur-2" name="jam_lembur_2[{{ $item->id }}]" 
                                value="{{ empty($item->jam_lembur_2) ? '' : $item->jam_lembur_2 }}"
                                {{ isset($item->hitungan_hari) ? '' : 'disabled' }}/>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>
@endsection

@push('css-plugins')

@endpush

@push('js-plugins')
    @php
        if (count($event) > 0) {
            foreach ($event as $key => $value) {
                $parseEvent[$value] = $value;
            }
        } else {
            $parseEvent = array();
        }
    @endphp
    <script>
        function init() {
            $('#absensi-datatable').dataTable( {
                "ordering": false,
                "bLengthChange" : false
            });
            $(document).on('change', '.custom-control-input', function() {
                $(this).closest('tr').find('.nilai, .jam-hadir, .jam-lembur-1, .jam-lembur-2').prop('disabled', !this.checked);
            })
            
            $('.jam-hadir').daterangepicker({
                timePicker: true,
                timePicker24Hour: true,
                timePickerIncrement: 1,
                locale: {
                    format: 'HH:mm'
                },
            }).on('show.daterangepicker', function (ev, picker) {
                picker.container.find(".calendar-table").hide();
            });

            $(document).on('click', '#simpan-absensi', function() {
                $("#form-absensi").submit();
            });
        }

        $(document).ready(function() {
            init();
        });
        
        var eventDates = {!! json_encode($parseEvent); !!}

        $(".tanggal-kehadiran").daterangepicker({
            locale: {
                format: 'DD/MM/YYYY',
            },
            singleDatePicker: true,
            isCustomDate: function( date ) {
                console.log(eventDates);
                var highlight = eventDates[moment(date).format("YYYY-MM-DD HH:mm:ss")];
                if( highlight ) {
                    return [true, "event-date", ''];
                } else {
                    return [true, '', ''];
                }
            },
        }, function (start) {
            var date = start.format('YYYY-MM-DD');
            $.ajax({
                url: '?t=' + date,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $("body").addClass("loading"); 
                },
                success: function (data) {
                    console.log(data);
                    $('#section-absensi').empty();
                    $('#section-absensi').html(data);
                    init();
                    $("body").removeClass("loading"); 
                }
            });
        });
    </script>
@endpush