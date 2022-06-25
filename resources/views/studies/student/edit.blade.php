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
                        <form method="POST" action="{{ str_replace("/edit", "", url()->current()) }}" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="row">
                                <div class="col s12">
                                    <ul class="tabs">
                                        <li class="tab col s3"><a class="active" href="#personal">Personal</a></li>
                                        <li class="tab col s3"><a href="#contact">Kontak</a></li>
                                        <li class="tab col s3"><a href="#family">Keluarga</a></li>
                                        <li class="tab col s3"><a href="#study">Pendidikan</a></li>
                                    </ul>
                                </div>
                                <div id="personal" class="col s12"><hr>
                                    {{-- Personal --}}
                                    <div class="row">
                                        <input type="hidden" name="old_photo" value="{{ $student->picture }}">
                                        <div class="col s4">
                                            <div class="row">
                                                <div class="col s12" style="text-align: center">
                                                    <img class="img-preview img-fluid" alt="Foto Profil" style="max-width: 300px; max-height: 400px" @if ($student->picture) src="{{ asset($student->picture) }}" @else src="/download/?file=/photos/blank-profile.jpeg" @endif>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="file-field input-field col s12">
                                                    <div class="btn">
                                                        <span>Unggah Foto</span>
                                                        <input type="file" name="photo" id="photo" value="{{ old('photo', $student->picture) }}">
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
                                                <div class="input-field col s6">
                                                    <input id="nik" type="text" placeholder="NIK" name="nik" value="{{ old('nik', $student->nik) }}">
                                                    <label for="nik">NIK <span class="materialize-red-text">*</span></label>
                                                    @error('nik')
                                                        <div class="error">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="input-field col s6">
                                                    <input id="nisn" type="text" placeholder="NISN" name="nisn" value="{{ old('nisn', $student->nisn) }}">
                                                    <label for="nisn">NISN <span class="materialize-red-text">*</span></label>
                                                    @error('nisn')
                                                        <div class="error">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-field col s3">
                                                    <input id="nis" type="text" placeholder="NIS" name="nis" value="{{ old('nis', $student->nis) }}">
                                                    <label for="nis">NIS <span class="materialize-red-text">*</span></label>
                                                    @error('nis')
                                                        <div class="error">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="input-field col s9">
                                                    <input id="full_name" type="text" placeholder="Nama Lengkap" name="full_name" value="{{ old('full_name', $student->full_name) }}">
                                                    <label for="full_name">Nama Lengkap <span class="materialize-red-text">*</span></label>
                                                    @error('full_name')
                                                        <div class="error">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-field col s4">
                                                    <input id="birth_date" class="datepicker" type="text" placeholder="dd/mm/yyyy" name="birth_date" value="{{ old('birth_date', date('d/m/Y', strtotime($student->birth_date))) }}">
                                                    <label for="birth_date">Tanggal Lahir <span class="materialize-red-text">*</span></label>
                                                    @error('birth_date')
                                                        <div class="error">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="input-field col s8">
                                                    <input id="birth_place" type="text" placeholder="Tempat Lahir" name="birth_place" value="{{ old('birth_place', $student->birth_place) }}">
                                                    <label for="birth_place">Tempat Lahir <span class="materialize-red-text">*</span></label>
                                                    @error('birth_place')
                                                        <div class="error">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-field col s3">
                                                    <input id="height" type="text" placeholder="143" name="height" value="{{ old('height', $student->height) }}">
                                                    <label for="height">Tinggi Badan (cm) <span class="materialize-red-text">*</span></label>
                                                    @error('height')
                                                        <div class="error">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="input-field col s3">
                                                    <input id="weight" type="text" placeholder="55" name="weight" value="{{ old('weight', $student->weight) }}">
                                                    <label for="weight">Berat Badan (kg) <span class="materialize-red-text">*</span></label>
                                                    @error('weight')
                                                        <div class="error">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="input-field col s6">
                                                    <p>
                                                        <label for="gender">
                                                            Jenis Kelamin <span class="materialize-red-text">*</span>
                                                        </label><br>
                                                        <label>
                                                            <input id="gender" name="gender" type="radio" @if(old('gender', $student->gender) == 'l') checked @endif value="l" checked />
                                                            <span>Laki-Laki</span>
                                                        </label>
                                                        <label>
                                                            <input id="gender" name="gender" type="radio" @if(old('gender', $student->gender) == 'p') checked @endif value="p" />
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
                                                    <select id="religion" name="religion" class="">
                                                        <option value="" selected>--- SILAHKAN PILIH ---</option>
                                                        @if ($religions)
                                                            @foreach ($religions as $religion)
                                                                <option @if(old('religion', $student->religion_id) == $religion->id) selected @endif value="{{ $religion->id }}">{{ $religion->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <label for="religion">Agama <span class="materialize-red-text">*</span></label>
                                                    @error('religion')
                                                        <div class="error">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="input-field col s6">
                                                    <select id="citizen" name="citizen" class="">
                                                        <option value="" selected>--- SILAHKAN PILIH ---</option>
                                                        <option @if(old('citizen', $student->citizen) == 'wni') selected @endif value="wni">Warga Negara Indonesia</option>
                                                        <option @if(old('citizen', $student->citizen) == 'wna') selected @endif value="wna">Warga Negara Asing</option>
                                                    </select>
                                                    <label for="citizen">Kewarganegaraan <span class="materialize-red-text">*</span></label>
                                                    @error('citizen')
                                                        <div class="error">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-field col s6">
                                                    <select id="language" name="language" class="">
                                                        <option value="" selected>--- SILAHKAN PILIH ---</option>
                                                        @if ($languages)
                                                            @foreach ($languages as $language)
                                                                <option @if(old('language', $student->language_id) == $language->id) selected @endif value="{{ $language->id }}">{{ $language->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <label for="language">Bahasa <span class="materialize-red-text">*</span></label>
                                                    @error('language')
                                                        <div class="error">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="input-field col s6">
                                                    <select id="blood_type" name="blood_type" class="">
                                                        <option value="" selected>--- SILAHKAN PILIH ---</option>
                                                        @if ($blood_types)
                                                            @foreach ($blood_types as $blood_type)
                                                                <option @if(old('blood_type', $student->blood_type_id) == $blood_type->id) selected @endif value="{{ $blood_type->id }}">{{ $blood_type->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <label for="blood_type">Golongan Darah</label>
                                                    @error('blood_type')
                                                        <div class="error">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="family" class="col s12"><hr>
                                    {{-- Keluarga --}}
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <select id="family_status" name="family_status" class="">
                                                <option value="" selected>--- SILAHKAN PILIH ---</option>
                                                @if ($families)
                                                    @foreach ($families as $family)
                                                        <option @if(old('family_status', $student->family_status_id) == $family->id) selected @endif value="{{ $family->id }}">{{ $family->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <label for="family_status">Status Keluarga <span class="materialize-red-text">*</span></label>
                                            @error('family_status')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s2">
                                            <input id="child_to" type="text" placeholder="1" name="child_to" value="{{ old('child_to', $student->child_to) }}">
                                            <label for="child_to">Anak Ke <span class="materialize-red-text">*</span></label>
                                            @error('child_to')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s2">
                                            <input id="child_count" type="text" placeholder="3" name="child_count" value="{{ old('child_count', $student->child_count) }}">
                                            <label for="child_count">Dari <span class="materialize-red-text">*</span></label>
                                            @error('child_count')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s2">
                                            <input id="stepbrother_count" type="text" placeholder="0" name="stepbrother_count" value="@if ($student->stepbrother_count) {{ old('stepbrother_count', $student->stepbrother_count) }} @else {{ old('stepbrother_count', 0) }} @endif">
                                            <label for="stepbrother_count">Saudara Tiri</label>
                                            @error('stepbrother_count')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s2">
                                            <input id="stepsibling_count" type="text" placeholder="0" name="stepsibling_count" value="@if ($student->stepsibling_count) {{ old('stepsibling_count', $student->stepsibling_count) }} @else {{ old('stepsibling_count', 0) }} @endif">
                                            <label for="stepsibling_count">Saudara Angkat</label>
                                            @error('stepsibling_count')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Ayah --}}
                                    <h6 class="card-title m-t-15">Identitas Ayah</h6><hr>
                                    <div class="row">
                                        <div class="input-field col s6">
                                            <input id="father_name" type="text" placeholder="Nama Ayah" name="father_name" value="{{ old('father_name', $father->full_name) }}">
                                            <label for="father_name">Nama Ayah <span class="materialize-red-text">*</span></label>
                                            @error('father_name')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s4">
                                            <input id="father_birth_place" type="text" placeholder="Tempat Lahir" name="father_birth_place" value="{{ old('father_birth_place', $father->birth_place) }}">
                                            <label for="father_birth_place">Tempat Lahir <span class="materialize-red-text">*</span></label>
                                            @error('father_birth_place')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s2">
                                            <input id="father_birth_date" class="datepicker" type="text" placeholder="dd/mm/yyyy" name="father_birth_date" value="{{ old('father_birth_date', date('d/m/Y', strtotime($father->birth_date))) }}">
                                            <label for="father_birth_date">Tanggal Lahir <span class="materialize-red-text">*</span></label>
                                            @error('father_birth_date')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Kontak Ayah --}}
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <textarea placeholder="Alamat" id="father_address" class="materialize-textarea" name="father_address">{{ old('father_address', $father->address) }}</textarea>
                                            <label for="father_address">Alamat <span class="materialize-red-text">*</span></label>
                                            @error('father_address')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <p>
                                                <label for="father_gender">
                                                    Jenis Kelamin <span class="materialize-red-text">*</span>
                                                </label>
                                                <label>
                                                    <input id="father_gender" name="father_gender" type="radio" disabled value="l" checked />
                                                    <span>Laki-Laki</span>
                                                </label>
                                                <label>
                                                    <input id="father_gender" name="father_gender" type="radio" disabled value="p" />
                                                    <span>Perempuan</span>
                                                </label>
                                            </p>
                                            <label for="father_gender"></label>
                                            @error('father_gender')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s3">
                                            <input id="father_phone_number" type="text" placeholder="Nomor HP" name="father_phone_number" 
                                                @if ($father->phone_number) 
                                                    value="{{ old('father_phone_number', $father->phone_number) }}"
                                                @else value="{{ old('father_phone_number', 0) }}"
                                                @endif>
                                            <label for="father_phone_number">Nomor HP <span class="materialize-red-text">*</span></label>
                                            @error('father_phone_number')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s2">
                                            <input id="father_home_number" type="text" placeholder="Nomor Telepon" name="father_home_number"
                                            @if ($father->home_number) 
                                                value="{{ old('father_home_number', $father->home_number) }}"
                                            @else value="{{ old('father_home_number', 0) }}"
                                            @endif>
                                            <label for="father_home_number">Nomor Telepon</label>
                                            @error('father_home_number')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s3">
                                            <select id="father_citizen" name="father_citizen" class="">
                                                <option value="" selected>--- SILAHKAN PILIH ---</option>
                                                <option @if(old('father_citizen', $father->citizen) == 'wni') selected @endif value="wni">Warga Negara Indonesia</option>
                                                <option @if(old('father_citizen', $father->citizen) == 'wna') selected @endif value="wna">Warga Negara Asing</option>
                                            </select>
                                            <label for="father_citizen">Kewarganegaraan <span class="materialize-red-text">*</span></label>
                                            @error('father_citizen')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Pendidikan/Pekerjaan Ayah --}}
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <input id="father_last_study" type="text" placeholder="S1 Agrobisnis" name="father_last_study" value="{{ old('father_last_study', $father->last_study) }}">
                                            <label for="father_last_study">Pendidikan Terakhir <span class="materialize-red-text">*</span></label>
                                            @error('father_last_study')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s4">
                                            <select id="father_occupation" name="father_occupation" class="">
                                                <option value="" selected>--- SILAHKAN PILIH ---</option>
                                                @if ($occupations)
                                                    @foreach ($occupations as $occupation)
                                                        <option @if(old('father_occupation', $father->occupation_id) == $occupation->id) selected @endif value="{{ $occupation->id }}">{{ $occupation->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <label for="father_occupation">Pekerjaan <span class="materialize-red-text">*</span></label>
                                            @error('father_occupation')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s3">
                                            <input id="father_revenue" type="text" placeholder="3.000.000" name="father_revenue" value="Rp {{ old('father_revenue', number_format($father->revenue, 0, ',', '.')) }},00" data-type="currency">
                                            <label for="father_revenue">Penghasilan <span class="materialize-red-text">*</span></label>
                                            @error('father_revenue')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s1">
                                            <select id="father_revenue_type" name="father_revenue_type" class="">
                                                <option @if(old('revenue_type', $father->revenue_type) == 'day') selected @endif value="day">/Hari</option>
                                                <option @if(old('revenue_type', $father->revenue_type) == 'month') selected @endif value="month" selected>/Bulan</option>
                                                <option @if(old('revenue_type', $father->revenue_type) == 'year') selected @endif value="year">/Tahun</option>
                                            </select>
                                            @error('father_revenue_type')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12">
                                            <div class="switch">
                                                <label>
                                                    Meninggal?
                                                    <input type="checkbox" @if (old('father_died', $father->died) == 1) checked @endif name="father_died" id="father_died" value="1">
                                                    <span class="lever"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Ibu --}}
                                    <h6 class="card-title m-t-15">Identitas Ibu</h6><hr>
                                    <div class="row">
                                        <div class="input-field col s6">
                                            <input id="mother_name" type="text" placeholder="Nama Ibu" name="mother_name" value="{{ old('mother_name', $mother->full_name) }}">
                                            <label for="mother_name">Nama Ibu <span class="materialize-red-text">*</span></label>
                                            @error('mother_name')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s4">
                                            <input id="mother_birth_place" type="text" placeholder="Tempat Lahir" name="mother_birth_place" value="{{ old('mother_birth_place', $mother->birth_place) }}">
                                            <label for="mother_birth_place">Tempat Lahir <span class="materialize-red-text">*</span></label>
                                            @error('mother_birth_place')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s2">
                                            <input id="mother_birth_date" class="datepicker" type="text" placeholder="dd/mm/yyyy" name="mother_birth_date" value="{{ old('mother_birth_date', date('d/m/Y', strtotime($mother->birth_date))) }}">
                                            <label for="mother_birth_date">Tanggal Lahir <span class="materialize-red-text">*</span></label>
                                            @error('mother_birth_date')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Kontak Ibu --}}
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <textarea placeholder="Alamat" id="mother_address" class="materialize-textarea" name="mother_address">{{ old('mother_address', $mother->address) }}</textarea>
                                            <label for="mother_address">Alamat <span class="materialize-red-text">*</span></label>
                                            @error('mother_address')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <p>
                                                <label for="mother_gender">
                                                    Jenis Kelamin <span class="materialize-red-text">*</span>
                                                </label>
                                                <label>
                                                    <input id="mother_gender" name="mother_gender" type="radio" disabled value="l" />
                                                    <span>Laki-Laki</span>
                                                </label>
                                                <label>
                                                    <input id="mother_gender" name="mother_gender" type="radio" disabled value="p" checked />
                                                    <span>Perempuan</span>
                                                </label>
                                            </p>
                                            <label for="mother_gender"></label>
                                            @error('mother_gender')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s3">
                                            <input id="mother_phone_number" type="text" placeholder="Nomor HP" name="mother_phone_number" 
                                            @if ($mother->phone_number) 
                                                value="{{ old('mother_phone_number', $mother->phone_number) }}"
                                            @else value="{{ old('mother_phone_number', 0) }}"
                                            @endif>
                                            <label for="mother_phone_number">Nomor HP <span class="materialize-red-text">*</span></label>
                                            @error('mother_phone_number')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s2">
                                            <input id="mother_home_number" type="text" placeholder="Nomor Telepon" name="mother_home_number" 
                                            @if ($mother->home_number) 
                                                value="{{ old('mother_home_number', $mother->home_number) }}"
                                            @else value="{{ old('mother_home_number', 0) }}"
                                            @endif>
                                            <label for="mother_home_number">Nomor Telepon</label>
                                            @error('mother_home_number')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s3">
                                            <select id="mother_citizen" name="mother_citizen" class="">
                                                <option value="" selected>--- SILAHKAN PILIH ---</option>
                                                <option @if(old('mother_citizen', $mother->citizen) == 'wni') selected @endif value="wni">Warga Negara Indonesia</option>
                                                <option @if(old('mother_citizen', $mother->citizen) == 'wna') selected @endif value="wna">Warga Negara Asing</option>
                                            </select>
                                            <label for="mother_citizen">Kewarganegaraan <span class="materialize-red-text">*</span></label>
                                            @error('mother_citizen')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Pendidikan/Pekerjaan Ibu --}}
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <input id="mother_last_study" type="text" placeholder="S1 Agrobisnis" name="mother_last_study" value="{{ old('mother_last_study', $mother->last_study) }}">
                                            <label for="mother_last_study">Pendidikan Terakhir <span class="materialize-red-text">*</span></label>
                                            @error('mother_last_study')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s4">
                                            <select id="mother_occupation" name="mother_occupation" class="">
                                                <option value="" selected>--- SILAHKAN PILIH ---</option>
                                                @if ($occupations)
                                                    @foreach ($occupations as $occupation)
                                                        <option @if(old('mother_occupation', $mother->occupation_id) == $occupation->id) selected @endif value="{{ $occupation->id }}">{{ $occupation->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <label for="mother_occupation">Pekerjaan <span class="materialize-red-text">*</span></label>
                                            @error('mother_occupation')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s3">
                                            <input id="mother_revenue" type="text" placeholder="3.000.000" name="mother_revenue" value="Rp {{ old('mother_revenue', number_format($mother->revenue, 0, ',', '.')) }},00" data-type="currency">
                                            <label for="mother_revenue">Penghasilan <span class="materialize-red-text">*</span></label>
                                            @error('mother_revenue')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s1">
                                            <select id="mother_revenue_type" name="mother_revenue_type" class="">
                                                <option @if(old('revenue_type', $mother->revenue_type) == 'day') selected @endif value="day">/Hari</option>
                                                <option @if(old('revenue_type', $mother->revenue_type) == 'month') selected @endif value="month" selected>/Bulan</option>
                                                <option @if(old('revenue_type', $mother->revenue_type) == 'year') selected @endif value="year">/Tahun</option>
                                            </select>
                                            @error('mother_revenue_type')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12">
                                            <div class="switch">
                                                <label>
                                                    Meninggal?
                                                    <input type="checkbox" @if (old('mother_died', $mother->died) == 1) checked @endif name="mother_died" id="mother_died" value="1">
                                                    <span class="lever"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Wali --}}
                                    <div class="row m-t-15">
                                        <div class="col s10">
                                            <h6 class="card-title">Identitas Wali 
                                            </h6>
                                        </div>
                                        <div class="col s2 right-align">
                                            <div class="switch">
                                                <label>
                                                    <input type="checkbox" @if(old('guardian') == 1 || $guardian) checked @endif value="1" name="guardian" id="sw_guardian">
                                                    <span class="lever"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="input-field col s6">
                                            <input id="guardian" type="text" placeholder="Nama Wali" name="guardian_name" value="@if($guardian) {{ old('guardian_name', $guardian->full_name) }} @else {{ old('guardian_name') }} @endif" @if(old('guardian') != 1) disabled @endif>
                                            <label for="guardian_name">Nama Wali</label>
                                            @error('guardian_name')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s4">
                                            <input id="guardian" type="text" placeholder="Tempat Lahir" name="guardian_birth_place" value="@if($guardian) {{ old('guardian_birth_place', $guardian->birth_place) }} @else {{ old('guardian_birth_place') }} @endif"  @if(old('guardian') != 1) disabled @endif>
                                            <label for="guardian_birth_place">Tempat Lahir</label>
                                            @error('guardian_birth_place')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s2">
                                            <input id="guardian" class="datepicker" type="text" placeholder="dd/mm/yyyy" name="guardian_birth_date" value="@if($guardian) {{ old('guardian_birth_date', date('d/m/Y', strtotime($guardian->birth_date))) }} @else {{ old('guardian_birth_date', '01/01/1970') }} @endif"  @if(old('guardian') != 1) disabled @endif>
                                            <label for="guardian_birth_date">Tanggal Lahir</label>
                                            @error('guardian_birth_date')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Kontak Wali --}}
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <textarea placeholder="Alamat" id="guardian" class="materialize-textarea" name="guardian_address"  @if(old('guardian') != 1) disabled @endif>@if($guardian) {{ old('guardian_address', $guardian->address) }} @else {{ old('guardian_address') }} @endif</textarea>
                                            <label for="guardian_address">Alamat</label>
                                            @error('guardian_address')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <p>
                                                <label for="guardian_gender">
                                                    Jenis Kelamin <span class="materialize-red-text">*</span>
                                                </label>
                                                <label>
                                                    <input id="guardian" name="guardian_gender" type="radio" @if($guardian) @if(old('guardian_gender', $guardian->gender) == 'l') checked @endif @else @if(old('guardian_gender') == 'l') checked @endif @endif value="l"  @if(old('guardian') != 1) disabled @endif />
                                                    <span>Laki-Laki</span>
                                                </label>
                                                <label>
                                                    <input id="guardian" name="guardian_gender" type="radio" @if($guardian) @if(old('guardian_gender', $guardian->gender) == 'p') checked @endif @else @if(old('guardian_gender') == 'p') checked @endif @endif value="p" checked  @if(old('guardian') != 1) disabled @endif />
                                                    <span>Perempuan</span>
                                                </label>
                                            </p>
                                            <label for="guardian_gender"></label>
                                            @error('guardian_gender')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s3">
                                            <input id="guardian" type="text" placeholder="Nomor HP" name="guardian_phone_number"  
                                            @if ($guardian)
                                                @if ($guardian->phone_number) 
                                                    value="{{ old('guardian_phone_number', $guardian->phone_number) }}"
                                                @else value="{{ old('guardian_phone_number', 0) }}"
                                                @endif  
                                            @endif @if(old('guardian') != 1) disabled @endif>
                                            <label for="guardian_phone_number">Nomor HP <span class="materialize-red-text">*</span></label>
                                            @error('guardian_phone_number')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s2">
                                            <input id="guardian" type="text" placeholder="Nomor Telepon" name="guardian_home_number" value="@if($guardian) {{ old('guardian_home_number', $guardian->home_number) }} @else {{ old('guardian_home_number') }} @endif"  @if(old('guardian') != 1) disabled @endif>
                                            <label for="guardian_home_number">Nomor Telepon</label>
                                            @error('guardian_home_number')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s3">
                                            <select id="guardian" name="guardian_citizen" class="">
                                                <option value="" selected>--- SILAHKAN PILIH ---</option>
                                                <option @if($guardian) @if(old('guardian_citizen', $guardian->citizen) == 'wni') selected @endif @else @if(old('guardian_citizen') == 'wni') selected @endif @endif value="wni">Warga Negara Indonesia</option>
                                                <option @if($guardian) @if(old('guardian_citizen', $guardian->citizen) == 'wna') selected @endif @else @if(old('guardian_citizen') == 'wna') selected @endif @endif value="wna">Warga Negara Asing</option>
                                            </select>
                                            <label for="guardian_citizen">Kewarganegaraan</label>
                                            @error('guardian_citizen')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Pendidikan/Pekerjaan Wali --}}
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <input id="guardian" type="text" placeholder="S1 Agrobisnis" name="guardian_last_study" value="@if($guardian) {{ old('guardian_last_study', $guardian->last_study) }} @else {{ old('guardian_last_study') }} @endif"  @if(old('guardian') != 1) disabled @endif>
                                            <label for="guardian_last_study">Pendidikan Terakhir</label>
                                            @error('guardian_last_study')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s4">
                                            <select id="guardian" name="guardian_occupation" class="">
                                                <option value="" selected>--- SILAHKAN PILIH ---</option>
                                                @if ($occupations)
                                                    @foreach ($occupations as $occupation)
                                                        <option @if($guardian) @if(old('guardian_occupation', $guardian->occupation_id) == $occupation->id) selected @endif @else @if(old('guardian_occupation') == $occupation->id) checked @endif @endif value="{{ $occupation->id }}">{{ $occupation->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <label for="guardian_occupation">Pekerjaan</label>
                                            @error('guardian_occupation')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s3">
                                            <input id="guardian" type="text" placeholder="3.000.000" name="guardian_revenue" value="@if($guardian) Rp {{ old('guardian_revenue', number_format($guardian->revenue, 0, ',', '.')) }},00 @else {{ old('guardian_revenue') }} @endif"  @if(old('guardian') != 1) disabled @endif data-type="currency">
                                            <label for="guardian_revenue">Penghasilan</label>
                                            @error('guardian_revenue')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s1">
                                            <select id="guardian" name="guardian_revenue_type" class="">
                                                <option @if($guardian) @if(old('guardian_revenue_type', $guardian->revenue_type) == 'day') selected @endif @else @if(old('guardian_revenue_type') == 'day') selected @endif @endif value="day">/Hari</option>
                                                <option @if($guardian) @if(old('guardian_revenue_type', $guardian->revenue_type) == 'month') selected @endif @else @if(old('guardian_revenue_type') == 'month') selected @endif @endif value="month" selected>/Bulan</option>
                                                <option @if($guardian) @if(old('guardian_revenue_type', $guardian->revenue_type) == 'year') selected @endif @else @if(old('guardian_revenue_type') == 'year') selected @endif @endif value="year">/Tahun</option>
                                            </select>
                                            @error('guardian_revenue_type')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12">
                                            <div class="switch">
                                                <label>
                                                    Meninggal?
                                                    <input type="checkbox" @if($guardian) @if(old('guardian_died', $guardian->died) == 1) checked @endif @else @if(old('guardian_died') == 1) selected @endif @endif name="guardian_died" id="guardian"  @if(old('guardian') != 1) disabled @endif value="1">
                                                    <span class="lever"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="contact" class="col s12"><hr>
                                    {{-- Kontak --}}
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <textarea placeholder="Alamat" id="address" class="materialize-textarea" name="address">{{ old('address', $student->address) }}</textarea>
                                            <label for="address">Alamat <span class="materialize-red-text">*</span></label>
                                            @error('address')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s2">
                                            <input id="distance" type="text" placeholder="10" name="distance" value="{{ old('distance', round($student->distance)) }}">
                                            <label for="distance">Jarak Tempuh (km) <span class="materialize-red-text">*</span></label>
                                            @error('distance')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s5">
                                            <input id="phone_number" type="text" placeholder="Nomor HP" name="phone_number" value="{{ old('phone_number', $student->phone_number) }}">
                                            <label for="phone_number">Nomor HP <span class="materialize-red-text">*</span></label>
                                            @error('phone_number')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s5">
                                            <input id="home_number" type="text" placeholder="Nomor Telepon" name="home_number"  
                                            @if ($student->home_number) 
                                                value="{{ old('home_number', $student->home_number) }}"
                                            @else value="{{ old('home_number', 0) }}"
                                            @endif>
                                            <label for="home_number">Nomor Telepon</label>
                                            @error('home_number')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div id="study" class="col s12"><hr>
                                    {{-- Studi/Pelajaran --}}
                                    <div class="row">
                                        <div class="input-field col s1">
                                            <input id="level" type="text" placeholder="Tingkat" name="level" value="{{ old('level', $student->level) }}">
                                            <label for="level">Tingkat <span class="materialize-red-text">*</span></label>
                                            @error('level')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s2">
                                            <input id="group" type="text" placeholder="Kelompok" name="group" value="{{ old('group', $student->group) }}">
                                            <label for="group">Kelompok <span class="materialize-red-text">*</span></label>
                                            @error('group')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s3">
                                            <input id="start_date" class="datepicker" type="text" placeholder="dd/mm/yyyy" name="start_date" value="{{ old('start_date', date('d/m/Y', strtotime($student->start_date))) }}">
                                            <label for="start_date">Tanggal Mulai <span class="materialize-red-text">*</span></label>
                                            @error('start_date')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s3">
                                            <select id="extracurricular" name="extracurricular" class="">
                                                <option value="" selected>--- SILAHKAN PILIH ---</option>
                                                @if ($extracurriculars)
                                                    @foreach ($extracurriculars as $extracurricular)
                                                        <option @if(old('extracurricular', $student->extracurricular_id) == $extracurricular->id) selected @endif value="{{ $extracurricular->id }}">{{ $extracurricular->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <label for="extracurricular">Ekstrakurikuler</label>
                                            @error('extracurricular')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s3">
                                            <select id="study_year" name="study_year" class="">
                                                <option value="" selected>--- SILAHKAN PILIH ---</option>
                                                @if ($studies)
                                                    @foreach ($studies as $study)
                                                        <option @if(old('study_year', $student->study_year_id) == $study->id) selected @endif value="{{ $study->id }}">{{ $study->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <label for="study_year">Tahun Pelajaran <span class="materialize-red-text">*</span></label>
                                            @error('study_year')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Pendidikan Terakhir --}}
                                    <div class="row">
                                        <div class="input-field col s2">
                                            <input id="sttb_no" type="text" placeholder="No STTB" name="sttb_no" value="{{ old('sttb_no', $student->sttb_no) }}">
                                            <label for="sttb_no">No STTB <span class="materialize-red-text">*</span></label>
                                            @error('sttb_no')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s3">
                                            <input id="first_study" type="text" placeholder="Pendidikan Pertama" name="first_study" value="{{ old('first_study', $student->first_study) }}">
                                            <label for="first_study">Pendidikan Pertama <span class="materialize-red-text">*</span></label>
                                            @error('first_study')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s3">
                                            <input id="major" type="text" placeholder="Jurusan" name="major" value="{{ old('major', $student->major) }}">
                                            <label for="major">Jurusan</label>
                                            @error('major')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s2">
                                            <input id="from_study_date" class="datepicker" type="text" placeholder="dd/mm/yyyy" name="from_study_date" value="{{ old('from_study_date', date('d/m/Y', strtotime($student->from_study_date))) }}">
                                            <label for="from_study_date">Dari Tanggal <span class="materialize-red-text">*</span></label>
                                            @error('from_study_date')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s2">
                                            <input id="to_study_date" class="datepicker" type="text" placeholder="dd/mm/yyyy" name="to_study_date" value="{{ old('to_study_date', date('d/m/Y', strtotime($student->to_study_date))) }}">
                                            <label for="to_study_date">Sampai Tanggal <span class="materialize-red-text">*</span></label>
                                            @error('to_study_date')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Pindah dari Sekolah Lain --}}
                                    <div class="row">
                                        <div class="input-field col s6">
                                            <input id="move_from" type="text" placeholder="SMP Negeri 6 Bekasi" name="move_from" value="{{ old('move_from', $student->move_from) }}">
                                            <label for="move_from">Pindah Dari</label>
                                            @error('move_from')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s6">
                                            <input id="move_reason" type="text" placeholder="Orang tua pindah kerja" name="move_reason" value="{{ old('move_reason', $student->move_reason) }}">
                                            <label for="move_reason">Alasan Pindah</label>
                                            @error('move_reason')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
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