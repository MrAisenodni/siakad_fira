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
                        <h5 class="card-title">Tambah {{ $menu->title }}</h5>
                        <form method="POST" action="{{ str_replace("/create", "", $menu->url) }}">
                            @csrf
                            <div class="row">
                                <div class="input-field col s6">
                                    <select id="lesson" name="lesson" class="">
                                        <option value="" selected>--- SILAHKAN PILIH ---</option>
                                        @if ($lessons)
                                            @foreach ($lessons as $lesson)
                                                <option @if(old('lesson') == $lesson->id) selected @endif value="{{ $lesson->id }}">[{{ $lesson->teacher->nip }}] {{ $lesson->teacher->full_name }} | {{ $lesson->lesson->name }} ({{ $lesson->class->name }})</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="lesson">Mata Pelajaran <span class="materialize-red-text">*</span></label>
                                    @error('lesson')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s2">
                                    <select id="day" name="day" class="">
                                        <option @if(old('day') == '1') selected @endif value="1" selected>Senin</option>
                                        <option @if(old('day') == '2') selected @endif value="2">Selasa</option>
                                        <option @if(old('day') == '3') selected @endif value="3">Rabu</option>
                                        <option @if(old('day') == '4') selected @endif value="4">Kamis</option>
                                        <option @if(old('day') == '5') selected @endif value="5">Jumat</option>
                                        <option @if(old('day') == '6') selected @endif value="6" disabled>Sabtu</option>
                                        <option @if(old('day') == '7') selected @endif value="7" disabled>Minggu</option>
                                    </select>
                                    <label for="day">Hari <span class="materialize-red-text">*</span></label>
                                    @error('day')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col s2">
                                    <label for="clock_in" class="m-t-20">Masuk <span class="materialize-red-text">*</span></label>
                                    <div class="input-fleid">
                                        <input id="clock_in" type="text" name="clock_in" placeholder="07:00" class="timepicker" value="{{ old('clock_in') }}">
                                    </div>
                                    @error('clock_in')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col s2">
                                    <label for="clock_out" class="m-t-20">Keluar <span class="materialize-red-text">*</span></label>
                                    <div class="input-fleid">
                                        <input id="clock_out" type="text" name="clock_out" placeholder="09:00" class="timepicker" value="{{ old('clock_out') }}">
                                    </div>
                                    @error('clock_out')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
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