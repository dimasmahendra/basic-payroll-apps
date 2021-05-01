<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class AngsuranDetail extends BaseModel
{
    use HasFactory;

    protected $table = "angsuran_detail";

    protected $appends = ["sisa_angsuran"];

    public function scopeKantor($query)
    {
        return $query->where('jenis_angsuran', '=', 'kantor');
    }

    public function scopeKoperasi($query)
    {
        return $query->where('jenis_angsuran', '=', 'koperasi');
    }

    public function karyawan()
    {
        return $this->hasOne(Karyawan::class, 'id', 'karyawan_id');
    }

    public function scopeDebet($query)
    {
        return $query->where('mutasi', '=', 'debet');
    }

    public function scopeKredit($query)
    {
        return $query->where('mutasi', '=', 'kredit');
    }

    public function getSisaAngsuranAttribute()
    {
        if ($this->jenis_angsuran == 'kantor') {
            $totalKredit = $this->where('karyawan_id', $this->karyawan_id)->kantor()->kredit()->sum('saldo');
            $totalDebet = $this->where('karyawan_id', $this->karyawan_id)->kantor()->debet()->sum('saldo');
        }
        if ($this->jenis_angsuran == 'koperasi') {
            $totalKredit = $this->where('karyawan_id', $this->karyawan_id)->koperasi()->kredit()->sum('saldo');
            $totalDebet = $this->where('karyawan_id', $this->karyawan_id)->koperasi()->debet()->sum('saldo');
        }
        return $totalKredit - $totalDebet;
    }

    public function groupDataByKaryawan($request)
    {
        foreach ($request->saldo as $key => $value) {
            $saldo[] = [
                'karyawan_id' => $key,
                'saldo' => floatval(str_replace('.', '' , $value))
            ]; 
        }
        foreach ($request->keterangan as $key => $value) {
            $keterangan[] = [
                'karyawan_id' => $key,
                'keterangan' => $value,
            ]; 
        }
        foreach ($request->angsuran_ke as $key => $value) {
            $angsuran_ke[] = [
                'karyawan_id' => $key,
                'angsuran_ke' => $value,
            ]; 
        }
        return array_replace_recursive($saldo, $keterangan, $angsuran_ke);
    } 
}
