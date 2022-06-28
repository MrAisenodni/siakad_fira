@extends('layouts.main')

@section('title', $menu->title)

@section('styles')
{{-- Prism --}}
<link href="{{ asset('/extra-libs/prism/prism.css') }}" rel="stylesheet">

{{-- Select2 --}}
<link href="{{ asset('/libs/select2/dist/css/select2.css') }}" rel="stylesheet">

{{-- Data Tables --}}
<link href="{{ asset('/dist/css/pages/data-table.css') }}" rel="stylesheet">
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
                            <div class="success-alert-bar p-15 m-t-10 m-b-10 red white-text" style="display: block">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="row">
                            {{-- <div class="col s12"><hr>
                                <form method="POST" action="{{ str_replace("/create", "", $menu->url) }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <input type="hidden" name="class" value="{{ $class }}">
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
                                            <select id="lesson" name="lesson" class="">
                                                <option value="" selected>--- SILAHKAN PILIH ---</option>
                                                @if ($lessons)
                                                    @foreach ($lessons as $lesson)
                                                        <option @if(old('lesson') == $lesson->id) selected @endif value="{{ $lesson->id }}">{{ $lesson->name }}</option>
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
                                            <a class="waves-effect waves-light btn btn-round blue strong" href="{{ url()->previous() }}">KEMBALI</a>
                                            <button class="waves-effect waves-light btn btn-round green strong" type="submit">SIMPAN</button>
                                        </div>
                                    </div>
                                </form>
                            </div> --}}
                        </div>
                    </div>
                </div>

                {{-- Edit Table --}}
                <div class="card">
                    <div class="card-content">
                        <h5 class="card-title">Editable with Datatable</h5>
                        <h6 class="card-subtitle">Just click on the table cell you want to edit.</h6>
                        <div class="table-responsive">
                            <table class="table striped m-b-20" id="editable-datatable">
                                <thead>
                                    <tr>
                                        <th>Rendering engine</th>
                                        <th>Browser</th>
                                        <th>Platform(s)</th>
                                        <th>Engine version</th>
                                        <th>CSS grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="1" class="gradeX">
                                        <td>Trident</td>
                                        <td>Internet Explorer 4.0 </td>
                                        <td>Win 95+</td>
                                        <td class="center">4</td>
                                        <td class="center">X</td>
                                    </tr>
                                </tbody>
                            </table>
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

{{-- Data Tables --}}
{{-- <script src="{{ asset('/extra-libs/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('/dist/js/pages/datatable/datatable-basic.init.js') }}"></script> --}}
<script src="{{ asset('/assets/extra-libs/jquery-datatables-editable/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/assets/extra-libs/tiny-editable/mindmup-editabletable.js') }}"></script>
<script src="{{ asset('/assets/extra-libs/tiny-editable/numeric-input-example.js') }}"></script>
{{-- $('#mainTable').editableTableWidget().numericInputExample().find('td:first').focus();
$('#editable-datatable').editableTableWidget().numericInputExample().find('td:first').focus();
$(function() {
    $('#editable-datatable').DataTable();
}); --}}

{{-- Form --}}
<script src="{{ asset('/dist/js/form.js') }}"></script>
@include('scripts.select2')
@endsection