<?php
namespace App\Collections;

use App\Models\Angsuran;
use App\Models\GajiMingguan as Mingguan;
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

        $komponen = array();
        foreach ($this as $key => $karyawan) {
            $data['komponen'] = $this->dataKomponen($karyawan, $periode_awal, $periode_akhir);
            $data['karyawan'] = $karyawan->toArray();
            $komponen[] = $data;
        }

        return $komponen;
    }

    public function dataKomponen($karyawan, $periode_awal, $periode_akhir)
    {
        $absen = $karyawan->absen($periode_awal, $periode_akhir)->first();
        foreach ($karyawan->komponenkaryawan as $k => $komponenkaryawan) {
            if ($komponenkaryawan->komponen_nama == 'upah_pokok') {
                $this->checkUpahPokok($absen, $komponenkaryawan);
            }
            else if ($komponenkaryawan->komponen_nama == 'tunjangan_makan') {
                $this->checkTunjanganMakan($absen, $komponenkaryawan);
            }
            else if ($komponenkaryawan->komponen_nama == 'tunjangan_stkr') {
                $this->checkTunjanganStkr($absen, $komponenkaryawan);
            }
            else if ($komponenkaryawan->komponen_nama == 'tunjangan_prh') {
                $this->checkTunjanganPrh($absen, $komponenkaryawan);
            }
            else if ($komponenkaryawan->komponen_nama == 'bonus_masuk') {
                $this->checkBonusMasuk($absen, $komponenkaryawan);
            }
            else if ($komponenkaryawan->komponen_nama == 'upah_lembur') {
                $this->checkUpahLembur($absen, $komponenkaryawan);
            }
            else {
                $komponenkaryawan->komponen_nilai = floatval(str_replace('.', '' , $komponenkaryawan->komponen_nilai));        
            }
            
            $komponenkaryawan->periode_awal = $periode_awal;
            $komponenkaryawan->periode_akhir = $periode_akhir;

            $data[] = $this->map($komponenkaryawan);
        }
        $data[] = $this->checkAngsuran($karyawan, $periode_awal, $periode_akhir, 'koperasi');
        $data[] = $this->checkAngsuran($karyawan, $periode_awal, $periode_akhir, 'kantor');

        foreach ($data as $i => $komponenmingguan) {
            $model = new Mingguan;
            $model->updateOrCreate(
                [
                    'karyawan_id' => $komponenmingguan['karyawan_id'], 
                    'periode_awal' => $komponenmingguan['periode_awal'],
                    'periode_akhir' => $komponenmingguan['periode_akhir'],
                    'komponen_nama' => $komponenmingguan['komponen_nama']
                ],
                [
                    'komponen_nilai' => $komponenmingguan['komponen_nilai']
                ]
            );
        }
        return $data;
    }

    public function checkUpahPokok($absen, $komponenkaryawan)
    {
        $komponenkaryawan->komponen_nilai = ((!empty($absen)) ? $absen->total_masuk : 0)  * floatval(str_replace('.', '' , $komponenkaryawan->komponen_nilai));
        return $this->map($komponenkaryawan);
    }

    public function checkTunjanganMakan($absen, $komponenkaryawan)
    {
        $komponenkaryawan->komponen_nilai = floatval(str_replace('.', '' , $komponenkaryawan->komponen_nilai));
        return $this->map($komponenkaryawan);
    }

    public function checkTunjanganStkr($absen, $komponenkaryawan)
    {
        $komponenkaryawan->komponen_nilai = floatval(str_replace('.', '' , $komponenkaryawan->komponen_nilai));
        return $this->map($komponenkaryawan);
    }

    public function checkTunjanganPrh($absen, $komponenkaryawan)
    {
        $komponenkaryawan->komponen_nilai = floatval(str_replace('.', '' , $komponenkaryawan->komponen_nilai));
        return $this->map($komponenkaryawan);
    }

    public function checkBonusMasuk($absen, $komponenkaryawan)
    {
        $total_masuk = (!empty($absen)) ? $absen->total_masuk : 0;
        $komponenkaryawan->komponen_nilai = (($total_masuk == 6) ? $total_masuk : 0)  * floatval(str_replace('.', '' , $komponenkaryawan->komponen_nilai));
        return $this->map($komponenkaryawan);
    }

    public function checkUpahLembur($absen, $komponenkaryawan)
    {
        $total_lembur_1 = 1.5 * ((!empty($absen)) ? $absen->total_lembur_1 : 0) * floatval(str_replace('.', '' , $komponenkaryawan->komponen_nilai));
        $total_lembur_2 = 2 * ((!empty($absen)) ? $absen->total_lembur_2 : 0) * floatval(str_replace('.', '' , $komponenkaryawan->komponen_nilai));        
        $komponenkaryawan->komponen_nilai = $total_lembur_1 + $total_lembur_2;
        return $this->map($komponenkaryawan);
    }

    /* public function checkBpjsOrangTua($absen, $komponenkaryawan)
    {
        # code...
    } */

    public function checkAngsuran($karyawan, $awal, $akhir, $jenis)
    {
        $angsuran = $karyawan->angsuran()->jenisAngsuran($jenis)->whereBetween('tanggal_angsuran_terakhir', [$awal, $akhir])
                        ->first('nilai_angsuran_terakhir');
        $nilai = ($angsuran) ? $angsuran->nilai_angsuran_terakhir : 0;
        
        $komponenkaryawan = new \stdClass();
        $komponenkaryawan->karyawan_id = $karyawan->id;
        $komponenkaryawan->komponen_nama = "angsuran_{$jenis}";
        $komponenkaryawan->komponen_nilai = $nilai;
        $komponenkaryawan->periode_awal = $awal;
        $komponenkaryawan->periode_akhir = $akhir;
        return $this->map($komponenkaryawan);
    }
}
