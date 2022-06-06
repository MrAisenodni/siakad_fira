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
                        <h5 class="card-title">Detail {{ $menu->title }}</h5>
                        @if (session('status'))
                            <div class="success-alert-bar p-15 m-t-10 m-b-10 red white-text" style="display: block">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ str_replace("/edit", "", url()->current()) }}">
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
                                        <div class="input-field col s3">
                                            <input id="nik" type="text" name="nik" value="{{ $student->nik }}" disabled>
                                            <label for="nik">NIK</label>
                                        </div>
                                        <div class="input-field col s2">
                                            <input id="nis" type="text" name="nis" value="{{ $student->nis }}" disabled>
                                            <label for="nis">NIS</label>
                                        </div>
                                        <div class="input-field col s2">
                                            <input id="nisn" type="text" name="nisn" value="{{ $student->nisn }}" disabled>
                                            <label for="nisn">NISN</label>
                                            @error('nisn')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s5">
                                            <input id="full_name" type="text" name="full_name" value="{{ $student->full_name }}" disabled>
                                            <label for="full_name">Nama Lengkap</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="input-field col s3">
                                            <input id="birth_date" class="datepicker" type="text" name="birth_date" value="{{ date('d/m/Y', strtotime($student->birth_date)) }}" disabled>
                                            <label for="birth_date">Tanggal Lahir</label>
                                        </div>
                                        <div class="input-field col s5">
                                            <input id="birth_place" type="text" name="birth_place" value="{{ $student->birth_place }}" disabled>
                                            <label for="birth_place">Tempat Lahir</label>
                                        </div>
                                        <div class="input-field col s2">
                                            <input id="height" type="text" name="height" value="{{ $student->height }}" disabled>
                                            <label for="height">Tinggi Badan (cm)</label>
                                        </div>
                                        <div class="input-field col s2">
                                            <input id="weight" type="text" name="weight" value="{{ old('weight', $student->weight) }}" disabled>
                                            <label for="weight">Berat Badan (kg)</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="input-field col s4">
                                            <input id="gender" type="text" name="gender" value="@if($student->gender == 'l') Laki-Laki @else Perempuan @endif" disabled>
                                            <label for="gender">Jenis Kelamin</label>
                                        </div>
                                        <div class="input-field col s8">
                                            <input id="religion" type="text" name="religion" value="{{ $student->religion->name }}" disabled>
                                            <label for="religion">Agama</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="input-field col s4">
                                            <input id="citizen" type="text"  name="citizen" value="@if($student->citizen == 'wni') Warga Negara Indonesia @else Warga Negara Asing @endif" disabled>
                                            <label for="citizen">Kewarganegaraan</label>
                                        </div>
                                        <div class="input-field col s4">
                                            <input id="language" type="text" name="language" value="{{ $student->language->name }}" disabled>
                                            <label for="language">Bahasa</label>
                                        </div>
                                        <div class="input-field col s4">
                                            <input id="blood_type" type="text" name="blood_type" value="{{ $student->blood_type->name }}" disabled>
                                            <label for="blood_type">Golongan Darah</label>
                                        </div>
                                    </div>
                                </div>
                                <div id="family" class="col s12"><hr>
                                    {{-- Keluarga --}}
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <input id="family_status" type="text" name="family_status" value="{{ $student->family_status->name }}" disabled>
                                            <label for="family_status">Golongan Darah</label>
                                        </div>
                                        <div class="input-field col s2">
                                            <input id="child_to" type="text" name="child_to" value="{{ $student->child_to }}" disabled>
                                            <label for="child_to">Anak Ke</label>
                                        </div>
                                        <div class="input-field col s2">
                                            <input id="child_count" type="text" name="child_count" value="{{ $student->child_count }}" disabled>
                                            <label for="child_count">Dari</label>
                                        </div>
                                        <div class="input-field col s2">
                                            <input id="stepbrother_count" type="text" name="stepbrother_count" value="{{ $student->stepbrother_count }}" disabled>
                                            <label for="stepbrother_count">Saudara Tiri</label>
                                        </div>
                                        <div class="input-field col s2">
                                            <input id="stepsibling_count" type="text" name="stepsibling_count" value="{{ $student->stepsibling_count }}" disabled>
                                            <label for="stepsibling_count">Saudara Angkat</label>
                                        </div>
                                    </div>

                                    {{-- Ayah --}}
                                    <h6 class="card-title m-t-15">Identitas Ayah</h6><hr>
                                    <div class="row">
                                        <div class="input-field col s6">
                                            <input id="father_name" type="text" name="father_name" value="{{ $father->full_name }}" disabled>
                                            <label for="father_name">Nama Ayah</label>
                                        </div>
                                        <div class="input-field col s4">
                                            <input id="father_birth_place" type="text" name="father_birth_place" value="{{ $father->birth_place }}" disabled>
                                            <label for="father_birth_place">Tempat Lahir</label>
                                        </div>
                                        <div class="input-field col s2">
                                            <input id="father_birth_date" class="datepicker" type="text" name="father_birth_date" value="{{ date('d/m/Y', strtotime($father->birth_date)) }}" disabled>
                                            <label for="father_birth_date">Tanggal Lahir</label>
                                        </div>
                                    </div>

                                    {{-- Kontak Ayah --}}
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <textarea id="father_address" class="materialize-textarea" name="father_address" disabled>{{ $father->address }}</textarea>
                                            <label for="father_address">Alamat</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <input id="father_gender" type="text" name="father_gender" value="@if($father->gender == 'l') Laki-Laki @else Perempuan @endif" disabled>
                                            <label for="father_gender">Jenis Kelamin</label>
                                        </div>
                                        <div class="input-field col s3">
                                            <input id="father_phone_number" type="text" name="father_phone_number" value="{{ $father->phone_number }}" disabled>
                                            <label for="father_phone_number">Nomor HP</label>
                                        </div>
                                        <div class="input-field col s2">
                                            <input id="father_home_number" type="text" name="father_home_number" value="{{ $father->home_number }}" disabled>
                                            <label for="father_home_number">Nomor Telepon</label>
                                        </div>
                                        <div class="input-field col s3">
                                            <input id="father_citizen" type="text"  name="father_citizen" value="@if($father->citizen == 'wni') Warga Negara Indonesia @else Warga Negara Asing @endif" disabled>
                                            <label for="father_citizen">Kewarganegaraan</label>
                                        </div>
                                    </div>

                                    {{-- Pendidikan/Pekerjaan Ayah --}}
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <input id="father_last_study" type="text" name="father_last_study" value="{{ $father->last_study }}" disabled>
                                            <label for="father_last_study">Pendidikan Terakhir</label>
                                        </div>
                                        <div class="input-field col s4">
                                            <input id="father_occupation" type="text" name="father_occupation" value="{{ $father->occupation->name }}" disabled>
                                            <label for="father_occupation">Pekerjaan</label>
                                        </div>
                                        <div class="input-field col s3">
                                            <input id="father_revenue" type="text" name="father_revenue" value="Rp {{ number_format($father->revenue, 0, ',', '.') }}" disabled>
                                            <label for="father_revenue">Penghasilan</label>
                                        </div>
                                        <div class="input-field col s1">
                                            <input id="father_revenue_type" type="text"  name="father_revenue_type" value="@if($father->revenue_type == 'day') 
                                                Hari
                                            @elseif ($father->revenue_type == 'month') 
                                                Bulan
                                            @else 
                                                Tahun
                                            @endif" disabled>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12">
                                            <div class="switch">
                                                <label>
                                                    Meninggal?
                                                    <input type="checkbox" @if (old('father_died', $father->died) == 1) checked @endif name="father_died" id="father_died" value="1" disabled>
                                                    <span class="lever"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Ibu --}}
                                    <h6 class="card-title m-t-15">Identitas Ibu</h6><hr>
                                    <div class="row">
                                        <div class="input-field col s6">
                                            <input id="mother_name" type="text" name="mother_name" value="{{ $mother->full_name }}" disabled>
                                            <label for="mother_name">Nama Ibu</label>
                                        </div>
                                        <div class="input-field col s4">
                                            <input id="mother_birth_place" type="text" name="mother_birth_place" value="{{ $mother->birth_place }}" disabled>
                                            <label for="mother_birth_place">Tempat Lahir</label>
                                        </div>
                                        <div class="input-field col s2">
                                            <input id="mother_birth_date" class="datepicker" type="text" name="mother_birth_date" value="{{ date('d/m/Y', strtotime($mother->birth_date)) }}" disabled>
                                            <label for="mother_birth_date">Tanggal Lahir</label>
                                        </div>
                                    </div>

                                    {{-- Kontak Ibu --}}
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <textarea id="mother_address" class="materialize-textarea" name="mother_address" disabled>{{ $mother->address }}</textarea>
                                            <label for="mother_address">Alamat</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <input id="mother_gender" type="text" name="mother_gender" value="@if($mother->gender == 'l') Laki-Laki @else Perempuan @endif" disabled>
                                            <label for="mother_gender">Jenis Kelamin</label>
                                        </div>
                                        <div class="input-field col s3">
                                            <input id="mother_phone_number" type="text" name="mother_phone_number" value="{{ $mother->phone_number }}" disabled>
                                            <label for="mother_phone_number">Nomor HP</label>
                                        </div>
                                        <div class="input-field col s2">
                                            <input id="mother_home_number" type="text" name="mother_home_number" value="{{ $mother->home_number }}" disabled>
                                            <label for="mother_home_number">Nomor Telepon</label>
                                        </div>
                                        <div class="input-field col s3">
                                            <input id="mother_citizen" type="text"  name="mother_citizen" value="@if($mother->citizen == 'wni') Warga Negara Indonesia @else Warga Negara Asing @endif" disabled>
                                            <label for="mother_citizen">Kewarganegaraan</label>
                                        </div>
                                    </div>

                                    {{-- Pendidikan/Pekerjaan Ibu --}}
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <input id="mother_last_study" type="text" name="mother_last_study" value="{{ $mother->last_study }}" disabled>
                                            <label for="mother_last_study">Pendidikan Terakhir</label>
                                        </div>
                                        <div class="input-field col s4">
                                            <input id="mother_occupation" type="text" name="mother_occupation" value="{{ $mother->occupation->name }}" disabled>
                                            <label for="mother_occupation">Pekerjaan</label>
                                        </div>
                                        <div class="input-field col s3">
                                            <input id="mother_revenue" type="text" name="mother_revenue" value="Rp {{ number_format($mother->revenue, 0, ',', '.') }}" disabled>
                                            <label for="mother_revenue">Penghasilan</label>
                                        </div>
                                        <div class="input-field col s1">
                                            <input id="mother_revenue_type" type="text"  name="mother_revenue_type" value="@if($mother->revenue_type == 'day') 
                                                Hari
                                            @elseif ($mother->revenue_type == 'month') 
                                                Bulan
                                            @else 
                                                Tahun
                                            @endif" disabled>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12">
                                            <div class="switch">
                                                <label>
                                                    Meninggal?
                                                    <input type="checkbox" @if (old('mother_died', $mother->died) == 1) checked @endif name="mother_died" id="mother_died" value="1" disabled>
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
                                            <textarea id="address" class="materialize-textarea" name="address" disabled>{{ $student->address }}</textarea>
                                            <label for="address">Alamat</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s2">
                                            <input id="distance" type="text" name="distance" value="{{ $student->distance }}" disabled>
                                            <label for="distance">Jarak Tempuh (km)</label>
                                        </div>
                                        <div class="input-field col s5">
                                            <input id="phone_number" type="text" name="phone_number" value="{{ $student->phone_number }}" disabled>
                                            <label for="phone_number">Nomor HP</label>
                                        </div>
                                        <div class="input-field col s5">
                                            <input id="home_number" type="text" name="home_number" value="{{ $student->home_number }}" disabled>
                                            <label for="home_number">Nomor Telepon</label>
                                        </div>
                                    </div>
                                </div>
                                <div id="study" class="col s12"><hr>
                                    {{-- Studi/Pelajaran --}}
                                    <div class="row">
                                        <div class="input-field col s1">
                                            <input id="level" type="text" name="level" value="{{ $student->level }}" disabled>
                                            <label for="level">Tingkat</label>
                                        </div>
                                        <div class="input-field col s2">
                                            <input id="group" type="text" name="group" value="{{ $student->group }}" disabled>
                                            <label for="group">Kelompok</label>
                                        </div>
                                        <div class="input-field col s3">
                                            <input id="start_date" class="datepicker" type="text" name="start_date" value="{{ date('d/m/Y', strtotime($student->start_date)) }}" disabled>
                                            <label for="start_date">Tanggal Mulai</label>
                                        </div>
                                        <div class="input-field col s3">
                                            <input id="extracurricular" type="text" name="extracurricular" value="{{ $student->extracurricular->name }}" disabled>
                                            <label for="extracurricular">Ekstrakurikuler</label>
                                        </div>
                                        <div class="input-field col s3">
                                            <input id="study_year" type="text" name="study_year" value="{{ $student->study_year->name }}" disabled>
                                            <label for="study_year">Tahun Pelajaran</label>
                                        </div>
                                    </div>

                                    {{-- Pendidikan Terakhir --}}
                                    <div class="row">
                                        <div class="input-field col s2">
                                            <input id="sttb_no" type="text" name="sttb_no" value="{{ $student->sttb_no }}" disabled>
                                            <label for="sttb_no">No STTB</label>
                                        </div>
                                        <div class="input-field col s3">
                                            <input id="first_study" type="text" name="first_study" value="{{ $student->first_study }}" disabled>
                                            <label for="first_study">Pendidikan Pertama</label>
                                        </div>
                                        <div class="input-field col s3">
                                            <input id="major" type="text" name="major" value="{{ $student->major }}" disabled>
                                            <label for="major">Jurusan</label>
                                        </div>
                                        <div class="input-field col s2">
                                            <input id="from_study_date" class="datepicker" type="text" name="from_study_date" value="{{ date('d/m/Y', strtotime($student->from_study_date)) }}" disabled>
                                            <label for="from_study_date">Dari Tanggal</label>
                                        </div>
                                        <div class="input-field col s2">
                                            <input id="to_study_date" class="datepicker" type="text" name="to_study_date" value="{{ date('d/m/Y', strtotime($student->to_study_date)) }}" disabled>
                                            <label for="to_study_date">Sampai Tanggal</label>
                                        </div>
                                    </div>

                                    {{-- Pindah dari Sekolah Lain --}}
                                    <div class="row">
                                        <div class="input-field col s6">
                                            <input id="move_from" type="text" name="move_from" value="{{ $student->move_from }}" disabled>
                                            <label for="move_from">Pindah Dari</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <input id="move_reason" type="text" name="move_reason" value="{{ $student->move_reason }}" disabled>
                                            <label for="move_reason">Alasan Pindah</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col s12" style="text-align: right">
                                    <a class="waves-effect waves-light btn btn-round blue strong" href="{{ $menu->url }}">KEMBALI</a>
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