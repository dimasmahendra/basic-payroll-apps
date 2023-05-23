<?php
namespace App\Collections;

use Auth;
use App\Models\Angsuran;
use App\Models\History;
use App\Models\Setting;
use App\Models\GajiBulanan as Bulanan;
use Illuminate\Database\Eloquent\Collection;

class GajiBulanan extends Collection
{
    public function map($komponen): array
    {
        return [
            "karyawan_id" => $komponen->karyawan_id,
            "tipe" => $komponen->tipe,
            "komponen_nama" => $komponen->komponen_nama,
            "komponen_nilai" => $komponen->komponen_nilai,
            "periode_awal" => $komponen->periode_awal,
            "periode_akhir" => $komponen->periode_akhir,
        ];
    }

    public function dataBulanan($req)
    {
        $periode_awal = date('Y-m-d', strtotime(str_replace('/', '-', $req->periode_awal)));
        $periode_akhir = date('Y-m-d', strtotime(str_replace('/', '-', $req->periode_akhir)));

        $keterangan = "Generate Gaji Bulanan periode " . $periode_awal . " - " . $periode_akhir;
        History::create([
            'name' => 'Generate',
            'nilai' => 'Gaji',
            'tipe' => 'Bulanan',
            'keterangan' => $keterangan,
            'updated_by' => Auth::id(),
        ]);

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
                continue;
            }
            else if ($komponenkaryawan->komponen_nama == 'upah_lembur') {
                $this->checkUpahLembur($absen, $komponenkaryawan);
            }
            else if ($komponenkaryawan->komponen_nama == 'potongan_absen') {
                $this->checkPotongan($absen, $komponenkaryawan);
            }
            else if ($komponenkaryawan->komponen_nama == 'bpjs_kesehatan') {
                $this->checkBpjsKesehatan($absen, $komponenkaryawan);
            }
            else if ($komponenkaryawan->komponen_nama == 'bpjs_tenagakerja') {
                $this->checkBpjsTenagaKerja($absen, $komponenkaryawan);
            }
            else if ($komponenkaryawan->komponen_nama == 'bpjs_orangtua') {
                $this->checkBpjsOrtu($absen, $komponenkaryawan);
            }
            else if ($komponenkaryawan->komponen_nama == 'iuran_wajib') {
                $this->checkIuranWajib($absen, $komponenkaryawan);
            }
            else {
                $komponenkaryawan->komponen_nilai = floatval(str_replace('.', '' , $komponenkaryawan->komponen_nilai));        
            }
            
            $komponenkaryawan->tipe = $karyawan->waktu_penggajian;
            $komponenkaryawan->periode_awal = $periode_awal;
            $komponenkaryawan->periode_akhir = $periode_akhir;
            
            $data[] = $this->map($komponenkaryawan);
        }
        
        $data[] = $this->checkAngsuran($karyawan, $periode_awal, $periode_akhir, 'koperasi');
        $data[] = $this->checkAngsuran($karyawan, $periode_awal, $periode_akhir, 'kantor');
        $data[] = $this->checkMasukKerja($absen, $karyawan, $periode_awal, $periode_akhir);
        $data[] = $this->checkLemburSatu($absen, $karyawan, $periode_awal, $periode_akhir);
        $data[] = $this->checkLemburDua($absen, $karyawan, $periode_awal, $periode_akhir);
        
        foreach ($data as $i => $komponenbulanan) {
            $model = new Bulanan;
            $model->updateOrCreate(
                [
                    'karyawan_id' => $komponenbulanan['karyawan_id'], 
                    'periode_awal' => $komponenbulanan['periode_awal'],
                    'periode_akhir' => $komponenbulanan['periode_akhir'],
                    'komponen_nama' => $komponenbulanan['komponen_nama'],
                    'tipe' => $komponenbulanan['tipe'],
                ],
                [
                    'komponen_nilai' => $komponenbulanan['komponen_nilai'],
                    'updated_by' => Auth::id()
                ]
            );
        }
        return $data;
    }

    public function checkLemburSatu($absen, $karyawan, $awal, $akhir)
    {   
        $komponenkaryawan = new \stdClass();
        $komponenkaryawan->karyawan_id = $karyawan->id;
        $komponenkaryawan->tipe = $karyawan->waktu_penggajian;
        $komponenkaryawan->komponen_nama = "total_lembur_1";
        $komponenkaryawan->komponen_nilai = empty($absen->total_lembur_1) ? 0 : $absen->total_lembur_1;
        $komponenkaryawan->periode_awal = $awal;
        $komponenkaryawan->periode_akhir = $akhir;
        return $this->map($komponenkaryawan);
    }

    public function checkLemburDua($absen, $karyawan, $awal, $akhir)
    {   
        $komponenkaryawan = new \stdClass();
        $komponenkaryawan->karyawan_id = $karyawan->id;
        $komponenkaryawan->tipe = $karyawan->waktu_penggajian;
        $komponenkaryawan->komponen_nama = "total_lembur_2";
        $komponenkaryawan->komponen_nilai = empty($absen->total_lembur_2) ? 0 : $absen->total_lembur_2;
        $komponenkaryawan->periode_awal = $awal;
        $komponenkaryawan->periode_akhir = $akhir;
        return $this->map($komponenkaryawan);
    }

    public function checkMasukKerja($absen, $karyawan, $awal, $akhir)
    {   
        $komponenkaryawan = new \stdClass();
        $komponenkaryawan->karyawan_id = $karyawan->id;
        $komponenkaryawan->tipe = $karyawan->waktu_penggajian;
        $komponenkaryawan->komponen_nama = "masuk_kerja";
        $komponenkaryawan->komponen_nilai = empty($absen->total_masuk) ? 0 : $absen->total_masuk;
        $komponenkaryawan->periode_awal = $awal;
        $komponenkaryawan->periode_akhir = $akhir;
        return $this->map($komponenkaryawan);
    }

    public function checkBpjsOrtu($absen, $komponenkaryawan)
    {
        $totalMasuk = !empty($absen) ? $absen->total_masuk : 0;
        if ($totalMasuk > 0) {
            $nilai = 1;
        } else {
            $nilai = 0;
        }
        $nilaiPotBPJS = floatval($komponenkaryawan->komponen_nilai);
        $komponenkaryawan->komponen_nilai = $nilai  * $nilaiPotBPJS;

        return $this->map($komponenkaryawan);
    }

    public function checkBpjsKesehatan($absen, $komponenkaryawan)
    {
        $totalMasuk = !empty($absen) ? $absen->total_masuk : 0;
        if ($totalMasuk > 0) {
            $nilai = 1;
        } else {
            $nilai = 0;
        }
        $nilaiPotBPJS = floatval($komponenkaryawan->komponen_nilai);
        $komponenkaryawan->komponen_nilai = $nilai  * $nilaiPotBPJS;

        return $this->map($komponenkaryawan);
    }

    public function checkBpjsTenagaKerja($absen, $komponenkaryawan)
    {
        $totalMasuk = !empty($absen) ? $absen->total_masuk : 0;
        if ($totalMasuk > 0) {
            $nilai = 1;
        } else {
            $nilai = 0;
        }
        $nilaiPotBPJS = floatval($komponenkaryawan->komponen_nilai);
        $komponenkaryawan->komponen_nilai = $nilai  * $nilaiPotBPJS;

        return $this->map($komponenkaryawan);
    }

    public function checkIuranWajib($absen, $komponenkaryawan)
    {
        $totalMasuk = !empty($absen) ? $absen->total_masuk : 0;
        if ($totalMasuk > 0) {
            $nilai = 1;
        } else {
            $nilai = 0;
        }
        $komponenkaryawan->komponen_nilai = $nilai  * floatval(str_replace('.', '' , $komponenkaryawan->komponen_nilai));
        return $this->map($komponenkaryawan);
    }

    public function checkPotongan($absen, $komponenkaryawan)
    {
        if (!empty($absen)) {
            $total_tidak_masuk = 25 - $absen->total_masuk;
            if ($total_tidak_masuk < 0) {
                $total_tidak_masuk = 0;
            }
            $komponenkaryawan->komponen_nilai = (floatval(str_replace('.', '' , $komponenkaryawan->komponen_nilai)) / 25) * $total_tidak_masuk;
            return $this->map($komponenkaryawan);
        } else {
            return $komponenkaryawan->komponen_nilai;
        }        
    }

    public function checkUpahPokok($absen, $komponenkaryawan)
    {
        $komponenkaryawan->komponen_nilai = floatval(str_replace('.', '' , $komponenkaryawan->komponen_nilai));
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

    public function checkUpahLembur($absen, $komponenkaryawan)
    {
        $data = Setting::Jamlembur()->get();
        foreach ($data as $key => $value) {
            $setting[$value->komponen_nama] = floatval(str_replace(',', '.' , $value->komponen_nilai));
        }

        $total_lembur_1 = $setting['jam_lembur1'] * ((!empty($absen)) ? $absen->total_lembur_1 : 0) * floatval(str_replace('.', '' , $komponenkaryawan->komponen_nilai));
        $total_lembur_2 = $setting['jam_lembur2'] * ((!empty($absen)) ? $absen->total_lembur_2 : 0) * floatval(str_replace('.', '' , $komponenkaryawan->komponen_nilai));        
        $komponenkaryawan->komponen_nilai = $total_lembur_1 + $total_lembur_2;
        return $this->map($komponenkaryawan);
    }

    public function checkAngsuran($karyawan, $awal, $akhir, $jenis)
    {
        $angsuran = $karyawan->angsuran()->jenisAngsuran($jenis)->kredit()->whereBetween('tanggal_angsuran_terakhir', [$awal, $akhir])
                        ->first('nilai_angsuran_terakhir');
        $nilai = ($angsuran) ? $angsuran->nilai_angsuran_terakhir : 0;
        
        $komponenkaryawan = new \stdClass();
        $komponenkaryawan->karyawan_id = $karyawan->id;
        $komponenkaryawan->tipe = $karyawan->waktu_penggajian;
        $komponenkaryawan->komponen_nama = "angsuran_{$jenis}";
        $komponenkaryawan->komponen_nilai = $nilai;
        $komponenkaryawan->periode_awal = $awal;
        $komponenkaryawan->periode_akhir = $akhir;
        return $this->map($komponenkaryawan);
    }
}
