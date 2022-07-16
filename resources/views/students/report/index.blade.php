@extends('layouts.main')

@section('title', $menu->title)

@section('styles')
    {{-- Prism --}}
    <link href="{{ asset('/extra-libs/prism/prism.css') }}" rel="stylesheet">

    {{-- Select2 --}}
    <link href="{{ asset('/libs/select2/dist/css/select2.css') }}" rel="stylesheet">

    {{-- Data Tables --}}
    <link href="{{ asset('/dist/css/pages/data-table.css') }}" rel="stylesheet">

    {{-- Select2 --}}
    <link href="{{ asset('/libs/select2/dist/css/select2.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <h5 class="card-title">Nilai Siswa</h5>
                        <form action="{{ url()->current() }}" method="GET">
                            <div class="row">
                                <div class="input-field col s2">
                                    <input id="clazz" type="text" name="clazz" value="{{ $clazz->class->name }}" disabled>
                                    <label for="clazz">Kelas</label>
                                </div>
                                <div class="input-field col s4">
                                    <input id="teacher_head" type="text" name="teacher_head" value="{{ $clazz->teacher->full_name }}" disabled>
                                    <label for="teacher_head">Wali Kelas</label>
                                </div>
                                <div class="input-field col s6">
                                    <select id="study_year" name="study_year" class="disabled select2">
                                        <option value="" selected>SEMUA</option>
                                        @if ($study_years)
                                            @foreach ($study_years as $study_year)
                                                <option @if(old('study_year') == $study_year->id) selected @endif value="{{ $study_year->id }}">{{ $study_year->name }} | {{ ucwords($study_year->semester) }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="study_year" class="active">Tahun Pelajaran</label>
                                    @error('study_year')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <hr>
                            <div class="row">
                                <div class="col s12" style="text-align: right">
                                    <button class="waves-effect waves-light btn btn-round green strong" type="submit">CARI</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            
                <ul class="card collapsible collapsible-accordion collapsible-dark">
                    <li class="">
                        <div class="collapsible-header">
                            <h5 class="card-title">Penilaian Harian</h5>                            
                        </div>
                        <div class="collapsible-body">
                            <table class="responsive-table display" style="width:100%">
                                <thead>
                                    <tr style="background: rgb(205, 255, 204)">
                                        <th style="border: 1px solid">Mata Pelajaran</th>
                                        @for ($i = 1; $i < 6; $i++)
                                            <th style="border: 1px solid">PH{{ $i }}</th>
                                            <th style="border: 1px solid">R{{ $i }}</th>
                                            <th style="border: 1px solid">N{{ $i }}</th>
                                        @endfor
                                        <th style="border: 1px solid">Rata PH</th>
                                        <th style="border: 1px solid">PTS</th>
                                        <th style="border: 1px solid">PAS</th>
                                        <th style="border: 1px solid">NPA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($reports)
                                        @foreach ($reports as $report)
                                            <tr id="noedit" data-id="{{ $report->id }}">
                                                <td style="border: 1px solid">{{ $report->lesson->name }}</td>
                                                @for ($i = 1; $i < 6; $i++)
                                                    <td style="border: 1px solid">
                                                        {{ $report['ph'.$i] }}
                                                    </td>
                                                    <td style="border: 1px solid">
                                                        {{ $report['r'.$i] }}
                                                    </td>
                                                    <td style="border: 1px solid">
                                                        {{ $report['n'.$i] }}
                                                    </td>
                                                @endfor
                                                <td style="border: 1px solid">{{ $report->avg_ph }}</td>
                                                <td style="border: 1px solid">{{ $report->pts }}</td>
                                                <td style="border: 1px solid">{{ $report->pas }}</td>
                                                <td style="border: 1px solid">{{ $report->npa }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </li>
                    <li class="active">
                        <div class="collapsible-header">
                            <h5 class="card-title">Nilai Tugas</h5>                            
                        </div>
                        <div class="collapsible-body">
                            <table class="responsive-table" style="width:100%; border: 1px solid">
                                <thead style="background: rgb(236, 217, 255)">
                                    <tr>
                                        <th style="border: 1px solid">Mata Pelajaran</th>
                                        @for ($i = 1; $i < 6; $i++)
                                            <th style="border: 1px solid">T{{ $i }}</th>
                                        @endfor
                                        <th style="border: 1px solid">Rata T</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($reports)
                                        @foreach ($reports as $report)
                                            <tr id="noedit" data-id="{{ $report->id }}">
                                                <td style="border: 1px solid">{{ $report->lesson->name }}</td>
                                                @for ($i = 1; $i < 6; $i++)
                                                    <td style="border: 1px solid">{{ $report['t'.$i] }}</td>
                                                @endfor
                                                <td style="border: 1px solid">{{ $report->avg_t }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </li>
                    <li class="">
                        <div class="collapsible-header">
                            <h5 class="card-title">Nilai Keterampilan</h5>                            
                        </div>
                        <div class="collapsible-body">
                            
                            <table class="responsive-table" style="width:100%; border: 1px solid">
                                <thead style="background: rgb(254, 241, 200)">
                                    <tr>
                                        <th style="border: 1px solid">Mata Pelajaran</th>
                                        @for ($i = 1; $i < 6; $i++)
                                            <th style="border: 1px solid">K{{ $i }}</th>
                                        @endfor
                                        <th style="border: 1px solid">Rata K</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($reports)
                                        @foreach ($reports as $report)
                                            <tr id="noedit" data-id="{{ $report->id }}">
                                                <td style="border: 1px solid">{{ $report->lesson->name }}</td>
                                                @for ($i = 1; $i < 6; $i++)
                                                    <td style="border: 1px solid">{{ $report['k'.$i] }}</td>
                                                @endfor
                                                <td style="border: 1px solid">{{ $report->avg_k }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Prism --}}
    <script src="{{ asset('/extra-libs/prism/prism.js') }}"></script>

    {{-- Select2 --}}
    <script src="{{ asset('/libs/select2/dist/js/select2.min.js') }}"></script>

    {{-- Data Tables --}}
    <script src="{{ asset('/extra-libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/dist/js/pages/datatable/datatable-basic.init.js') }}"></script>

    {{-- Select2 --}}
    <script src="{{ asset('/libs/select2/dist/js/select2.min.js') }}"></script>

    {{-- Form --}}
    <script src="{{ asset('/dist/js/form.js') }}"></script>
    @include('scripts.select2')
@endsection