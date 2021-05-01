<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAngsuranTable3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('angsuran_detail', function (Blueprint $table) {
            $table->dropColumn(['saldo']);
        });

        Schema::table('angsuran_detail', function (Blueprint $table) {
            $table->double('saldo', 20, 2)->after('tanggal_angsuran');
        });

        Schema::table('angsuran', function (Blueprint $table) {
            $table->dropColumn(['sisa_angsuran', 'nilai_angsuran_terakhir']);
        });

        Schema::table('angsuran', function (Blueprint $table) {
            $table->double('sisa_angsuran', 20, 2)->after('jenis_angsuran');
            $table->double('nilai_angsuran_terakhir', 20, 2)->after('sisa_angsuran');
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('angsuran_detail', function (Blueprint $table) {
            $table->dropColumn(['saldo']);
        });

        Schema::table('angsuran_detail', function (Blueprint $table) {
            $table->double('saldo', 20, 2)->after('tanggal_angsuran');
        });

        Schema::table('angsuran', function (Blueprint $table) {
            $table->dropColumn(['sisa_angsuran', 'nilai_angsuran_terakhir']);
        });

        Schema::table('angsuran', function (Blueprint $table) {
            $table->double('sisa_angsuran', 20, 2)->after('jenis_angsuran');
            $table->double('nilai_angsuran_terakhir', 20, 2)->after('sisa_angsuran');
        });
    }
}
