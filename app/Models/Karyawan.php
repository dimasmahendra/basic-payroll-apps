<?php

namespace App\Models;

use App\Models\KomponenKaryawan;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Karyawan extends BaseModel
{
    use HasFactory;

    protected $table = "karyawan";

    protected $appends = ["jam_hadir"];

    public function rules()
    {
        return [
            "nik_karyawan" => "required",
            "nama_lengkap" => "required",
            "tipe" => "required",   
            "waktu_penggajian" => "required"
        ];
    }

    public function message()
    {   
        return [
            "nik_karyawan.required" => "NIK Karyawan field is required.",
            "nama_lengkap.required" => "Nama Lengkap field is required.",
            "tipe.required" => "Tipe field is required.",
            "waktu_penggajian.required" => "Waktu Penggajian field is required."
        ];
    }

    public static function boot()
    {
        parent::boot();
        self::deleted(function($model){
            $model->komponenkaryawan()->delete();
        });
    }

    public function komponenkaryawan()
    {
        return $this->hasMany(KomponenKaryawan::class, 'karyawan_id', 'id');
    }

    public function getJamHadirAttribute()
    {
        $jam_masuk = (empty($this->jam_masuk)) ? $this->jam_masuk : date('H:i', strtotime($this->jam_masuk));
        $jam_keluar = (empty($this->jam_keluar)) ? $this->jam_keluar : date('H:i', strtotime($this->jam_keluar));

        if (!empty($jam_masuk) && !empty($jam_keluar)) {
            return "{$jam_masuk} - {$jam_keluar}";
        } else {
            return "08:00 - 17:00";
        }
    }
}
