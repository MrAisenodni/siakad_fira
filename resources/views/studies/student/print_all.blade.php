<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Lembar Buku Induk Siswa</title>
        <style>
            .m-5 {
                margin: 5px 5px 5px 5px;
            }
            .m-10 {
                margin: 10px 10px 10px 10px;
            }
            .p-20 {
                margin: 20px 20px 20px 20px!important;
            }
            .ml-5 {
                margin-left: 5px;
            }
            .mr-5 {
                margin-right: 5px;
            }
            .mr-10 {
                margin-right: 10px!important;
            }
            .center {
                margin-left: auto;
                margin-right: auto;
            }
            .text-center {
                text-align: center;
            }
            .text-left {
                text-align: left;
            }
            .text-right {
                text-align: right;
            }
            table td, table td * {
                vertical-align: top;
            }
        </style>
    </head>
    <body>
        <h3 class="text-center">LEMBAR BUKU INDUK SISWA</h3>
        
        @if ($students)
            @foreach ($students as $student)
                <table class="center">
                    <tr>
                        <th class="text-left">Nomor Induk Siswa</th>
                        <td>:</td>
                        <td>{{ $student->nis }}</td>
                    </tr>
                    <tr>
                        <th class="text-left">Nomor Induk Siswa Nasional</th>
                        <td>:</td>
                        <td>{{ $student->nisn }}</td>
                    </tr>
                </table><br>
                
                <table id="student" style="width: 100%">
                    {{-- Keterangan Tentang Diri Siswa --}}
                    <tr>
                        <th colspan="4" class="text-left ml-5" style="width: 100%">A. KETERANGAN TENTANG DIRI SISWA</th>
                        <td rowspan="50" class="text-center" style="width: 150px">
                            {{-- <img src="{{ asset($student->picture) }}" alt="Foto Siswa" class="mr-10" width="100%"> --}}
                            <img src="{{ public_path($student->picture) }}" alt="Foto Siswa" class="mr-10" width="100%">
                            <p style="font-size: 8pt">Cap tiga jari tengah ini di atas pas foto bagian bawah waktu diterima di sekolah</p>
                            <p style="font-size: 8pt">&nbsp;</p>
                            <p style="font-size: 8pt">Tanda Tangan</p>
                            <p style="font-size: 8pt">&nbsp;</p>
                            <p style="font-size: 8pt">({{ $student->full_name }})</p>
                        </td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">1.</td>
                        <td>Nama Siswa</td>
                        <td width="2px">:</td> 
                        <td>{{ $student->full_name }}</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">2.</td>
                        <td>Jenis Siswa</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->gender == 'l') Laki-Laki @else Perempuan @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">3.</td>
                        <td>Tempat dan Tanggal Lahir</td>
                        <td width="2px">:</td> 
                        <td>{{ $student->birth_place.', '.tanggal_indonesia($student->birth_date, false) }}</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">4.</td>
                        <td>Agama</td>
                        <td width="2px">:</td> 
                        <td>{{ $student->religion->name }}</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">5.</td>
                        <td>Kewarganegaraan</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->citizen == 'wni') Warga Negara Indonesia @else Warga Negara Asing @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">6.</td>
                        <td>Anak Ke Berapa</td>
                        <td width="2px">:</td> 
                        <td>{{ $student->child_to }}</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">7.</td>
                        <td>Jumlah Saudara Kandung</td>
                        <td width="2px">:</td> 
                        <td>{{ $student->child_count }}</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">8.</td>
                        <td>Jumlah Saudara Tiri</td>
                        <td width="2px">:</td> 
                        <td>{{ $student->stepbrother_count }}</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">9.</td>
                        <td>Jumlah Saudara Angkat</td>
                        <td width="2px">:</td> 
                        <td>{{ $student->stepsibling_count }}</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">10.</td>
                        <td>Anak Yatim/Yatim Piatu</td>
                        <td width="2px">:</td> 
                        <td>{{ $student->stepsibling_count+$student->stepbrother_count }}</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">11.</td>
                        <td>Bahasa Sehari-hari Di Rumah</td>
                        <td width="2px">:</td> 
                        <td>{{ $student->language->name }}</td>
                    </tr>
                    <tr><td><td><td></td></td></td></tr>

                    {{-- Keterangan Tempat Tinggal --}}
                    <tr>
                        <th colspan="4" class="text-left ml-5">B. KETERANGAN TEMPAT TINGGAL</th>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">12.</td>
                        <td>Alamat</td>
                        <td width="2px">:</td> 
                        <td>{{ $student->address }}</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">13.</td>
                        <td>Nomor Telepon</td>
                        <td width="2px">:</td> 
                        <td>{{ $student->phone_number }}@if ($student->home_number) /{{ $student->home_number }} @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">14.</td>
                        <td>Tinggal Dengan Orang Tua/Saudara Di Asrama/Kost</td>
                        <td width="2px">:</td> 
                        <td>Orang Tua</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">15.</td>
                        <td>Jarak Tempat Tinggal ke Sekolah</td>
                        <td width="2px">:</td> 
                        <td>{{ $student->distance }}</td>
                    </tr>
                    <tr><td><td><td></td></td></td></tr>

                    {{-- Keterangan Kesehatan --}}
                    <tr>
                        <th colspan="4" class="text-left ml-5">C. KETERANGAN KESEHATAN</th>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">16.</td>
                        <td>Golongan Darah</td>
                        <td width="2px">:</td> 
                        <td>{{ $student->blood_type->name }}</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">17.</td>
                        <td>Penyakit yang Pernah Diderita</td>
                        <td width="2px">:</td> 
                        <td>-</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">18.</td>
                        <td>Kelainan Jasmani</td>
                        <td width="2px">:</td> 
                        <td>-</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">19.</td>
                        <td>Tinggi dan Berat Badan</td>
                        <td width="2px">:</td> 
                        <td>{{ $student->height }} cm / {{ $student->weight }} kg</td>
                    </tr>
                    <tr><td><td><td></td></td></td></tr>

                    {{-- Keterangan Pendidikan --}}
                    <tr>
                        <th colspan="4" class="text-left ml-5">D. KETERANGAN PENDIDIKAN</th>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">20.</td>
                        <td>Pendidikan Sebelumnya</td>
                        <td width="2px"></td> 
                        <td></td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5"></td>
                        <td>a. Lulusan Dari</td>
                        <td width="2px">:</td> 
                        <td>{{ $student->first_study }}</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5"></td>
                        <td>b. Tanggal dan Nomor STTB</td>
                        <td width="2px">:</td> 
                        <td>{{ tanggal_indonesia($student->from_study_date, false) }} No {{ $student->sttb_no }}</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5"></td>
                        <td>c. Lama Belajar</td>
                        <td width="2px">:</td> 
                        <td>{{ date('Y', strtotime($student->to_study_date))-date('Y', strtotime($student->from_study_date)) }} Tahun</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">21.</td>
                        <td>Pindahan Dari</td>
                        <td width="2px"></td> 
                        <td></td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5"></td>
                        <td>a. Dari Sekolah</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->move_from) {{ $student->move_from }} @else - @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5"></td>
                        <td>b. Alasan</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->reason_move) {{ $student->reason_move }} @else - @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">22.</td>
                        <td>Diterima di Sekolah ini</td>
                        <td width="2px"></td> 
                        <td></td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5"></td>
                        <td>a. Di Tingkat</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->level) {{ $student->level }} @else - @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5"></td>
                        <td>b. Kelompok</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->group) {{ $student->group }} @else - @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5"></td>
                        <td>c. Jurusan</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->major) {{ $student->major }} @else - @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5"></td>
                        <td>d. Tanggal</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->start_date) {{ tanggal_indonesia($student->start_date, false) }} @else - @endif</td>
                    </tr>
                    <tr><td><td><td></td></td></td></tr>

                    {{-- Keterangan Tentang Ayah Kandung --}}
                    <tr>
                        <th colspan="4" class="text-left ml-5">E. KETERANGAN TENTANG AYAH KANDUNG</th>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">23.</td>
                        <td>Nama</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->father) {{ $student->father->full_name }} @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">24.</td>
                        <td>Tempat dan Tanggal Lahir</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->father) {{ $student->father->birth_place }}, {{ tanggal_indonesia($student->father->birth_date, false) }} @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">25.</td>
                        <td>Agama</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->father) {{ $student->father->religion->name }} @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">26.</td>
                        <td>Kewarganegaraan</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->father) @if ($student->father->citizen == 'wni') Warga Negara Indonesia @else Warga Negara Asing @endif @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">27.</td>
                        <td>Pendidikan</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->father) {{ $student->father->last_study }} @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">28.</td>
                        <td>Pekerjaan</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->father) {{ $student->father->occupation->name }} @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">29.</td>
                        <td>Penghasilan per Bulan</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->father) {{ 'Rp '.format_uang($student->father->revenue).', 00' }} @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">30.</td>
                        <td>Alamat Rumah/Nomor Telepon</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->father) {{ $student->father->address }} / HP: {{ $student->father->phone_number }} @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">31.</td>
                        <td>Masih Hidup/Sudah Meninggal</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->father) @if ($student->father->died == 1) Sudah Meninggal @else Masih Hidup @endif @endif</td>
                    </tr>
                    <tr><td><td><td></td></td></td></tr>

                    {{-- Keterangan Tentang Ibu Kandung --}}
                    <tr>
                        <th colspan="4" class="text-left ml-5">F. KETERANGAN TENTANG IBU KANDUNG</th>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">32.</td>
                        <td>Nama</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->mother) {{ $student->mother->full_name }} @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">33.</td>
                        <td>Tempat dan Tanggal Lahir</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->mother) {{ $student->mother->birth_place }}, {{ tanggal_indonesia($student->mother->birth_date, false) }} @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">34.</td>
                        <td>Agama</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->mother) {{ $student->mother->religion->name }} @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">35.</td>
                        <td>Kewarganegaraan</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->mother) @if ($student->mother->citizen == 'wni') Warga Negara Indonesia @else Warga Negara Asing @endif @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">36.</td>
                        <td>Pendidikan</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->mother) {{ $student->mother->last_study }} @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">37.</td>
                        <td>Pekerjaan</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->mother) {{ $student->mother->occupation->name }} @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">38.</td>
                        <td>Penghasilan per Bulan</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->mother) {{ 'Rp '.format_uang($student->mother->revenue).', 00' }} @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">39.</td>
                        <td>Alamat Rumah/Nomor Telepon</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->mother) {{ $student->mother->address }} / HP: {{ $student->mother->phone_number }} @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">40.</td>
                        <td>Masih Hidup/Sudah Meninggal</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->mother) @if ($student->mother->died == 1) Sudah Meninggal @else Masih Hidup @endif @endif</td>
                    </tr>
                    <tr><td><td><td></td></td></td></tr>

                    {{-- Keterangan Tentang Wali --}}
                    <tr>
                        <th colspan="4" class="text-left ml-5">G. KETERANGAN TENTANG WALI</th>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">32.</td>
                        <td>Nama</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->guardian) {{ $student->guardian->full_name }} @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">33.</td>
                        <td>Tempat dan Tanggal Lahir</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->guardian) {{ $student->guardian->birth_place }}, {{ tanggal_indonesia($student->guardian->birth_date, false) }} @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">34.</td>
                        <td>Agama</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->guardian) {{ $student->guardian->religion->name }} @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">35.</td>
                        <td>Kewarganegaraan</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->guardian) @if ($student->guardian->citizen == 'wni') Warga Negara Indonesia @else Warga Negara Asing @endif @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">36.</td>
                        <td>Pendidikan</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->guardian) {{ $student->guardian->last_study }} @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">37.</td>
                        <td>Pekerjaan</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->guardian) {{ $student->guardian->occupation->name }} @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">38.</td>
                        <td>Penghasilan per Bulan</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->guardian) {{ 'Rp '.format_uang($student->guardian->revenue).', 00' }} @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">39.</td>
                        <td>Alamat Rumah/Nomor Telepon</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->guardian) {{ $student->guardian->address }} / HP: {{ $student->guardian->phone_number }} @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">40.</td>
                        <td>Masih Hidup/Sudah Meninggal</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->guardian) @if ($student->guardian->died == 1) Sudah Meninggal @else Masih Hidup @endif @endif</td>
                    </tr>
                    <tr><td><td><td></td></td></td></tr>

                    {{-- Kegemaran Siswa --}}
                    <tr>
                        <th colspan="4" class="text-left ml-5">H. KEGEMARAN SISWA</th>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">50.</td>
                        <td>Kesenian</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->art_interest) {{ $student->art_interest }} @else - @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">51.</td>
                        <td>Olahraga</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->sport_interest) {{ $student->sport_interest }} @else - @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">52.</td>
                        <td>Kemasyarakatan/Organisasi</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->extracurricular_id) {{ $student->extracurricular->name }} @else - @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">53.</td>
                        <td>Lain-Lain</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->other_interest) {{ $student->other_interest }} @else - @endif</td>
                    </tr>
                    <tr><td><td><td></td></td></td></tr>

                    {{-- Keterangan Perkembangan Siswa --}}
                    <tr>
                        <th colspan="4" class="text-left ml-5">H. KETERANGAN PERKEMBANGAN SISWA</th>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">54.</td>
                        <td>Menerima Bea Siswa</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->scholarship_id) {{ $student->scholarship_id }} @else Tahun - /TK/ - dari - @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">54.</td>
                        <td>Meninggalkan Sekolah</td>
                        <td width="2px"></td> 
                        <td>@if ($student->leave_school) {{ $student->leave_school }} @else - @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5"></td>
                        <td>a. Tanggal Meninggalkan Sekolah</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->leave_date) {{ tanggal_indonesia($student->leave_date, false) }} @else - @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5"></td>
                        <td>b. Alasan</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->leave_reason) {{ $student->leave_reason }} @else - @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">55.</td>
                        <td>Akhir Pendidikan</td>
                        <td width="2px"></td> 
                        <td>@if ($student->last_study) {{ $student->last_study }} @else - @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5"></td>
                        <td>a. Tamat Belajar</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->end_study) {{ tanggal_indonesia($student->end_study, false) }} @else - @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5"></td>
                        <td>b. Nomor STTB</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->sttb_no_end) {{ $student->sttb_no_end }} @else - @endif</td>
                    </tr>
                    <tr><td><td><td></td></td></td></tr>

                    {{-- Keterangan Setelah Selesai Pendidikan --}}
                    <tr>
                        <th colspan="4" class="text-left ml-5">H. KETERANGAN SETELAH SELESAI PENDIDIKAN</th>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">56.</td>
                        <td>Melanjutkan di</td>
                        <td width="2px"></td> 
                        <td>@if ($student->next_study) {{ $student->next_study }} @else - @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5">57.</td>
                        <td>Bekerja</td>
                        <td width="2px"></td> 
                        <td>@if ($student->occupation_id) {{ $student->occupation_id }} @else - @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5"></td>
                        <td>a. Tanggal Mulai Kerja</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->start_work) {{ tanggal_indonesia($student->start_work, false) }} @else - @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5"></td>
                        <td>b. Nama Perusahaan/Lembaga/Lain-Lain</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->company_name) {{ $student->company_name }} @else - @endif</td>
                    </tr>
                    <tr>
                        <td width="5px" class="ml-5"></td>
                        <td>c. Penghasilan</td>
                        <td width="2px">:</td> 
                        <td>@if ($student->revenue) {{ 'Rp '.format_uang($student->revenue).',00' }} @else - @endif</td>
                    </tr>
                </table>
            @endforeach
        @endif
    </body>
</html>