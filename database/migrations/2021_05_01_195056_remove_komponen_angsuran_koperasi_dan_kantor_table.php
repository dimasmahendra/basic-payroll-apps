<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\KomponenGaji;
use App\Models\KomponenKaryawan;

class RemoveKomponenAngsuranKoperasiDanKantorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        KomponenGaji::whereIn('id', [10, 11])->forceDelete();
        KomponenKaryawan::whereIn('komponen_id', [10, 11])->forceDelete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
