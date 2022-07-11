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
                {{-- Card For Filter --}}
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s12">
                                <h5 class="card-title">Kelola {{ $menu->title }}</h5>
                            </div>
                        </div>
                        <form action="{{ url()->current() }}" method="GET">
                            <div class="row">
                                <div class="input-field col s4">
                                    <select id="month" name="month" class="">
                                        <option value="" selected>SEMUA</option>
                                        @if ($months)
                                            @foreach ($months as $month)
                                                <option @if(old('month', $inp_month) == $month->id) selected @endif value="{{ $month->id }}">{{ $month->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="month">Bulan</label>
                                    @error('month')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s4">
                                    <select id="year" name="year" class="">
                                        <option value="" selected>SEMUA</option>
                                        @for ($i = date('Y', strtotime(now())); $i >= 1700; $i--)
                                            <option @if(old('year', $inp_year) == $i) selected @endif value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                    <label for="year">Tahun</label>
                                    @error('year')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s4">
                                    <select id="clazz" name="clazz" class="">
                                        <option value="" selected>SEMUA</option>
                                        @if ($classes)
                                            @foreach ($classes as $clazz)
                                                <option @if(old('clazz', $inp_clazz) == $clazz->id) selected @endif value="{{ $clazz->id }}">{{ $clazz->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="clazz">Kelas</label>
                                    @error('clazz')
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

                {{-- Card For Table --}}
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s6">
                                <h5 class="card-title">Daftar Siswa</h5>
                            </div>
                            <div class="col s6 right-align">
                                <a class="waves-effect waves-light btn btn-round primary strong" href="/cetak/spp?month={{ $inp_month }}&year={{ $inp_year }}&clazz={{ $inp_clazz }}"><i class="material-icons">print</i></a>
                                <a class="waves-effect waves-light btn btn-round blue strong" href="{{ $menu->url }}/create-tagihan">GENERATE TAGIHAN</a>
                                <a class="waves-effect waves-light btn btn-round green strong" href="{{ $menu->url }}/create">TAMBAH</a>
                            </div>
                            @if (session('error'))
                                <div class="col s12">
                                    <div class="success-alert-bar p-15 m-t-10 red white-text" style="display: block">
                                        {{ session('error') }}
                                    </div>
                                </div>
                            @endif
                            @if (session('status'))
                                <div class="col s12">
                                    <div class="success-alert-bar p-15 m-t-10 green white-text" style="display: block">
                                        {{ session('status') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <table id="listpayment_config" class="responsive-table display" style="width:100%" onload="message()">
                            <thead>
                                <tr>
                                    <th>NIS</th>
                                    <th>Nama Lengkap</th>
                                    <th>Kelas</th>
                                    <th>Tahun</th>
                                    <th>Bulan</th>
                                    <th>Nomor HP</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($payments)
                                    @foreach ($payments as $payment)
                                        <tr id="data" data-id="{{ $payment->id }}">
                                            <td>{{ $payment->student->nis }}</td>
                                            <td>{{ $payment->student->full_name }}</td>
                                            <td>{{ $payment->class->name }}</td>
                                            <td>{{ $payment->year }}</td>
                                            <td>
                                                @if ($months)
                                                    @foreach ($months as $month)
                                                        @if ($payment->month == $month->id) {{ $month->name }} @endif
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>{{ $payment->student->phone_number }}</td>
                                            <td>
                                                @if ($payment->status == 'belum')
                                                    <button class="waves-effect waves-light btn btn-round red strong" type="button">BELUM LUNAS</button>
                                                @else
                                                    <button class="waves-effect waves-light btn btn-round green strong" type="button">SUDAH LUNAS</button>
                                                @endif
                                            </td>
                                            <td id="no-data">
                                                <form action="/what" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="full_name" value="{{ $payment->student->full_name }}">
                                                    <input type="hidden" name="month" value="@if ($months)
                                                        @foreach ($months as $month)
                                                            @if ($payment->month == $month->id) {{ $month->name }} @endif
                                                        @endforeach
                                                    @endif">
                                                    <input type="hidden" name="year" value="{{ $payment->year }}">
                                                    <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                                                    <input type="hidden" name="phone_number" value="{{ $payment->student->phone_number }}">
                                                    <button class="btn btn-round primary strong" type="submit" @if ($payment->push_wa == 1 || $payment->status == 'lunas') disabled @endif><i class="material-icons">send</i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        {{-- <table id="zero_config" class="responsive-table display" style="width:100%" onload="message()">
                            <thead>
                                <tr>
                                    <th>NIS</th>
                                    <th>Nama Lengkap</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($payments)
                                    @foreach ($payments as $payment)
                                        <tr id="data" data-id="{{ $payment->id }}">
                                            <td>{{ $payment->student->nis }}</td>
                                            <td>{{ $payment->student->full_name }}</td>
                                            <td>
                                                @if ($payment->status == 'lunas')
                                                    <button class="waves-effect waves-light btn btn-round green strong" type="button">LUNAS</button>
                                                @else
                                                    <button class="waves-effect waves-light btn btn-round red strong" type="button">BELUM LUNAS</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table> --}}
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
    <script src="{{ asset('/extra-libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/dist/js/pages/datatable/datatable-basic.init.js') }}"></script>
    
    {{-- Form --}}
    <script src="{{ asset('/dist/js/form.js') }}"></script>
    @include('scripts.select2')
@endsection