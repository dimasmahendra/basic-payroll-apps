<div class="table-responsive">
    <table id="absensi-datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>Hadir</th>
                <th>Nama Karyawan</th>
                <th>Nilai</th>
                <th>Jam Datang</th>
                <th>Jam Lembur 1</th>
                <th>Jam Lembur 2</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($karyawan as $key => $item)
            <tr>
                <td>
                    <div class="custom-control custom-switch switch-success">
                        <input type="checkbox" class="custom-control-input" id="customSwitches{{ $key+1 }}" name="status" {{ empty($item->hitungan_hari) ? '' : 'checked' }}> 
                        <label class="custom-control-label" for="customSwitches{{ $key+1 }}"></label>
                    </div>
                </td>
                <td>{{ $item->nama_lengkap }}</td>
                <td style="width: 10%">
                    <select class="form-control nilai" name="hitungan_hari[{{ $item->id }}]" {{ isset($item->hitungan_hari) ? '' : 'disabled' }}>
                        <option value="1" {{ (!empty($item->hitungan_hari) && $item->hitungan_hari == 1.0) ? 'selected' : '' }}>1</option>
                        <option value="0.5" {{ (!empty($item->hitungan_hari) && $item->hitungan_hari == 0.5) ? 'selected' : '' }}>0.5</option>
                    </select>
                </td>
                <td style="width: 10%">
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