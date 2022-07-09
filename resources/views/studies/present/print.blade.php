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
            .text-left {
                text-align: left;
            }
            .text-right {
                text-align: right;
            }
        </style>
    </head>
    <body>
        <h3>{{ $provider->company_name }}<br>Tahun Pelajaran {{ $clazz->study_year->name }} Semester {{ ucwords($clazz->study_year->semester) }}</h3><br>
        <table class="no-border">
            <tr class="no-border">
                <th class="no-border text-left">Kelas</th>
                <td class="no-border text-left">: {{ $clazz->class->name }}</td>
            </tr>
            <tr class="no-border">
                <th class="no-border text-left">Wali Kelas</th>
                <td class="no-border text-left">: {{ $clazz->teacher->full_name }}</td>
            </tr>
        </table>
        <br>

        <table id="" style="width:100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: center; line-height: 20px; background: #D2D2D2">
                    <th rowspan="2">No</th>
                    <th rowspan="2">Nama Siswa</th>
                    @if ($clazz->study_year->semester == 'genap')
                        @php $month = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'] @endphp
                    @else
                        @php $month = ['Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] @endphp
                    @endif
                    @for ($i = 0; $i < 6; $i++)
                        <th colspan="4">{{ $month[$i] }}</th>
                    @endfor
                    <th colspan="4">Jumlah</th>
                </tr>
                <tr style="text-align: center; line-height: 20px; background: #D2D2D2">
                    @for ($i = 0; $i < 7; $i++)
                        <th>H</th>
                        <th>S</th>
                        <th>I</th>
                        <th>A</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @if ($classes)
                    @foreach ($classes as $clazz)
                        <tr>
                            <td style="text-align: center">{{ $loop->iteration }}</td>
                            <td>{{ $clazz->full_name }}</td>
                            @for ($i = 0; $i < 7; $i++)
                                <td style="text-align: center">H</td>
                                <td style="text-align: center">S</td>
                                <td style="text-align: center">I</td>
                                <td style="text-align: center">A</td>
                            @endfor
                        </tr>
                    @endforeach
                    <tr style="background: #C6E0B4">
                        <td></td>
                        <th class="text-right">TOTAL</th>
                        @for ($i = 0; $i < 7; $i++)
                            <th style="text-align: center">H</th>
                            <th style="text-align: center">S</th>
                            <th style="text-align: center">I</th>
                            <th style="text-align: center">A</th>
                        @endfor
                    </tr>
                @endif
            </tbody>
        </table><br><br>
    </body>
</html>