<?php

namespace App\Http\Controllers\Cms;

use App\Models\Angsuran;
use App\Models\AngsuranDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AngsuranController extends Controller
{
    public function indexKantor() {
        $angsuran = Angsuran::kantor()->get();
        return view('cms.angsuran.kantor.index', [
            "angsuran" => $angsuran
        ]);
    }

    public function indexKoperasi() {
        $angsuran = Angsuran::koperasi()->get();
        return view('cms.angsuran.koperasi.index', [
            "angsuran" => $angsuran
        ]);
    }

    public function create()
    {
        return view('cms.angsuran.create');
    }

    public function store(Request $request)
    {
        $karyawan_id = $request->karyawan_id;
        $jenis_angsuran =$request->jenis_angsuran;

        $model = new AngsuranDetail;
        $model->karyawan_id = $karyawan_id;
        $model->jenis_angsuran = $jenis_angsuran;
        $model->mutasi = $request->mutasi;
        $model->tanggal_angsuran = date('Y-m-d', strtotime(str_replace('/', '-', $request->tanggal_angsuran)));
        $model->saldo = floatval(str_replace('.', '' ,$request->nominal));
        $model->keterangan = $request->keterangan;
        $model->save();        

        $angsuran = Angsuran::where('karyawan_id', $karyawan_id)->where('jenis_angsuran', $jenis_angsuran)->first();
        if (empty($angsuran)) {
            $angsuran = new Angsuran;
        }

        $angsuran->karyawan_id = $karyawan_id;
        $angsuran->jenis_angsuran = $model->jenis_angsuran;
        $angsuran->sisa_angsuran = $model->sisa_angsuran;
        $angsuran->save();

        return redirect(route('angsuran.show', [
                "jenis" => $model->jenis_angsuran,
                "id" => $karyawan_id
            ]))->with("message", "Simpan Berhasil");
    }

    public function show($jenis, $id)
    {
        $angsuran = AngsuranDetail::where('karyawan_id', $id)->where('jenis_angsuran', $jenis)->get();
        return view('cms.angsuran.'.$jenis.'.detail', [
            "angsuran" => $angsuran
        ]);
    }
}
