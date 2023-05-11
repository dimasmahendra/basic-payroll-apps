<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class InternalDataController extends Controller
{
    public function index(Request $request)
    {
        return redirect(route('login'));
    }

    public function karyawan(Request $request)
    {
        if (!$request->ajax()) {
            abort(404, "Not found");
        }
        $query = $request->query();
        if (!isset($query['search'])) {
            return [];
        }
        $karyawan = Karyawan::searchany($query['search'],["nik_karyawan", "nama_lengkap"])
                    ->limit(10)
                    ->get([
                        'id',
                        'nik_karyawan', 
                        'nama_lengkap'
                    ]);
        return $karyawan;
    }

    public function history()
    {
        $data = History::orderBy('created_at', 'DESC')->get();
        return view('cms.history.index', [
            "data" => $data
        ]);
    }
}
