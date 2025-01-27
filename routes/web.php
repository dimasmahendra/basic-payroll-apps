<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\InternalDataController::class, 'index']);
Route::get('/login', [App\Http\Controllers\AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'loginProcess'])->name('login-process');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logoutProcess'])->name('logout');

Route::middleware(["auth"])->group(function(){
    Route::prefix("admin")->group(function(){
        Route::get('/dashboard', [App\Http\Controllers\Cms\DashboardController::class, 'index'])->name('dashboard');

        // KARYAWAN
        Route::get('/karyawan', [App\Http\Controllers\Cms\KaryawanController::class, 'index'])->name('karyawan');
        Route::get('/karyawan/create', [App\Http\Controllers\Cms\KaryawanController::class, 'create'])->name('karyawan.create');
        Route::get('/karyawan/edit/{id}', [App\Http\Controllers\Cms\KaryawanController::class, 'edit'])->name('karyawan.edit');
        Route::get('/karyawan/destroy/{id}', [App\Http\Controllers\Cms\KaryawanController::class, 'destroy'])->name('karyawan.destroy');
        Route::put('/karyawan/update/{id}', [App\Http\Controllers\Cms\KaryawanController::class, 'update'])->name('karyawan.update');
        Route::post('/karyawan/store', [App\Http\Controllers\Cms\KaryawanController::class, 'store'])->name('karyawan.store');
        
        // Absensi
        Route::get('/absensi', [App\Http\Controllers\Cms\AbsensiController::class, 'index'])->name('absensi');
        Route::post('/absensi/store', [App\Http\Controllers\Cms\AbsensiController::class, 'store'])->name('absensi.store');
        Route::get('/absensi/remove/{idabsensi?}', [App\Http\Controllers\Cms\AbsensiController::class, 'remove'])->name('absensi.remove');

        // Angsuran Kantor
        Route::get('/angsuran/kantor', [App\Http\Controllers\Cms\AngsuranController::class, 'indexKantor'])->name('angsuran.kantor');
        Route::get('/angsuran/koperasi', [App\Http\Controllers\Cms\AngsuranController::class, 'indexKoperasi'])->name('angsuran.koperasi');
        Route::get('/angsuran/create', [App\Http\Controllers\Cms\AngsuranController::class, 'create'])->name('angsuran.create');
        // Route::get('/angsuran/kantor/bayar', [App\Http\Controllers\Cms\AngsuranController::class, 'showBayarKantor'])->name('angsuran.kantor.bayar');
        Route::get('/angsuran/bayar/{type}', [App\Http\Controllers\Cms\AngsuranController::class, 'showBayarKantor'])->name('angsuran.bayar.show');
        Route::get('/angsuran/show/{jenis}/{id}', [App\Http\Controllers\Cms\AngsuranController::class, 'show'])->name('angsuran.show');
        Route::post('/angsuran/store', [App\Http\Controllers\Cms\AngsuranController::class, 'store'])->name('angsuran.store');
        Route::post('/angsuran/bayar', [App\Http\Controllers\Cms\AngsuranController::class, 'bayarAngsuran'])->name('angsuran.bayar');

        // Gaji Harian
        Route::get('/gaji/harian', [App\Http\Controllers\Cms\HarianController::class, 'index'])->name('harian');
        Route::get("/gaji/harian/export/{awal}/{akhir}", [App\Http\Controllers\Cms\HarianController::class, 'export'])->name("generate.export");
        Route::post('/gaji/harian/generate', [App\Http\Controllers\Cms\HarianController::class, 'generate'])->name('generate.harian');

        // History Gaji Mingguan
        Route::get('/history/harian', [App\Http\Controllers\Cms\HarianController::class, 'history'])->name('history-harian');
        Route::get('/history/harian/{awal}/{akhir}', [App\Http\Controllers\Cms\HarianController::class, 'detail'])->name('history-harian.detail');
        Route::get("/history/harian/pdf/{awal}/{akhir}", [App\Http\Controllers\Cms\HarianController::class, 'pdf'])->name("history-harian.pdf");
        Route::get("/history/harian/remove/{awal}/{akhir}", [App\Http\Controllers\Cms\HarianController::class, 'remove'])->name("history-harian.remove");

        // Gaji Bulanan
        Route::get('/gaji/bulanan', [App\Http\Controllers\Cms\BulananController::class, 'index'])->name('bulanan');
        Route::get("/gaji/bulanan/export/{awal}/{akhir}/{tipe}", [App\Http\Controllers\Cms\BulananController::class, 'export'])->name("bulanan.export");
        Route::post('/gaji/bulanan/generate', [App\Http\Controllers\Cms\BulananController::class, 'generate'])->name('generate.bulanan');

        // History Gaji Bulanan
        Route::get('/history/bulanan', [App\Http\Controllers\Cms\BulananController::class, 'history'])->name('history-bulanan');
        Route::get("/history/bulanan/hapus/{awal}/{akhir}", [App\Http\Controllers\Cms\BulananController::class, 'remove'])->name("history-bulanan.remove");
        Route::get('/history/bulanan/{awal}/{akhir}/{tipe}', [App\Http\Controllers\Cms\BulananController::class, 'detail'])->name('history-bulanan.detail');
        Route::get("/history/bulanan/pdf/{awal}/{akhir}/{tipe}", [App\Http\Controllers\Cms\BulananController::class, 'pdf'])->name("history-bulanan.pdf");

        /* Master Data */
        // Jabatan
        Route::get('/jabatan', [App\Http\Controllers\Cms\JabatanController::class, 'index'])->name('jabatan');
        Route::get('/jabatan/create', [App\Http\Controllers\Cms\JabatanController::class, 'create'])->name('jabatan.create');
        Route::post('/jabatan/store', [App\Http\Controllers\Cms\JabatanController::class, 'store'])->name('jabatan.store');
        Route::get('/jabatan/edit/{id}', [App\Http\Controllers\Cms\JabatanController::class, 'edit'])->name('jabatan.edit');
        Route::put('/jabatan/update/{id}', [App\Http\Controllers\Cms\JabatanController::class, 'update'])->name('jabatan.update');
        Route::get('/jabatan/destroy/{id}', [App\Http\Controllers\Cms\JabatanController::class, 'destroy'])->name('jabatan.destroy');

        // BPJS
        Route::get('/bpjs', [App\Http\Controllers\Cms\BPJSController::class, 'index'])->name('bpjs');
        Route::post('/bpjs/store', [App\Http\Controllers\Cms\BPJSController::class, 'store'])->name('bpjs.store');

        // History
        Route::get('/history', [App\Http\Controllers\InternalDataController::class, 'history'])->name('history');

        // Jam Lembur
        Route::get('/jam-lembur', [App\Http\Controllers\Cms\BPJSController::class, 'jamlemburIndex'])->name('jam-lembur');
        Route::post('/jam-lembur/store', [App\Http\Controllers\Cms\BPJSController::class, 'jamlemburStore'])->name('jam-lembur.store');
    });

    Route::prefix("internal-api")->group(function(){
        Route::get('/data/karyawan', [App\Http\Controllers\InternalDataController::class, 'karyawan'])->name('internal.karyawan');
    });
});

Route::get('/partial-waktu-bulanan', function() {
    return view('cms.partial.bulanan');
});

Route::get('/partial-waktu-mingguan', function() {
    return view('cms.partial.mingguan');
});