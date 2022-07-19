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
                        @if (session('status'))
                            <div class="success-alert-bar p-15 m-t-10 m-b-10 green white-text" style="display: block">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="success-alert-bar p-15 m-t-10 m-b-10 red white-text" style="display: block">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="input-field col s2">
                                <input id="clazz" type="text" name="clazz" value="{{ $clazz->class->name }}" disabled>
                                <label for="clazz">Kelas</label>
                            </div>
                            <div class="input-field col s3">
                                <input id="study_year" type="text" name="study_year" value="{{ $clazz->study_year->name }}" disabled>
                                <label for="study_year">Tahun Pelajaran</label>
                            </div>
                            <div class="input-field col s3">
                                <input id="semester" type="text" name="semester" value="{{ $clazz->study_year->semester }}" disabled>
                                <label for="semester">Semester</label>
                            </div>
                            <div class="input-field col s4">
                                <input id="teacher_head" type="text" name="teacher_head" value="{{ $clazz->teacher->full_name }}" disabled>
                                <label for="teacher_head">Wali Kelas</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <input id="lesson" type="text" name="lesson" value="{{ $lesson->lesson->name }}" disabled>
                                <label for="lesson">Mata Pelajaran</label>
                            </div>
                            <div class="input-field col s6">
                                <input id="teacher" type="text" name="teacher" value="{{ $lesson->teacher->full_name }}" disabled>
                                <label for="teacher">Guru Pengajar</label>
                            </div>
                        </div>

                        <form method="POST" action="{{ str_replace("/edit", "", url()->current()) }}">
                        @method('put')
                        @csrf
                        <input type="hidden" name="count" value="{{ $students->count() }}">
                        <hr>
                        <div class="row">
                            <div class="col s12" style="text-align: right">
                                <a class="waves-effect waves-light btn btn-round blue strong" href="{{ $menu->url }}/{{ $clazz->id }}">KEMBALI</a>
                                <a class="waves-effect waves-light btn btn-round red strong" href="{{ $menu->url }}/{{ $clazz->id }}/{{ $lesson->lesson_id }}">GENERATE</a>
                                <a class="waves-effect waves-light btn btn-round primary strong" href="{{ $menu->url }}/{{ $clazz->id }}/{{ $lesson->lesson_id }}/cetak">CETAK</a>
                                <button class="waves-effect waves-light btn btn-round green strong" type="submit">SIMPAN</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                    <ul class="card collapsible collapsible-accordion collapsible-dark">
                        <li class="">
                            <div class="collapsible-header">
                                <h5 class="card-title">Penilaian Harian</h5>                            
                            </div>
                            <div class="collapsible-body">
                                <input type="hidden" name="kkm" value="{{ $lesson->lesson->kkm }}">
                                <table class="responsive-table display" style="width:100%">
                                    <thead>
                                        <tr style="background: rgb(205, 255, 204)">
                                            <th style="border: 1px solid">NIS</th>
                                            <th style="border: 1px solid">Siswa</th>
                                            @for ($i = 1; $i < 6; $i++)
                                                <th style="border: 1px solid">PH{{ $i }}</th>
                                                <th style="border: 1px solid">R{{ $i }}</th>
                                                <th style="border: 1px solid">N{{ $i }}</th>
                                            @endfor
                                            <th style="border: 1px solid">Rata PH</th>
                                            <th style="border: 1px solid">PTS</th>
                                            <th style="border: 1px solid">PAS</th>
                                            <th style="border: 1px solid">NPA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($reports)
                                            @foreach (json_decode($reports, true) as $report)
                                                <tr id="noedit" data-id="{{ $report['student_id'] }}">
                                                    <td style="border: 1px solid">{{ $report['nis'] }}</td>
                                                    <td style="border: 1px solid">{{ $report['full_name'] }}</td>
                                                    @for ($i = 1; $i < 6; $i++)
                                                        <td style="border: 1px solid">
                                                            <div class="input-field">
                                                                <input class="auto_calculate" id="ph{{ $i }}_{{ $report['student_id'] }}" data-id="{{ $report['student_id'] }}" type="text" name="ph{{ $i }}_{{ $report['student_id'] }}" placeholder="PH{{ $i }}" 
                                                                    @if ($report['ph'.$i])
                                                                        value="{{ old('ph'.$i.'_'.$report['student_id'], $report['ph'.$i]) }}"
                                                                    @else
                                                                        value="{{ old('ph'.$i.'_'.$report['student_id']) }}"
                                                                    @endif
                                                                >
                                                                @error('ph'.$i.'_'.$report['student_id'])
                                                                    <div class="error">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </td>
                                                        <td style="border: 1px solid">
                                                            <div class="input-field">
                                                                <input class="auto_calculate" id="r{{ $i }}_{{ $report['student_id'] }}" data-id="{{ $report['student_id'] }}" type="text" name="r{{ $i }}_{{ $report['student_id'] }}" placeholder="R{{ $i }}" 
                                                                    @if ($report['r'.$i])
                                                                        value="{{ old('r'.$i.'_'.$report['student_id'], $report['r'.$i]) }}"
                                                                    @else
                                                                        value="{{ old('r'.$i.'_'.$report['student_id']) }}"
                                                                    @endif
                                                                >
                                                                @error('r'.$i.'_'.$report['student_id'])
                                                                    <div class="error">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </td>
                                                        <td style="border: 1px solid">
                                                            <div class="input-field">
                                                                <input type="hidden" id="nh{{ $i }}_{{ $report['student_id'] }}" name="n{{ $i }}_{{ $report['student_id'] }}" 
                                                                    @if ($report['n'.$i])
                                                                        value="{{ old('n'.$i.'_'.$report['student_id'], $report['n'.$i]) }}"
                                                                    @else
                                                                        value="{{ old('n'.$i.'_'.$report['student_id']) }}"
                                                                    @endif
                                                                >
                                                                <input id="n{{ $i }}_{{ $report['student_id'] }}" type="text" name="n{{ $i }}_{{ $report['student_id'] }}" placeholder="N{{ $i }}" disabled
                                                                    @if ($report['n'.$i])
                                                                        value="{{ old('n'.$i.'_'.$report['student_id'], $report['n'.$i]) }}"
                                                                    @else
                                                                        value="{{ old('n'.$i.'_'.$report['student_id']) }}"
                                                                    @endif
                                                                >
                                                            </div>
                                                        </td>
                                                    @endfor
                                                    <td style="border: 1px solid">
                                                        <div class="input-field">
                                                            <input type="hidden" name="avg_ph{{ $report['student_id'] }}" 
                                                                @if ($report['avg_ph'])
                                                                    value="{{ old('avg_ph'.$report['student_id'], $report['avg_ph']) }}"
                                                                @else
                                                                    value="{{ old('avg_ph'.$report['student_id']) }}"
                                                                @endif
                                                            >
                                                            <input id="avg_ph{{ $report['student_id'] }}" type="text" name="avg_ph{{ $report['student_id'] }}" placeholder="Rata PH" disabled
                                                                @if ($report['avg_ph'])
                                                                    value="{{ old('avg_ph'.$report['student_id'], $report['avg_ph']) }}"
                                                                @else
                                                                    value="{{ old('avg_ph'.$report['student_id']) }}"
                                                                @endif
                                                            >
                                                        </div>
                                                    </td>
                                                    <td style="border: 1px solid">
                                                        <div class="input-field">
                                                            <input class="auto_npa" id="pts{{ $report['student_id'] }}" data-id="{{ $report['student_id'] }}" type="text" name="pts{{ $report['student_id'] }}" placeholder="PTS" 
                                                                @if ($report['pts'])
                                                                    value="{{ old('pts'.$report['student_id'], $report['pts']) }}"
                                                                @else
                                                                    value="{{ old('pts'.$report['student_id']) }}"
                                                                @endif
                                                            >
                                                            @error('pts'.$report['student_id'])
                                                                <div class="error">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                    <td style="border: 1px solid">
                                                        <div class="input-field">
                                                            <input class="auto_npa" id="pas{{ $report['student_id'] }}" data-id="{{ $report['student_id'] }}" type="text" name="pas{{ $report['student_id'] }}" placeholder="PAS" 
                                                                @if ($report['pas'])
                                                                    value="{{ old('pas'.$report['student_id'], $report['pas']) }}"
                                                                @else
                                                                    value="{{ old('pas'.$report['student_id']) }}"
                                                                @endif
                                                            >
                                                            @error('pas'.$report['student_id'])
                                                                <div class="error">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                    <td style="border: 1px solid">
                                                        <div class="input-field">
                                                            <input type="hidden" id="npah{{ $report['student_id'] }}" name="npa{{ $report['student_id'] }}" 
                                                                @if ($report['npa'])
                                                                    value="{{ old('npa'.$report['student_id'], $report['npa']) }}"
                                                                @else
                                                                    value="{{ old('npa'.$report['student_id']) }}"
                                                                @endif
                                                            >
                                                            <input id="npa{{ $report['student_id'] }}" type="text" name="npa{{ $report['student_id'] }}" placeholder="NPA" disabled
                                                                @if ($report['npa'])
                                                                    value="{{ old('npa'.$report['student_id'], $report['npa']) }}"
                                                                @else
                                                                    value="{{ old('npa'.$report['student_id']) }}"
                                                                @endif
                                                            >
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </li>
                        <li class="active">
                            <div class="collapsible-header">
                                <h5 class="card-title">Nilai Tugas</h5>                            
                            </div>
                            <div class="collapsible-body">
                                <table class="responsive-table" style="width:100%; border: 1px solid">
                                    <thead style="background: rgb(236, 217, 255)">
                                        <tr>
                                            <th style="border: 1px solid">NIS</th>
                                            <th style="border: 1px solid">Siswa</th>
                                            @for ($i = 1; $i < 6; $i++)
                                                <th style="border: 1px solid">T{{ $i }}</th>
                                            @endfor
                                            <th style="border: 1px solid">Rata T</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($reports)
                                            @foreach (json_decode($reports, true) as $report)
                                                <tr id="noedit" data-id="{{ $report['student_id'] }}">
                                                    <td style="border: 1px solid">{{ $report['nis'] }}</td>
                                                    <td style="border: 1px solid">{{ $report['full_name'] }}</td>
                                                    @for ($i = 1; $i < 6; $i++)
                                                        <td style="border: 1px solid">
                                                            <div class="input-field">
                                                                <input class="auto_calculate" data-id="{{ $report['student_id'] }}" id="t{{ $i }}_{{ $report['student_id'] }}" type="text" name="t{{ $i }}_{{ $report['student_id'] }}" placeholder="T{{ $i }}" 
                                                                    @if ($report['t'.$i])
                                                                        value="{{ old('t'.$i.'_'.$report['student_id'], $report['t'.$i]) }}"
                                                                    @else
                                                                        value="{{ old('t'.$i.'_'.$report['student_id']) }}"
                                                                    @endif
                                                                >
                                                                @error('t'.$i.'_'.$report['student_id'])
                                                                    <div class="error">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </td>
                                                    @endfor
                                                    <td style="border: 1px solid">
                                                        <div class="input-field">
                                                            <input type="hidden" name="avg_t{{ $report['student_id'] }}" 
                                                                @if ($report['avg_t'])
                                                                    value="{{ old('avg_t'.$report['student_id'], $report['avg_t']) }}"
                                                                @else
                                                                    value="{{ old('avg_t'.$report['student_id']) }}"
                                                                @endif
                                                            >
                                                            <input id="avg_t{{ $report['student_id'] }}" type="text" name="avg_t{{ $report['student_id'] }}" placeholder="Rata T" disabled
                                                                @if ($report['avg_t'])
                                                                    value="{{ old('avg_t'.$report['student_id'], $report['avg_t']) }}"
                                                                @else
                                                                    value="{{ old('avg_t'.$report['student_id']) }}"
                                                                @endif
                                                            >
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </li>
                        <li class="">
                            <div class="collapsible-header">
                                <h5 class="card-title">Nilai Keterampilan</h5>                            
                            </div>
                            <div class="collapsible-body">
                                
                                <table class="responsive-table" style="width:100%; border: 1px solid">
                                    <thead style="background: rgb(254, 241, 200)">
                                        <tr>
                                            <th style="border: 1px solid">NIS</th>
                                            <th style="border: 1px solid">Siswa</th>
                                            @for ($i = 1; $i < 6; $i++)
                                                <th style="border: 1px solid">K{{ $i }}</th>
                                            @endfor
                                            <th style="border: 1px solid">Rata K</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($reports)
                                            @foreach (json_decode($reports, true) as $report)
                                                <tr id="noedit" data-id="{{ $report['student_id'] }}">
                                                    <td style="border: 1px solid">{{ $report['nis'] }}</td>
                                                    <td style="border: 1px solid">{{ $report['full_name'] }}</td>
                                                    @for ($i = 1; $i < 6; $i++)
                                                        <td style="border: 1px solid">
                                                            <div class="input-field">
                                                                <input class="auto_calculate" data-id="{{ $report['student_id'] }}" id="k{{ $i }}_{{ $report['student_id'] }}" type="text" name="k{{ $i }}_{{ $report['student_id'] }}" placeholder="K{{ $i }}"
                                                                    @if ($report['k'.$i])
                                                                        value="{{ old('k'.$i.'_'.$report['student_id'], $report['k'.$i]) }}"
                                                                    @else
                                                                        value="{{ old('k'.$i.'_'.$report['student_id']) }}"
                                                                    @endif
                                                                >
                                                                @error('k'.$i.'_'.$report['student_id'])
                                                                    <div class="error">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </td>
                                                    @endfor
                                                    <td style="border: 1px solid">
                                                        <div class="input-field">
                                                            <input type="hidden" name="avg_k{{ $report['student_id'] }}" 
                                                                @if ($report['avg_k'])
                                                                    value="{{ old('avg_k'.$report['student_id'], $report['avg_k']) }}"
                                                                @else
                                                                    value="{{ old('avg_k'.$report['student_id']) }}"
                                                                @endif
                                                            >
                                                            <input id="avg_k{{ $report['student_id'] }}" type="text" name="avg_k{{ $report['student_id'] }}" placeholder="Rata K" disabled
                                                                @if ($report['avg_k'])
                                                                    value="{{ old('avg_k'.$report['student_id'], $report['avg_k']) }}"
                                                                @else
                                                                    value="{{ old('avg_k'.$report['student_id']) }}"
                                                                @endif
                                                            >
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
                </form>
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