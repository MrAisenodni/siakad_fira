<style>
    table, th, td {
        border: 1px solid;
    }

    .no-border {
        border: none;
    }

    h3 {
        text-align: center;
        margin-bottom: 2px;
    }
</style>

<h3>SMP Kartika VIII-1<br>Tahun Pelajaran {{ $classes[0]->study_year }}<br>Nomor Urut Peserta Didik</h3>
<br>

<table id="" style="width:100%; border-collapse: collapse;">
    <thead>
        <tr style="text-align: center; line-height: 20px">
            <th>No</th>
            <th>Nomor Induk</th>
            <th>Nomor Induk Siswa Nasional</th>
            <th>Nama Peserta Didik</th>
            <th>L/P</th>
            <th>Kelas</th>
        </tr>
    </thead>
    <tbody>
        @if ($classes)
            @foreach ($classes as $clas)
                <tr>
                    <td style="text-align: center">{{ $loop->iteration }}</td>
                    <td style="text-align: center">{{ $clas->nis }}</td>
                    <td style="text-align: center">{{ $clas->nisn }}</td>
                    <td>{{ $clas->full_name }}</td>
                    <td style="text-align: center">{{ $clas->gender }}</td>
                    <td style="text-align: center">{{ $clas->class }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table><br><br>

<table id="" class="no-border" style="width:100%;">
    <tr>
        <th class="no-border">Mengetahui,</th>
        <th class="no-border">Petugas</th>
    </tr>
    <tr>
        <th class="no-border">Kepala Sekolah</th>
        <th class="no-border"></th>
    </tr>
    <tr>
        <th class="no-border"><br><br><br><br><br></th>
        <th class="no-border"><br><br><br><br><br></th>
    </tr>
    <tr>
        <th class="no-border" style="text-decoration: underline">{{ $head->full_name }}</th>
        <th class="no-border" style="text-decoration: underline">{{ $admin }}</th>
    </tr>
    <tr>
        <th class="no-border">NIP {{ $head->nip }}</th>
        <th class="no-border">NIP -</th>
    </tr>
</table>