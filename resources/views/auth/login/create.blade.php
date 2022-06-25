@extends('layouts.main')

@section('title', $menu->title)

@section('styles')
    {{-- Prism --}}
    <link href="{{ asset('/extra-libs/prism/prism.css') }}" rel="stylesheet">

    {{-- Select2 --}}
    <link href="{{ asset('/libs/select2/dist/css/select2.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <h5 class="card-title">Tambah {{ $menu->title }}</h5>
                        <form method="POST" action="{{ str_replace("/create", "", $menu->url) }}">
                            @csrf
                            <div class="row">
                                <div class="input-field col s6">
                                    <select id="student_name" name="student_name" class="">
                                        <option value="" selected>--- SILAHKAN PILIH ---</option>
                                        @if ($students)
                                            @foreach ($students as $student)
                                                <option @if(old('student_name') == $student->id) selected @endif value="{{ $student->id }}">[{{ $student->nis }}] {{ $student->full_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="student_name">Nama Siswa</label>
                                    @error('student_name')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s6">
                                    <select id="teacher_name" name="teacher_name" class="" disabled>
                                        <option value="" selected>--- SILAHKAN PILIH ---</option>
                                        @if ($teachers)
                                            @foreach ($teachers as $teacher)
                                                <option @if(old('teacher_name') == $teacher->id) selected @endif value="{{ $teacher->id }}">[{{ $teacher->nip }}] {{ $teacher->full_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="teacher_name">Nama Guru</label>
                                    @error('teacher_name')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s5">
                                    <input id="username" type="text" placeholder="siswa_123" name="username" value="{{ old('username') }}">
                                    <label for="username">Nama Pengguna (Username) <span class="materialize-red-text">*</span></label>
                                    @error('username')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s5">
                                    <input id="password" type="password" placeholder="testng_123" name="password" value="{{ old('password') }}">
                                    <label for="password">Kata Sandi <span class="materialize-red-text">*</span></label>
                                    @error('password')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s2">
                                    <select id="role" name="role" class="">
                                        <option @if(old('role') == 'teacher') selected @endif value="teacher" selected>Guru</option>
                                        <option @if(old('role') == 'student') selected @endif value="student">Siswa</option>
                                        <option @if(old('role') == 'parent') selected @endif value="parent">Orang Tua</option>
                                    </select>
                                    <label for="role">Posisi</label>
                                    @error('role')
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
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Prism --}}
    <script src="{{ asset('/extra-libs/prism/prism.js') }}"></script>

    {{-- Select2 --}}
    <script src="{{ asset('/libs/select2/dist/js/select2.min.js') }}"></script>

    {{-- Form --}}
    <script src="{{ asset('/dist/js/form.js') }}"></script>
    @include('scripts.select2')
@endsection