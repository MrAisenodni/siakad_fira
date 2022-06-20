@extends('layouts.main')

@section('title', $menu->title)

@section('styles')
    {{-- Data Tables --}}
    <link href="{{ asset('/dist/css/pages/data-table.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <h5 class="card-title">Detail Siswa</h5>
                        <div class="row">
                            <div class="col s12"><hr>
                                <div class="row">
                                    <div class="input-field col s2">
                                        <input id="nis" type="text" name="nis" value="{{ $student->nis }}" disabled>
                                        <label for="nis">NIS</label>
                                    </div>
                                    <div class="input-field col s2">
                                        <input id="nisn" type="text" name="nisn" value="{{ $student->nisn }}" disabled>
                                        <label for="nisn">NISN</label>
                                        @error('nisn')
                                            <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="input-field col s7">
                                        <input id="full_name" type="text" name="full_name" value="{{ $student->full_name }}" disabled>
                                        <label for="full_name">Nama Lengkap</label>
                                    </div>
                                    <div class="input-field col s1">
                                        <input id="clazz" type="text" name="clazz" value="{{ $student->class->class->name }}" disabled>
                                        <label for="clazz">Kelas</label>
                                        @error('clazz')
                                            <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col s12" style="text-align: right">
                                        <a class="waves-effect waves-light btn btn-round blue strong" href="{{ url()->previous() }}">KEMBALI</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s10">
                                <h5 class="card-title">{{ $menu->title }}</h5>
                            </div>
                            <div class="col s2 right-align">
                                <a class="waves-effect waves-light btn btn-round green strong" href="{{ url()->current() }}/create">TAMBAH</a>
                            </div>
                            @if (session('status'))
                                <div class="col s12">
                                    <div class="success-alert-bar p-15 m-t-10 green white-text" style="display: block">
                                        {{ session('status') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <table id="zero_config" class="responsive-table display" style="width:100%" onload="message()">
                                    <thead>
                                        <tr>
                                            <th>Mata Pelajaran</th>
                                            <th>Bulan 1</th>
                                            <th>Bulan 2</th>
                                            <th>Bulan 3</th>
                                            <th>Bulan 4</th>
                                            <th>UTS</th>
                                            <th>UAS</th>
                                            <th>Nilai Akhir</th>
                                            <th>Nilai Rata-Rata</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($reports)
                                            @foreach ($reports as $report)
                                                <tr id="data" data-id="{{ $report->id }}" data-aid="{{ $student->id }}">
                                                    <td>{{ $report->lesson->name }}</td>
                                                    <td>{{ $report->score_1 }}</td>
                                                    <td>{{ $report->score_2 }}</td>
                                                    <td>{{ $report->score_3 }}</td>
                                                    <td>{{ $report->score_4 }}</td>
                                                    <td>{{ $report->score_uts }}</td>
                                                    <td>{{ $report->score_uas }}</td>
                                                    <td>{{ $report->score_na }}</td>
                                                    <td>{{ $report->score_avg }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row m-t-10">
                            <div class="col s12" style="text-align: right">
                                <a class="waves-effect waves-light btn btn-round blue strong" href="{{ url()->previous() }}">KEMBALI</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Data Tables --}}
    <script src="{{ asset('/extra-libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/dist/js/pages/datatable/datatable-basic.init.js') }}"></script>
@endsection