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
                                <h5 class="card-title">Kelola {{ $menu->title }}</h5>
                            </div>
                            <div class="col s2 right-align">
                                <a class="waves-effect waves-light btn btn-round green strong" href="{{ $menu->url }}/create">TAMBAH</a>
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
                                    <th>Nama Lengkap</th>
                                    <th>Username</th>
                                    <th>Posisi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($logins)
                                    @foreach ($logins as $login)
                                        <tr id="data" data-id="{{ $login->id }}">
                                            <td>
                                                @if ($login->role == 'teacher')
                                                    [{{ $login->teacher->nip }}] {{ $login->teacher->full_name }}
                                                @elseif ($login->role == 'admin')
                                                    Administrator
                                                @else
                                                    [{{ $login->student->nis }}] {{ $login->student->full_name }}
                                                @endif
                                            </td>
                                            <td>{{ $login->username }}</td>
                                            <td>
                                                @if ($login->role == 'teacher')
                                                    Guru
                                                @elseif ($login->role == 'student')
                                                    Siswa
                                                @elseif ($login->role == 'parent')
                                                    Orang Tua
                                                @else 
                                                    Administrator
                                                @endif
                                            </td>
                                            <td id="no-data" class="text-center" style="width: 5%">
                                                <form action="{{ $menu->url }}/{{ $login->id }}" method="POST" class="d-inline">
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
    <script src="{{ asset('/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/dist/js/pages/datatable/datatable-basic.init.js') }}"></script>
@endsection