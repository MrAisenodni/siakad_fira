@extends('layouts.main')

@section('title', $menu->title)

@section('styles')
    {{-- Prism --}}
    <link href="{{ asset('/extra-libs/prism/prism.css') }}" rel="stylesheet">
    
    {{-- Select2 --}}
    <link href="{{ asset('/libs/select2/dist/css/select2.css') }}" rel="stylesheet">
    
    {{-- Datepicker --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('/libs/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">
@endsection

@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <h5 class="card-title">Ubah {{ $menu->title }}</h5>
                        @if (session('status'))
                            <div class="success-alert-bar p-15 m-t-10 m-b-10 red white-text" style="display: block">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ str_replace("/edit", "", url()->current()) }}">
                            @method('put')
                            @csrf
                            <div class="row">
                                <div class="input-field col s2">
                                    <select id="role" name="role" class="role_present">
                                        <option @error(old('role', $present->role) == 'student') selected @enderror value="student" selected>Siswa</option>
                                        <option @error(old('role', $present->role) == 'teacher') selected @enderror value="teacher">Guru</option>
                                    </select>
                                    <label for="role">Posisi</label>
                                    @error('role')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s4">
                                    <select id="lesson" name="lesson" class="">
                                        <option value="" selected>--- SILAHKAN PILIH ---</option>
                                        @if ($lessons)
                                            @foreach ($lessons as $lesson)
                                                <option @if(old('lesson', $present->lesson_id) == $lesson->id) selected @endif value="{{ $lesson->id }}">{{ $lesson->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="lesson">Mata Pelajaran <span class="materialize-red-text">*</span></label>
                                    @error('lesson')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s2">
                                    <select id="reason" name="reason" class="">
                                        <option value="" selected>--- PILIH ---</option>
                                        @if ($reasons)
                                            @foreach ($reasons as $reason)
                                                <option @if(old('reason', $present->reason_id) == $reason->id) selected @endif value="{{ $reason->id }}">{{ $reason->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="reason">Alasan Absen</label>
                                    @error('reason')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col s4">
                                    <label for="other_reason" class="m-t-20">Alasan Lain</label>
                                    <div class="input-fleid">
                                        <input id="other_reason" type="text" name="other_reason" placeholder="Acara keluarga" value="{{ old('other_reason', $present->reason) }}">
                                    </div>
                                    @error('other_reason')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col s2">
                                    <label for="clock_in" class="m-t-20">Masuk <span class="materialize-red-text">*</span></label>
                                    <div class="input-fleid">
                                        <input id="clock_in" type="text" name="clock_in" placeholder="13/01/2022 07:00" class="datetimepicker" value="{{ old('clock_in', date('d/m/Y H:i', strtotime($present->clock_in))) }}">
                                    </div>
                                    @error('clock_in')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col s2">
                                    <label for="clock_out" class="m-t-20">Keluar <span class="materialize-red-text">*</span></label>
                                    <div class="input-fleid">
                                        <input id="clock_out" type="text" name="clock_out" placeholder="13/01/2022 14:30" class="datetimepicker" value="{{ old('clock_out', date('d/m/Y H:i', strtotime($present->clock_out))) }}">
                                    </div>
                                    @error('clock_out')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s4">
                                    <select id="student" name="student" class="">
                                        <option value="" selected>--- SILAHKAN PILIH ---</option>
                                        @if ($students)
                                            @foreach ($students as $student)
                                                <option 
                                                @if ($present->role == 'student')
                                                    @if(old('student', $present->user_id) == $student->id) selected @endif                                                     
                                                @endif
                                                value="{{ $student->id }}">[{{ $student->nis }}] {{ $student->full_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="student">Siswa <span class="materialize-red-text">*</span></label>
                                    @error('student')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s4">
                                    <select id="teacher" name="teacher" class="" disabled>
                                        <option value="" selected>--- SILAHKAN PILIH ---</option>
                                        @if ($teachers)
                                            @foreach ($teachers as $teacher)
                                                <option  
                                                @if ($present->role == 'teacher')
                                                    @if(old('teacher', $present->user_id) == $teacher->id) selected @endif                                                     
                                                @endif 
                                                value="{{ $teacher->id }}">[{{ $teacher->nip }}] {{ $teacher->full_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="teacher">Guru <span class="materialize-red-text">*</span></label>
                                    @error('teacher')
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

    {{-- Datepicker --}}
    <script src="{{ asset('/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('/libs/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker-custom.js') }}"></script>
    
    {{-- Form --}}
    <script src="{{ asset('/dist/js/form.js') }}"></script>
    @include('scripts.datepicker')
    @include('scripts.select2')
@endsection