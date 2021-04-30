<?php

namespace App\Models;

use App\Models\KomponenKaryawan;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absensi extends BaseModel
{
    use HasFactory;

    protected $table = "absensi";
    
    public function groupDataByKaryawan($request)
    {
        foreach ($request->hitungan_hari as $key => $value) {
            $hitungan_hari[] = [
                'karyawan_id' => $key,
                'hitungan_hari' => floatval($value)
            ]; 
        }
        foreach ($request->jam_hadir as $key => $value) {
            $jam = explode(' - ',$value);
            $jam_hadir[] = [
                'karyawan_id' => $key,
                'jam_masuk' => $jam[0],
                'jam_keluar' => $jam[1],
            ]; 
        }
        foreach ($request->jam_lembur_1 as $key => $value) {
            $jam_lembur_1[] = [
                'karyawan_id' => $key,
                'jam_lembur_1' => floatval($value)
            ]; 
        }
        foreach ($request->jam_lembur_2 as $key => $value) {
            $jam_lembur_2[] = [
                'karyawan_id' => $key,
                'jam_lembur_2' => floatval($value)
            ]; 
        }
        return array_replace_recursive($hitungan_hari, $jam_hadir, $jam_lembur_1, $jam_lembur_2);
    }  
    
    public function komponenkaryawan()
    {
        return $this->hasMany(KomponenKaryawan::class, 'karyawan_id', 'karyawan_id');
    }
}
