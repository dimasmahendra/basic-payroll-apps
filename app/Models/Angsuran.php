<?php

namespace App\Models;

use App\Models\Karyawan;
use App\Models\AngsuranDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Angsuran extends BaseModel
{
    use HasFactory;

    protected $table = "angsuran";

    public function scopeKantor($query)
    {
        return $query->where('jenis_angsuran', '=', 'kantor');
    }

    public function scopeKoperasi($query)
    {
        return $query->where('jenis_angsuran', '=', 'koperasi');
    }

    public function scopeJenisAngsuran($query, $jenis)
    {
        return $query->where('jenis_angsuran', '=', $jenis);
    }

    public function scopeKredit($query)
    {
        return $query->where('mutasi_terakhir', '=', 'kredit');
    }

    public function karyawan()
    {
        return $this->hasOne(Karyawan::class, 'id', 'karyawan_id');
    }

    public function getSisaPembayaranAttribute()
    {
        if ($this->jenis_angsuran == 'kantor') {
            $totalDebet = AngsuranDetail::where('karyawan_id', $this->karyawan_id)->kantor()->debet()->sum('saldo');
            $totalKredit = AngsuranDetail::where('karyawan_id', $this->karyawan_id)->kantor()->kredit()->sum('saldo');
        }
        if ($this->jenis_angsuran == 'koperasi') {
            $totalDebet = AngsuranDetail::where('karyawan_id', $this->karyawan_id)->koperasi()->debet()->sum('saldo');
            $totalKredit = AngsuranDetail::where('karyawan_id', $this->karyawan_id)->koperasi()->kredit()->sum('saldo');
        }
        return $totalKredit - $totalDebet;
    }
}
