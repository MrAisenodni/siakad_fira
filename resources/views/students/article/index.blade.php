@extends('layouts.main')

@section('title', $menu->title)

@section('styles')
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
                        <div class="row">
                            <div class="col s10">
                                <h5 class="card-title">Daftar {{ $menu->title }}</h5>
                            </div>
                        </div>
                        <table id="zero_config" class="responsive-table display" style="width:100%" onload="message()">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($articles)
                                    @foreach ($articles as $article)
                                        <tr id="show" data-id="{{ $article->id }}">
                                            <td>{{ $article->title }}</td>
                                            <td>{{ $article->category->name }}</td>
                                            <td>
                                                @if ($article->status == 'new')
                                                    <button class="waves-effect waves-light btn btn-round primary strong" type="button">BARU</button>
                                                @elseif ($article->status == 'publish')
                                                    <button class="waves-effect waves-light btn btn-round green strong" type="button">TERBIT</button>
                                                @else
                                                    <button class="waves-effect waves-light btn btn-round red strong" type="button">ARSIP</button>
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
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Data Tables --}}
    <script src="{{ asset('/extra-libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/dist/js/pages/datatable/datatable-basic.init.js') }}"></script>
@endsection