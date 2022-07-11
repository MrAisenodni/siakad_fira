<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ public_path('/images/logo-smp-nobg.png') }}">
        <title>Histori Pelunasan SPP {{ $provider->company_name }}</title>
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
        </style>
    </head>
    <body>
        <h3>{{ $provider->founder_name }}<br>{{ $provider->company_name }}<br>{{ $provider->company_address }}</h3>
        <br>
        <table style="border: none">
            <tr>
                <th class="text-left" style="border: none">Tahun</th>
                <td style="border: none">: {{ $payments[0]->year }}</td>
            </tr>
            <tr>
                <th class="text-left" style="border: none">SPP/Bulan</th>
                <td style="border: none">: Rp {{ format_uang($payments[0]->amount) }}</td>
            </tr>
            <tr>
                <th class="text-left" style="border: none">Kelas</th>
                <td style="border: none">: {{ $payments[0]->class_name }}</td>
            </tr>
            <tr>
                <th class="text-left" style="border: none">Wali Kelas</th>
                <td style="border: none">: {{ $payments[0]->teacher_name }}</td>
            </tr>
        </table><br>

        <table id="" style="width:100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: center; line-height: 20px; background: #D2D2D2">
                    <th>No</th>
                    <th>Nama Siswa</th>
                    @foreach ($months as $month)
                        <th>{{ $month->name }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @if ($payments)
                    @foreach ($payments as $payment)
                        <tr>
                            <td style="text-align: center">{{ $loop->iteration }}</td>
                            <td colspan="">{{ $payment->full_name }}</td>
                            @foreach ($months as $month)
                                @if ($month->id == $payment->month) 
                                    @if ($payment->due_date)
                                        <td>{{ date('d-m-Y', strtotime($payment->due_date)) }}</td>
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    <td></td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table><br><br>
    </body>
</html>