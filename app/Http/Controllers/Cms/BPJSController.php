<?php

namespace App\Http\Controllers\Cms;

use Auth;
use App\Models\History;
use App\Models\Karyawan;
use App\Models\KomponenKaryawan;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BPJSController extends Controller
{
    public function index() {
        $data = Setting::bpjs()->get();
        foreach ($data as $key => $value) {
            $setting[$value->komponen_nama] = $value->komponen_nilai;
        }
        return view('cms.bpjs.index', [
            "setting" => $setting
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            foreach ($request->all() as $key => $value) {
                if ($key == "_token") {
                    continue;
                } else {
                    $model = new Setting;
                    $model->updateOrCreate(
                        [
                            'nama' => "bpjs", 
                            'komponen_nama' => $key
                        ],
                        [
                            'komponen_nilai' => $value
                        ]
                    );
                }
            }
            DB::commit();

            $this->updateKaryawan($request->all());

            History::log([
                'name' => 'BPJS',
                'nilai' => 'Update',
                'tipe' => 'Update BPJS',
                'keterangan' => json_encode($request->all()),
                'updated_by' => Auth::id(),
            ]);

            return redirect(route('bpjs'))->with("message", "Berhasil Simpan");
        } catch (Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
        }
    }

    public function updateKaryawan($data)
    {
        try {

            DB::beginTransaction();

            ini_set("memory_limit", "-1");

            $find = Karyawan::get();
            $chunks = $find->chunk(15);
            foreach ($chunks as $k => $v) {
                
                foreach ($v as $i => $data_karyawan) {
                    $model = KomponenKaryawan::whereIn('komponen_nama', ['bpjs_kesehatan', 'bpjs_tenagakerja', 'bpjs_orangtua'])
                                ->where('karyawan_id', $data_karyawan->id)
                                ->get();

                    foreach ($model as $e => $kk) {
                        if ($data_karyawan->bpjs_kesehatan == 1 && $kk->komponen_nama == 'bpjs_kesehatan') {
                            $kk->komponen_nilai = $data['bpjs_kesehatan'];
                        }
                        if ($data_karyawan->bpjs_tenagakerja == 1 && $kk->komponen_nama == 'bpjs_tenagakerja') {
                            $kk->komponen_nilai = $data['bpjs_tenagakerja'];
                        }
                        if ($data_karyawan->bpjs_orangtua == 1 && $kk->komponen_nama == 'bpjs_orangtua') {
                            $kk->komponen_nilai = $data['bpjs_orangtua'] * $data_karyawan->jumlah_orangtua;
                        }
                        $kk->save();
                    }
                }
            }

            DB::commit();

            return true;
        } catch (Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
        }
    }
}
