
<div class="form-group">
    <label>Waktu Penggajian <span class="text-warning">*</span></label> 
    <select class="form-control" id="waktugaji-bulanan" name="waktu_penggajian" required>
        <option value="awal" {{ (isset($karyawan) && $karyawan->waktu_penggajian == 'awal') ? 'selected' : '' }}>Awal</option>
        <option value="tengah" {{ (isset($karyawan) && $karyawan->waktu_penggajian == 'tengah') ? 'selected' : '' }}>Tengah</option>
    </select>
</div>