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
                        <h5 class="card-title">{{ $menu->title }} Siswa</h5>
                        <form method="POST" action="{{ $menu->url }}">
                            @csrf
                            <input type="hidden" name="clazz_id" value="{{ $clazz->id }}">
                            <div class="row">
                                <div class="input-field col s5">
                                    <input id="study_date" class="datepicker" type="text" placeholder="dd/mm/yyyy" name="study_date" value="{{ old('study_date', $study_date) }}" required>
                                    <label for="study_date">Tanggal</label>
                                    @error('study_date')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s3">
                                    <label for="clazz">Kelas</label>
                                    <input id="clazz" type="text" name="clazz" value="{{ $clazz->class->name }}" disabled>
                                </div>
                                <div class="input-field col s4">
                                    <label for="study_year">Tahun Pelajaran</label>
                                    <input id="study_year" type="text" name="study_year" value="{{ $clazz->study_year->name }}" disabled>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col s12" style="text-align: right">
                                    <a class="waves-effect waves-light btn btn-round blue strong" href="{{ $menu->url }}">KEMBALI</a>
                                    <button class="waves-effect waves-light btn btn-round green strong" type="submit">TAMBAH</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-content">
                        <form method="POST" action="{{ url()->current() }}/{{ $clazz->id }}">
                            @method('put')
                            @csrf
                            <div class="row">
                                <div class="col s8">
                                    <h5 class="card-title">Daftar Siswa</h5>
                                </div>
                                <div class="col s4" style="text-align: right">
                                    <button class="waves-effect waves-light btn btn-round green strong" type="submit">SIMPAN</button>
                                </div>
                            </div>
                            @if (session('status'))
                                <div class="row">
                                    <div class="col s12">
                                        <div class="success-alert-bar p-15 m-t-10 green white-text" style="display: block">
                                            {{ session('status') }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="row">
                                    <div class="col s12">
                                        <div class="success-alert-bar p-15 m-t-10 red white-text" style="display: block">
                                            {{ session('error') }}
                                        </div>
                                    </div>
                                </div>
                            @endif<hr>
                            <input type="hidden" name="study_date" value="{{ old('study_date', $study_date) }}">
                            <input type="hidden" name="c_student" value="{{ $classes->count() }}">
                            @if ($classes)
                            @foreach ($classes as $claz)
                                <input type="hidden" name="student{{ $loop->iteration }}" value="{{ $claz->student_id }}">
                                <input type="hidden" name="clazz{{ $loop->iteration }}" value="{{ $claz->id }}">
                                    <div class="row">
                                        <div class="input-field col s7">
                                            <label for="full_name">Nama Siswa</label>
                                            <input id="full_name" type="text" name="full_name" value="{{ $claz->student->full_name }}" disabled>
                                        </div>
                                        <div class="col s1">
                                            <label class="input-field">
                                                <input class="with-gap" name="present{{ $loop->iteration }}" type="radio" value="present" checked />
                                                <span>Hadir</span>
                                            </label>
                                        </div>
                                        <div class="col s1">
                                            <label class="input-field">
                                                <input class="with-gap" name="present{{ $loop->iteration }}" type="radio" value="sick" />
                                                <span>Sakit</span>
                                            </label>
                                        </div>
                                        <div class="col s1">
                                            <label class="input-field">
                                                <input class="with-gap" name="present{{ $loop->iteration }}" type="radio" value="permit" />
                                                <span>Izin</span>
                                            </label>
                                        </div>
                                        <div class="col s1">
                                            <label class="input-field">
                                                <input class="with-gap" name="present{{ $loop->iteration }}" type="radio" value="absent" />
                                                <span>Absen</span>
                                            </label>
                                        </div>
                                        <div class="col s1"></div>
                                    </div>
                                @endforeach
                            @endif

                            <hr>
                            <div class="row">
                                <div class="col s12" style="text-align: right">
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