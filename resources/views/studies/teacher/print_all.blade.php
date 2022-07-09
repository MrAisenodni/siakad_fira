<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ public_path('/images/logo-smp-nobg.png') }}">
        <title>Daftar Tenaga Didik di {{ $provider->company_name }}</title>
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
        <h3>{{ $provider->company_name }}<br>Daftar Tenaga Didik</h3>
        <br>

        <table id="" style="width:100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: center; line-height: 20px; background: grey">
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama Guru</th>
                    <th>Tempat, Tanggal Lahir</th>
                    <th>Bidang Studi</th>
                    <th>L/P</th>
                    <th>No HP/Telp</th>
                </tr>
            </thead>
            <tbody>
                @if ($teachers)
                    @foreach ($teachers as $teacher)
                        <tr>
                            <td style="text-align: center">{{ $loop->iteration }}</td>
                            <td style="text-align: center">{{ $teacher->nip }}</td>
                            <td>{{ $teacher->full_name }}</td>
                            <td>{{ $teacher->birth_place }}, {{ date('d F Y', strtotime($teacher->birth_date)) }}</td>
                            <td style="text-align: center">{{ $teacher->field_study }}</td>
                            <td style="text-align: center">{{ strtoupper($teacher->gender) }}</td>
                            <td style="text-align: center">{{ $teacher->phone_number }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table><br><br>
    </body>
</html>