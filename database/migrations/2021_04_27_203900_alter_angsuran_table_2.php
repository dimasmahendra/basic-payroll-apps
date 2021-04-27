<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAngsuranTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('angsuran', function (Blueprint $table) {
            $table->double('nilai_angsuran_terakhir', 8, 2)->after('sisa_angsuran');
            $table->enum('mutasi_terakhir', ['debet', 'kredit'])->after('nilai_angsuran_terakhir');
            $table->dateTime('tanggal_angsuran_terakhir')->nullable()->after('mutasi_terakhir');
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
            $table->dropColumn(['nilai_angsuran_terakhir', 'mutasi_terakhir', 'tanggal_angsuran_terakhir']);
        });
    }
}
