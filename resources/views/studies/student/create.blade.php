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
                                <div class="input-field col s3">
                                    <input id="nik" type="text" placeholder="NIK" name="nik" value="{{ old('nik') }}">
                                    <label for="nik">NIK</label>
                                    @error('nik')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s2">
                                    <input id="nis" type="text" placeholder="NIS" name="nis" value="{{ old('nis') }}">
                                    <label for="nis">NIS</label>
                                    @error('nis')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s2">
                                    <input id="nisn" type="text" placeholder="NISN" name="nisn" value="{{ old('nisn') }}">
                                    <label for="nisn">NISN</label>
                                    @error('nisn')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s5">
                                    <input id="full_name" type="text" placeholder="Nama Lengkap" name="full_name" value="{{ old('full_name') }}">
                                    <label for="full_name">Nama Lengkap</label>
                                    @error('full_name')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s4">
                                    <input id="birth_date" class="datepicker" type="text" placeholder="dd/mm/yyyy" name="birth_date" value="{{ old('birth_date') }}">
                                    <label for="birth_date">Tanggal Lahir</label>
                                    @error('birth_date')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s8">
                                    <input id="birth_place" type="text" placeholder="Tempat Lahir" name="birth_place" value="{{ old('birth_place') }}">
                                    <label for="birth_place">Tempat Lahir</label>
                                    @error('birth_place')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s4">
                                    <p>
                                        <label for="gender">
                                            Jenis Kelamin
                                        </label>
                                        <label>
                                            <input id="gender" name="gender" type="radio" @if(old('gender')) checked @endif value="l" />
                                            <span>Laki-Laki</span>
                                        </label>
                                        <label>
                                            <input id="gender" name="gender" type="radio" @if(old('gender')) checked @endif value="p" />
                                            <span>Perempuan</span>
                                        </label>
                                    </p>
                                    <label for="gender"></label>
                                    @error('gender')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s8">
                                    <select id="religion" name="religion" class="">
                                        <option value="" disabled selected>--- SILAHKAN PILIH ---</option>
                                        @if ($religions)
                                            @foreach ($religions as $religion)
                                                <option @if(old('religion') == $religion->id) selected @endif value="{{ $religion->id }}">{{ $religion->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="religion">Agama</label>
                                    @error('religion')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s4">
                                    <select id="citizen" name="citizen" class="">
                                        <option value="" disabled selected>--- SILAHKAN PILIH ---</option>
                                        <option value="wni">Warga Negara Indonesia</option>
                                        <option value="wna">Warga Negara Asing</option>
                                    </select>
                                    <label for="citizen">Kewarganegaraan</label>
                                    @error('citizen')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s4">
                                    <select id="language" name="language" class="">
                                        <option value="" disabled selected>--- SILAHKAN PILIH ---</option>
                                        @if ($languages)
                                            @foreach ($languages as $language)
                                                <option @if(old('language') == $language->id) selected @endif value="{{ $language->id }}">{{ $language->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="language">Bahasa</label>
                                    @error('language')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s4">
                                    <select id="blood_type" name="blood_type" class="">
                                        <option value="" disabled selected>--- SILAHKAN PILIH ---</option>
                                        @if ($blood_types)
                                            @foreach ($blood_types as $blood_type)
                                                <option @if(old('blood_type') == $blood_type->id) selected @endif value="{{ $blood_type->id }}">{{ $blood_type->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="blood_type">Golongan Darah</label>
                                    @error('blood_type')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Family --}}
                            <div class="row">
                                <div class="input-field col s4">
                                    <select id="family" name="family" class="">
                                        <option value="" disabled selected>--- SILAHKAN PILIH ---</option>
                                        @if ($families)
                                            @foreach ($families as $family)
                                                <option @if(old('family') == $family->id) selected @endif value="{{ $family->id }}">{{ $family->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="family">Status Keluarga</label>
                                    @error('family')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s2">
                                    <input id="child_to" type="text" placeholder="1" name="child_to" value="{{ old('child_to') }}">
                                    <label for="child_to">Anak Ke</label>
                                    @error('child_to')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s2">
                                    <input id="child_count" type="text" placeholder="3" name="child_count" value="{{ old('child_count') }}">
                                    <label for="child_count">Dari</label>
                                    @error('child_count')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s2">
                                    <input id="stepbrother_count" type="text" placeholder="0" name="stepbrother_count" value="{{ old('stepbrother_count') }}">
                                    <label for="stepbrother_count">Saudara Tiri</label>
                                    @error('stepbrother_count')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s2">
                                    <input id="stepsibling_count" type="text" placeholder="0" name="stepsibling_count" value="{{ old('stepsibling_count') }}">
                                    <label for="stepsibling_count">Saudara Angkat</label>
                                    @error('stepsibling_count')
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