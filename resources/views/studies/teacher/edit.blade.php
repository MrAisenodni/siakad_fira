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
                        @if (session('error'))
                            <div class="success-alert-bar p-15 m-t-10 m-b-10 red white-text" style="display: block">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('status'))
                            <div class="success-alert-bar p-15 m-t-10 m-b-10 green white-text" style="display: block">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ str_replace("/edit", "", url()->current()) }}" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            {{-- Personal --}}
                            <div class="row">
                                <div class="col s4">
                                    <div class="row">
                                        <div class="col s12" style="text-align: center">
                                            <img class="img-preview img-fluid" alt="Foto Profil" style="max-width: 300px; max-height: 400px" 
                                                @if ($teacher->picture)
                                                    src="{{ asset($teacher->picture) }}"
                                                @else
                                                    src="{{ asset('/images/blank-profile.png') }}"
                                                @endif 
                                            >
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="file-field input-field col s12">
                                            <div class="btn">
                                                <span>Unggah Foto</span>
                                                <input type="hidden" name="old_photo" value="{{ $teacher->picture }}">
                                                <input type="file" name="photo" id="photo" value="{{ old('photo') }}">
                                            </div>
                                            <div class="file-path-wrapper">
                                                <input class="file-path validate" type="text">
                                            </div>
                                            @error('photo')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col s8">
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
                                            <label for="birth_date">Tanggal Lahir</label>
                                            @error('birth_date')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s5">
                                            <input id="birth_place" type="text" placeholder="Tempat Lahir" name="birth_place" value="{{ old('birth_place', $teacher->birth_place) }}">
                                            <label for="birth_place">Tempat Lahir</label>
                                            @error('birth_place')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col s4">
                                            <p>
                                                <label for="gender" class="input-field">
                                                    Jenis Kelamin<br>
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
                                        <div class="input-field col s6">
                                            <input id="phone_number" type="text" placeholder="6285889784451" name="phone_number" value="{{ old('phone_number', $teacher->phone_number) }}">
                                            <label for="phone_number">No HP</label>
                                            @error('phone_number')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s6">
                                            <input id="email" type="email" placeholder="testing@test.com" name="email" value="{{ old('email', $teacher->email) }}">
                                            <label for="email">Email</label>
                                            @error('email')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s6">
                                            <select id="religion" name="religion" class="disabled select2">
                                                <option value="" selected>--- SILAHKAN PILIH ---</option>
                                                @if ($religions)
                                                    @foreach ($religions as $religion)
                                                        <option @if(old('religion', $teacher->religion_id) == $religion->id) selected @endif value="{{ $religion->id }}">{{ $religion->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <label for="religion" class="active">Agama</label>
                                            @error('religion')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s6">
                                            <input id="last_study" type="text" placeholder="S1 Ilmu Komunikasi" name="last_study" value="{{ old('last_study', $teacher->last_study) }}">
                                            <label for="last_study">Pendidikan Terakhir</label>
                                            @error('last_study')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="address" type="text" placeholder="Alamat" name="address" value="{{ old('address', $teacher->address) }}">
                                            <label for="address">Alamat</label>
                                            @error('address')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="input-field col s3">
                                    <input id="field_study" type="text" placeholder="Bidang Studi" name="field_study" value="{{ old('field_study', $teacher->field_study) }}">
                                    <label for="field_study">Bidang Studi</label>
                                    @error('field_study')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s2">
                                    <input id="role_admin" type="text" placeholder="Peran Administrasi" name="role_admin" value="{{ old('role_admin', $teacher->role_admin) }}">
                                    <label for="role_admin">Peran Administrasi</label>
                                    @error('role_admin')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col s3">
                                    <div class="row">
                                        <div class="col s12">
                                            <label for="curriculum_assist">
                                                <input id="curriculum_assist" name="curriculum_assist" type="checkbox" @if(old('curriculum_assist', $teacher->curriculum_assist) == "1") checked @endif value="1" />
                                                <span>Wakil Kurikulum</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 10px">
                                        <div class="col s12">
                                            <label for="student_assist">
                                                <input id="student_assist" name="student_assist" type="checkbox" @if(old('student_assist', $teacher->student_assist) == "1") checked @endif value="1" />
                                                <span>Wakil Kesiswaan</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s4">
                                    <div class="row">
                                        <div class="col s12">
                                            <label for="facilities_assist">
                                                <input id="facilities_assist" name="facilities_assist" type="checkbox" @if(old('facilities_assist', $teacher->facilities_assist) == "1") checked @endif value="1" />
                                                <span>Wakil Sarana dan Prasarana</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 10px">
                                        <div class="col s12">
                                            <label for="emissary_assist">
                                                <input id="emissary_assist" name="emissary_assist" type="checkbox" @if(old('emissary_assist', $teacher->emissary_assist) == "1") checked @endif value="1" />
                                                <span>Wakil Caraka</span>
                                            </label>
                                        </div>
                                    </div>
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