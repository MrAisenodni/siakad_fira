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
                        @if (session('status'))
                            <div class="success-alert-bar p-15 m-t-10 m-b-10 red white-text" style="display: block">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ str_replace("/create", "", $menu->url) }}">
                            @csrf
                            <div class="row">
                                <div class="input-field col s2">
                                    <select id="type" name="type" class="">
                                        <option @error(old('type') == 'std') selected @enderror value="std" selected>UMUM</option>
                                        <option @error(old('type') == 'uts') selected @enderror value="uts">UTS</option>
                                        <option @error(old('type') == 'uas') selected @enderror value="uas">UAS</option>
                                    </select>
                                    <label for="type">Tipe</label>
                                    @error('type')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s10">
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
                            </div>

                            <div class="row">
                                <div class="input-field col s3">
                                    <select id="day" name="day" class="">
                                        <option @if(old('day') == '1') selected @endif value="1" selected>Senin</option>
                                        <option @if(old('day') == '2') selected @endif value="2">Selasa</option>
                                        <option @if(old('day') == '3') selected @endif value="3">Rabu</option>
                                        <option @if(old('day') == '4') selected @endif value="4">Kamis</option>
                                        <option @if(old('day') == '5') selected @endif value="5">Jumat</option>
                                        <option @if(old('day') == '6') selected @endif value="6">Sabtu</option>
                                        <option @if(old('day') == '7') selected @endif value="7">Minggu</option>
                                    </select>
                                    <label for="day">Hari <span class="materialize-red-text">*</span></label>
                                    @error('day')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col s3">
                                    <label for="clock" class="m-t-20">Pukul <span class="materialize-red-text">*</span></label>
                                    <div class="input-fleid">
                                        <input id="clock" type="text" name="clock" placeholder="07:00" class="timepicker" value="{{ old('clock') }}">
                                    </div>
                                    @error('clock')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s6">
                                    <select id="spv_teacher" name="spv_teacher" class="" disabled>
                                        <option value="" selected>--- SILAHKAN PILIH ---</option>
                                        @if ($teachers)
                                            @foreach ($teachers as $teacher)
                                                <option @if(old('spv_teacher') == $teacher->id) selected @endif value="{{ $teacher->id }}">[{{ $teacher->nip }}] {{ $teacher->full_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="spv_teacher">Guru Pengawas</label>
                                    @error('spv_teacher')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <p class="error">*Jika Tipe diisi bernilai UTS atau UAS, maka Guru Pengawas wajib diisi.</p>

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