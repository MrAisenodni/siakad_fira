@extends('layouts.main')

@section('title', $menu->title)

@section('styles')
    {{-- Prism --}}
    <link href="{{ asset('/extra-libs/prism/prism.css') }}" rel="stylesheet">
    
    {{-- Select2 --}}
    <link href="{{ asset('/libs/select2/dist/css/select2.css') }}" rel="stylesheet">
    
    {{-- Datepicker --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('/libs/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">

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
                        <h5 class="card-title">Detail {{ $menu->title }}</h5>
                        @if (session('status'))
                            <div class="success-alert-bar p-15 m-t-10 m-b-10 green white-text" style="display: block">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="success-alert-bar p-15 m-t-10 m-b-10 red white-text" style="display: block">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ str_replace("/edit", "", url()->current()) }}">
                            @method('put')
                            @csrf
                            <div class="row">
                                <div class="input-field col s6">
                                    <select id="lesson" name="lesson" class="">
                                        <option value="" selected>--- SILAHKAN PILIH ---</option>
                                        @if ($lessons)
                                            @foreach ($lessons as $lesson)
                                                <option @if(old('lesson', $exam->lesson_id) == $lesson->id) selected @endif value="{{ $lesson->id }}">{{ $lesson->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="lesson">Mata Pelajaran <span class="materialize-red-text">*</span></label>
                                    @error('lesson')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s6">
                                    <select id="teacher" name="teacher" class="">
                                        <option value="" selected>--- SILAHKAN PILIH ---</option>
                                        @if ($teachers)
                                            @foreach ($teachers as $teacher)
                                                <option @if(old('teacher', $exam->teacher_id) == $teacher->id) selected @endif value="{{ $teacher->id }}">[{{ $teacher->nip }}] {{ $teacher->full_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="teacher">Guru Pengawas <span class="materialize-red-text">*</span></label>
                                    @error('teacher')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>          
                            </div>
                            <div class="row">  
                                <div class="input-field col s4">
                                    <select id="clazz" name="clazz" class="">
                                        <option value="" selected>--- SILAHKAN PILIH ---</option>
                                        @if ($classes)
                                            @foreach ($classes as $clazz)
                                                <option @if(old('clazz', $exam->class_id) == $clazz->id) selected @endif value="{{ $clazz->id }}">{{ $clazz->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="clazz">Kelas <span class="materialize-red-text">*</span></label>
                                    @error('clazz')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>             
                                <div class="input-field col s4">
                                    <label for="date">Tanggal Ujian <span class="materialize-red-text">*</span></label>
                                        <input id="date" type="text" name="date" placeholder="dd/MM/yyyy" class="datepicker" value="{{ old('date', date('d/m/Y', strtotime($exam->date))) }}">
                                    @error('date')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s2">
                                    <label for="clock_in">Masuk <span class="materialize-red-text">*</span></label>
                                    <input id="clock_in" type="text" name="clock_in" placeholder="07:00" class="timepicker" value="{{ old('clock_in', date('H:i', strtotime($exam->clock_in))) }}">
                                    @error('clock_in')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s2">
                                    <label for="clock_out">Keluar <span class="materialize-red-text">*</span></label>
                                    <input id="clock_out" type="text" name="clock_out" placeholder="09:00" class="timepicker" value="{{ old('clock_out', date('H:i', strtotime($exam->clock_out))) }}">
                                    @error('clock_out')
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
                            <div class="col s12">
                                <h5 class="card-title">Daftar Siswa</h5>
                            </div>
                        </div>
                        <div class="row">
                            <form action="{{ $menu->url }}/student" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $exam->id }}">
                                <div class="input-field col s10">
                                    <select id="student" name="student" class="">
                                        <option value="" selected>--- SILAHKAN PILIH ---</option>
                                        @if ($students)
                                            @foreach ($students as $student)
                                                <option @if(old('student') == $student->id) selected @endif value="{{ $student->id }}">[{{ $student->nis }}] {{ $student->full_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="student">Siswa</label>
                                    @error('student')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col s2 right-align">
                                    <button class="waves-effect waves-light btn btn-round green strong" type="submit">TAMBAH</button>
                                </div>
                            </form>
                        </div>
                        <table id="noedit_config" class="responsive-table display" style="width:100%" onload="message()">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($exam->exam_detail)
                                    @foreach ($exam->exam_detail as $exam)
                                        <tr id="data" data-id="{{ $exam->id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $exam->student->nis }}</td>
                                            <td>{{ $exam->student->full_name }}</td>
                                            <td>{{ $exam->student->class->class->name }}</td>
                                            <td id="no-data" class="text-center" style="width: 5%">
                                                <form action="{{ $menu->url }}/student/{{ $exam->id }}" method="POST" class="d-inline">
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
    {{-- Prism --}}
    <script src="{{ asset('/extra-libs/prism/prism.js') }}"></script>
    
    {{-- Select2 --}}
    <script src="{{ asset('/libs/select2/dist/js/select2.min.js') }}"></script>

    {{-- Datepicker --}}
    <script src="{{ asset('/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('/libs/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker-custom.js') }}"></script>

    {{-- Data Tables --}}
    <script src="{{ asset('/extra-libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/dist/js/pages/datatable/datatable-basic.init.js') }}"></script>
    
    {{-- Form --}}
    <script src="{{ asset('/dist/js/form.js') }}"></script>
    @include('scripts.datepicker')
    @include('scripts.select2')
@endsection