<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterGajiBulananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gaji_bulanan', function (Blueprint $table) {
            $table->smallInteger('updated_by')->nullable()->after('komponen_nilai');
        });
        Schema::table('gaji_mingguan', function (Blueprint $table) {
            $table->smallInteger('updated_by')->nullable()->after('komponen_nilai');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gaji_bulanan', function (Blueprint $table) {
            $table->dropColumn(['updated_by']);
        });
        Schema::table('gaji_mingguan', function (Blueprint $table) {
            $table->dropColumn(['updated_by']);
        });
    }
}
