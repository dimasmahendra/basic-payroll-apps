<?php

namespace App\Http\Controllers\Cms;

use Auth;
use PDF;
use App\Models\Absensi;
use App\Models\History;
use App\Models\KaryawanBulanan;
use App\Models\KomponenGaji;
use App\Models\Excel\GajiBulananExport;
use App\Models\GajiBulanan as Bulanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;

class BulananController extends Controller
{
    public function index() {
        return view('cms.bulanan.index');
    }

    public function generate(Request $request)
    {
        try {

            DB::beginTransaction();

            $model = new KaryawanBulanan;
            $karyawan = $model->select('karyawan.*')->bulanan()
                        ->jenisWaktu($request->waktu_penggajian)
                        ->leftJoin('jabatan', 'jabatan.id', '=', 'karyawan.jabatan_id')
                        ->orderBy('jabatan.order')
                        ->get()
                        ->dataBulanan($request);

            DB::commit();

            if (count($karyawan) > 0) {
                $awal = date('Y-m-d', strtotime(str_replace('/', '-', $request->periode_awal)));
                $akhir = date('Y-m-d', strtotime(str_replace('/', '-', $request->periode_akhir)));
                return view('cms.bulanan.generate', [
                    "karyawan" => $karyawan,
                    "komponen" => KomponenGaji::orderBy('order')->get(),
                    "periode" => $request->periode_awal .' - '. $request->periode_akhir,
                    "awal" => $awal,
                    "akhir" => $akhir,
                    "tipe" => $request->waktu_penggajian
                ]);
            } else {
                return redirect(route('bulanan'))->with("error", "Tidak Ada karyawan Bulanan Pada periode yang di pilih.");
            }
        } catch (Throwable $th) {                        
            DB::rollBack();
            History::log([
                'name' => 'Gaji Bulanan',
                'nilai' => 'Generate',
                'tipe' => 'Generate Gaji Bulanan',
                'keterangan' => $th->getMessage() . " Request " . json_encode($request->all()),
                'updated_by' => Auth::id(),
            ]);
        }
    }

    public function export($awal, $akhir, $tipe)
    {
        $karyawan = KaryawanBulanan::select('karyawan.*')->bulanan()
                    ->jenisWaktu($tipe)
                    ->leftJoin('jabatan', 'jabatan.id', '=', 'karyawan.jabatan_id')
                    ->orderBy('jabatan.order')
                    ->get();


        if ($karyawan->isEmpty()) {
            return redirect(route('history-bulanan.detail', ['awal' => $awal, 'akhir' => $akhir]))
                    ->with("error", "Tidak Ada karyawan Bulanan Pada periode yang di pilih.");
        }
        
        $cache_key = "@generate-gaji-bulanan-".now();
        // Cache::forget($cache_key);
        if (Cache::has($cache_key)) {
            $fromCache = Cache::get($cache_key);
            if (isset($fromCache['path']) && Storage::disk("public")->exists($fromCache['path'])) {
                return $fromCache;
            } else {
                Cache::forget($cache_key);
            }
        }
        $data = [];
        
        foreach ($karyawan as $key => $value) {
            $karyawanbulanan = $value->karyawanbulanan()
                                    ->whereDate('periode_awal', '=', $awal)
                                    ->whereDate('periode_akhir', '=', $akhir)
                                    ->get();
            foreach ($karyawanbulanan as $i => $komponen) {
                $array['no'] = $key + 1;
                $array['nik_karyawan'] = $value->nik_karyawan;
                $array['nama_lengkap'] = $value->nama_lengkap;
                $array[$komponen->komponen_nama] = $komponen->komponen_nilai;
            }
            $array['total_gaji'] = $komponen->hitungTotal($array);
            $array['total_potongan'] = $komponen->hitungPotongan($array);
            $array['periode'] = date("d F Y", strtotime($awal)) . " - " . date("d F Y", strtotime($akhir));
            $data[] = $array;
        }

        $collection = (object) collect($data);
        $gajiExport = new GajiBulananExport($collection);
        $now = date("d-m-Y H-i-s");
        $name = 'Gaji-Bulanan-Export-'.$now.'.xlsx';
        $path = "export-gaji-bulanan/$name";
        $ad = Excel::store($gajiExport, $path, 'public');
        $data = [
            "file_name" => $name,
            "path" => storage_path('app/public/'. $path),
            "url" => $path
        ];
        $toCache = $data;
        Cache::rememberForever($cache_key, function() use ($toCache){
            return $toCache;
        });

        $headers = array(
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        );
        return response()->download($data['path'], $data['file_name'], $headers);
    }

    public function history()
    {
        $data = Bulanan::select('periode_awal', 'tipe','periode_akhir', 'updated_by', DB::raw('DATE(created_at) as created_at'))
                        ->distinct()
                        ->orderBy("periode_awal", "DESC")
                        ->get();

        return view('cms.bulanan.history', [
            "data" => $data
        ]);
    }

    public function detail($awal, $akhir, $tipe)
    {
        $karyawan = KaryawanBulanan::select('karyawan.*')->bulanan()
                    ->jenisWaktu($tipe)
                    ->leftJoin('jabatan', 'jabatan.id', '=', 'karyawan.jabatan_id')
                    ->orderBy('jabatan.order')
                    ->get();

        foreach ($karyawan as $key => $value) {
            $karyawanbulanan = $value->karyawanbulanan()
                                    ->whereDate('periode_awal', '=', $awal)
                                    ->whereDate('periode_akhir', '=', $akhir)
                                    ->get();
            foreach ($karyawanbulanan as $i => $komponen) {
                $array['no'] = $key + 1;
                $array['nik_karyawan'] = $value->nik_karyawan;
                $array['nama_lengkap'] = $value->nama_lengkap;
                $array[$komponen->komponen_nama] = $komponen->komponen_nilai;
            }
            $array['total_gaji'] = $komponen->hitungTotal($array);
            $array['total_potongan'] = $komponen->hitungPotongan($array);
            $data[] = $array;
        }

        return view('cms.bulanan.history-detail', [
            "komponen" => KomponenGaji::orderBy('order')->get(),
            "periode" => date('d F Y', strtotime($awal)) .' - '. date('d F Y', strtotime($akhir)),
            "karyawan" => $data,
            "awal" => $awal,
            "akhir" => $akhir,
            "tipe" => $tipe
        ]);
    }

    public function pdf($awal, $akhir, $tipe)
    {
        $karyawan = KaryawanBulanan::select('karyawan.*')->bulanan()
                    ->jenisWaktu($tipe)
                    ->leftJoin('jabatan', 'jabatan.id', '=', 'karyawan.jabatan_id')
                    ->orderBy('jabatan.order')
                    ->get();

        if ($karyawan->isEmpty()) {
            return redirect(route('history-bulanan.detail', ['awal' => $awal, 'akhir' => $akhir]))
                    ->with("error", "Tidak Ada karyawan Bulanan Pada periode yang di pilih.");
        }
        
        foreach ($karyawan as $key => $value) {
            $karyawanbulanan = $value->karyawanbulanan()
                                    ->whereDate('periode_awal', '=', $awal)
                                    ->whereDate('periode_akhir', '=', $akhir)
                                    ->get();
            $absen = $value->absen($awal, $akhir)->first();
            $komponengaji = array();
            foreach ($karyawanbulanan as $i => $komponen) {
                $array['no'] = $key + 1;
                $array['nik_karyawan'] = $value->nik_karyawan;
                $array['nama_lengkap'] = $value->nama_lengkap;
                $array['masuk_kerja'] = isset($absen->total_masuk) ? $absen->total_masuk : 0;
                $array['total_lembur_1'] = isset($absen->total_lembur_1) ? $absen->total_lembur_1 : 0;
                $array['total_lembur_2'] = isset($absen->total_lembur_2) ? $absen->total_lembur_2 : 0;
                // $array[$komponen->komponen_nama] = floatval(str_replace('.', '' , $komponen->komponen_nilai));
                $array[$komponen->komponen_nama] = floatval($komponen->komponen_nilai);
                $array['angsuran_ke_kantor'] = isset($value->angsuranKeKantor) ? (empty($value->angsuranKeKantor->angsuran_ke_terakhir) ? 0 : $value->angsuranKeKantor->angsuran_ke_terakhir) : 0;
                $array['angsuran_ke_koperasi'] = isset($value->angsuranKeKoperasi) ? (empty($value->angsuranKeKoperasi->angsuran_ke_terakhir) ? 0 : $value->angsuranKeKoperasi->angsuran_ke_terakhir) : 0;
            }
            $array['total_gaji'] = $komponen->hitungTotal($array);
            $array['total_potongan'] = $komponen->hitungPotongan($array);
            $data[] = $array;
        }
        $collection = collect($data);
        $pdf = PDF::loadView('cms.bulanan.pdf-gaji', [
            "data" => $collection,
            "awal" => $awal
        ]);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream();
    }

    public function remove($awal, $akhir)
    {
        $keterangan = "Hapus Gaji Bulanan periode " . $awal . " - " . $akhir;
        History::create([
            'name' => 'Gaji Bulanan',
            'nilai' => 'delete',
            'tipe' => 'bulanan',
            'keterangan' => $keterangan,
            'updated_by' => Auth::id(),
        ]);

        Bulanan::whereDate('periode_awal', '=', $awal)
                ->whereDate('periode_akhir', '=', $akhir)
                ->forceDelete();

        return redirect()->back();
    }
}
