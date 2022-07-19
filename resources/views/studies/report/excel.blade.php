<table>
    <thead>
        <tr>
            <th colspan="33" style="text-align: center">{{ $provider[0]->company_name }}</th>
            {{-- <th style="text-align: center">Semester {{ ucwords($reports[0]->class->study_year->semester) }}</th> --}}
        </tr>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Nama</th>
            <th colspan="25">Pengetahuan</th>
            <th colspan="6">Keterampilan</th>
        </tr>
        <tr>
            @for ($i = 1; $i < 6; $i++)
                <th>PH{{ $i }}</th>
                <th>R{{ $i }}</th>
                <th>N{{ $i }}</th>
            @endfor
            <th>AVG PH</th>
            @for ($i = 1; $i < 6; $i++)
                <th>T{{ $i }}</th>
            @endfor
            <th>AVG T</th>
            <th>UTS</th>
            <th>UAS</th>
            <th>NPA</th>
            @for ($i = 1; $i < 6; $i++)
                <th>K{{ $i }}</th>
            @endfor
            <th>AVG K</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reports as $report)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $report->student->full_name }}</td>
                <td>{{ $report->ph }}</td>
            </tr>
        @endforeach
    </tbody>
</table>