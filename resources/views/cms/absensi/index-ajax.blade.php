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
                        <input type="checkbox" class="custom-control-input" id="customSwitches{{ $key+1 }}" name="status"> 
                        <label class="custom-control-label" for="customSwitches{{ $key+1 }}"></label>
                    </div>
                </td>
                <td>{{ $item->nama_lengkap }}</td>
                <td style="width: 10%">
                    <select class="form-control nilai" name="nilai[{{ $item->id }}]" disabled>
                        <option value="1">1</option>
                        <option value="0.5">0.5</option>
                    </select>
                </td>
                <td style="width: 10%">
                    <input type="text" class="form-control jam-hadir" name="jam_hadir[{{ $item->id }}]" disabled/>
                </td>
                <td style="width: 10%">
                    <input type="text" class="form-control jam-lembur-1" name="jam_lembur_1[{{ $item->id }}]" disabled/>
                </td>
                <td style="width: 10%">
                    <input type="text" class="form-control jam-lembur-2" name="jam_lembur_2[{{ $item->id }}]" disabled/>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>