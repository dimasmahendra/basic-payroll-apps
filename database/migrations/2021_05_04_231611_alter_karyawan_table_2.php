<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterKaryawanTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('karyawan', function (Blueprint $table) {
            $table->smallInteger('bpjs_kesehatan')->nullable()->after('waktu_penggajian');
            $table->smallInteger('bpjs_tenagakerja')->nullable()->after('bpjs_kesehatan');
            $table->smallInteger('bpjs_orangtua')->nullable()->after('bpjs_tenagakerja');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('karyawan', function (Blueprint $table) {
            $table->dropColumn(['bpjs_kesehatan', 'bpjs_tenagakerja', 'bpjs_orangtua']);
        });
    }
}
