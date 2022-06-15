@extends('layouts.main')

@section('title', $menu->title)

@section('styles')
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
                        <div class="row">
                            <div class="col s8">
                                <h5 class="card-title">Kelola {{ $menu->title }}</h5>
                            </div>
                            <div class="col s4 right-align">
                                <a class="waves-effect waves-light btn btn-round green strong" href="{{ $menu->url }}/clockin" @if ($checkin || $checkabs) disabled @endif>Clock In</a>
                                <a class="waves-effect waves-light btn btn-round warning strong" href="{{ $menu->url }}/clockout" @if ($checkout || $checkabs) disabled @endif>Clock Out</a>
                                <a class="waves-effect waves-light btn btn-round red strong" href="{{ $menu->url }}/create" @if ($checkin || $checkabs) disabled @endif>Absen</a>
                            </div>
                            @if (session('status'))
                                <div class="col s12">
                                    <div class="success-alert-bar p-15 m-t-10 green white-text" style="display: block">
                                        {{ session('status') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <table id="zero_config" class="responsive-table display" style="width:100%" onload="message()">
                            <thead>
                                <tr>
                                    <th>Mata Pelajaran</th>
                                    <th>Masuk</th>
                                    <th>Keluar</th>
                                    <th>Alasan Absen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($presents)
                                    @foreach ($presents as $present)
                                        <tr id="show" data-id="{{ $present->id }}">
                                            <td>{{ $present->lesson->name }}</td>
                                            <td>@if ($present->clock_in) {{ date('H:i', strtotime($present->clock_in)) }} @else - @endif</td>
                                            <td>@if ($present->clock_out) {{ date('H:i', strtotime($present->clock_out)) }} @else - @endif</td>
                                            <td @if ($present->reason_id) style="color: red" @endif>@if ($present->reason_id) [{{ $present->mst_reason->name }}] {{ $present->reason }} @else - @endif</td>
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
@endsection

@section('scripts')
    {{-- Data Tables --}}
    <script src="{{ asset('/extra-libs/Datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/dist/js/pages/datatable/datatable-basic.init.js') }}"></script>
@endsection