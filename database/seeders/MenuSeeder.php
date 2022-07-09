<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{
    DB,
    Schema,
};

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate All Table Setting
        Schema::disableForeignKeyConstraints();
        DB::table('stg_sub_menu')->truncate();
        DB::table('stg_menu')->truncate();
        Schema::enableForeignKeyConstraints();

        // Tabel Menu
        DB::table('stg_menu')->insert([
            [
                'title'         => 'Dashboard',
                'url'           => '/',
                'icon'          => 'dashboard',
                'parent'        => 0,
                'role'          => 'admin,teacher,parent,student',
            ],
            [
                'title'         => 'Profil',
                'url'           => '/studi/profil',
                'icon'          => 'account_circle',
                'parent'        => 0,
                'role'          => 'teacher,student,parent',
            ],
            [
                'title'         => 'Siswa',
                'url'           => '/studi/siswa',
                'icon'          => 'face',
                'parent'        => 0,
                'role'          => 'admin,teacher',
            ],
            [
                'title'         => 'Guru',
                'url'           => '/studi/guru',
                'icon'          => 'account_circle',
                'parent'        => 0,
                'role'          => 'admin',
            ],
            [
                'title'         => 'Orang Tua',
                'url'           => '/studi/orang-tua',
                'icon'          => 'accessibility',
                'parent'        => 0,
                'role'          => 'admin',
            ],
            [
                'title'         => 'Kelas',
                'url'           => '/studi/kelas',
                'icon'          => 'class',
                'parent'        => 0,
                'role'          => 'admin',
            ],
            [
                'title'         => 'Mata Pelajaran',
                'url'           => '/studi/mata-pelajaran',
                'icon'          => 'local_library',
                'parent'        => 0,
                'role'          => 'admin',
            ],
            [
                'title'         => 'Presensi',
                'url'           => '/studi/presensi',
                'icon'          => 'touch_app',
                'parent'        => 0,
                'role'          => 'admin,teacher,parent,student',
            ],
            [
                'title'         => 'Jadwal Pelajaran',
                'url'           => '/studi/jadwal-pembelajaran',
                'icon'          => 'schedule',
                'parent'        => 0,
                'role'          => 'admin,teacher,parent,student',
            ],
            [
                'title'         => 'Jadwal UTS',
                'url'           => '/studi/jadwal-uts',
                'icon'          => 'event_note',
                'parent'        => 0,
                'role'          => 'admin,teacher,parent,student',
            ],
            [
                'title'         => 'Jadwal UAS',
                'url'           => '/studi/jadwal-uas',
                'icon'          => 'event',
                'parent'        => 0,
                'role'          => 'admin,teacher,parent,student',
            ],
            [
                'title'         => 'Nilai Siswa',
                'url'           => '/studi/nilai-siswa',
                'icon'          => 'assignment',
                'parent'        => 0,
                'role'          => 'admin,teacher,parent,student',
            ],
            [
                'title'         => 'Pembayaran SPP',
                'url'           => '/studi/spp',
                'icon'          => 'credit_card',
                'parent'        => 0,
                'role'          => 'admin,parent,student',
            ],
            [
                'title'         => 'Pengumuman',
                'url'           => '/studi/pengumuman',
                'icon'          => 'announcement',
                'parent'        => 0,
                'role'          => 'admin,teacher,parent,student',
            ],
            [
                'title'         => 'Master',
                'url'           => null,
                'icon'          => 'settings',
                'parent'        => 1,
                'role'          => 'admin',
            ],
            [
                'title'         => 'Profil Sekolah',
                'url'           => '/provider',
                'icon'          => 'school',
                'parent'        => 0,
                'role'          => 'admin',
            ],
        ]);

        // Tabel Sub Menu
        DB::table('stg_sub_menu')->insert([
            [
                'title'         => 'Akun Login',
                'url'           => '/master/login',
                'icon'          => 'lock',
                'menu_id'       => 15,
                'role'          => 'admin',
            ],
            [
                'title'         => 'Agama',
                'url'           => '/master/agama',
                'icon'          => 'brightness_7',
                'menu_id'       => 15,
                'role'          => 'admin',
            ],
            [
                'title'         => 'Status Keluarga',
                'url'           => '/master/status-keluarga',
                'icon'          => 'group',
                'menu_id'       => 15,
                'role'          => 'admin',
            ],
            [
                'title'         => 'Pekerjaan',
                'url'           => '/master/pekerjaan',
                'icon'          => 'business_center',
                'menu_id'       => 15,
                'role'          => 'admin',
            ],
            [
                'title'         => 'Golongan Darah',
                'url'           => '/master/golongan-darah',
                'icon'          => 'fiber_manual_record',
                'menu_id'       => 15,
                'role'          => 'admin',
            ],
            [
                'title'         => 'Mata Pelajaran',
                'url'           => '/master/mata-pelajaran',
                'icon'          => 'library_books',
                'menu_id'       => 15,
                'role'          => 'admin',
            ],
            [
                'title'         => 'Bahasa',
                'url'           => '/master/bahasa',
                'icon'          => 'language',
                'menu_id'       => 15,
                'role'          => 'admin',
            ],
            [
                'title'         => 'Kelas',
                'url'           => '/master/kelas',
                'icon'          => 'class',
                'menu_id'       => 15,
                'role'          => 'admin',
            ],
            [
                'title'         => 'Ekstrakurikuler',
                'url'           => '/master/ekstrakurikuler',
                'icon'          => 'favorite',
                'menu_id'       => 15,
                'role'          => 'admin',
            ],
            [
                'title'         => 'Tahun Pelajaran',
                'url'           => '/master/tahun-pelajaran',
                'icon'          => 'date_range',
                'menu_id'       => 15,
                'role'          => 'admin',
            ],
            [
                'title'         => 'Nilai',
                'url'           => '/master/nilai',
                'icon'          => 'assignment_turned_in',
                'menu_id'       => 15,
                'role'          => 'admin',
            ],
            [
                'title'         => 'Alasan',
                'url'           => '/master/alasan',
                'icon'          => 'remove_circle_outline',
                'menu_id'       => 15,
                'role'          => 'admin',
            ],
            [
                'title'         => 'SPP',
                'url'           => '/master/spp',
                'icon'          => 'credit_card',
                'menu_id'       => 15,
                'role'          => 'admin',
            ],
            [
                'title'         => 'Kategori',
                'url'           => '/master/kategori',
                'icon'          => 'art_track',
                'menu_id'       => 15,
                'role'          => 'admin',
            ],
            [
                'title'         => 'Tags',
                'url'           => '/master/tag',
                'icon'          => 'bookmark',
                'menu_id'       => 15,
                'role'          => 'admin',
            ],
        ]);
    }
}
