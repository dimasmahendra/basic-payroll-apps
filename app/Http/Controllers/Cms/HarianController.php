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
        $model = new Karyawan;
        $karyawan = $model->mingguan()->get()->dataMingguan($request);
        if (count($karyawan) > 0) { 
            return view('cms.harian.generate', [
                "karyawan" => $karyawan,
                "komponen" => KomponenGaji::get(),
                "periode" => $request->periode_awal .' - '. $request->periode_akhir
            ]);
        } else {
            return redirect(route('harian'))->with("error", "Tidak Ada karyawan Mingguan Pada periode yang di pilih.");
        }
    }
}
