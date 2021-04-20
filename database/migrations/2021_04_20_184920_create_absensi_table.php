<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('karyawan_id');
            $table->double('hitungan_hari', 2, 1);
            $table->time('jam_masuk');
            $table->time('jam_keluar');
            $table->double('jam_lembur_1', 2, 1);
            $table->double('jam_lembur_2', 2, 1);
            $table->dateTime('tanggal_kehadiran');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absensi');
    }
}
