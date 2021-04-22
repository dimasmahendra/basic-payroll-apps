<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAngsuranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('angsuran_detail');
        Schema::create('angsuran_detail', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('karyawan_id');
            $table->enum('jenis_angsuran', ['kantor', 'koperasi']);
            $table->enum('mutasi', ['debet', 'kredit']);
            $table->dateTime('tanggal_angsuran');
            $table->double('saldo', 8, 2);
            $table->text('keterangan');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::dropIfExists('angsuran');
        Schema::create('angsuran', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('karyawan_id');
            $table->enum('jenis_angsuran', ['kantor', 'koperasi']);
            $table->double('sisa_angsuran', 8, 2);
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
        Schema::create('angsuran_detail', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('karyawan_id');
            $table->enum('jenis_angsuran', ['kantor', 'koperasi']);
            $table->enum('mutasi', ['debet', 'kredit']);
            $table->dateTime('tanggal_angsuran');
            $table->double('saldo', 8, 2);
            $table->text('keterangan');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('angsuran', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('karyawan_id');
            $table->enum('jenis_angsuran', ['kantor', 'koperasi']);
            $table->enum('mutasi', ['debet', 'kredit']);
            $table->double('sisa_angsuran', 8, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
