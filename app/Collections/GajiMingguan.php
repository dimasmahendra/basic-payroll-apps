<?php
namespace App\Collections;

use App\Models\Angsuran;
use Illuminate\Database\Eloquent\Collection;

class GajiMingguan extends Collection
{
    public function map($komponen): array
    {
        return [
            "karyawan_id" => $komponen->karyawan_id,
            "komponen_nama" => $komponen->komponen_nama,
            "komponen_nilai" => $komponen->komponen_nilai,
            "periode_awal" => $komponen->periode_awal,
            "periode_akhir" => $komponen->periode_akhir,
        ];
    }

    public function dataMingguan($req)
    {
        $periode_awal = date('Y-m-d', strtotime(str_replace('/', '-', $req->periode_awal)));
        $periode_akhir = date('Y-m-d', strtotime(str_replace('/', '-', $req->periode_akhir)));

        foreach ($this as $key => $value) {
            $userKomponen = array();
            foreach ($value->komponenkaryawan as $k => $komponenkaryawan) {
                if ($komponenkaryawan->komponen_nama == 'upah_pokok') {
                    $this->checkUpahPokok($value->absen, $komponenkaryawan);
                }
                if ($komponenkaryawan->komponen_nama == 'tunjangan_makan') {
                    $this->checkTunjanganMakan($value->absen, $komponenkaryawan);
                }
                else if ($komponenkaryawan->komponen_nama == 'bonus_masuk') {
                    $this->checkBonusMasuk($value->absen, $komponenkaryawan);
                }
                else if ($komponenkaryawan->komponen_nama == 'upah_lembur') {
                    $this->checkUpahLembur($value->absen, $komponenkaryawan);
                }
                else if ($komponenkaryawan->komponen_nama == 'angsuran_hutang_koperasi') {
                    $this->checkAngsuran($komponenkaryawan, $periode_awal, $periode_akhir, 'koperasi');
                }
                else if ($komponenkaryawan->komponen_nama == 'angsuran_hutang_kantor') {
                    $this->checkAngsuran($komponenkaryawan, $periode_awal, $periode_akhir, 'kantor');
                } 
                else {
                    $komponenkaryawan->komponen_nilai = floatval(str_replace('.', '' , $komponenkaryawan->komponen_nilai));        
                }
                $komponenkaryawan->periode_awal = $periode_awal;
                $komponenkaryawan->periode_akhir = $periode_akhir;
                $userKomponen[] = $this->map($komponenkaryawan);
            }
            $komponen[] = $userKomponen;
        }
        dd($komponen);
    }

    public function checkAngsuran($komponenkaryawan, $awal, $akhir, $jenis)
    {
        $angsuran = Angsuran::jenisAngsuran($jenis)->where([
                            'karyawan_id' => $komponenkaryawan->karyawan_id,    
                            'mutasi_terakhir' => 'kredit',
                        ])
                        ->whereBetween('tanggal_angsuran_terakhir', [$awal, $akhir])
                        ->first('nilai_angsuran_terakhir');
        $nilai = ($angsuran) ? $angsuran->nilai_angsuran_terakhir : 0;
        if ($nilai == 0) {
            $komponenkaryawan->komponen_nilai = floatval(str_replace('.', '' , $komponenkaryawan->komponen_nilai));
        } else {
            $komponenkaryawan->komponen_nilai = "($nilai)";
        }
        return $this->map($komponenkaryawan);
    }

    public function checkUpahPokok($absen, $komponenkaryawan)
    {
        $komponenkaryawan->komponen_nilai = (($absen) ? $absen->total_masuk : 0)  * floatval(str_replace('.', '' , $komponenkaryawan->komponen_nilai));
        return $this->map($komponenkaryawan);
    }

    public function checkBonusMasuk($absen, $komponenkaryawan)
    {
        $total_masuk = ($absen) ? $absen->total_masuk : 0;
        $komponenkaryawan->komponen_nilai = (($total_masuk == 6) ? $total_masuk : 0)  * floatval(str_replace('.', '' , $komponenkaryawan->komponen_nilai));
        return $this->map($komponenkaryawan);
    }

    public function checkUpahLembur($absen, $komponenkaryawan)
    {
        $total_lembur_1 = 1.5 * (($absen) ? $absen->total_lembur_1 : 0) * floatval(str_replace('.', '' , $komponenkaryawan->komponen_nilai));
        $total_lembur_2 = 2 * (($absen) ? $absen->total_lembur_2 : 0) * floatval(str_replace('.', '' , $komponenkaryawan->komponen_nilai));        
        $komponenkaryawan->komponen_nilai = $total_lembur_1 + $total_lembur_2;
        return $this->map($komponenkaryawan);
    }

    public function checkTunjanganMakan($absen, $komponenkaryawan)
    {
        $komponenkaryawan->komponen_nilai = (($absen) ? $absen->total_masuk : 0)  * floatval(str_replace('.', '' , $komponenkaryawan->komponen_nilai));
        return $this->map($komponenkaryawan);
    }
}
