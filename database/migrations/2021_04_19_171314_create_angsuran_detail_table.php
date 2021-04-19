<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAngsuranDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('angsuran_detail', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('karyawan_id');
            $table->enum('jenis_angsuran', ['kantor', 'koperasi']);
            $table->enum('mutasi', ['kantor', 'koperasi']);
            $table->dateTime('tanggal_angsuran');
            $table->double('saldo', 8, 2);
            $table->text('keterangan');
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
        Schema::dropIfExists('angsuran_detail');
    }
}
