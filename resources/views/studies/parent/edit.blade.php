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
                        <h5 class="card-title">Ubah {{ $menu->title }} ({{ $status }})</h5>
                        @if (session('status'))
                            <div class="success-alert-bar p-15 m-t-10 m-b-10 red white-text" style="display: block">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ str_replace("/edit", "", url()->current()) }}">
                            @method('put')
                            @csrf
                            <div class="row">
                                <div class="input-field col s6">
                                    <input id="full_name" type="text" placeholder="Nama {{ $status }}" name="full_name" value="{{ old('full_name', $parent->full_name) }}">
                                    <label for="full_name">Nama {{ $status }} <span class="materialize-red-text">*</span></label>
                                    @error('full_name')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s4">
                                    <input id="birth_place" type="text" placeholder="Tempat Lahir" name="birth_place" value="{{ old('birth_place', $parent->birth_place) }}">
                                    <label for="birth_place">Tempat Lahir <span class="materialize-red-text">*</span></label>
                                    @error('birth_place')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s2">
                                    <input id="birth_date" class="datepicker" type="text" placeholder="dd/mm/yyyy" name="birth_date" value="{{ old('birth_date', date('d/m/Y', strtotime($parent->birth_date))) }}">
                                    <label for="birth_date">Tanggal Lahir <span class="materialize-red-text">*</span></label>
                                    @error('birth_date')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Kontak {{ $status }} --}}
                            <div class="row">
                                <div class="input-field col s12">
                                    <textarea placeholder="Alamat" id="address" class="materialize-textarea" name="address">{{ old('address', $parent->address) }}</textarea>
                                    <label for="address">Alamat <span class="materialize-red-text">*</span></label>
                                    @error('address')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s4">
                                    <p>
                                        <input type="hidden" name="status" value="{{ $status }}">
                                        <label for="gender">
                                            Jenis Kelamin <span class="materialize-red-text">*</span>
                                        </label>
                                        <label>
                                            <input id="gender" @if(old('gender', $parent->gender) == 'l') checked @endif name="gender" type="radio" value="l" />
                                            <span>Laki-Laki</span>
                                        </label>
                                        <label>
                                            <input id="gender" @if(old('gender', $parent->gender) == 'p') checked @endif name="gender" type="radio" value="p" />
                                            <span>Perempuan</span>
                                        </label>
                                    </p>
                                    <label for="gender"></label>
                                    @error('gender')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s3">
                                    <input id="phone_number" type="text" placeholder="Nomor HP" name="phone_number" value="{{ old('phone_number', $parent->phone_number) }}">
                                    <label for="phone_number">Nomor HP <span class="materialize-red-text">*</span></label>
                                    @error('phone_number')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s2">
                                    <input id="home_number" type="text" placeholder="Nomor Telepon" name="home_number" value="{{ old('home_number', $parent->home_number) }}">
                                    <label for="home_number">Nomor Telepon</label>
                                    @error('home_number')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s3">
                                    <select id="citizen" name="citizen" class="">
                                        <option value="" selected>--- SILAHKAN PILIH ---</option>
                                        <option @if(old('citizen', $parent->citizen) == 'wni') selected @endif value="wni">Warga Negara Indonesia</option>
                                        <option @if(old('citizen', $parent->citizen) == 'wna') selected @endif value="wna">Warga Negara Asing</option>
                                    </select>
                                    <label for="citizen">Kewarganegaraan <span class="materialize-red-text">*</span></label>
                                    @error('citizen')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Pendidikan/Pekerjaan {{ $status }} --}}
                            <div class="row">
                                <div class="input-field col s4">
                                    <input id="last_study" type="text" placeholder="S1 Agrobisnis" name="last_study" value="{{ old('last_study', $parent->last_study) }}">
                                    <label for="last_study">Pendidikan Terakhir <span class="materialize-red-text">*</span></label>
                                    @error('last_study')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s4">
                                    <select id="occupation" name="occupation" class="">
                                        <option value="" selected>--- SILAHKAN PILIH ---</option>
                                        @if ($occupations)
                                            @foreach ($occupations as $occupation)
                                                <option @if(old('occupation', $parent->occupation_id) == $occupation->id) selected @endif value="{{ $occupation->id }}">{{ $occupation->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="occupation">Pekerjaan <span class="materialize-red-text">*</span></label>
                                    @error('occupation')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s3">
                                    <input id="revenue" type="text" placeholder="3.000.000" name="revenue" value="{{ old('revenue', $parent->revenue) }}" data-type="currency">
                                    <label for="revenue">Penghasilan <span class="materialize-red-text">*</span></label>
                                    @error('revenue')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s1">
                                    <select id="revenue_type" name="revenue_type" class="">
                                        <option @if(old('revenue_type', $parent->revenue_type) == 'day') selected @endif value="day">/Hari</option>
                                        <option @if(old('revenue_type', $parent->revenue_type) == 'month') selected @endif value="month" selected>/Bulan</option>
                                        <option @if(old('revenue_type', $parent->revenue_type) == 'year') selected @endif value="year">/Tahun</option>
                                    </select>
                                    @error('revenue_type')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12">
                                    <div class="switch">
                                        <label>
                                            Meninggal?
                                            <input type="checkbox" @if (old('died', $parent->died) == 1) checked @endif name="died" id="died" value="1">
                                            <span class="lever"></span>
                                        </label>
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
@endsection