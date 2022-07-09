<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ public_path('/images/logo-smp-nobg.png') }}">
        <title>Daftar Peserta Didik di {{ $provider->company_name }}</title>
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
    </head>
    <body>
        <h3>{{ $provider->company_name }}<br>Daftar Peserta Didik</h3>
        <br>

        <table id="" style="width:100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: center; line-height: 20px; background: grey">
                    <th>No</th>
                    <th>Nomor Induk</th>
                    <th>Nomor Induk Siswa Nasional</th>
                    <th>Nama Peserta Didik</th>
                    <th>Tempat, Tgl Lahir</th>
                    <th>L/P</th>
                    <th>No HP/Telp</th>
                    <th>Nama Ayah</th>
                    <th>Nama Ibu</th>
                    <th>Nama Wali</th>
                </tr>
            </thead>
            <tbody>
                @if ($students)
                    @foreach ($students as $student)
                        <tr>
                            <td style="text-align: center">{{ $loop->iteration }}</td>
                            <td style="text-align: center">{{ $student->nis }}</td>
                            <td style="text-align: center">{{ $student->nisn }}</td>
                            <td>{{ $student->full_name }}</td>
                            <td>{{ $student->birth_place }}, {{ date('d F Y', strtotime($student->birth_date)) }}</td>
                            <td style="text-align: center">{{ strtoupper($student->gender) }}</td>
                            <td style="text-align: center">{{ $student->phone_number }}</td>
                            <td>@if ($student->father) {{ $student->father->full_name }} @endif</td>
                            <td>@if ($student->mother) {{ $student->mother->full_name }} @endif</td>
                            <td>@if ($student->guardian) {{ $student->guardian->full_name }} @endif</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table><br><br>
    </body>
</html>