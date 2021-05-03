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