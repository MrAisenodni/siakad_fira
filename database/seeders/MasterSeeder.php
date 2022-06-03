<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{
    DB,
    Schema,
};

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate All Table Master
        Schema::disableForeignKeyConstraints();
        DB::table('mst_religion')->truncate();
        DB::table('mst_family_status')->truncate();
        DB::table('mst_occupation')->truncate();
        DB::table('mst_class')->truncate();
        DB::table('mst_lesson')->truncate();
        DB::table('mst_reason')->truncate();
        DB::table('mst_extracurricular')->truncate();
        DB::table('mst_language')->truncate();
        DB::table('mst_blood_type')->truncate();
        DB::table('mst_study_year')->truncate();
        Schema::enableForeignKeyConstraints();

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

        // Master Mata Pelajaran (18)
        DB::table('mst_lesson')->insert([
            [
                'name'          => 'Biologi',
                'code'          => 'IPA001',
                'kkm'           => 75,
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Fisika',
                'code'          => 'IPA002',
                'kkm'           => 73,
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Kimia',
                'code'          => 'IPA003',
                'kkm'           => 70,
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Matematika Lanjutan',
                'code'          => 'IPA004',
                'kkm'           => 75,
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Ekonomi',
                'code'          => 'IPS001',
                'kkm'           => 66,
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Sosiologi',
                'code'          => 'IPS002',
                'kkm'           => 65,
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Sejarah Lanjutan',
                'code'          => 'IPS003',
                'kkm'           => 70,
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Bahasa Jerman',
                'code'          => 'IPS004',
                'kkm'           => 72,
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Bahasa Indonesia',
                'code'          => 'IPC001',
                'kkm'           => 76,
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Bahasa Inggris',
                'code'          => 'IPC002',
                'kkm'           => 72,
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Matematika',
                'code'          => 'IPC003',
                'kkm'           => 78,
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Sejarah',
                'code'          => 'IPC004',
                'kkm'           => 66,
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Olahraga',
                'code'          => 'IPC005',
                'kkm'           => 65,
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Seni BUdaya',
                'code'          => 'IPC006',
                'kkm'           => 72,
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Pendidikan Kewaganegaraan',
                'code'          => 'IPC007',
                'kkm'           => 68,
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Agama Islam',
                'code'          => 'IPC008',
                'kkm'           => 71,
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Agama Kristen',
                'code'          => 'IPC009',
                'kkm'           => 71,
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Agama Buddha',
                'code'          => 'IPC010',
                'kkm'           => 71,
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => 'Pendidikan Lingkungan Hidup',
                'code'          => 'IPC011',
                'kkm'           => 62,
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

        // Master Kelas (9)
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

        // Master Tahun Pelajaran
        DB::table('mst_study_year')->insert([
            [
                'name'          => '2021/2022',
                'semester'      => 'Ganjil',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => '2021/2022',
                'semester'      => 'Genap',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => '2022/2023',
                'semester'      => 'Ganjil',
                'created_by'    => 'Migrasi',
            ],
            [
                'name'          => '2021/2022',
                'semester'      => 'Genap',
                'created_by'    => 'Migrasi',
            ],
        ]);
    }
}
