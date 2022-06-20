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
                        <h5 class="card-title">{{ $menu->title }} Siswa</h5>
                        <form method="GET" action="{{ url()->current() }}/cari">
                            @csrf
                            <input type="hidden" name="clazz_id" value="{{ $present->class_id }}">
                            <input type="hidden" name="study_year_id" value="{{ $present->study_year_id }}">
                            <div class="row">
                                <div class="input-field col s4">
                                    <select id="month" name="month" class="">
                                        <option value="" selected>--- SILAHKAN PILIH ---</option>
                                        @if ($months)
                                            @foreach ($months as $month)
                                                <option @if(old('month') == $month->id) selected @endif value="{{ $month->id }}">{{ $month->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="month">Bulan <span class="materialize-red-text">*</span></label>
                                    @error('month')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s4">
                                    <label for="clazz">Kelas</label>
                                    <input id="clazz" type="text" name="clazz" value="{{ $present->class->name }}" disabled>
                                </div>
                                <div class="input-field col s4">
                                    <label for="study_year">Tahun Pelajaran</label>
                                    <input id="study_year" type="text" name="study_year" value="{{ $present->study_year->name }}" disabled>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col s12" style="text-align: right">
                                    <a class="waves-effect waves-light btn btn-round blue strong" href="{{ $menu->url }}">KEMBALI</a>
                                    <button class="waves-effect waves-light btn btn-round green strong" type="submit">CARI</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @if ($month)
                    <div class="card">
                        <div class="card-content">
                            <div class="row">
                                <div class="col s12">
                                    <table id="zero_config" class="responsive-table display" style="width:100%" onload="message()">
                                        <thead>
                                            <tr>
                                                <th>Nama Siswa</th>
                                                <th>Hari</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td>Muhammad Fiqri Alfayed</td>
                                            <td>1</td>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
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