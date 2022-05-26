<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tabel Menu
        DB::table('stg_menu')->insert([
            [
                'title'         => 'Dashboard',
                'url'           => '/',
                'icon'          => 'dashboard',
                'parent'        => 0,
            ],
            [
                'title'         => 'Siswa',
                'url'           => '/studi/siswa',
                'icon'          => 'face',
                'parent'        => 0,
            ],
            [
                'title'         => 'Guru',
                'url'           => '/studi/guru',
                'icon'          => 'account_circle',
                'parent'        => 0,
            ],
            [
                'title'         => 'Orang Tua',
                'url'           => '/studi/orang-tua',
                'icon'          => 'accessibility',
                'parent'        => 0,
            ],
            [
                'title'         => 'Kelas',
                'url'           => '/studi/kelas',
                'icon'          => 'class',
                'parent'        => 0,
            ],
            [
                'title'         => 'Mata Pelajaran',
                'url'           => '/studi/mata-pelajaran',
                'icon'          => 'local_library',
                'parent'        => 0,
            ],
            [
                'title'         => 'Presensi',
                'url'           => '/studi/presensi',
                'icon'          => 'touch_app',
                'parent'        => 0,
            ],
            [
                'title'         => 'Jadwal Pembelajaran/Ujian',
                'url'           => '/studi/jadwal-pembelajaran',
                'icon'          => 'schedule',
                'parent'        => 0,
            ],
            [
                'title'         => 'Nilai Siswa',
                'url'           => '/studi/nilai-siswa',
                'icon'          => 'assignment',
                'parent'        => 0,
            ],
            [
                'title'         => 'Master',
                'url'           => null,
                'icon'          => 'settings',
                'parent'        => 1,
            ],
        ]);

        // Tabel Sub Menu
        DB::table('stg_sub_menu')->insert([
            [
                'title'         => 'Agama',
                'url'           => '/master/agama',
                'icon'          => 'brightness_7',
                'menu_id'       => 10
            ],
            [
                'title'         => 'Status Keluarga',
                'url'           => '/master/status-keluarga',
                'icon'          => 'group',
                'menu_id'       => 10
            ],
            [
                'title'         => 'Pekerjaan',
                'url'           => '/master/pekerjaan',
                'icon'          => 'business_center',
                'menu_id'       => 10
            ],
            [
                'title'         => 'Mata Pelajaran',
                'url'           => '/master/mata-pelajaran',
                'icon'          => 'library_books',
                'menu_id'       => 10
            ],
            [
                'title'         => 'Kelas',
                'url'           => '/master/kelas',
                'icon'          => 'class',
                'menu_id'       => 10
            ],
            [
                'title'         => 'Tahun Pelajaran',
                'url'           => '/master/tahun-pelajaran',
                'icon'          => 'date_range',
                'menu_id'       => 10
            ],
            [
                'title'         => 'Alasan',
                'url'           => '/master/alasan',
                'icon'          => 'remove_circle_outline',
                'menu_id'       => 10
            ],
        ]);
    }
}
