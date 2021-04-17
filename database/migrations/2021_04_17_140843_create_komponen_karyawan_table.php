<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKomponenKaryawanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('komponen_karyawan', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('karyawan_id');
            $table->smallInteger('komponen_id');
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
        Schema::dropIfExists('komponen_karyawan');
    }
}
