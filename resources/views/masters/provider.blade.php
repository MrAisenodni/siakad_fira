@extends('layouts.main')

@section('title', $menu->title)

@section('styles')
    {{-- Prism --}}
    <link href="{{ asset('/extra-libs/prism/prism.css') }}" rel="stylesheet">
    
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
                        <h5 class="card-title">{{ $menu->title }}</h5>
                        @if (session('status'))
                            <div class="success-alert-bar p-15 m-t-10 m-b-10 green white-text" style="display: block">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ $menu->url }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $provider->id }}">
                            {{-- Section School --}}
                            <div class="row">
                                <div class="input-field col s3">
                                    <input id="company_no" type="text" placeholder="Nomor Induk" name="company_no" value="{{ old('company_no', $provider->company_no) }}">
                                    <label for="company_no">Nomor Induk Sekolah</label>
                                    @error('company_no')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s9">
                                    <input id="company_name" type="text" placeholder="Nama Sekolah" name="company_name" value="{{ old('company_name', $provider->company_name) }}">
                                    <label for="company_name">Nama Sekolah</label>
                                    @error('company_name')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s6">
                                    <input id="company_birth_date" class="datepicker" type="text" placeholder="dd/mm/yyyy" name="company_birth_date" value="{{ old('company_birth_date', date('d/m/Y', strtotime($provider->company_birth_date))) }}">
                                    <label for="company_birth_date">Tanggal Berdiri</label>
                                    @error('company_birth_date')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s6">
                                    <input id="company_phone_number" type="text" placeholder="Nomor Telepon" name="company_phone_number" value="{{ old('company_phone_number', $provider->company_phone_number) }}">
                                    <label for="company_phone_number">Nomor Telepon</label>
                                    @error('company_phone_number')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="company_address" type="text" placeholder="Alamat Sekolah" name="company_address" value="{{ old('company_address', $provider->company_address) }}">
                                    <label for="company_address">Alamat Sekolah</label>
                                    @error('company_address')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            {{-- Section Head --}}
                            <div class="row">
                                <div class="input-field col s3">
                                    <input id="owner_nip" type="text" placeholder="NIP" name="owner_nip" value="{{ old('owner_nip', $provider->owner_nip) }}">
                                    <label for="owner_nip">NIP</label>
                                    @error('owner_nip')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s9">
                                    <input id="owner_name" type="text" placeholder="Nama Kepala Sekolah" name="owner_name" value="{{ old('owner_name', $provider->owner_name) }}">
                                    <label for="owner_name">Nama Kepala Sekolah</label>
                                    @error('owner_name')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s4">
                                    <input id="owner_birth_place" type="text" placeholder="Tempat Lahir" name="owner_birth_place" value="{{ old('owner_birth_place', $provider->owner_birth_place) }}">
                                    <label for="owner_birth_place">Tempat Lahir</label>
                                    @error('owner_birth_place')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s4">
                                    <input id="owner_birth_date" class="datepicker" type="text" placeholder="dd/mm/yyyy" name="owner_birth_date" value="{{ old('owner_birth_date', date('d/m/Y', strtotime($provider->owner_birth_date))) }}">
                                    <label for="owner_birth_date">Tanggal Lahir</label>
                                    @error('owner_birth_date')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s4">
                                    <input id="owner_phone_number" type="text" placeholder="Nomor HP" name="owner_phone_number" value="{{ old('owner_phone_number', $provider->owner_phone_number) }}">
                                    <label for="owner_phone_number">Nomor HP</label>
                                    @error('owner_phone_number')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="owner_address" type="text" placeholder="Alamat" name="owner_address" value="{{ old('owner_address', $provider->owner_address) }}">
                                    <label for="owner_address">Alamat</label>
                                    @error('owner_address')
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
    
    {{-- Datepicker --}}
    <script src="{{ asset('/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('/libs/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker-custom.js') }}"></script>

    {{-- Form --}}
    <script src="{{ asset('/dist/js/form.js') }}"></script>
    @include('scripts.datepicker')
@endsection