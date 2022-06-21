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
                        <div class="row" style="margin-bottom: 5px">
                            <div class="col s8">
                                <h5 class="card-title">{{ $menu->title }} Siswa</h5>
                            </div>
                            <div class="col s4 right-align">
                                {{-- <a class="waves-effect waves-light btn btn-round green strong" href="{{ $menu->url }}/create">Tambah</a> --}}
                            </div>
                            @if (session('status'))
                                <div class="col s12">
                                    <div class="success-alert-bar p-15 m-t-10 green white-text" style="display: block">
                                        {{ session('status') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <table id="zero_config" class="responsive-table display" style="width:100%" onload="message()">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kelas</th>
                                            <th>Tahun Pelajaran</th>
                                            <th>Jumlah Siswa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($classes)
                                            @foreach ($classes as $clazz)
                                                <tr id="show" data-id="{{ $clazz->id }}">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $clazz->class->name }}</td>
                                                    <td>{{ $clazz->study_year->name }}</td>
                                                    <td>{{ $clazz->student }}</td>
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
    {{-- Data Tables --}}
    <script src="{{ asset('/extra-libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/dist/js/pages/datatable/datatable-basic.init.js') }}"></script>
@endsection