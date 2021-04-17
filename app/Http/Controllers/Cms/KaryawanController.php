<?php

namespace App\Http\Controllers\Cms;

use App\Helpers\CommonHelper;
use App\Models\Karyawan;
use App\Models\KomponenGaji;
use App\Models\KomponenKaryawan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KaryawanController extends Controller
{
    public function index() {
        $karyawan = Karyawan::get();
        return view('cms.karyawan.index', [
            "karyawan" => $karyawan
        ]);
    }

    public function create()
    {
        $komponen = KomponenGaji::orderBy('order')->get();
        return view('cms.karyawan.create', [
            "komponen" => $komponen
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $model = new Karyawan($request->all());
            $model->validate();
            if ($model->fails) {
                return redirect(route('karyawan.create'))
                ->withErrors($model->errors)
                ->withInput();
            }

            $model->nik_karyawan = $request->nik_karyawan;
            $model->nama_lengkap = $request->nama_lengkap;
            $model->tipe = $request->tipe;
            $model->waktu_penggajian = $request->waktu_penggajian;
            $model->status = (isset($request->status) && $request->status == "on") ? '1' : '0';
            $model->save();       

            $komponentKaryawan = new KomponenKaryawan;
            $komponen = $komponentKaryawan->formatData($request->all());
            foreach ($komponen as $key => $value) {
                $attr = clone $komponentKaryawan;
                $attr->karyawan_id = $model->id;
                $attr->komponen_id = $value['komponen_id'];
                $attr->komponen_nama = $value['komponen_nama'];
                $attr->komponen_nilai = $value['komponen_nilai'];
                $attr->save();
            }
            
            DB::commit();
            return redirect(route('karyawan'))->with("message", "Berhasil Simpan");

        } catch (Exception $e) {
            DB::rollBack();
        }        
    }
}
