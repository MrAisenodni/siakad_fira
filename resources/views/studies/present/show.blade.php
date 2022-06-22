@extends('layouts.main')

@section('title', $menu->title)

@section('styles')
    {{-- Prism --}}
    <link href="{{ asset('/extra-libs/prism/prism.css') }}" rel="stylesheet">

    {{-- Select2 --}}
    <link href="{{ asset('/libs/select2/dist/css/select2.css') }}" rel="stylesheet">

    {{-- Datepicker --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('/libs/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">
    
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
                        <form method="POST" action="{{ $menu->url }}">
                            @csrf
                            <input type="hidden" name="clazz_id" value="{{ $clazz->id }}">
                            <div class="row">
                                <div class="input-field col s5">
                                    <input id="study_date" class="datepicker" type="text" placeholder="dd/mm/yyyy" name="study_date" value="{{ old('study_date') }}" required>
                                    <label for="study_date">Tanggal</label>
                                    @error('study_date')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s3">
                                    <label for="clazz">Kelas</label>
                                    <input id="clazz" type="text" name="clazz" value="{{ $clazz->class->name }}" disabled>
                                </div>
                                <div class="input-field col s4">
                                    <label for="study_year">Tahun Pelajaran</label>
                                    <input id="study_year" type="text" name="study_year" value="{{ $clazz->study_year->name }}" disabled>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col s12" style="text-align: right">
                                    <a class="waves-effect waves-light btn btn-round blue strong" href="{{ $menu->url }}">KEMBALI</a>
                                    <button class="waves-effect waves-light btn btn-round green strong" type="submit">TAMBAH</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <form action="{{ url()->current() }}" method="GET">
                                @csrf
                                <div class="input-field col s5">
                                    <select id="month" name="month" class="">
                                        <option value="" selected>SEMUA</option>
                                        @if ($months)
                                            @foreach ($months as $month)
                                                <option 
                                                    @if ($inp_month) 
                                                        @if(old('month', $inp_month) == $month->id) selected @endif 
                                                    @else 
                                                        @if(old('month') == $month->id) selected @endif 
                                                    @endif value="{{ $month->id }}">{{ $month->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="month">Bulan</label>
                                    @error('month')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s5">
                                    <select id="year" name="year" class="">
                                        <option value="" selected>SEMUA</option>
                                        @for ($i = date('Y', strtotime(now())); $i >= 1700; $i--)
                                            <option 
                                                @if ($inp_year) 
                                                    @if(old('year', $inp_year) == $i) selected @endif 
                                                @else 
                                                    @if(old('year') == $i) selected @endif 
                                                @endif value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                    <label for="year">Tahun</label>
                                    @error('year')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s2" style="text-align: right">
                                    <button class="waves-effect waves-light btn btn-round green strong" type="submit">CARI</button>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            @if (session('status'))
                                <div class="col s12">
                                    <div class="success-alert-bar p-15 m-t-10 green white-text" style="display: block">
                                        {{ session('status') }}
                                    </div>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="col s12">
                                    <div class="success-alert-bar p-15 m-t-10 red white-text" style="display: block">
                                        {{ session('error') }}
                                    </div>
                                </div>
                            @endif
                            <div class="col s12">
                                <table id="present_config" class="responsive-table display" style="width:100%" onload="message()">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Siswa</th>
                                            <th>Hadir</th>
                                            <th>Sakit</th>
                                            <th>Izin</th>
                                            <th>Absen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($classes)
                                            @foreach ($classes as $claz)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $claz->full_name }}</td>
                                                    <td>
                                                        @if ($claz->present)
                                                            {{ $claz->present }}
                                                        @else
                                                            0
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($claz->sick)
                                                            {{ $claz->sick }}
                                                        @else
                                                            0
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($claz->permit)
                                                            {{ $claz->permit }}
                                                        @else
                                                            0
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($claz->absent)
                                                            {{ $claz->absent }}
                                                        @else
                                                            0
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Prism --}}
    <script src="{{ asset('/extra-libs/prism/prism.js') }}"></script>

    {{-- Select2 --}}
    <script src="{{ asset('/libs/select2/dist/js/select2.min.js') }}"></script>

    {{-- Datepicker --}}
    <script src="{{ asset('/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('/libs/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker-custom.js') }}"></script>

    {{-- Data Tables --}}
    <script src="{{ asset('/extra-libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/dist/js/pages/datatable/datatable-basic.init.js') }}"></script>

    {{-- Form --}}
    <script src="{{ asset('/dist/js/form.js') }}"></script>
    @include('scripts.datepicker')
    @include('scripts.select2')
@endsection