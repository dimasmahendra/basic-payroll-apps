<?php

namespace App\Http\Controllers\Cms;

use App\Models\Angsuran;
use App\Models\AngsuranDetail;
use App\Models\Karyawan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $model->mutasi = "debet";
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
        $angsuran->nilai_angsuran_terakhir = $model->saldo;
        $angsuran->mutasi_terakhir = $model->mutasi;
        $angsuran->tanggal_angsuran_terakhir = $model->tanggal_angsuran;
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

    public function showBayarKantor(Request $request)
    {
        $eventDate = AngsuranDetail::where([
                                'mutasi' => 'kredit',
                                'jenis_angsuran' => 'kantor',
                            ])->
                        distinct()->pluck('tanggal_angsuran');

        if($request->ajax()){
            $karyawan = Karyawan::select('karyawan.*', 'angsuran_detail.saldo', 'angsuran_detail.keterangan', 'angsuran_detail.tanggal_angsuran', 
                        'angsuran_detail.mutasi', 'angsuran_detail.jenis_angsuran', 'angsuran_detail.angsuran_ke')
                        ->leftJoin('angsuran_detail', function($query) use($request) {
                        $query->on('karyawan.id', '=', 'angsuran_detail.karyawan_id')
                        ->where('mutasi', '=', 'kredit')
                        ->whereDate('tanggal_angsuran', '=', $request->t);
                    })
                    ->get();

            return view('cms.angsuran.kantor.bayarindex-ajax', [
                "karyawan" => $karyawan,
                "event" => $eventDate
            ]);
        } else {
            $karyawan = Karyawan::select('karyawan.*', 'angsuran_detail.saldo', 'angsuran_detail.keterangan', 'angsuran_detail.tanggal_angsuran', 
                        'angsuran_detail.mutasi', 'angsuran_detail.jenis_angsuran', 'angsuran_detail.angsuran_ke')
                        ->leftJoin('angsuran_detail', function($query) {
                        $query->on('karyawan.id', '=', 'angsuran_detail.karyawan_id')
                        ->where('mutasi', '=', 'kredit')
                        ->whereDate('tanggal_angsuran', '=', date('Y-m-d'));
                    })
                    ->get();

            return view('cms.angsuran.kantor.bayarindex', [
                "karyawan" => $karyawan,
                "event" => $eventDate
            ]);
        }        
    }

    public function bayarAngsuran(Request $request)
    {
        DB::beginTransaction();
        try {
            $model = new AngsuranDetail;
            $tanggal_angsuran = date('Y-m-d', strtotime(str_replace('/', '-', $request->tanggal_angsuran)));
            $data = $model->groupDataByKaryawan($request);

            foreach ($data as $key => $value) {
                $model->updateOrCreate(
                    [
                        'tanggal_angsuran' => $tanggal_angsuran, 
                        'karyawan_id' => $value['karyawan_id'],
                        'mutasi' => $request->mutasi,
                        'jenis_angsuran' => $request->jenis_angsuran
                    ],
                    [
                        'saldo' => $value['saldo'],
                        'keterangan' => $value['keterangan'],
                        'angsuran_ke' => $value['angsuran_ke']
                    ]
                );
            }

            foreach ($data as $index => $item) {
                $angsuran = Angsuran::find($item['karyawan_id']);
                $angsuran->sisa_angsuran = $angsuran->sisa_pembayaran;
                $angsuran->nilai_angsuran_terakhir = $item['saldo'];
                $angsuran->mutasi_terakhir = $request->mutasi;
                $angsuran->tanggal_angsuran_terakhir = $tanggal_angsuran;
                $angsuran->angsuran_ke_terakhir = $item['angsuran_ke'];
                $angsuran->save();
            }

            DB::commit();
            return redirect(route('angsuran.kantor.bayar'))->with("message", "Berhasil Simpan");
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
