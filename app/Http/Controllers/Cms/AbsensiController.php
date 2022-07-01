<?php

namespace App\Http\Controllers\Cms;

use Auth;
use App\Models\Absensi;
use App\Models\History;
use App\Models\Karyawan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    public function index(Request $request) 
    {
        $eventDate = Absensi::distinct()->pluck('tanggal_kehadiran');
        if($request->ajax()){
            $karyawan = Karyawan::select('karyawan.*', 'absensi.id AS absensi_id', 'absensi.hitungan_hari', 'absensi.jam_masuk', 'absensi.jam_keluar', 'absensi.jam_lembur_1', 'absensi.jam_lembur_2', 
                    'absensi.tanggal_kehadiran')
                    ->leftJoin('absensi', function($query) use($request) {
                        $query->on('karyawan.id', '=', 'absensi.karyawan_id')
                        ->whereDate('tanggal_kehadiran', '=', $request->t);
                    })
                    ->get();
            return view('cms.absensi.index-ajax', [
                "karyawan" => $karyawan,
                "event" => $eventDate
            ]);
        } else {
            $karyawan = Karyawan::select('karyawan.*', 'absensi.id AS absensi_id', 'absensi.hitungan_hari', 'absensi.jam_masuk', 'absensi.jam_keluar', 'absensi.jam_lembur_1', 'absensi.jam_lembur_2', 
                        'absensi.tanggal_kehadiran')
                        ->leftJoin('absensi', function($query) {
                        $query->on('karyawan.id', '=', 'absensi.karyawan_id')
                        ->whereDate('tanggal_kehadiran', '=', date('Y-m-d'));
                    })
                    ->get();
            return view('cms.absensi.index', [
                "karyawan" => $karyawan,
                "event" => $eventDate
            ]);
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            if (isset($request->status)) {
                $model = new Absensi;
                $tanggal_kehadiran = date('Y-m-d', strtotime(str_replace('/', '-', $request->tanggal_kehadiran)));
                $data = $model->groupDataByKaryawan($request);
    
                foreach ($data as $key => $value) {
                    $absensi = Absensi::where([
                        ['tanggal_kehadiran', '=', $tanggal_kehadiran],
                        ['karyawan_id', '=', $value['karyawan_id']]
                    ])->first();
    
                    if (empty($absensi)) {
                        $absensi = new Absensi;
                    }
    
                    $absensi->karyawan_id = $value['karyawan_id'];
                    $absensi->tanggal_kehadiran = $tanggal_kehadiran;
                    $absensi->hitungan_hari = $value['hitungan_hari'];
                    $absensi->jam_masuk = $value['jam_masuk'];
                    $absensi->jam_keluar = $value['jam_keluar'];
                    $absensi->jam_lembur_1 = $value['jam_lembur_1'];
                    $absensi->jam_lembur_2 = $value['jam_lembur_2'];
                    $absensi->save();
                }
                DB::commit();
                return redirect(route('absensi'))->with("message", "Berhasil Simpan");
            } else {
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function remove($idabsensi)
    {
        DB::beginTransaction();
        try {
            $absensi = Absensi::find($idabsensi);

            $keterangan = "Absensi karyawan id " . $absensi->karyawan_id. " pada tanggal " . $absensi->tanggal_kehadiran . " dihapus oleh " . Auth::user()->email;
            History::create([
                'name' => 'Absensi',
                'nilai' => $idabsensi,
                'tipe' => 'Hapus Data',
                'keterangan' => $keterangan,
                'updated_by' => Auth::id(),
            ]);

            $absensi->forceDelete();
            DB::commit();
            return redirect(route('absensi'))->with("message", "Berhasil Hapus Data");
        } catch (\Throwable $th) {
            DB::rollBack();
        }        
    }
}
