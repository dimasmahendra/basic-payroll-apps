<?php

namespace App\Http\Controllers\Cms;

use App\Models\Karyawan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index() {
        $karyawan = Karyawan::get();
        return view('cms.absensi.index', [
            "karyawan" => $karyawan
        ]);
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
