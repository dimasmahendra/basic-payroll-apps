<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class KomponenKaryawan extends BaseModel
{
    use HasFactory;

    protected $table = "komponen_karyawan";

    public function formatData($data)
    {
        $jumlah_orangtua = $data['jumlah_orangtua'];
        foreach ($data as $key => $value) {     
            $komponens = explode("|", $key);
            if (count($komponens) == 2) {
                list($k, $v) = $komponens;
                if ($v == "bpjs_orangtua") {
                    $value = floatval(str_replace('.', '' , $value)) * $jumlah_orangtua;
                } else {
                    $value = floatval(str_replace('.', '' , $value));
                }
                $result[] = [
                    'komponen_id' => $k,
                    'komponen_nama' => $v,
                    'komponen_nilai' => ($value == null) ? 0 : $value,
                ];
            } else {
                unset($komponens);
            }
        }
        return $result;
    }
}
