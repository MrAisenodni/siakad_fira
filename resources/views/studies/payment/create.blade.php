@extends('layouts.main')

@section('title', $menu->title)

@section('styles')
    {{-- Select2 --}}
    <link href="{{ asset('/libs/select2/dist/css/select2.css') }}" rel="stylesheet">

    {{-- Data Tables --}}
    <link href="{{ asset('/dist/css/pages/data-table.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col s8">
                <div class="card">
                    <div class="card-content">
                        <h5 class="card-title">Daftar Siswa</h5>
                        <table id="zero_config" class="responsive-table display" style="width:100%" onload="message()">
                            <thead>
                                <tr>
                                    <th>NIS</th>
                                    <th>Nama Lengkap</th>
                                    <th>Kelas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($students)
                                    @foreach ($students as $student)
                                        <tr id="data_select" data-id="{{ $student->id }}" data-select="">
                                            <td>{{ $student->nis }}</td>
                                            <td>{{ $student->full_name }}</td>
                                            <td>{{ $student->class->class->name }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col s4">
                <div class="card">
                    <div class="card-content">
                        <h5 class="card-title">Tambah {{ $menu->title }}</h5>
                        <form method="POST" action="{{ str_replace("/create", "", $menu->url) }}">
                            @csrf
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="student" type="hidden" name="student" value="{{ old('student') }}" readonly>
                                    <input id="nis" type="text" placeholder="0" name="nis" value="{{ old('nis') }}" readonly>
                                    <label for="nis">NIS</label>
                                    @error('nis')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s12">
                                    <input id="full_name" type="text" placeholder="Nama" name="full_name" value="{{ old('full_name') }}" readonly>
                                    <label for="full_name">Nama Siswa</label>
                                    @error('full_name')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s12">
                                    <input id="clas" type="text" placeholder="10" name="clas" value="{{ old('clas') }}" readonly>
                                    <label for="clas">Kelas</label>
                                    @error('clas')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <select id="payment" name="payment" class="auto_fill">
                                        <option value="" selected>--- SILAHKAN PILIH ---</option>
                                        @if ($payments)
                                            @foreach ($payments as $payment)
                                                <option @if(old('payment') == $payment->id) selected @endif value="{{ $payment->id }}">{{ $payment->year }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="payment">Tahun</label>
                                    @error('payment')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s12">
                                    <select id="month" name="month">
                                        @if ($months)
                                            @foreach ($months as $month)
                                                <option @if(old('month') == $month->id) selected @endif value="{{ $month->id }}">{{ $month->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="month">Bulan</label>
                                    @error('month')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s12">
                                    <input id="year" type="hidden" name="year" value="{{ old('year') }}" readonly>
                                    <input id="amount" type="text" placeholder="Rp 2.000.000" name="amount" value="{{ old('amount') }}" readonly>
                                    <label for="amount">Nominal</label>
                                    @error('amount')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col s12" style="text-align: right">
                                    <a class="waves-effect waves-light btn btn-round blue strong" href="{{ $menu->url }}">KEMBALI</a>
                                    <button class="waves-effect waves-light btn btn-round green strong" type="submit">BAYAR</button>
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
    {{-- Select2 --}}
    <script src="{{ asset('/libs/select2/dist/js/select2.min.js') }}"></script>

    {{-- Data Tables --}}
    <script src="{{ asset('/extra-libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/dist/js/pages/datatable/datatable-basic.init.js') }}"></script>

    {{-- Form --}}
    <script src="{{ asset('/dist/js/form.js') }}"></script>
    @include('scripts.select2')
@endsection