@extends('layouts.main')

@section('title', $menu->title)

@section('styles')
    {{-- Prism --}}
    <link href="{{ asset('/extra-libs/prism/prism.css') }}" rel="stylesheet">
    
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
                        <h5 class="card-title">{{ $menu->title }} Siswa</h5>
                        <form method="GET" action="{{ url()->current() }}/cari">
                            @csrf
                            <input type="hidden" name="month_id" value="@if ($inp_month) {{ $inp_month }} @else {{ $present->month_id }} @endif">
                            <input type="hidden" name="clazz_id" value="{{ $present->id }}">
                            <div class="row">
                                <div class="input-field col s4">
                                    <label for="month">Bulan</label>
                                    @if ($months)
                                        @foreach ($months as $month)
                                            @if ($month->id == $inp_month)
                                                <input id="month" type="text" name="month" value="{{ $month->name }}" disabled>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                                <div class="input-field col s4">
                                    <label for="clazz">Kelas</label>
                                    <input id="clazz" type="text" name="clazz" value="{{ $present->class->name }}" disabled>
                                </div>
                                <div class="input-field col s4">
                                    <label for="study_year">Tahun Pelajaran</label>
                                    <input id="study_year" type="text" name="study_year" value="{{ $present->study_year->name }}" disabled>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col s12" style="text-align: right">
                                    <a class="waves-effect waves-light btn btn-round blue strong" href="{{ $menu->url }}">KEMBALI</a>
                                    <button class="waves-effect waves-light btn btn-round green strong" type="submit">CARI</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-content">
                        <form action="{{ url()->current() }}" method="POST">
                            @method('put')
                            @csrf
                            <div class="row">
                                <div class="col s8">
                                    <h5 class="card-title">Daftar Siswa</h5>
                                </div>
                                <div class="col s4" style="text-align: right">
                                    <button class="waves-effect waves-light btn btn-round green strong" type="submit">SIMPAN</button>
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col s12">
                                    <table id="complex_header" class="responsive-table display" style="width:100%; border: 1px solid black; border-collapse: collapse;" onload="message()">
                                        <thead>
                                            <tr style="font-size: 8pt">
                                                <th rowspan="2" style="text-align: center; padding: 2px 0px">No</th>
                                                <th rowspan="2" style="text-align: center; padding: 2px 0px">Nama Siswa</th>
                                                <th colspan="31" style="text-align: center; padding: 2px 0px">Hari</th>
                                                <th colspan="3" style="text-align: center; padding: 2px 0px">Keterangan</th>
                                            </tr>
                                            <tr style="font-size: 8pt">
                                                @for ($i = 1; $i <= 31; $i++)
                                                    <th style="text-align: center; padding: 2px 0px" width="2%">{{ $i }}</th>
                                                @endfor
                                                <th style="text-align: center; padding: 2px 0px">Izin</th>
                                                <th style="text-align: center; padding: 2px 0px">Sakit</th>
                                                <th style="text-align: center; padding: 2px 0px">Absen</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($students)
                                                @foreach ($students as $student)
                                                    <tr style="font-size: 8pt">
                                                        <input type="hidden" name="present{{ $student->id }}" value="">
                                                        <td style="padding: 2px 2px">{{ $loop->iteration }}</td>
                                                        <td  style="padding: 2px 2px">{{ $student->full_name }}</td>
                                                        @for ($i = 1; $i <= 31; $i++)
                                                            <td  style="padding: 2px 2px">
                                                                <label>
                                                                    <input class="present" type="checkbox" style="opacity: 100; pointer-events: visible" />
                                                                </label>
                                                            </td>
                                                        @endfor
                                                        <td  style="padding: 2px 2px">
                                                            <div class="input-field" style="margin: 0rem">
                                                                <input id="permit" type="number" name="permit" value="{{ old('permit', 0) }}" style="font-size: 8pt; text-align: center;">
                                                            </div>
                                                        </td>
                                                        <td  style="padding: 2px 2px">
                                                            <div class="input-field" style="margin: 0rem">
                                                                <input id="sick" type="number" name="sick" value="{{ old('sick', 0) }}" style="font-size: 8pt; text-align: center;">
                                                            </div>                                                            
                                                        </td>
                                                        <td  style="padding: 2px 2px">
                                                            <div class="input-field" style="margin: 0rem">
                                                                <input id="absent" type="number" name="absent" value="{{ old('absent', 0) }}" style="font-size: 8pt; text-align: center;">
                                                            </div>                                                            
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <hr>
                            <div class="row">
                                <div class="col s12" style="text-align: right">
                                    <a class="waves-effect waves-light btn btn-round blue strong" href="{{ $menu->url }}">KEMBALI</a>
                                    <button class="waves-effect waves-light btn btn-round green strong" type="submit">SIMPAN</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Prism --}}
    <script src="{{ asset('/extra-libs/prism/prism.js') }}"></script>
    
    {{-- Data Tables --}}
    <script src="{{ asset('/extra-libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/dist/js/pages/datatable/datatable-basic.init.js') }}"></script>

    {{-- Form --}}
    <script src="{{ asset('/dist/js/form.js') }}"></script>
@endsection