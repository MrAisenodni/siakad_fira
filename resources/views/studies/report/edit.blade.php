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
                                <table id="noedit" class="responsive-table display" style="width:100%">
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
                                                    <td style="border: 1px solid">{{ $report->student->nis }}</td>
                                                    <td style="border: 1px solid">{{ $report->student->full_name }}</td>
                                                    @for ($i = 1; $i < 6; $i++)
                                                        <td style="border: 1px solid">
                                                            <div class="input-field">
                                                                <input class="auto_calculate" id="ph{{ $i }}_{{ $report->student_id }}" data-id="{{ $report->student_id }}" type="text" name="ph{{ $i }}_{{ $report->student_id }}" placeholder="PH{{ $i }}" value="{{ old('ph'.$i.'_'.$report->student_id, $report['ph'.$i]) }}">
                                                                @error('ph'.$i.'_'.$report->student_id)
                                                                    <div class="error">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </td>
                                                        <td style="border: 1px solid">
                                                            <div class="input-field">
                                                                <input class="auto_calculate" id="r{{ $i }}_{{ $report->student_id }}" data-id="{{ $report->student_id }}" type="text" name="r{{ $i }}_{{ $report->student_id }}" placeholder="R{{ $i }}" value="{{ old('r'.$i.'_'.$report->student_id, $report['r'.$i]) }}">
                                                                @error('r'.$i.'_'.$report->student_id)
                                                                    <div class="error">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </td>
                                                        <td style="border: 1px solid">
                                                            <div class="input-field">
                                                                <input type="hidden" id="nh{{ $i }}_{{ $report->student_id }}" name="n{{ $i }}_{{ $report->student_id }}" value="{{ old('n'.$i.'_'.$report->student_id) }}">
                                                                <input id="n{{ $i }}_{{ $report->student_id }}" type="text" name="n{{ $i }}_{{ $report->student_id }}" placeholder="N{{ $i }}" value="{{ old('n'.$i.'_'.$report->student_id, $report['n'.$i]) }}" disabled>
                                                            </div>
                                                        </td>
                                                    @endfor
                                                    <td style="border: 1px solid">
                                                        <div class="input-field">
                                                            <input type="hidden" name="avg_ph{{ $report->student_id }}" value="{{ old('avg_ph'.$report->student_id) }}">
                                                            <input id="avg_ph{{ $report->student_id }}" type="text" name="avg_ph{{ $report->student_id }}" placeholder="Rata PH" value="{{ old('avg_ph'.$report->student_id, $report->avg_ph) }}" disabled>
                                                        </div>
                                                    </td>
                                                    <td style="border: 1px solid">
                                                        <div class="input-field">
                                                            <input class="auto_npa" id="pts{{ $report->student_id }}" data-id="{{ $report->student_id }}" type="text" name="pts{{ $report->student_id }}" placeholder="PTS" value="{{ old('pts'.$report->student_id, $report->pts) }}">
                                                            @error('pts{{ $report->student_id }}')
                                                                <div class="error">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                    <td style="border: 1px solid">
                                                        <div class="input-field">
                                                            <input class="auto_npa" id="pas{{ $report->student_id }}" data-id="{{ $report->student_id }}" type="text" name="pas{{ $report->student_id }}" placeholder="PAS" value="{{ old('pas'.$report->student_id, $report->pas) }}">
                                                            @error('pas{{ $report->student_id }}')
                                                                <div class="error">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                    <td style="border: 1px solid">
                                                        <div class="input-field">
                                                            <input type="hidden" id="npah{{ $report->student_id }}" name="npa{{ $report->student_id }}" value="{{ old('npa'.$report->student_id, $report->npa) }}">
                                                            <input id="npa{{ $report->student_id }}" type="text" name="npa{{ $report->student_id }}" placeholder="NPA" value="{{ old('npa'.$report->student_id, $report->npa) }}" disabled>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            @if ($students)
                                                @foreach ($students as $student)
                                                    <tr id="noedit" data-id="{{ $student->id }}">
                                                        <td style="border: 1px solid">{{ $student->nis }}</td>
                                                        <td style="border: 1px solid">{{ $student->full_name }}</td>
                                                        @for ($i = 1; $i < 6; $i++)
                                                            <td style="border: 1px solid">
                                                                <div class="input-field">
                                                                    <input class="auto_calculate" id="ph{{ $i }}_{{ $student->id }}" data-id="{{ $student->id }}" type="text" name="ph{{ $i }}_{{ $student->id }}" placeholder="PH{{ $i }}" value="{{ old('ph'.$i.'_'.$student->id) }}">
                                                                    @error('ph'.$i.'_'.$student->id)
                                                                        <div class="error">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td style="border: 1px solid">
                                                                <div class="input-field">
                                                                    <input class="auto_calculate" id="r{{ $i }}_{{ $student->id }}" data-id="{{ $student->id }}" type="text" name="r{{ $i }}_{{ $student->id }}" placeholder="R{{ $i }}" value="{{ old('r'.$i.'_'.$student->id) }}">
                                                                    @error('r'.$i.'_'.$student->id)
                                                                        <div class="error">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td style="border: 1px solid">
                                                                <div class="input-field">
                                                                    <input type="hidden" name="n{{ $i }}_{{ $student->id }}" value="{{ old('n'.$i.'_'.$student->id) }}">
                                                                    <input id="n{{ $i }}_{{ $student->id }}" type="text" name="n{{ $i }}_{{ $student->id }}" placeholder="N{{ $i }}" value="{{ old('n'.$i.'_'.$student->id) }}" disabled>
                                                                </div>
                                                            </td>
                                                        @endfor
                                                        <td style="border: 1px solid">
                                                            <div class="input-field">
                                                                <input type="hidden" name="avg_ph{{ $student->id }}" value="{{ old('avg_ph'.$student->id) }}">
                                                                <input id="avg_ph{{ $student->id }}" type="text" name="avg_ph{{ $student->id }}" placeholder="Rata PH" value="{{ old('avg_ph'.$student->id) }}" disabled>
                                                            </div>
                                                        </td>
                                                        <td style="border: 1px solid">
                                                            <div class="input-field">
                                                                <input class="auto_npa" id="pts{{ $student->id }}" data-id="{{ $student->id }}" type="text" name="pts{{ $student->id }}" placeholder="PTS" value="{{ old('pts'.$student->id) }}">
                                                                @error('pts{{ $student->id }}')
                                                                    <div class="error">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </td>
                                                        <td style="border: 1px solid">
                                                            <div class="input-field">
                                                                <input class="auto_npa" id="pas{{ $student->id }}" data-id="{{ $student->id }}" type="text" name="pas{{ $student->id }}" placeholder="PAS" value="{{ old('pas'.$student->id) }}">
                                                                @error('pas{{ $student->id }}')
                                                                    <div class="error">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </td>
                                                        <td style="border: 1px solid">
                                                            <div class="input-field">
                                                                <input type="hidden" name="npa{{ $student->id }}">
                                                                <input id="npa{{ $student->id }}" type="text" name="npa{{ $student->id }}" placeholder="NPA" value="" disabled>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
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
                                <table id="" class="responsive-table" style="width:100%; border: 1px solid">
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
                                                    <td style="border: 1px solid">{{ $report->student->nis }}</td>
                                                    <td style="border: 1px solid">{{ $report->student->full_name }}</td>
                                                    @for ($i = 1; $i < 6; $i++)
                                                        <td style="border: 1px solid">
                                                            <div class="input-field">
                                                                <input class="auto_calculate" data-id="{{ $report->student_id }}" id="t{{ $i }}_{{ $report->student_id }}" type="text" name="t{{ $i }}_{{ $report->student_id }}" placeholder="T{{ $i }}" value="{{ old('t'.$i.'_'.$report->student_id, $report['t'.$i]) }}">
                                                                @error('t'.$i.'_'.$report->student_id)
                                                                    <div class="error">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </td>
                                                    @endfor
                                                    <td style="border: 1px solid">
                                                        <div class="input-field">
                                                            <input type="hidden" name="avg_t{{ $report->student_id }}" value="{{ old('avg_t'.$report->student_id, $report->avg_t) }}">
                                                            <input id="avg_t{{ $report->student_id }}" type="text" name="avg_t{{ $report->student_id }}" placeholder="Rata T" value="{{ old('avg_t'.$report->student_id, $report->avg_t) }}" disabled>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            @if ($students)
                                                @foreach ($students as $student)
                                                    <tr id="noedit" data-id="{{ $student->id }}">
                                                        <td style="border: 1px solid">{{ $student->nis }}</td>
                                                        <td style="border: 1px solid">{{ $student->full_name }}</td>
                                                        @for ($i = 1; $i < 6; $i++)
                                                            <td style="border: 1px solid">
                                                                <div class="input-field">
                                                                    <input class="auto_calculate" data-id="{{ $student->id }}" id="t{{ $i }}_{{ $student->id }}" type="text" name="t{{ $i }}_{{ $student->id }}" placeholder="T{{ $i }}" value="{{ old('t'.$i.'_'.$student->id) }}">
                                                                    @error('t'.$i.'_'.$student->id)
                                                                        <div class="error">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        @endfor
                                                        <td style="border: 1px solid">
                                                            <div class="input-field">
                                                                <input type="hidden" name="avg_t{{ $student->id }}" value="{{ old('avg_t'.$student->id) }}">
                                                                <input id="avg_t{{ $student->id }}" type="text" name="avg_t{{ $student->id }}" placeholder="Rata T" value="{{ old('avg_t'.$student->id) }}" disabled>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
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
                                
                                <table id="" class="responsive-table" style="width:100%; border: 1px solid">
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
                                                    <td style="border: 1px solid">{{ $report->student->nis }}</td>
                                                    <td style="border: 1px solid">{{ $report->student->full_name }}</td>
                                                    @for ($i = 1; $i < 6; $i++)
                                                        <td style="border: 1px solid">
                                                            <div class="input-field">
                                                                <input class="auto_calculate" data-id="{{ $report->student_id }}" id="k{{ $i }}_{{ $report->student_id }}" type="text" name="k{{ $i }}_{{ $report->student_id }}" placeholder="K{{ $i }}" value="{{ old('k'.$i.'_'.$report->student_id, $report['k'.$i]) }}">
                                                                @error('k'.$i.'_'.$report->student_id)
                                                                    <div class="error">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </td>
                                                    @endfor
                                                    <td style="border: 1px solid">
                                                        <div class="input-field">
                                                            <input type="hidden" name="avg_k{{ $report->student_id }}" value="{{ old('avg_k'.$report->student_id, $report->avg_k) }}">
                                                            <input id="avg_k{{ $report->student_id }}" type="text" name="avg_k{{ $report->student_id }}" placeholder="Rata K" value="{{ old('avg_k'.$report->student_id, $report->avg_k) }}" disabled>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            @if ($students)
                                                @foreach ($students as $student)
                                                    <tr id="noedit" data-id="{{ $student->id }}">
                                                        <td style="border: 1px solid">{{ $student->nis }}</td>
                                                        <td style="border: 1px solid">{{ $student->full_name }}</td>
                                                        @for ($i = 1; $i < 6; $i++)
                                                            <td style="border: 1px solid">
                                                                <div class="input-field">
                                                                    <input class="auto_calculate" data-id="{{ $student->id }}" id="k{{ $i }}_{{ $student->id }}" type="text" name="k{{ $i }}_{{ $student->id }}" placeholder="K{{ $i }}" value="{{ old('k'.$i.'_'.$student->id) }}">
                                                                    @error('k'.$i.'_'.$student->id)
                                                                        <div class="error">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        @endfor
                                                        <td style="border: 1px solid">
                                                            <div class="input-field">
                                                                <input type="hidden" name="avg_k{{ $student->id }}" value="{{ old('avg_k'.$student->id) }}">
                                                                <input id="avg_k{{ $student->id }}" type="text" name="avg_k{{ $student->id }}" placeholder="Rata K" value="{{ old('avg_k'.$student->id) }}" disabled>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
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