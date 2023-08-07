@php
    $title = "Angsuran Kantor";
    $breadcrumbs[] = ["label" => "Angsuran Kantor", "url" => "#"];
    $breadcrumbs[] = ["label" => "Pembayaran Angsuran", "url" => "#"];
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
                <h4 class="card-title">Daftar Pembayaran Angsuran Karyawan</h4>
            </div>
            <div class="col-auto">
                <button class="btn btn-outline-success waves-effect waves-light d-inline-block" id="simpan-bayar-angsuran">
                    <i class="mdi mdi-plus-circle-outline mr-2"></i>Simpan Data
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form id="form-bayar-angsuran-kantor" method="POST" action="{{ route('angsuran.bayar') }}">
            {{ csrf_field() }}
            <div class="col-md-2">
                <div class="form-group">
                    <label>Tanggal Hadir<span class="text-warning">*</span></label> 
                    <input type="text" class="form-control tanggal-angsuran" name="tanggal_angsuran" required/>
                </div>
            </div>
            <input type="hidden" name="jenis_angsuran" value="kantor" />
            <input type="hidden" name="mutasi" value="kredit" />
            <div class="table-responsive" id="section-absensi">
                <table id="absensi-datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>Aksi</th>
                            <th>Nama Karyawan</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>Angsuran Ke</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($karyawan as $key => $item)
                        <tr>
                            <td style="width: 5%">
                                <div class="custom-control custom-switch switch-success">
                                    <input type="checkbox" class="custom-control-input" id="customSwitches{{ $key+1 }}" name="status" {{ empty($item->tanggal_angsuran) ? '' : 'checked' }}> 
                                    <label class="custom-control-label" for="customSwitches{{ $key+1 }}"></label>
                                </div>
                            </td>
                            <td style="width: 20%">{{ $item->nama_lengkap }}</td>
                            <td style="width: 15%">
                                <input type="text" class="form-control saldo currency" name="saldo[{{ $item->id }}]" 
                                value="{{ empty($item->saldo) ? '' : $item->saldo }}"
                                {{ isset($item->tanggal_angsuran) ? '' : 'disabled' }}/>
                            </td>
                            <td style="width: 30%">
                                <input type="text" class="form-control keterangan" name="keterangan[{{ $item->id }}]" 
                                value="{{ empty($item->keterangan) ? '' : $item->keterangan }}"
                                {{ isset($item->tanggal_angsuran) ? '' : 'disabled' }}/>
                            </td>
                            <td style="width: 5%">
                                <input type="text" class="form-control angsuran_ke" name="angsuran_ke[{{ $item->id }}]" 
                                value="{{ empty($item->angsuran_ke) ? '' : $item->angsuran_ke }}"
                                {{ isset($item->tanggal_angsuran) ? '' : 'disabled' }}/>
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
                "bLengthChange" : false,
                "pageLength": 50
            });
            $(document).on('change', '.custom-control-input', function() {
                $(this).closest('tr').find('.saldo, .keterangan, .angsuran_ke').prop('disabled', !this.checked);
            })

            $(document).on('click', '#simpan-bayar-angsuran', function() {
                $("#form-bayar-angsuran-kantor").submit();
            });

            $(".currency").maskMoney({
                thousands: ".",
                decimal:',',
                precision: 0,
                affixesStay: false,
                allowZero: true
            })
        }

        $(document).ready(function() {
            init();
        });
        
        var eventDates = {!! json_encode($parseEvent); !!}

        $(".tanggal-angsuran").daterangepicker({
            locale: {
                format: 'DD/MM/YYYY',
            },
            singleDatePicker: true,
            isCustomDate: function( date ) {
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
                success: function (data) {
                    console.log(data);
                    $('#section-absensi').empty();
                    $('#section-absensi').html(data);
                    init();
                }
            });
        });
    </script>
@endpush