<?php

namespace App\Http\Controllers\Cms;

use App\Models\Setting;
use App\Models\Karyawan;
use App\Models\Jabatan;
use App\Models\KomponenGaji;
use App\Models\KomponenKaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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
        $data = Setting::bpjs()->get();
        foreach ($data as $key => $value) {
            $setting[$value->komponen_nama] = $value->komponen_nilai;
        }

        return view('cms.karyawan.create', [
            "komponen" => $komponen,
            "bpjs" => $setting,
            "jabatan" => Jabatan::dropdown('id', 'nama')
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $model = new Karyawan($request->all());
            $model->nik_karyawan = $request->nik_karyawan;
            $model->nama_lengkap = $request->nama_lengkap;
            $model->jabatan_id = $request->jabatan_id;
            $model->tipe = $request->tipe;
            $model->waktu_penggajian = $request->waktu_penggajian;
            $model->status = (isset($request->status) && $request->status == "on") ? '1' : '0';
            $model->bpjs_kesehatan = (isset($request->bpjs_kesehatan) && $request->bpjs_kesehatan == "on") ? 1 : 0;
            $model->bpjs_tenagakerja = (isset($request->bpjs_tenagakerja) && $request->bpjs_tenagakerja == "on") ? 1 : 0;
            $model->bpjs_orangtua = (isset($request->bpjs_orangtua) && $request->bpjs_orangtua == "on") ? 1 : 0;
            $model->jumlah_orangtua = $request->jumlah_orangtua;
            $model->save();       

            $komponentKaryawan = new KomponenKaryawan;
            $komponen = $komponentKaryawan->formatData($request->all());
            foreach ($komponen as $key => $value) {
                if ($model->tipe == 'mingguan' && $value['komponen_nama'] == 'potongan_absen') {
                    $value['komponen_nilai'] = 0;
                }
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

    public function edit($id)
    {
        $karyawan = Karyawan::find($id);
        $komponen = KomponenGaji::select('komponen_gaji.*', 'komponen_karyawan.karyawan_id', 'komponen_karyawan.komponen_nama', 'komponen_karyawan.komponen_nilai')
                    ->leftJoin('komponen_karyawan', function($query) use ($id) {
                        $query->on('komponen_gaji.id', '=', 'komponen_karyawan.komponen_id')
                        ->where('komponen_karyawan.karyawan_id', '=', "$id")
                        ->orderBy('order');
                    })
                    ->orderBy('order')
                    ->get();

        $data = Setting::bpjs()->get();
        foreach ($data as $key => $value) {
            $setting[$value->komponen_nama] = $value->komponen_nilai;
        }
        
        return view('cms.karyawan.edit', [
            "id" => $id,
            "komponen" => $komponen,
            "karyawan" => $karyawan,
            "bpjs" => $setting,
            "jabatan" => Jabatan::dropdown('id', 'nama')
        ]);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $model = Karyawan::find($id);
            $model->nik_karyawan = $request->nik_karyawan;
            $model->nama_lengkap = $request->nama_lengkap;
            $model->jabatan_id = $request->jabatan_id;
            $model->tipe = $request->tipe;
            $model->waktu_penggajian = $request->waktu_penggajian;
            $model->status = (isset($request->status) && $request->status == "on") ? '1' : '0';
            $model->bpjs_kesehatan = (isset($request->bpjs_kesehatan) && $request->bpjs_kesehatan == "on") ? 1 : 0;
            $model->bpjs_tenagakerja = (isset($request->bpjs_tenagakerja) && $request->bpjs_tenagakerja == "on") ? 1 : 0;
            $model->bpjs_orangtua = (isset($request->bpjs_orangtua) && $request->bpjs_orangtua == "on") ? 1 : 0;
            $model->jumlah_orangtua = $request->jumlah_orangtua;
            $model->save();       

            $komponentKaryawan = new KomponenKaryawan;
            $komponen = $komponentKaryawan->formatData($request->all());
            foreach ($komponen as $key => $value) {
                if ($model->tipe == 'mingguan' && $value['komponen_nama'] == 'potongan_absen') {
                    $value['komponen_nilai'] = 0;
                }
                $attr = clone $komponentKaryawan;
                $attr->updateOrCreate(
                    ['karyawan_id' => $id, 'komponen_id' => $value['komponen_id'], 'komponen_nama' => $value['komponen_nama']],
                    ['komponen_nilai' => $value['komponen_nilai']]
                );
            }
            
            DB::commit();
            return redirect(route('karyawan'))->with("message", "Berhasil Simpan");

        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public function destroy($id)
    {
        $karyawan = Karyawan::find($id);
        $karyawan->delete();
        return redirect(route('karyawan'))->with("message", "Berhasil Hapus Data");
    }
}
