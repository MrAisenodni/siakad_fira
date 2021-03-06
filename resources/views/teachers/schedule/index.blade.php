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
                        <div class="row">
                            <div class="col s10">
                                <h5 class="card-title">{{ $menu->title }}</h5>
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
                                    <th>Jadwal</th>
                                    <th>Waktu</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Kelas</th>
                                    <th>Guru</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($schedules)
                                    @foreach ($schedules as $schedule)
                                        <tr id="show" data-id="{{ $schedule->id }}">
                                            <td>
                                                @if ($schedule->day == '1') Senin @endif
                                                @if ($schedule->day == '2') Selasa @endif
                                                @if ($schedule->day == '3') Rabu @endif
                                                @if ($schedule->day == '4') Kamis @endif
                                                @if ($schedule->day == '5') Jumat @endif
                                                @if ($schedule->day == '6') Sabtu @endif
                                                @if ($schedule->day == '7') Minggu @endif
                                            </td>
                                            <td>({{ date('H:i', strtotime($schedule->clock_in)) }} - {{ date('H:i', strtotime($schedule->clock_out)) }})</td>
                                            <td>{{ $schedule->lesson->lesson->name }}</td>
                                            <td>{{ $schedule->lesson->class->name }}</td>
                                            <td>{{ $schedule->lesson->teacher->full_name }}</td>
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