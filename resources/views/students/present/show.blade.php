@extends('layouts.main')

@section('title', $menu->title)

@section('styles')
@endsection

@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <h5 class="card-title">Detail {{ $menu->title }}</h5>
                        <div class="row">
                            <div class="input-field col s4">
                                <label for="lesson">Mata Pelajaran</label>
                                <input id="lesson" type="text" name="lesson" value="{{ $present->lesson->name }}" disabled>
                            </div>
                            <div class="input-field col s2">
                                <label for="date_in">Jadwal</label>
                                <input id="date_in" type="text" name="date_in" value="@if ($present->clock_in) {{ date('d/m/Y', strtotime($present->clock_in)) }} @else - @endif" disabled>
                            </div>
                            <div class="input-field col s1">
                                <label for="clock_in">Masuk</label>
                                <input id="clock_in" type="text" name="clock_in" value="@if ($present->clock_in) {{ date('H:i', strtotime($present->clock_in)) }} @else - @endif" disabled>
                            </div>
                            <div class="input-field col s1">
                                <label for="clock_out">Pulang</label>
                                <input id="clock_out" type="text" name="clock_out" value="@if ($present->clock_out) {{ date('H:i', strtotime($present->clock_out)) }} @else - @endif" disabled>
                            </div>
                            <div class="input-field col s4">
                                <label for="reason">Alasan</label>
                                <input id="reason" type="text" name="reason" @if ($present->reason_id) style="color: red" value="[{{ $present->mst_reason->name }}] {{ $present->reason }}" @else value="-" @endif disabled>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col s12" style="text-align: right">
                                <a class="waves-effect waves-light btn btn-round blue strong" href="{{ $menu->url }}">KEMBALI</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection