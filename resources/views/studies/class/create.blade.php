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
                        @if (session('error'))
                            <div class="success-alert-bar p-15 m-t-10 m-b-10 red white-text" style="display: block">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ str_replace("/create", "", $menu->url) }}">
                            @csrf
                            <div class="row">
                                <div class="input-field col s4">
                                    <select id="teacher" name="teacher" class="disabled select2">
                                        <option value="" selected>--- SILAHKAN PILIH ---</option>
                                        @if ($teachers)
                                            @foreach ($teachers as $teacher)
                                                <option @if(old('teacher') == $teacher->id) selected @endif value="{{ $teacher->id }}">[{{ $teacher->nip }}] {{ $teacher->full_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="teacher" class="active">Wali Kelas <span class="materialize-red-text">*</span></label>
                                    @error('teacher')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s4">
                                    <select id="study" name="study" class="disabled select2">
                                        <option value="" selected>--- SILAHKAN PILIH ---</option>
                                        @if ($studies)
                                            @foreach ($studies as $study)
                                                <option @if(old('study') == $study->id) selected @endif value="{{ $study->id }}">{{ $study->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="study" class="active">Tahun Ajar <span class="materialize-red-text">*</span></label>
                                    @error('study')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s4">
                                    <select id="class" name="class" class="disabled select2">
                                        <option value="" selected>--- SILAHKAN PILIH ---</option>
                                        @if ($mst_classes)
                                            @foreach ($mst_classes as $class)
                                                <option @if(old('class') == $class->id) selected @endif value="{{ $class->id }}">{{ $class->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="class" class="active">Kelas <span class="materialize-red-text">*</span></label>
                                    @error('class')
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
    
    {{-- Form --}}
    <script src="{{ asset('/dist/js/form.js') }}"></script>
    @include('scripts.select2')
@endsection
