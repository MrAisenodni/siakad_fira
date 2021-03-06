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
                        <h5 class="card-title">{{ $menu->title }}</h5>
                        @if (session('error'))
                            <div class="success-alert-bar p-15 m-t-10 m-b-10 red white-text" style="display: block">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ str_replace("/edit", "", url()->current()) }}">
                            @method('put')
                            @csrf
                            <input type="hidden" name="class_id" value="{{ $clazz->class_id }}">
                            <input type="hidden" name="study_year_id" value="{{ $clazz->study_year_id }}">
                            <input type="hidden" name="teacher_id" value="{{ $clazz->teacher_id }}">
                            <div class="row">
                                <div class="input-field col s6">
                                    <input id="clazz" type="text" placeholder="Kelas" name="clazz" value="{{ $clazz->class->name }}" disabled>
                                    <label for="clazz">Kelas</label>
                                </div>
                                <div class="input-field col s6">
                                    <input id="study_year" type="text" placeholder="Tahun Pelajaran" name="study_year" value="{{ $clazz->study_year->name }}" disabled>
                                    <label for="study_year">Tahun Pelajaran</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s6">
                                    <input id="teacher" type="text" placeholder="Wali Kelas" name="teacher" value="{{ $clazz->teacher->full_name }}" disabled>
                                    <label for="teacher">Wali Kelas</label>
                                </div>
                                <div class="input-field col s6">
                                    <select id="student" name="student" class="disabled select2">
                                        <option value="" selected>--- SILAHKAN PILIH ---</option>
                                        @if ($students)
                                            @foreach ($students as $student)
                                                <option @if(old('student') == $student->id) selected @endif value="{{ $student->id }}">[{{ $student->nis }}] {{ $student->full_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="student" class="active">Siswa <span class="materialize-red-text">*</span></label>
                                    @error('student')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

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

                {{-- Daftar Siswa --}}
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s8">
                                <h5 class="card-title">Daftar Siswa</h5>
                            </div>
                            <div class="col s4 right-align">
                                <a class="waves-effect waves-light btn btn-round primary strong" href="{{ $menu->url }}/{{ $clazz->id }}/cetak"><i class="material-icons">print</i></a>
                                {{-- <a class="waves-effect waves-light btn btn-round green strong" href="{{ $menu->url }}/create">TAMBAH</a> --}}
                            </div>
                            @if (session('status'))
                                <div class="col s12">
                                    <div class="success-alert-bar p-15 m-t-10 green white-text" style="display: block">
                                        {{ session('status') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <table id="noedit_config" class="responsive-table display" style="width:100%" onload="message()">
                            <thead>
                                <tr>
                                    <th>NIS</th>
                                    <th>Siswa</th>
                                    <th>Nomor HP</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($classes)
                                    @foreach ($classes as $clas)
                                        @if ($clas->student)
                                            <tr id="data" data-id="{{ $clas->id }}">
                                                <td>{{ $clas->student->nis }}</td>
                                                <td>{{ $clas->student->full_name }}</td>
                                                <td>{{ $clas->student->phone_number }}</td>
                                                <td id="no-data" class="text-center" style="width: 5%">
                                                    <form action="{{ $menu->url }}/{{ $clas->id }}" method="POST" class="d-inline">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="submit" class="transparent fas fa-trash materialize-red-text" style="border: 0px"></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endif
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