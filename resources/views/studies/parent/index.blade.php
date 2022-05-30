@extends('layouts.main')

@section('title', $menu->title)

@section('styles')
    {{-- Data Tables --}}
    <link href="{{ asset('/dist/css/pages/data-table.css') }}" rel="stylesheet">

    {{-- Sweet Alert --}}
    <link href="{{ asset('/libs/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s12">
                                <h5 class="card-title">Kelola {{ $menu->title }}</h5>
                            </div>
                            {{-- <div class="col s2 right-align">
                                <a class="waves-effect waves-light btn btn-round green strong" href="{{ $menu->url }}/create">TAMBAH</a>
                            </div> --}}
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
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>Nama Orang Tua/Wali</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($parents)
                                    @foreach ($parents as $parent)
                                        <tr id="data" data-id="{{ $parent->id }}">
                                            <td>{{ $parent->student->nis }}</td>
                                            <td>{{ $parent->student->full_name }}</td>
                                            <td>{{ $parent->full_name }} @if($parent->died == 1) <p class="red-text">*meninggal</p> @endif</td>
                                            <td>
                                                @if ($parent->gender == 'l')
                                                    Laki-Laki
                                                @else
                                                    Perempuan
                                                @endif
                                            </td>
                                            <td>
                                                @if ($parent->gender == 'l' && $parent->parent == 1)
                                                    Ayah
                                                @elseif ($parent->gender == 'p' && $parent->parent == 1)
                                                    Ibu
                                                @else
                                                    Wali
                                                @endif
                                            </td>
                                            <td id="no-data" class="text-center" style="width: 5%">
                                                <form action="{{ $menu->url }}/{{ $parent->id }}" method="POST" class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" class="transparent fas fa-trash materialize-red-text" style="border: 0px"></button>
                                                </form>
                                            </td>
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

    {{-- Sweet Alert --}}
    <script src="{{ asset('/libs/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('/libs/sweetalert2/sweet-alert.init.js') }}"></script>
@endsection