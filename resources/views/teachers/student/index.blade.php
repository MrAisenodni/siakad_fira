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
                            <div class="col s10">
                                <h5 class="card-title">Daftar {{ $menu->title }}</h5>
                            </div>
                        </div>
                        <table id="zero_config" class="responsive-table display" style="width:100%" onload="message()">
                            <thead>
                                <tr>
                                    <th>NIS</th>
                                    <th>NISN</th>
                                    <th>Nama</th>
                                    <th>No HP/Telepon</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($students)
                                    @foreach ($students as $student)
                                        <tr id="data" data-id="{{ $student->id }}">
                                            <td>{{ $student->nis }}</td>
                                            <td>{{ $student->nisn }}</td>
                                            <td>{{ $student->full_name }}</td>
                                            <td>{{ $student->phone_number }}@if($student->home_number != 0) /{{ $student->home_number }} @endif</td>
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