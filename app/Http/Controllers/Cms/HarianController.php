<?php

namespace App\Http\Controllers\Cms;

use PDF;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\KomponenGaji;
use App\Models\Excel\GajiMingguanExport;
use App\Models\GajiMingguan as Mingguan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;

class HarianController extends Controller
{
    // public $type = "harian";

    public function index() {
        return view('cms.harian.index');
    }

    public function generate(Request $request)
    {
        DB::beginTransaction();
        try {
            $model = new Karyawan;
            $karyawan = $model->mingguan()->get()->dataMingguan($request);
            DB::commit();
            if (count($karyawan) > 0) {
                $awal = date('Y-m-d', strtotime(str_replace('/', '-', $request->periode_awal)));
                $akhir = date('Y-m-d', strtotime(str_replace('/', '-', $request->periode_akhir)));
                return view('cms.harian.generate', [
                    "karyawan" => $karyawan,
                    "komponen" => KomponenGaji::orderBy('order')->get(),
                    "periode" => $request->periode_awal .' - '. $request->periode_akhir,
                    "awal" => $awal,
                    "akhir" => $akhir
                ]);
            } else {
                return redirect(route('harian'))->with("error", "Tidak Ada karyawan Mingguan Pada periode yang di pilih.");
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
            DB::rollBack();
        }
    }

    public function export($awal, $akhir)
    {
        $karyawan = Karyawan::mingguan()->get();
        $cache_key = "@generate-gaji-mingguan-".now();
        // Cache::forget($cache_key);
        if (Cache::has($cache_key)) {
            $fromCache = Cache::get($cache_key);
            if (isset($fromCache['path']) && Storage::disk("public")->exists($fromCache['path'])) {
                return $fromCache;
            } else {
                Cache::forget($cache_key);
            }
        }
        $data = [];
        
        foreach ($karyawan as $key => $value) {
            $karyawanmingguan = $value->karyawanmingguan()
                                    ->whereDate('periode_awal', '=', $awal)
                                    ->whereDate('periode_akhir', '=', $akhir)
                                    ->get();
            foreach ($karyawanmingguan as $i => $komponen) {
                $array['no'] = $key + 1;
                $array['nik_karyawan'] = $value->nik_karyawan;
                $array['nama_lengkap'] = $value->nama_lengkap;
                $array[$komponen->komponen_nama] = $komponen->komponen_nilai;
            }
            $array['total_gaji'] = $komponen->hitungTotal($array);
            $array['total_potongan'] = $komponen->hitungPotongan($array);
            $array['periode'] = $awal . "-" . $akhir;
            $data[] = $array;
        }

        $collection = (object) collect($data);
        $gajimingguanExport = new GajiMingguanExport($collection);
        $now = date("d-m-Y H-i-s");
        $name = 'Gaji-Mingguan-Export-'.$now.'.xlsx';
        $path = "export-gaji-mingguan/$name";
        $ad = Excel::store($gajimingguanExport, $path, 'public');
        $data = [
            "file_name" => $name,
            "path" => storage_path('app/public/'. $path),
            "url" => $path
        ];
        $toCache = $data;
        Cache::rememberForever($cache_key, function() use ($toCache){
            return $toCache;
        });

        $headers = array(
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        );
        return response()->download($data['path'], $data['file_name'], $headers);
    }

    public function history()
    {
        $data = Mingguan::select('periode_awal', 'periode_akhir', 'updated_by', DB::raw('DATE(created_at) as created_at'))
                            ->distinct()
                            ->get();
                            
        return view('cms.harian.history', [
            "data" => $data
        ]);
    }

    public function detail($awal, $akhir)
    {
        $karyawan = Karyawan::select('karyawan.*')->mingguan()
                    ->join('jabatan', 'jabatan.id', '=', 'karyawan.jabatan_id')
                    ->orderBy('jabatan.order')
                    ->get();

        foreach ($karyawan as $key => $value) {
            $karyawanmingguan = $value->karyawanmingguan()
                                    ->whereDate('periode_awal', '=', $awal)
                                    ->whereDate('periode_akhir', '=', $akhir)
                                    ->get();
            foreach ($karyawanmingguan as $i => $komponen) {
                $array['no'] = $key + 1;
                $array['nik_karyawan'] = $value->nik_karyawan;
                $array['nama_lengkap'] = $value->nama_lengkap;
                $array[$komponen->komponen_nama] = $komponen->komponen_nilai;
            }
            $array['total_gaji'] = $komponen->hitungTotal($array);
            $array['total_potongan'] = $komponen->hitungPotongan($array);
            $data[] = $array;
        }

        return view('cms.harian.history-detail', [
            "komponen" => KomponenGaji::orderBy('order')->get(),
            "periode" => date('d F Y', strtotime($awal)) .' - '. date('d F Y', strtotime($akhir)),
            "karyawan" => $data,
            "awal" => $awal,
            "akhir" => $akhir
        ]);
    }

    public function pdf($awal, $akhir)
    {
        $karyawan = Karyawan::mingguan()->get();
        foreach ($karyawan as $key => $value) {
            $karyawanmingguan = $value->karyawanmingguan()
                                    ->whereDate('periode_awal', '=', $awal)
                                    ->whereDate('periode_akhir', '=', $akhir)
                                    ->get();
            $absen = $value->absen($awal, $akhir)->first();
            $komponengaji = array();
            foreach ($karyawanmingguan as $i => $komponen) {
                $array['no'] = $key + 1;
                $array['nik_karyawan'] = $value->nik_karyawan;
                $array['nama_lengkap'] = $value->nama_lengkap;
                $array['masuk_kerja'] = isset($absen->total_masuk) ? $absen->total_masuk : 0;
                $array['total_lembur_1'] = isset($absen->total_lembur_1) ? $absen->total_lembur_1 : 0;
                $array['total_lembur_2'] = isset($absen->total_lembur_2) ? $absen->total_lembur_2 : 0;
                $array[$komponen->komponen_nama] = floatval(str_replace('.', '' , $komponen->komponen_nilai));
                $array['angsuran_ke_kantor'] = isset($value->angsuranKeKantor) ? (empty($value->angsuranKeKantor->angsuran_ke_terakhir) ? 0 : $value->angsuranKeKantor->angsuran_ke_terakhir) : 0;
                $array['angsuran_ke_koperasi'] = isset($value->angsuranKeKoperasi) ? (empty($value->angsuranKeKoperasi->angsuran_ke_terakhir) ? 0 : $value->angsuranKeKoperasi->angsuran_ke_terakhir) : 0;
            }
            $array['total_gaji'] = $komponen->hitungTotal($array);
            $array['total_potongan'] = $komponen->hitungPotongan($array);
            $data[] = $array;
        }
        $collection = collect($data);
        // return view('cms.harian.pdf-gaji', [
        //     "data" => $collection,
        //     "awal" => $awal
        // ]);

        $pdf = PDF::loadView('cms.harian.pdf-gaji', [
            "data" => $collection,
            "awal" => $awal
        ]);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream();
    }
}
