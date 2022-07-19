@extends('layouts.main')

@section('title', $menu->title)

@section('styles')
    {{-- Prism --}}
    <link href="{{ asset('/extra-libs/prism/prism.css') }}" rel="stylesheet">
    
    {{-- Select2 --}}
    <link href="{{ asset('/libs/select2/dist/css/select2.css') }}" rel="stylesheet">
    
    {{-- Datepicker --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('/libs/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">

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
                        <div class="row">
                            <div class="col s6">
                                <h5 class="card-title">History {{ $menu->title }}</h5>
                            </div>
                            <div class="col s6 right-align">
                                <a class="waves-effect waves-light btn btn-round green strong btn modal-trigger" href="#create">TAMBAH</a>
                                {{-- <a class="waves-effect waves-light btn btn-round green strong" href="{{ $menu->url }}/create">TAMBAH</a> --}}
                            </div>
                        </div>
                        <div class="row">
                            @if (session('status'))
                                <div class="col s12">
                                    <div class="success-alert-bar p-15 m-t-10 green white-text" style="display: block">
                                        {{ session('status') }}
                                    </div>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="col s12">
                                    <div class="success-alert-bar p-15 m-t-10 red white-text" style="display: block">
                                        {{ session('error') }}
                                    </div>
                                </div>
                            @endif
                            <div class="col s12">
                                <table id="zero_config" class="responsive-table display" style="width:100%" onload="message()">
                                    <thead>
                                        <tr>
                                            <th>Tahun</th>
                                            <th>Bulan</th>
                                            <th>Nominal</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($paystuds)
                                            @foreach ($paystuds as $pay)
                                                <tr id="data" data-url="{{ $menu->url }}/{{ $pay->id }}/edit" data-id="{{ $pay->id }}" @if($payment->id == $pay->id) class="blue white-text" @endif>
                                                    <td>{{ $pay->year }}</td>
                                                    <td>
                                                        @if ($months)
                                                            @foreach ($months as $month)
                                                                @if ($pay->month == $month->id)
                                                                    {{ $month->name }}
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>{{ 'Rp '.number_format($pay->amount, 0, ',', '.') }}</td>
                                                    <td>
                                                        @if ($pay->status == 'lunas')
                                                            <button class="waves-effect waves-light btn btn-round green strong" type="button">LUNAS</button>
                                                        @else
                                                            <button class="waves-effect waves-light btn btn-round red strong" type="button">BELUM LUNAS</button>
                                                        @endif    
                                                    </td>
                                                    <td id="no-data" class="text-center" style="width: 5%">
                                                        <form action="{{ $menu->url }}/{{ $pay->id }}" method="POST" class="d-inline">
                                                            @method('delete')
                                                            @csrf
                                                            <input type="hidden" name="student" value="{{ $pay->student_id }}">
                                                            <button type="submit" class="transparent fas fa-trash @if($payment->id == $pay->id) white-text @else materialize-red-text @endif" style="border: 0px"></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col s4">
                <div class="card">
                    <div class="card-content">
                        <h5 class="card-title">Ubah {{ $menu->title }}</h5>
                        <form method="POST" action="{{ str_replace("/edit", "", url()->current()) }}">
                            @method('put')
                            @csrf
                            <input type="hidden" name="student" value="{{ $payment->student_id }}">
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="nis" type="text" placeholder="10" name="NIS" value="{{ old('nis', $payment->student->nis) }}" readonly>
                                    <label for="nis">NIS</label>
                                    @error('nis')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="full_name" type="text" placeholder="10" name="Nama Siswa" value="{{ old('full_name', $payment->student->full_name) }}" readonly>
                                    <label for="full_name">Nama Siswa</label>
                                    @error('full_name')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="hidden" name="clazz" value="{{ $payment->class->id }}">
                                    <input id="clas" type="text" placeholder="10" name="clas" value="{{ old('clas', $payment->student->class->class->name) }}" readonly>
                                    <label for="clas">Kelas</label>
                                    @error('clas')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <select id="payment" name="payment" class="auto_fill disabled select2">
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
                                    <select id="month" name="month" class="disabled select2">
                                        @if ($months)
                                            @foreach ($months as $month)
                                                <option @if(old('month', $payment->month) == $month->id) selected @endif value="{{ $month->id }}">{{ $month->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="month" class="active">Bulan</label>
                                    @error('month')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s12">
                                    <input id="due_date" class="datepicker" type="text" placeholder="dd/mm/yyyy" name="due_date" 
                                        @if ($payment->due_date)
                                            value="{{ old('due_date', date('d/m/Y', strtotime($payment->due_date))) }}"
                                        @else
                                            value="{{ old('due_date') }}"
                                        @endif
                                    >
                                    <label for="due_date">Tanggal Pelunasan</label>
                                    @error('due_date')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s12">
                                    <input id="year" type="hidden" name="year" value="{{ old('year', $payment->payment->year) }}" readonly>
                                    <input id="amount" type="text" name="amount" value="{{ old('amount', 'Rp '.number_format($payment->payment->amount, 0, ',', '.')) }}" readonly>
                                    <label for="amount">Nominal</label>
                                    @error('amount')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s12">
                                    <select id="status" name="status" class="">
                                        <option @if(old('status', $payment->status) == 'lunas') selected @endif value="lunas">Lunas</option>
                                        <option @if(old('status', $payment->status) == 'belum') selected @endif value="belum">Belum Linas</option>
                                    </select>
                                    <label for="status">Status</label>
                                    @error('status')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col s12" style="text-align: right">
                                    <a class="waves-effect waves-light btn btn-round blue strong" href="{{ $menu->url }}">KEMBALI</a>
                                    <button class="waves-effect waves-light btn btn-round green strong" type="submit">BAYAR</button>
                                </form>
                                {{-- Testing Whatsapp --}}
                                <form action="/what" method="POST" style="display: none">
                                    @csrf
                                    <input type="hidden" name="phone_number" value="{{ $payment->student->phone_number }}">
                                    <button class="waves-effect waves-light btn btn-round primary strong" type="submit">PUSH</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="create" class="modal">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s12">
                                <h5 class="card-title">Tambah {{ $menu->title }}</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <form method="POST" action="{{ str_replace("/create", "", $menu->url) }}">
                                    @csrf
                                    <div class="row">
                                        <input type="hidden" name="uid" id="url_id" value="{{ $payment->id }}">
                                        <input type="hidden" name="mod_student" id="mod_student" value="{{ $payment->student_id }}">
                                        <input type="hidden" name="mod_clazz" id="mod_clazz" value="{{ $payment->class->id }}">
                                        <div class="input-field col s12">
                                            <select id="mod_payment" name="mod_payment" class="modal_auto_fill">
                                                <option value="" selected>--- SILAHKAN PILIH ---</option>
                                                @if ($payments)
                                                    @foreach ($payments as $payment)
                                                        <option @if(old('mod_payment') == $payment->id) selected @endif value="{{ $payment->id }}">{{ $payment->year }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <label for="mod_payment">Tahun</label>
                                            @error('mod_payment')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s12">
                                            <select id="mod_month" name="mod_month" class="">
                                                @if ($months)
                                                    @foreach ($months as $month)
                                                        <option @if(old('mod_month') == $month->id) selected @endif value="{{ $month->id }}">{{ $month->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <label for="mod_month" class="active">Bulan</label>
                                            @error('mod_month')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s12">
                                            <input id="mod_due_date" class="datepicker" type="text" placeholder="dd/mm/yyyy" name="mod_due_date" 
                                                @if ($payment->due_date)
                                                    value="{{ old('mod_due_date', date('d/m/Y', strtotime($payment->due_date))) }}"
                                                @else
                                                    value="{{ old('mod_due_date') }}"
                                                @endif
                                            >
                                            <label for="mod_due_date">Tanggal Pelunasan</label>
                                            @error('mod_due_date')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s12">
                                            <input id="mod_year" type="hidden" name="mod_year" value="{{ old('mod_year') }}" readonly>
                                            <input id="mod_amount" type="text" placeholder="Rp 2.000.000" name="mod_amount" value="{{ old('mod_amount') }}" readonly>
                                            <label for="mod_amount">Nominal</label>
                                            @error('mod_amount')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="input-field col s12">
                                            <select id="mod_status" name="mod_status" class="">
                                                <option @if(old('mod_status', $payment->status) == 'lunas') selected @endif value="lunas">Lunas</option>
                                                <option @if(old('mod_status', $payment->status) == 'belum') selected @endif value="belum">Belum Linas</option>
                                            </select>
                                            <label for="mod_status">Status</label>
                                            @error('mod_status')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                        
                                    <hr>
                                    <div class="row">
                                        <div class="col s12" style="text-align: right">
                                            <a href="#!" class="modal-action modal-close btn btn-round blue strong">TUTUP</a>
                                            {{-- <a class="waves-effect waves-light btn btn-round blue strong" href="{{ $menu->url }}">TUTUP</a> --}}
                                            <button class="waves-effect waves-light btn btn-round green strong" type="submit">BAYAR</button>
                                        </div>
                                    </div>
                                </form>                        
                            </div>
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
    
    {{-- Datepicker --}}
    <script src="{{ asset('/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('/libs/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker-custom.js') }}"></script>

    {{-- Data Tables --}}
    <script src="{{ asset('/extra-libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/dist/js/pages/datatable/datatable-basic.init.js') }}"></script>

    {{-- Form --}}
    <script src="{{ asset('/dist/js/form.js') }}"></script>
    @include('scripts.datepicker')
    @include('scripts.select2')
@endsection