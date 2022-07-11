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
                            <input type="hidden" id="class_id" name="class_id" value="{{ $clazz->class_id }}">
                            <input type="hidden" id="study_year_id" name="study_year_id" value="{{ $clazz->study_year_id }}">
                            <input type="hidden" name="teacher_id" value="{{ $clazz->teacher_id }}">
                            <div class="row">
                                <div class="input-field col s4">
                                    <input id="clazz" type="text" name="clazz" value="{{ $clazz->class->name }}" disabled>
                                    <label for="clazz">Kelas</label>
                                </div>
                                <div class="input-field col s4">
                                    <input id="study_year" type="text" name="study_year" value="{{ $clazz->study_year->name }}" disabled>
                                    <label for="study_year">Tahun Pelajaran</label>
                                </div>
                                <div class="input-field col s4">
                                    <input id="teacher_head" type="text" name="teacher_head" value="{{ $clazz->teacher->full_name }}" disabled>
                                    <label for="teacher_head">Wali Kelas</label>
                                </div>
                            </div>

                            {{-- <div class="row">
                                <div class="input-field col s6">
                                    <select id="lesson" name="lesson" class="auto_fill_teacher">
                                        <option selected value="">=== SILAHKAN PILIH ===</option>
                                        @if ($lessons)
                                            @foreach ($lessons as $lesson)
                                                <option @if(old('lesson') == $lesson->id) selected @endif value="{{ $lesson->id }}">{{ $lesson->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="lesson">Mata Pelajaran</label>
                                    @error('lesson')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s6">
                                    <input id="teacher" type="text" placeholder="Guru" name="teacher" disabled>
                                    <label for="teacher">Guru</label>
                                </div>
                            </div> --}}

                            <hr>
                            <div class="row">
                                <div class="col s12" style="text-align: right">
                                    <a class="waves-effect waves-light btn btn-round blue strong" href="{{ $menu->url }}">KEMBALI</a>
                                    <button class="waves-effect waves-light btn btn-round green strong" type="submit">CARI</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Daftar Mata Pelajaran --}}
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s8">
                                <h5 class="card-title">Daftar Mata Pelajaran</h5>
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
                        <div class="row">
                            <div class="col s12">
                                <table id="payment_config" class="responsive-table display" style="width:100%" onload="message()">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Guru</th>
                                            <th>KKM</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($lessons)
                                            @foreach ($lessons as $lesson)
                                                <tr id="data" data-id="{{ $lesson->id }}">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $lesson->name }}</td>
                                                    <td>{{ $lesson->full_name }}</td>
                                                    <td>{{ $lesson->kkm }}</td>
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