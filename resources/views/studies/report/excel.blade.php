<table>
    <thead>
        <tr>
            <th colspan="34" style="text-align: center">{{ $provider[0]->company_name }}</th>
            {{-- <th style="text-align: center">Semester {{ ucwords($reports[0]->class->study_year->semester) }}</th> --}}
        </tr>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">NIS</th>
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
                <td>{{ $report->nis }}</td>
                <td>{{ $report->full_name }}</td>
                <td>{{ $report->ph1 }}</td>
                <td>{{ $report->r1 }}</td>
                <td>{{ $report->n1 }}</td>
                <td>{{ $report->ph2 }}</td>
                <td>{{ $report->r2 }}</td>
                <td>{{ $report->n2 }}</td>
                <td>{{ $report->ph3 }}</td>
                <td>{{ $report->r3 }}</td>
                <td>{{ $report->n3 }}</td>
                <td>{{ $report->ph4 }}</td>
                <td>{{ $report->r4 }}</td>
                <td>{{ $report->n4 }}</td>
                <td>{{ $report->ph5 }}</td>
                <td>{{ $report->r5 }}</td>
                <td>{{ $report->n5 }}</td>
                <td>{{ $report->avg_ph }}</td>
                <td>{{ $report->t1 }}</td>
                <td>{{ $report->t2 }}</td>
                <td>{{ $report->t3 }}</td>
                <td>{{ $report->t4 }}</td>
                <td>{{ $report->t5 }}</td>
                <td>{{ $report->avg_t }}</td>
                <td>{{ $report->pts }}</td>
                <td>{{ $report->pas }}</td>
                <td>{{ $report->npa }}</td>
                <td>{{ $report->k1 }}</td>
                <td>{{ $report->k2 }}</td>
                <td>{{ $report->k3 }}</td>
                <td>{{ $report->k4 }}</td>
                <td>{{ $report->k5 }}</td>
                <td>{{ $report->avg_k }}</td>
            </tr>
        @endforeach
    </tbody>
</table>