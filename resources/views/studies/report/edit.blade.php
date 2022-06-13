@extends('layouts.main')

@section('title', $menu->title)

@section('styles')
    {{-- Prism --}}
    <link href="{{ asset('/extra-libs/prism/prism.css') }}" rel="stylesheet">
    
    {{-- Select2 --}}
    <link href="{{ asset('/libs/select2/dist/css/select2.css') }}" rel="stylesheet">
    
    {{-- Datepicker --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('/libs/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">
@endsection

@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <h5 class="card-title">Detail Siswa</h5>
                        @if (session('status'))
                            <div class="success-alert-bar p-15 m-t-10 m-b-10 red white-text" style="display: block">
                                {{ session('status') }}
                            </div>
                        @endif
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <h5 class="card-title">{{ $menu->title }}</h5>
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
                                @if ($lessons)
                                    @foreach ($lessons as $lesson)
                                        <tr id="data" data-id="{{ $lesson->id }}">
                                            <td>{{ $lesson->lesson->name }}</td>
                                            @if ($lesson->lesson->score)
                                                @foreach ($lesson->lesson->score as $score)
                                                    <td>{{ $score->score_1 }}</td>
                                                    <td>{{ $score->score_2 }}</td>
                                                    <td>{{ $score->score_3 }}</td>
                                                    <td>{{ $score->score_4 }}</td>
                                                    <td>{{ $score->score_uts }}</td>
                                                    <td>{{ $score->score_uas }}</td>
                                                    <td>{{ $score->score_na }}</td>
                                                    <td>{{ $score->score_avg }}</td>
                                                @endforeach
                                            @else
                                                <td>80</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <form method="POST" action="{{ str_replace("/edit", "", url()->current()) }}">
                            @method('put')
                            @csrf

                            <hr>
                            <div class="row">
                                <div class="col s12" style="text-align: right">
                                    <a class="waves-effect waves-light btn btn-round blue strong" href="{{ $menu->url }}">KEMBALI</a>
                                    <button class="waves-effect waves-light btn btn-round green strong" type="submit" style="display: none">SIMPAN</button>
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
    
    {{-- Select2 --}}
    <script src="{{ asset('/libs/select2/dist/js/select2.min.js') }}"></script>

    {{-- Datepicker --}}
    <script src="{{ asset('/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('/libs/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker-custom.js') }}"></script>
    
    {{-- Form --}}
    <script src="{{ asset('/dist/js/form.js') }}"></script>
    @include('scripts.datepicker')
    @include('scripts.select2')
@endsection