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
                                <div class="input-field col s2">
                                    <input id="type" type="text" name="type" value="@if ($schedule->type == 'std') PELAJARAN 
                                        @elseif ($schedule->type == 'uts') UTS
                                        @else UAS
                                        @endif" disabled>
                                    <label for="type">Tipe</label>
                                </div>
                                <div class="input-field col s10">
                                    <input id="lesson" type="text" name="lesson" value="[{{ $schedule->lesson->teacher->nip }}] {{ $schedule->lesson->teacher->full_name }} | {{ $schedule->lesson->lesson->name }} ({{ $schedule->lesson->class->name }})" disabled>
                                    <label for="lesson">Mata Pelajaran</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col @if ($schedule->teacher) s3 @else s6 @endif">
                                    <input id="day" type="text" name="day" data-day="@php $day = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']; @endphp" value="@for($i=0; $i<7; $i++)@if($i+1 == $schedule->day){{str_replace(' ', '', $day[$i])}}@endif @endfor" disabled>
                                    <label for="day">Hari</label>
                                </div>
                                <div class="input-field col @if ($schedule->teacher) s3 @else s6 @endif">
                                    <input id="clock_in" type="text" name="clock_in" value="{{ date('H:i', strtotime($schedule->clock_in)).' - '.date('H:i', strtotime($schedule->clock_out)) }}" disabled>
                                    <label for="clock_in">Waktu</label>
                                </div>
                                @if ($schedule->teacher) 
                                    <div class="input-field col s6">
                                        <input id="spv_teacher" type="text" name="spv_teacher" value="[{{ $schedule->teacher->nip }}] {{ $schedule->teacher->full_name }}" disabled>
                                        <label for="spv_teacher">Guru Pengawas</label>
                                    </div>
                                @endif
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