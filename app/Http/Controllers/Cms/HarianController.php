<?php

namespace App\Http\Controllers\Cms;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        dd($karyawan);
        if (count($karyawan) > 0) {   
            dd("dimas");
        } else {
            return redirect(route('harian'))->with("error", "Tidak Ada karyawan Mingguan");
        }
    }
}
