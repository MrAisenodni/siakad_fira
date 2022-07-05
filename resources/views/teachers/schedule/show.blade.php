@extends('layouts.main')

@section('title', $menu->title)

@section('styles')
    {{-- Prism --}}
    <link href="{{ asset('/extra-libs/prism/prism.css') }}" rel="stylesheet">

    {{-- Select2 --}}
    <link href="{{ asset('/libs/select2/dist/css/select2.css') }}" rel="stylesheet">

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
                        <h5 class="card-title">Detail {{ $menu->title }}</h5>
                        @if (session('status'))
                            <div class="success-alert-bar p-15 m-t-10 m-b-10 red white-text" style="display: block">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ str_replace("/edit", "", url()->current()) }}">
                            @method('put')
                            @csrf
                            <div class="row">
                                <div class="input-field col s6">
                                    <input id="lesson" type="text" name="lesson" value="{{ $schedule->lesson->lesson->name }}" disabled>
                                    <label for="lesson">Mata Pelajaran</label>
                                </div>
                                <div class="input-field col s2">
                                    <input id="clazz" type="text" name="clazz" value="{{ $schedule->lesson->class->name }}" disabled>
                                    <label for="clazz">Kelas</label>
                                </div>
                                <div class="input-field col s2">
                                    <input id="day" type="text" name="day" data-day="@php $day = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']; @endphp" value="@for($i=0; $i<7; $i++)@if($i+1 == $schedule->day){{str_replace(' ', '', $day[$i])}}@endif @endfor" disabled>
                                    <label for="day">Hari</label>
                                </div>
                                <div class="input-field col s2">
                                    <input id="clock_in" type="text" name="clock_in" value="{{ date('H:i', strtotime($schedule->clock_in)).' - '.date('H:i', strtotime($schedule->clock_out)) }}" disabled>
                                    <label for="clock_in">Waktu</label>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col s12" style="text-align: right">
                                    <a class="waves-effect waves-light btn btn-round blue strong" href="{{ $menu->url }}">KEMBALI</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s12">
                                <h5 class="card-title">Daftar Siswa</h5>
                            </div>
                            <div class="col s12">
                                <table id="zero_config" class="responsive-table display" style="width:100%" onload="message()">
                                    <thead>
                                        <tr>
                                            <th>NIS</th>
                                            <th>NISN</th>
                                            <th>Nama Siswa</th>
                                            <th>No HP/Telp</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($students)
                                            @foreach ($students as $student)
                                                <tr data-id="{{ $student->id }}">
                                                    <td>{{ $student->nis }}</td>
                                                    <td>{{ $student->nisn }}</td>
                                                    <td>{{ $student->full_name }}</td>
                                                    <td>{{ $student->phone_number }}@if($student->home_number)/{{ $student->home_number }}@endif</td>
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

    {{-- Data Tables --}}
    <script src="{{ asset('/extra-libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/dist/js/pages/datatable/datatable-basic.init.js') }}"></script>
    
    {{-- Form --}}
    <script src="{{ asset('/dist/js/form.js') }}"></script>
    @include('scripts.select2')
@endsection