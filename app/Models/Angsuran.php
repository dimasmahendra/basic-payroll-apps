<?php

namespace App\Models;

use App\Models\Karyawan;
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

    public function karyawan()
    {
        return $this->hasOne(Karyawan::class, 'id', 'karyawan_id');
    }
}
