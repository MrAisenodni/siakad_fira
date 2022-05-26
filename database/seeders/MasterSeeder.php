<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Master Agama
        DB::table('mst_religion')->insert([
            [
                'name'          => 'Islam',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Kristen',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Buddha',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Hindu',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Konghucu',
                'created_by'    => 'Migrasi',
            ],
        ]);

        // Master Status Keluarga
        DB::table('mst_family_status')->insert([
            [
                'name'          => 'Anak Kandung',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Anak Angkat',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Yatim',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Piatu',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Yatim Piatu',
                'created_by'    => 'Migrasi',
            ],
        ]);

        // Master Pekerjaan
        DB::table('mst_occupation')->insert([
            [
                'name'          => 'PNS',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Karyawan Swasta',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Pejabat Tinggi',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Direktur',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Manager',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Petani',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Nelayan',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Kolektor',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Kurator',
                'created_by'    => 'Migrasi',
            ],
        ]);

        // Master Kelas
        DB::table('mst_class')->insert([
            [
                'name'          => '10.1',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => '10.2',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => '10.3',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => '11.1',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => '11.2',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => '11.3',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => '12.1',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => '12.2',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => '12.3',
                'created_by'    => 'Migrasi',
            ],
        ]);

        // Master Alasan
        DB::table('mst_reason')->insert([
            [
                'name'          => 'Sakit',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Izin',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Libur',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Cuti Tahunan',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Cuti Besar',
                'created_by'    => 'Migrasi',
            ],
        ]);

        // Master Ekstrakurikuler
        DB::table('mst_extracurricular')->insert([
            [
                'name'          => 'Basket',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Voli',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Badminton',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Futsal',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Drumband',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Paskibra',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Pramuka',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Baca Tulis Al Quran',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Marawis',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Tari dan Seni Musik',
                'created_by'    => 'Migrasi',
            ],
        ]);

        // Master Bahasa
        DB::table('mst_language')->insert([
            [
                'name'          => 'Indonesia',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Inggris',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Jawa',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Sunda',
                'created_by'    => 'Migrasi',
            ],
        ]);

        // Master Golongan Darah
        DB::table('mst_blood_type')->insert([
            [
                'name'          => 'A',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'B',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'AB',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'O',
                'created_by'    => 'Migrasi',
            ],
        ]);
    }
}
