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
                        <h5 class="card-title">History Pembayaran SPP</h5>
                        <table id="zero_config" class="responsive-table display" style="width:100%" onload="message()">
                            <thead>
                                <tr>
                                    <th>Tahun</th>
                                    <th>Bulan</th>
                                    <th>Nominal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($paystuds)
                                    @foreach ($paystuds as $pay)
                                        <tr id="data_select" data-id="{{ $pay->id }}" @if($payment->id == $pay->id) data-select="{{ $pay->id }}" class="blue white-text" @endif>
                                            <td>{{ $pay->year }}</td>
                                            <td>{{ $pay->month }}</td>
                                            <td>{{ 'Rp '.number_format($pay->amount, 0, ',', '.') }}</td>
                                            <td>
                                                @if ($pay->status == 'lunas')
                                                    <button class="waves-effect waves-light btn btn-round green strong" type="button">LUNAS</button>
                                                @else
                                                    <button class="waves-effect waves-light btn btn-round red strong" type="button">BELUM LUNAS</button>
                                                @endif    
                                            </td>
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
                        <h5 class="card-title">Ubah {{ $menu->title }}</h5>
                        <form method="POST" action="{{ str_replace("/edit", "", url()->current()) }}">
                            @csrf
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="student" type="hidden" name="student" value="{{ old('student', $payment->student->id) }}" readonly>
                                    <input id="nis" type="text" placeholder="0" name="nis" value="{{ old('nis', $payment->student->nis) }}" readonly>
                                    <label for="nis">NIS</label>
                                    @error('nis')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s12">
                                    <input id="full_name" type="text" placeholder="Nama" name="full_name" value="{{ old('full_name', $payment->student->full_name) }}" readonly>
                                    <label for="full_name">Nama Siswa</label>
                                    @error('full_name')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s12">
                                    <input id="clas" type="text" placeholder="10" name="clas" value="{{ old('clas', $payment->student->class->class->name) }}" readonly>
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
                                            @foreach ($payments as $pay)
                                                <option @if(old('payment', $payment->payment_id) == $pay->id) selected @endif value="{{ $pay->id }}">{{ $pay->year }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="payment">Tahun</label>
                                    @error('payment')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s12">
                                    <select id="month" name="month" class="auto_fill">
                                        <option @if(old('month', $payment->month) == 1) selected @endif value="1" selected>Januari</option>
                                        <option @if(old('month', $payment->month) == 2) selected @endif value="2">Februari</option>
                                        <option @if(old('month', $payment->month) == 3) selected @endif value="3">Maret</option>
                                        <option @if(old('month', $payment->month) == 4) selected @endif value="4">April</option>
                                        <option @if(old('month', $payment->month) == 5) selected @endif value="5">Mei</option>
                                        <option @if(old('month', $payment->month) == 6) selected @endif value="6">Juni</option>
                                        <option @if(old('month', $payment->month) == 7) selected @endif value="7">Juli</option>
                                        <option @if(old('month', $payment->month) == 8) selected @endif value="8">Agustus</option>
                                        <option @if(old('month', $payment->month) == 9) selected @endif value="9">September</option>
                                        <option @if(old('month', $payment->month) == 10) selected @endif value="10">Oktober</option>
                                        <option @if(old('month', $payment->month) == 11) selected @endif value="11">November</option>
                                        <option @if(old('month', $payment->month) == 12) selected @endif value="12">Desember</option>
                                    </select>
                                    <label for="month">Bulan</label>
                                    @error('month')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s12">
                                    <input id="year" type="hidden" name="year" value="{{ old('year', $payment->year) }}" readonly>
                                    <input id="amount" type="text" name="amount" value="{{ old('amount', 'Rp '.number_format($payment->amount, 0, ',', '.')) }}" readonly>
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
    <script src="{{ asset('/extra-libs/Datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/dist/js/pages/datatable/datatable-basic.init.js') }}"></script>

    {{-- Form --}}
    <script src="{{ asset('/dist/js/form.js') }}"></script>
    @include('scripts.select2')
@endsection