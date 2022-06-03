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
                        <h5 class="card-title">Ubah {{ $menu->title }}</h5>
                        <form method="POST" action="{{ str_replace("/edit", "", url()->current()) }}">
                            @method('put')
                            @csrf
                            <div class="row">
                                <div class="input-field col s6">
                                    <select id="student_name" name="student_name" class="">
                                        <option value="">--- SILAHKAN PILIH ---</option>
                                        @if ($students)
                                            @foreach ($students as $student)
                                                <option @if ($login->role == 'student' || $login->role == 'parent') 
                                                    @if(old('student_name', $login->user_id) == $student->id) 
                                                        selected 
                                                    @endif 
                                                @endif value="{{ $student->id }}">[{{ $student->nis }}] {{ $student->full_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="student_name">Nama Siswa</label>
                                    @error('student_name')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s6">
                                    <select id="teacher_name" name="teacher_name" class="">
                                        <option value="">--- SILAHKAN PILIH ---</option>
                                        @if ($teachers)
                                            @foreach ($teachers as $teacher)
                                                <option @if ($login->role == 'teacher') 
                                                    @if(old('teacher_name', $login->user_id) == $teacher->id) 
                                                        selected 
                                                    @endif 
                                                @endif value="{{ $teacher->id }}">[{{ $teacher->nip }}] {{ $teacher->full_name }}</option>
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
                                    <input id="username" type="text" placeholder="siswa_123" name="username" value="{{ old('username', $login->username) }}">
                                    <label for="username">Nama Pengguna (Username) <span class="materialize-red-text">*</span></label>
                                    @error('username')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s5">
                                    <input id="password" type="password" placeholder="testng_123" name="password" value="{{ old('password') }}">
                                    <label for="password">Kata Sandi Baru <span class="materialize-red-text">*</span></label>
                                    @error('password')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s2">
                                    <select id="role" name="role" class="">
                                        <option @if(old('role', $login->role) == 'teacher') selected @endif value="teacher">Guru</option>
                                        <option @if(old('role', $login->role) == 'student') selected @endif value="student">Siswa</option>
                                        <option @if(old('role', $login->role) == 'parent') selected @endif value="parent">Orang Tua</option>
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
    <script src="{{ asset('/extra-libs/prism/prism.js') }}"></script>
    
    {{-- Select2 --}}
    <script src="{{ asset('/libs/select2/dist/js/select2.min.js') }}"></script>

    @include('scripts.select2')
@endsection