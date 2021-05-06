<?php

namespace App\Http\Controllers\Cms;

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
            return redirect(route('bpjs'))->with("message", "Berhasil Simpan");
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
        }
    }
}
