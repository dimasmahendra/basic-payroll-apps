<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGajiBulananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gaji_bulanan', function (Blueprint $table) {
            $table->id();
            $table->dateTime('periode_awal');
            $table->dateTime('periode_akhir');
            $table->smallInteger('karyawan_id');
            $table->string('komponen_nama');
            $table->string('komponen_nilai');
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
        Schema::dropIfExists('gaji_bulanan');
    }
}
