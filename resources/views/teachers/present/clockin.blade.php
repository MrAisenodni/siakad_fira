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
                        <h5 class="card-title">{{ $menu->title }} Masuk</h5>
                        <form method="POST" action="{{ str_replace("/clockin", "", $menu->url) }}">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user_id }}">
                            <input type="hidden" name="role" value="{{ $role }}">
                            <div class="row">
                                <div class="input-field col s6">
                                    <select id="lesson" name="lesson" class="">
                                        <option value="" selected>--- SILAHKAN PILIH ---</option>
                                        @if ($lessons)
                                            @foreach ($lessons as $lesson)
                                                <option @if(old('lesson') == $lesson->id) selected @endif value="{{ $lesson->id }}">{{ $lesson->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="lesson">Mata Pelajaran <span class="materialize-red-text">*</span></label>
                                    @error('lesson')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col s3">
                                    <label for="date_in" class="m-t-20">Jadwal</label>
                                    <input id="date_in" type="hidden" name="date_in" value="{{ old('date_in', date('Y-m-d ', strtotime(now()))) }}">
                                    <div class="input-fleid">
                                        <input id="date_in" type="hidden" name="date_in" value="{{ old('date_in', date('Y-m-d', strtotime(now()))) }}">
                                        <input id="date_in" type="text" value="{{ old('date_in', date('d/m/Y', strtotime(now()))) }}" disabled>
                                    </div>
                                    @error('date_in')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col s3">
                                    <label for="clock_in" class="m-t-20">Masuk</label>
                                    <div class="input-fleid">
                                        <input id="clock_in" type="hidden" name="clock_in" value="{{ old('clock_in', date('H:i', strtotime(now()))) }}">
                                        <input id="clock_in" type="text" value="{{ old('clock_in', date('H:i', strtotime(now()))) }}" disabled>
                                    </div>
                                    @error('clock_in')
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