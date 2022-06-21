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
                        <div class="row" style="margin-bottom: 5px">
                            <div class="col s8">
                                <h5 class="card-title">{{ $menu->title }} Siswa</h5>
                            </div>
                            <div class="col s4 right-align">
                                {{-- <a class="waves-effect waves-light btn btn-round green strong" href="{{ $menu->url }}/create">Tambah</a> --}}
                            </div>
                            @if (session('status'))
                                <div class="col s12">
                                    <div class="success-alert-bar p-15 m-t-10 green white-text" style="display: block">
                                        {{ session('status') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <form action="{{ url()->current() }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="input-field col s4">
                                    <label for="clazz">Kelas</label>
                                    <input id="clazz" type="text" name="clazz" value="{{ $classes[0]->class->name }}" disabled>
                                </div>
                                <div class="input-field col s4">
                                    <label for="study_year">Tahun Pelajaran</label>
                                    <input id="study_year" type="text" name="study_year" value="{{ $classes[0]->study_year->name }}" disabled>
                                </div>
                                <div class="input-field col s4">
                                    <input id="study_date" class="datepicker" type="text" placeholder="dd/mm/yyyy" name="study_date" value="{{ old('study_date') }}" required>
                                    <label for="study_date">Tanggal</label>
                                    @error('study_date')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col s12" style="text-align: right">
                                    <button class="waves-effect waves-light btn btn-round green strong" type="submit">CARI</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s12">
                                <table id="zero_config" class="responsive-table display" style="width:100%" onload="message()">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Siswa</th>
                                            <th>Hadir</th>
                                            <th>Sakit</th>
                                            <th>Izin</th>
                                            <th>Absen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($classes)
                                            @foreach ($classes as $clazz)
                                                <tr id="show" data-id="{{ $clazz->id }}">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $clazz->student->full_name }}</td>
                                                    <td>
                                                        <label class="input-field">
                                                            <input class="with-gap" name="present{{ $loop->iteration }}" type="radio" value="present" />
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="input-field">
                                                            <input class="with-gap" name="present{{ $loop->iteration }}" type="radio" value="sick" />
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="input-field">
                                                            <input class="with-gap" name="present{{ $loop->iteration }}" type="radio" value="permit" />
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="input-field">
                                                            <input class="with-gap" name="present{{ $loop->iteration }}" type="radio" value="absent" />
                                                        </label>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
    
    {{-- Form --}}
    <script src="{{ asset('/dist/js/form.js') }}"></script>
    @include('scripts.select2')
@endsection