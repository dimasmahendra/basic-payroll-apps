<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterKomponenKaryawanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('komponen_karyawan', function (Blueprint $table) {
            $table->smallInteger('order')->nullable()->after('komponen_nilai');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('komponen_karyawan', function (Blueprint $table) {
            $table->dropColumn(['order']);
        });
    }
}
