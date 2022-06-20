@extends('layouts.main')

@section('title', $menu->title)

@section('styles')
    {{-- Data Tables --}}
    <link href="{{ asset('/dist/css/pages/data-table.css') }}" rel="stylesheet">

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
                        <h5 class="card-title">Detail Siswa</h5>
                        @if (session('status'))
                            <div class="success-alert-bar p-15 m-t-10 m-b-10 green white-text" style="display: block">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col s12"><hr>
                                <form method="POST" action="{{ str_replace("/edit", "", url()->current()) }}">
                                    @method('put')
                                    @csrf
                                    <div class="row">
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
                                        <div class="input-field col s7">
                                            <input id="full_name" type="text" name="full_name" value="{{ $student->full_name }}" disabled>
                                            <label for="full_name">Nama Lengkap</label>
                                        </div>
                                        <div class="input-field col s1">
                                            <input id="clazz" type="text" name="clazz" value="{{ $student->class->class->name }}" disabled>
                                            <label for="clazz">Kelas</label>
                                            @error('clazz')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s6">
                                            <select id="lesson" name="lesson" class="" disabled>
                                                @if ($lessons)
                                                    @foreach ($lessons as $lesson)
                                                        <option @if(old('lesson', $report->lesson_id) == $lesson->id) selected @endif value="{{ $lesson->id }}">{{ $lesson->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <label for="lesson">Mata Pelajaran <span class="materialize-red-text">*</span></label>
                                            @error('lesson')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s4">
                                            <input id="score" type="text" name="score" placeholder="87" value="{{ old('score', 0) }}">
                                            <label for="score">Nilai <span class="materialize-red-text">*</span></label>
                                            @error('score')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s2">
                                            <select id="type" name="type" class="">
                                                <option value="uh1" selected>UH1</option>
                                                <option value="uh2">UH2</option>
                                                <option value="uh3">UH3</option>
                                                <option value="uh4">UH4</option>
                                                <option value="uts">UTS</option>
                                                <option value="uas">UAS</option>
                                            </select>
                                            <label for="type">Tipe</label>
                                            @error('type')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col s12" style="text-align: right">
                                            <a class="waves-effect waves-light btn btn-round blue strong" href="{{ str_replace('/'.$report->id.'/edit', '', url()->previous()) }}">KEMBALI</a>
                                            <button class="waves-effect waves-light btn btn-round green strong" type="submit">SIMPAN</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <h5 class="card-title">{{ $menu->title }}</h5>
                        <div class="row">
                            <div class="col s12">
                                <table id="zero_config" class="responsive-table display" style="width:100%" onload="message()">
                                    <thead>
                                        <tr>
                                            <th>Nilai</th>
                                            <th>Tipe</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($report_details)
                                            @foreach ($report_details as $report_detail)
                                                <tr data-id="{{ $report_detail->id }}">
                                                    <td>{{ $report_detail->score }}</td>
                                                    <td>{{ $report_detail->type }}</td>
                                                    <td id="no-data" class="text-center" style="width: 5%">
                                                        <form action="{{ $menu->url }}/{{ $report_detail->id }}" method="POST" class="d-inline">
                                                            @method('delete')
                                                            @csrf
                                                            <input type="hidden" name="report" value="{{ $report->id }}">
                                                            <input type="hidden" name="student" value="{{ $report->student_id }}">
                                                            <input type="hidden" name="type" value="{{ $report_detail->type }}">
                                                            <button type="submit" class="transparent fas fa-trash materialize-red-text" style="border: 0px"></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row m-t-10">
                            <div class="col s12" style="text-align: right">
                                <a class="waves-effect waves-light btn btn-round blue strong" href="{{ str_replace('/'.$report->id.'/edit', '', url()->previous()) }}">KEMBALI</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Data Tables --}}
    <script src="{{ asset('/extra-libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/dist/js/pages/datatable/datatable-basic.init.js') }}"></script>

    {{-- Select2 --}}
    <script src="{{ asset('/libs/select2/dist/js/select2.min.js') }}"></script>

    {{-- Form --}}
    <script src="{{ asset('/dist/js/form.js') }}"></script>
    @include('scripts.select2')
@endsection