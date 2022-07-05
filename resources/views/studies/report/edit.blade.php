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
                        <h5 class="card-title">{{ $menu->title }}</h5>
                        @if (session('error'))
                            <div class="success-alert-bar p-15 m-t-10 m-b-10 red white-text" style="display: block">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ str_replace("/edit", "", url()->current()) }}">
                            @method('put')
                            @csrf
                            <div class="row">
                                <div class="input-field col s4">
                                    <input id="clazz" type="text" name="clazz" value="{{ $clazz->class->name }}" disabled>
                                    <label for="clazz">Kelas</label>
                                </div>
                                <div class="input-field col s4">
                                    <input id="study_year" type="text" name="study_year" value="{{ $clazz->study_year->name }}" disabled>
                                    <label for="study_year">Tahun Pelajaran</label>
                                </div>
                                <div class="input-field col s4">
                                    <input id="teacher_head" type="text" name="teacher_head" value="{{ $clazz->teacher->full_name }}" disabled>
                                    <label for="teacher_head">Wali Kelas</label>
                                </div>
                            </div>

                            {{-- <div class="row">
                                <div class="input-field col s4">
                                    <select id="lesson" name="lesson" class="auto_fill_teacher">
                                        @if ($lessons)
                                            <option selected value="">=== SILAHKAN PILIH ===</option>
                                            @foreach ($lessons as $lesson)
                                                <option @if(old('lesson', $less) == $lesson->id) selected @endif value="{{ $lesson->id }}">{{ $lesson->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="lesson">Mata Pelajaran</label>
                                    @error('lesson')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s4">
                                    <input id="teacher" type="text" placeholder="Guru" name="teacher" disabled>
                                    <label for="teacher">Guru</label>
                                </div>
                                <div class="input-field col s4">
                                    <select id="type" name="type">
                                        <option @if(old('type') == 'ph') selected @endif value="ph">Ujian Harian</option>
                                        <option @if(old('type') == 't') selected @endif value="t">Tugas</option>
                                        <option @if(old('type') == 'r') selected @endif value="r">Remedial</option>
                                        <option @if(old('type') == 'k') selected @endif value="k">Keterampilan</option>
                                        <option @if(old('type') == 'uts') selected @endif value="uts">UTS</option>
                                        <option @if(old('type') == 'uas') selected @endif value="uas">UAS</option>
                                    </select>
                                    <label for="type">Tipe Nilai</label>
                                    @error('type')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div> --}}
                            {{-- </div> --}}

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

                <ul class="collapsible">
                    <li>
                        <div class="collapsible-header"><h5 class="card-title">Ujian Harian</h5></div>
                        <div class="collapsible-body">
                            <table id="noedit" class="responsive-table display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>NIS</th>
                                        <th>Siswa</th>
                                        @for ($i = 1; $i < 6; $i++)
                                            <th>PH{{ $i }}</th>
                                            <th>R{{ $i }}</th>
                                            <th>N{{ $i }}</th>
                                        @endfor
                                            <th>Rata PH</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($students)
                                        @foreach ($students as $student)
                                            <tr id="noedit" data-id="{{ $student->id }}">
                                                <td>{{ $student->nis }}</td>
                                                <td>{{ $student->full_name }}</td>
                                                @for ($i = 1; $i < 6; $i++)
                                                    <td>
                                                        <div class="input-field">
                                                            <input id="ph{{ $i }}" type="text" name="ph{{ $i }}" placeholder="PH1" value="">
                                                            @error('ph'.$i)
                                                                <div class="error">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-field">
                                                            <input id="r{{ $i }}" type="text" name="r{{ $i }}" placeholder="R1" value="">
                                                            @error('r'.$i)
                                                                <div class="error">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-field">
                                                            <input id="n{{ $i }}" type="text" name="n{{ $i }}" placeholder="N1" value="">
                                                            @error('n'.$i)
                                                                <div class="error">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                @endfor
                                                <td>
                                                    <div class="input-field">
                                                        <input id="n{{ $i }}" type="text" name="n{{ $i }}" placeholder="N1" value="">
                                                        @error('n'.$i)
                                                            <div class="error">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </li>
                </ul>

                <ul id="tugas" class="collapsible">
                    <li class="active">
                        <div class="collapsible-header"><h5 class="card-title">Tugas</h5></div>
                        <div class="collapsible-body">
                            <p>TEsting</p>
                            {{-- <table id="noedit" class="responsive-table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>NIS</th>
                                        <th>Siswa</th>
                                        @for ($i = 1; $i < 6; $i++)
                                            <th>T{{ $i }}</th>
                                        @endfor
                                        <th>Rata T</th>
                                        <th>PTS</th>
                                        <th>PAS</th>
                                        <th>NPA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($students)
                                        @foreach ($students as $student)
                                            <tr id="noedit" data-id="{{ $student->id }}">
                                                <td>{{ $student->nis }}</td>
                                                <td>{{ $student->full_name }}</td>
                                                @for ($i = 1; $i < 6; $i++)
                                                    <td>
                                                        <div class="input-field">
                                                            <input id="t{{ $i }}" type="text" name="t{{ $i }}" placeholder="T{{ $i }}" value="{{ old('t'.$i) }}">
                                                            @error('t'.$i)
                                                                <div class="error">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                @endfor
                                                <td>
                                                    <div class="input-field">
                                                        <input id="n{{ $i }}" type="text" name="n{{ $i }}" placeholder="N1" value="">
                                                        @error('n'.$i)
                                                            <div class="error">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table> --}}
                        </div>
                    </li>
                </ul>
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
    <script src="{{ asset('/extra-libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/dist/js/pages/datatable/datatable-basic.init.js') }}"></script>
    
    {{-- Form --}}
    <script src="{{ asset('/dist/js/form.js') }}"></script>
    @include('scripts.select2')
@endsection