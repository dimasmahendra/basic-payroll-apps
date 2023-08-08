<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GajiBulanan extends BaseModel
{
    use HasFactory;

    protected $table = "gaji_bulanan";

    public function hitungTotal($komponen)
    {
        $sum = 0;
        $pemasukan = [
            'upah_pokok',
            'tunjangan_makan',
            'tunjangan_stkr',
            'tunjangan_prh',
            'tunjangan_phg',
            'upah_lembur',
        ];
        foreach ($komponen as $key => $value) {
            if (in_array($key, $pemasukan)) {
                $sum += $value;
            }
        }
        return $sum;
    }

    public function hitungPotongan($komponen)
    {
        $sum = 0;
        $pemasukan = [
            'bpjs_kesehatan',
            'bpjs_tenagakerja',
            'bpjs_orangtua',
            'iuran_wajib',
            'potongan_absen',
            'angsuran_koperasi',
            'angsuran_kantor',
        ];
        foreach ($komponen as $key => $value) {
            if (in_array($key, $pemasukan)) {
                $sum += $value;
            }
        }
        return $sum;
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }
}
