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
                        @if (session('status'))
                            <div class="success-alert-bar p-15 m-t-10 m-b-10 red white-text" style="display: block">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ str_replace("/edit", "", url()->current()) }}">
                            @method('put')
                            @csrf
                            {{-- Personal --}}
                            <div class="row">
                                <div class="input-field col s4">
                                    <input id="nip" type="text" placeholder="NIP" name="nip" value="{{ old('nip', $teacher->nip) }}">
                                    <label for="nip">NIP <span class="materialize-red-text">*</span></label>
                                    @error('nip')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s8">
                                    <input id="full_name" type="text" placeholder="Nama Lengkap" name="full_name" value="{{ old('full_name', $teacher->full_name) }}">
                                    <label for="full_name">Nama Lengkap <span class="materialize-red-text">*</span></label>
                                    @error('full_name')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s3">
                                    <input id="birth_date" class="datepicker" type="text" placeholder="dd/mm/yyyy" name="birth_date" value="{{ old('birth_date', date('d/m/Y', strtotime($teacher->birth_date))) }}">
                                    <label for="birth_date">Tanggal Lahir <span class="materialize-red-text">*</span></label>
                                    @error('birth_date')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s5">
                                    <input id="birth_place" type="text" placeholder="Tempat Lahir" name="birth_place" value="{{ old('birth_place', $teacher->birth_place) }}">
                                    <label for="birth_place">Tempat Lahir <span class="materialize-red-text">*</span></label>
                                    @error('birth_place')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s4">
                                    <p>
                                        <label for="gender">
                                            Jenis Kelamin <span class="materialize-red-text">*</span>
                                        </label>
                                        <label>
                                            <input id="gender" name="gender" type="radio" @if(old('gender', $teacher->gender) == 'l') checked @endif value="l" checked />
                                            <span>Laki-Laki</span>
                                        </label>
                                        <label>
                                            <input id="gender" name="gender" type="radio" @if(old('gender', $teacher->gender) == 'p') checked @endif value="p" />
                                            <span>Perempuan</span>
                                        </label>
                                    </p>
                                    <label for="gender"></label>
                                    @error('gender')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s4">
                                    <input id="phone_number" type="text" placeholder="6285889784451" name="phone_number" value="{{ old('phone_number', $teacher->phone_number) }}">
                                    <label for="phone_number">No HP <span class="materialize-red-text">*</span></label>
                                    @error('phone_number')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s4">
                                    <input id="email" type="email" placeholder="testing@test.com" name="email" value="{{ old('email', $teacher->email) }}">
                                    <label for="email">Email <span class="materialize-red-text">*</span></label>
                                    @error('email')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s4">
                                    <select id="religion" name="religion" class="">
                                        <option value="" selected>--- SILAHKAN PILIH ---</option>
                                        @if ($religions)
                                            @foreach ($religions as $religion)
                                                <option @if(old('religion', $teacher->religion_id) == $religion->id) selected @endif value="{{ $religion->id }}">{{ $religion->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="religion">Agama <span class="materialize-red-text">*</span></label>
                                    @error('religion')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s4">
                                    <input id="last_study" type="text" placeholder="S1 Ilmu Komunikasi" name="last_study" value="{{ old('last_study', $teacher->last_study) }}">
                                    <label for="last_study">Pendidikan Terakhir <span class="materialize-red-text">*</span></label>
                                    @error('last_study')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s4">
                                    <p>
                                        <label for="role">
                                            Peran <span class="materialize-red-text">*</span>
                                        </label>
                                        <label>
                                            <input id="role" name="role" type="radio" @if(old('role', $teacher->role) == 'teacher') checked @endif value="teacher" checked />
                                            <span>Guru</span>
                                        </label>
                                        <label>
                                            <input id="role" name="role" type="radio" @if(old('role', $teacher->role) == 'head') checked @endif value="head" />
                                            <span>Kepala Sekolah</span>
                                        </label>
                                    </p>
                                    <label for="role"></label>
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
@endsection