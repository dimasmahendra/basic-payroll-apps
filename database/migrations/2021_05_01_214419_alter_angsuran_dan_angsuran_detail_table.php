<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAngsuranDanAngsuranDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('angsuran_detail', function (Blueprint $table) {
            $table->dropColumn(['keterangan']);
        });

        Schema::table('angsuran', function (Blueprint $table) {
            $table->string('angsuran_ke_terakhir')->nullable()->after('tanggal_angsuran_terakhir');
        });

        Schema::table('angsuran_detail', function (Blueprint $table) {
            $table->text('keterangan')->nullable()->after('saldo');
            $table->string('angsuran_ke')->nullable()->after('keterangan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('angsuran', function (Blueprint $table) {
            $table->dropColumn(['angsuran_ke_terakhir']);
        });

        Schema::table('angsuran_detail', function (Blueprint $table) {
            $table->dropColumn(['angsuran_ke']);
        });
    }
}
