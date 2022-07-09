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
                                <a class="waves-effect waves-light btn btn-round blue strong" href="{{ $menu->url }}">KEMBALI</a>
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
                                            @foreach ($reports as $report)
                                                <tr id="noedit" data-id="{{ $report->id }}">
                                                    <td style="border: 1px solid">{{ $report->nis }}</td>
                                                    <td style="border: 1px solid">{{ $report->full_name }}</td>
                                                    @for ($i = 1; $i < 6; $i++)
                                                        <td style="border: 1px solid">
                                                            <div class="input-field">
                                                                <input class="auto_calculate" id="ph{{ $i }}_{{ $report->id }}" data-id="{{ $report->id }}" type="text" name="ph{{ $i }}_{{ $report->id }}" placeholder="PH{{ $i }}" 
                                                                    @if ($report->report)
                                                                        value="{{ old('ph'.$i.'_'.$report->id, $report->report['ph'.$i]) }}"
                                                                    @else
                                                                        value="{{ old('ph'.$i.'_'.$report->id) }}"
                                                                    @endif
                                                                >
                                                                @error('ph'.$i.'_'.$report->id)
                                                                    <div class="error">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </td>
                                                        <td style="border: 1px solid">
                                                            <div class="input-field">
                                                                <input class="auto_calculate" id="r{{ $i }}_{{ $report->id }}" data-id="{{ $report->id }}" type="text" name="r{{ $i }}_{{ $report->id }}" placeholder="R{{ $i }}" 
                                                                    @if ($report->report)
                                                                        value="{{ old('r'.$i.'_'.$report->id, $report->report['r'.$i]) }}"
                                                                    @else
                                                                        value="{{ old('r'.$i.'_'.$report->id) }}"
                                                                    @endif
                                                                >
                                                                @error('r'.$i.'_'.$report->id)
                                                                    <div class="error">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </td>
                                                        <td style="border: 1px solid">
                                                            <div class="input-field">
                                                                <input type="hidden" id="nh{{ $i }}_{{ $report->id }}" name="n{{ $i }}_{{ $report->id }}" 
                                                                    @if ($report->report)
                                                                        value="{{ old('n'.$i.'_'.$report->id, $report->report['n'.$i]) }}"
                                                                    @else
                                                                        value="{{ old('n'.$i.'_'.$report->id) }}"
                                                                    @endif
                                                                >
                                                                <input id="n{{ $i }}_{{ $report->id }}" type="text" name="n{{ $i }}_{{ $report->id }}" placeholder="N{{ $i }}" disabled
                                                                    @if ($report->report)
                                                                        value="{{ old('n'.$i.'_'.$report->id, $report->report['n'.$i]) }}"
                                                                    @else
                                                                        value="{{ old('n'.$i.'_'.$report->id) }}"
                                                                    @endif
                                                                >
                                                            </div>
                                                        </td>
                                                    @endfor
                                                    <td style="border: 1px solid">
                                                        <div class="input-field">
                                                            <input type="hidden" name="avg_ph{{ $report->id }}" 
                                                                @if ($report->report)
                                                                    value="{{ old('avg_ph'.$report->id, $report->report->avg_ph) }}"
                                                                @else
                                                                    value="{{ old('avg_ph'.$report->id) }}"
                                                                @endif
                                                            >
                                                            <input id="avg_ph{{ $report->id }}" type="text" name="avg_ph{{ $report->id }}" placeholder="Rata PH" disabled
                                                            @if ($report->report)
                                                                    value="{{ old('avg_ph'.$report->id, $report->report->avg_ph) }}"
                                                                @else
                                                                    value="{{ old('avg_ph'.$report->id) }}"
                                                                @endif
                                                            >
                                                        </div>
                                                    </td>
                                                    <td style="border: 1px solid">
                                                        <div class="input-field">
                                                            <input class="auto_npa" id="pts{{ $report->id }}" data-id="{{ $report->id }}" type="text" name="pts{{ $report->id }}" placeholder="PTS" 
                                                                @if ($report->report)
                                                                    value="{{ old('pts'.$report->id, $report->report->pts) }}"
                                                                @else
                                                                    value="{{ old('pts'.$report->id) }}"
                                                                @endif
                                                            >
                                                            @error('pts{{ $report->id }}')
                                                                <div class="error">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                    <td style="border: 1px solid">
                                                        <div class="input-field">
                                                            <input class="auto_npa" id="pas{{ $report->id }}" data-id="{{ $report->id }}" type="text" name="pas{{ $report->id }}" placeholder="PAS" 
                                                                @if ($report->report)
                                                                    value="{{ old('pas'.$report->id, $report->report->pas) }}"
                                                                @else
                                                                    value="{{ old('pas'.$report->id) }}"
                                                                @endif
                                                            >
                                                            @error('pas{{ $report->id }}')
                                                                <div class="error">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                    <td style="border: 1px solid">
                                                        <div class="input-field">
                                                            <input type="hidden" id="npah{{ $report->id }}" name="npa{{ $report->id }}" 
                                                                @if ($report->report)
                                                                    value="{{ old('npa'.$report->id, $report->report->npa) }}"
                                                                @else
                                                                    value="{{ old('npa'.$report->id) }}"
                                                                @endif
                                                            >
                                                            <input id="npa{{ $report->id }}" type="text" name="npa{{ $report->id }}" placeholder="NPA" disabled
                                                                @if ($report->report)
                                                                    value="{{ old('npa'.$report->id, $report->report->npa) }}"
                                                                @else
                                                                    value="{{ old('npa'.$report->id) }}"
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
                                            @foreach ($reports as $report)
                                                <tr id="noedit" data-id="{{ $report->id }}">
                                                    <td style="border: 1px solid">{{ $report->nis }}</td>
                                                    <td style="border: 1px solid">{{ $report->full_name }}</td>
                                                    @for ($i = 1; $i < 6; $i++)
                                                        <td style="border: 1px solid">
                                                            <div class="input-field">
                                                                <input class="auto_calculate" data-id="{{ $report->id }}" id="t{{ $i }}_{{ $report->id }}" type="text" name="t{{ $i }}_{{ $report->id }}" placeholder="T{{ $i }}" 
                                                                    @if ($report->report)
                                                                        value="{{ old('t'.$i.'_'.$report->id, $report->report['t'.$i]) }}"
                                                                    @else
                                                                        value="{{ old('t'.$i.'_'.$report->id) }}"
                                                                    @endif
                                                                >
                                                                @error('t'.$i.'_'.$report->id)
                                                                    <div class="error">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </td>
                                                    @endfor
                                                    <td style="border: 1px solid">
                                                        <div class="input-field">
                                                            <input type="hidden" name="avg_t{{ $report->id }}" 
                                                                @if ($report->report)
                                                                    value="{{ old('avg_t'.$report->id, $report->report->avg_t) }}"
                                                                @else
                                                                    value="{{ old('avg_t'.$report->id) }}"
                                                                @endif
                                                            >
                                                            <input id="avg_t{{ $report->id }}" type="text" name="avg_t{{ $report->id }}" placeholder="Rata T" disabled
                                                                @if ($report->report)
                                                                    value="{{ old('avg_t'.$report->id, $report->report->avg_t) }}"
                                                                @else
                                                                    value="{{ old('avg_t'.$report->id) }}"
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
                                            @foreach ($reports as $report)
                                                <tr id="noedit" data-id="{{ $report->id }}">
                                                    <td style="border: 1px solid">{{ $report->nis }}</td>
                                                    <td style="border: 1px solid">{{ $report->full_name }}</td>
                                                    @for ($i = 1; $i < 6; $i++)
                                                        <td style="border: 1px solid">
                                                            <div class="input-field">
                                                                <input class="auto_calculate" data-id="{{ $report->id }}" id="k{{ $i }}_{{ $report->id }}" type="text" name="k{{ $i }}_{{ $report->id }}" placeholder="K{{ $i }}"
                                                                    @if ($report->report)
                                                                        value="{{ old('k'.$i.'_'.$report->id, $report->report['k'.$i]) }}"
                                                                    @else
                                                                        value="{{ old('k'.$i.'_'.$report->id) }}"
                                                                    @endif
                                                                >
                                                                @error('k'.$i.'_'.$report->id)
                                                                    <div class="error">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </td>
                                                    @endfor
                                                    <td style="border: 1px solid">
                                                        <div class="input-field">
                                                            <input type="hidden" name="avg_k{{ $report->id }}" 
                                                                @if ($report->report)
                                                                    value="{{ old('avg_k'.$report->id, $report->report->avg_k) }}"
                                                                @else
                                                                    value="{{ old('avg_k'.$report->id) }}"
                                                                @endif
                                                            >
                                                            <input id="avg_k{{ $report->id }}" type="text" name="avg_k{{ $report->id }}" placeholder="Rata K" disabled
                                                                @if ($report->report)
                                                                    value="{{ old('avg_k'.$report->id, $report->report->avg_k) }}"
                                                                @else
                                                                    value="{{ old('avg_k'.$report->id) }}"
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