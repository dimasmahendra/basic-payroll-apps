<?php

namespace App\Http\Controllers\Cms;

use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\KomponenGaji;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HarianController extends Controller
{
    public $type = "harian";

    public function index() {
        return view('cms.harian.index');
    }

    public function generate(Request $request)
    {
        $model = new Absensi;
        // $karyawan = $model->mingguan()->get()->dataMingguan($request);

        $periode_awal = date('Y-m-d', strtotime(str_replace('/', '-', $request->periode_awal)));
        $periode_akhir = date('Y-m-d', strtotime(str_replace('/', '-', $request->periode_akhir)));
        $karyawan = $model->select([
            'absensi.karyawan_id',
            DB::raw("SUM(absensi.hitungan_hari) as total_masuk"),
            DB::raw("SUM(absensi.jam_lembur_1) as total_lembur_1"),
            DB::raw("SUM(absensi.jam_lembur_2) as total_lembur_2"),
        ])
        ->leftJoin('karyawan', function($query) {
            $query->on('absensi.karyawan_id', '=', 'karyawan.id')
            ->where('karyawan.tipe', 'like', '%mingguan%');
        })
        ->whereBetween('tanggal_kehadiran', [$periode_awal, $periode_akhir])
        ->groupBy('absensi.karyawan_id')
        ->get();

        if (count($karyawan) > 0) { 
            return view('cms.harian.generate', [
                "karyawan" => $karyawan,
                "komponen" => KomponenGaji::get(),
                "periode" => $request->periode_awal .' - '. $request->periode_akhir
            ]);
        } else {
            return redirect(route('harian'))->with("error", "Tidak Ada karyawan Mingguan");
        }
    }
}
