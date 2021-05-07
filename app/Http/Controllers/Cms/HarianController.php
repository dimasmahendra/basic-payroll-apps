<?php

namespace App\Http\Controllers\Cms;

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

class HarianController extends Controller
{
    public $type = "harian";

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
        $cache_key = "@generate-gaji-mingguan_".now();
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
}
