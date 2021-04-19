<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', function () {
    return view('welcome');
})->name('index');

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

        // Angsuran Kantor
        Route::get('/angsuran/{jenis}', [App\Http\Controllers\Cms\AngsuranController::class, 'index'])->name('angsuran');

        // Absensi
        Route::get('/absensi', [App\Http\Controllers\Cms\AbsensiController::class, 'index'])->name('absensi');
        Route::post('/absensi/store', [App\Http\Controllers\Cms\AbsensiController::class, 'store'])->name('absensi.store');
    });
});

Route::get('/partial-waktu-bulanan', function() {
    return view('cms.partial.bulanan');
});

Route::get('/partial-waktu-mingguan', function() {
    return view('cms.partial.mingguan');
});