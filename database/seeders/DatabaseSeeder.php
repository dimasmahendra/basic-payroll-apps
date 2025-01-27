<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Setting;
use App\Models\KomponenGaji;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $komponen = [
            [
                'nama' => 'upah_pokok',
                'label' => 'Upah Pokok',
                'status' => '1',
                'order' => 1,
                'created_at' => now(),
            ],[
                'nama' => 'tunjangan_makan',
                'label' => 'Tunj. T. Mkn',
                'status' => '1',
                'order' => 2,
                'created_at' => now(),
            ],[
                'nama' => 'tunjangan_stkr',
                'label' => 'Tunj. Stkr',
                'status' => '1',
                'order' => 3,
                'created_at' => now(),
            ],[
                'nama' => 'tunjangan_prh',
                'label' => 'Tunj. Prh',
                'status' => '1',
                'order' => 4,
                'created_at' => now(),
            ],[
                'nama' => 'tunjangan_phg',
                'label' => 'Tunj. Phg',
                'status' => '1',
                'order' => 5,
                'created_at' => now(),
            ],[
                'nama' => 'bonus_masuk',
                'label' => 'Bonus Masuk',
                'status' => '1',
                'order' => 5,
                'created_at' => now(),
            ],[
                'nama' => 'upah_lembur',
                'label' => 'Upah Lembur',
                'status' => '1',
                'order' => 6,
                'created_at' => now(),
            ],[
                'nama' => 'potongan_absen',
                'label' => 'Potongan Absen',
                'status' => '1',
                'order' => 7,
                'created_at' => now(),
            ],[
                'nama' => 'bpjs_kesehatan',
                'label' => 'Pot. BPJS Kes',
                'status' => '1',
                'order' => 8,
                'created_at' => now(),
            ],[
                'nama' => 'bpjs_tenagakerja',
                'label' => 'Pot. BPJS Ket',
                'status' => '1',
                'order' => 9,
                'created_at' => now(),
            ],[
                'nama' => 'bpjs_orangtua',
                'label' => 'Pot. BPJS Orang Tua',
                'status' => '1',
                'order' => 10,
                'created_at' => now(),
            ],[
                'nama' => 'iuran_wajib',
                'label' => 'Iuran Wjb Kop.',
                'status' => '1',
                'order' => 11,
                'created_at' => now(),
            ],
        ];

        foreach ($komponen as $key => $value) {
            KomponenGaji::create($value);
        }

        $setting = [
            [
                'nama' => 'bpjs',
                'komponen_nama' => 'nilaiumk',
                'komponen_nilai' => '0',
                'created_at' => now(),
            ],[
                'nama' => 'bpjs',
                'komponen_nama' => 'persen_kesehatan',
                'komponen_nilai' => '0',
                'created_at' => now(),
            ],[
                'nama' => 'bpjs',
                'komponen_nama' => 'bpjs_kesehatan',
                'komponen_nilai' => '0',
                'created_at' => now(),
            ],[
                'nama' => 'bpjs',
                'komponen_nama' => 'persen_tenaga',
                'komponen_nilai' => '0',
                'created_at' => now(),
            ],[
                'nama' => 'bpjs',
                'komponen_nama' => 'bpjs_tenagakerja',
                'komponen_nilai' => '0',
                'created_at' => now(),
            ], [
                'nama' => 'bpjs',
                'komponen_nama' => 'persen_orangtua',
                'komponen_nilai' => '0',
                'created_at' => now(),
            ], [
                'nama' => 'bpjs',
                'komponen_nama' => 'bpjs_orangtua',
                'komponen_nilai' => '0',
                'created_at' => now(),
            ], [
                'nama' => 'jam-lembur',
                'komponen_nama' => 'jam_lembur1',
                'komponen_nilai' => '0',
                'created_at' => now(),
            ], [
                'nama' => 'jam-lembur',
                'komponen_nama' => 'jam_lembur2',
                'komponen_nilai' => '0',
                'created_at' => now(),
            ]
        ];

        foreach ($setting as $s => $index) {
            $model = new Setting;
            $model->updateOrCreate(
                [
                    'nama' => $index['nama'], 
                    'komponen_nama' => $index['komponen_nama']
                ],
                [
                    'komponen_nilai' => $index['komponen_nilai']
                ]
            );
        }
    }
}
