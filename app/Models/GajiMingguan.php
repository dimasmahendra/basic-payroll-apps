<?php

namespace App\Models;

use App\Models\KomponenGaji;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GajiMingguan extends BaseModel
{
    use HasFactory;

    protected $table = "gaji_mingguan";

    protected $appends = ["total_pemasukan"];

    public function komponengaji()
    {
        return $this->hasOne(KomponenGaji::class, 'nama', 'komponen_nama');
    }

    public function hitungTotal($komponen)
    {
        $sum = 0;
        $pemasukan = [
            'upah_pokok',
            'tunjangan_makan',
            'tunjangan_stkr',
            'tunjangan_prh',
            'bonus_masuk',
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
            // 'angsuran_koperasi',
            // 'angsuran_kantor',
        ];
        foreach ($komponen as $key => $value) {
            if (in_array($key, $pemasukan)) {
                $sum += $value;
            }
        }
        return $sum;
    }
}
