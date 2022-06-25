<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        
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
        </style>
    </head>
    <body>
        <h3 class="text-center">LEMBAR BUKU INDUK SISWA</h3>
        
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
        
        <table style="width: 100%">
            <tr>
                <th colspan="4" class="text-left ml-5">Keterangan Tentang Diri Siswa</th>
                <td class="text-right" width="10%">
                    <img src="{{ asset($student->picture) }}" alt="Foto Siswa" class="mr-10">
                </td>
            </tr>   
            <tr>
                <td width="5px" class="ml-5">1.</td>
                <td>Nama Siswa</td>
                <td width="5px">:</td>
                <td class="text-left">{{ $student->full_name }}</td>
            </tr>
        </table>
    </body>
</html>