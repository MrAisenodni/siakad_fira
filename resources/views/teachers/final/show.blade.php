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
                                <div class="input-field col s12">
                                    <label for="lesson">Mata Pelajaran</label>
                                    <input id="lesson" type="text" name="lesson" placeholder="Mata Pelajaran" value="[{{ $final->lesson->teacher->nip }}] {{ $final->lesson->teacher->full_name }} | {{ $final->lesson->lesson->name }} ({{ $final->lesson->class->name }})" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s7">
                                    <label for="teacher">Pengawas</label>
                                    <input id="teacher" type="text" name="teacher" placeholder="Pengawas" value="[{{ $final->teacher->nip }}] {{ $final->teacher->full_name }}" disabled>
                                </div>
                                <div class="input-field col s5">
                                    <label for="date">Jadwal Ujian</label>
                                    <input id="date" type="text" name="date" placeholder="Jadwal" value="{{ date('d/m/Y', strtotime($final->date)) }} | {{ date('H:i', strtotime($final->clock_in)).' - '.date('H:i', strtotime($final->clock_out)) }}" disabled>
                                </div>
                            </div>
                            
                            <hr>
                            <div class="row">
                                <div class="col s12" style="text-align: right">
                                    <a class="waves-effect waves-light btn btn-round blue strong" href="{{ $menu->url }}">KEMBALI</a>
                                    {{-- <button class="waves-effect waves-light btn btn-round green strong" type="submit">SIMPAN</button> --}}
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