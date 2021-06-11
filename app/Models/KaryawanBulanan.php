<?php

namespace App\Models;

use App\Models\Angsuran;
use App\Models\KomponenKaryawan;
use App\Models\GajiBulanan as Bulanan;
use App\Collections\GajiBulanan;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KaryawanBulanan extends BaseModel
{
    use HasFactory;

    protected $table = "karyawan";

    public function newCollection(array $models = [])
    {
        return new GajiBulanan($models);
    }

    public function scopeBulanan($query)
    {
        return $query->where('tipe', 'like', '%bulanan%')->where(['status' => '1']);
    }

    public function scopeJenisWaktu($query, $jenis)
    {
        return $query->where('waktu_penggajian', 'like', '%' . $jenis . '%');
    }

    public function komponenkaryawan()
    {
        return $this->hasMany(KomponenKaryawan::class, 'karyawan_id', 'id');
    }

    public function absen($awal, $akhir)
    {
        return $this->hasOne(Absensi::class, 'karyawan_id', 'id')
                ->select([
                    'absensi.karyawan_id',
                    DB::raw("SUM(absensi.hitungan_hari) as total_masuk"),
                    DB::raw("SUM(absensi.jam_lembur_1) as total_lembur_1"),
                    DB::raw("SUM(absensi.jam_lembur_2) as total_lembur_2"),
                ])
                ->whereBetween('tanggal_kehadiran', [$awal, $akhir])
                ->groupBy('absensi.karyawan_id');
    }

    public function angsuran()
    {
        return $this->hasOne(Angsuran::class, 'karyawan_id', 'id');
    }

    public function karyawanbulanan()
    {
        return $this->hasMany(Bulanan::class, 'karyawan_id', 'id');
    }

    public function angsuranKeKantor()
    {
        return $this->hasOne(Angsuran::class, 'karyawan_id', 'id')
                    ->where('jenis_angsuran', 'kantor');
    }

    public function angsuranKeKoperasi()
    {
        return $this->hasOne(Angsuran::class, 'karyawan_id', 'id')
                    ->where('jenis_angsuran', 'koperasi');
    }
}
