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
                                <h5 class="card-title">Kelola {{ $menu->title }}</h5>
                            </div>
                            <div class="col s2 right-align">
                                <a class="waves-effect waves-light btn btn-round green strong" href="{{ $menu->url }}/create">TAMBAH</a>
                            </div>
                            @if (session('status'))
                                <div class="col s12">
                                    <div class="success-alert-bar p-15 m-t-10 green white-text" style="display: block">
                                        {{ session('status') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <table id="zero_config" class="responsive-table display" style="width:100%" onload="message()">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($articles)
                                    @foreach ($articles as $article)
                                        <tr id="data" data-id="{{ $article->id }}">
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
                                            <td id="no-data" class="text-center" style="width: 5%">
                                                <form action="{{ $menu->url }}/{{ $article->id }}" method="POST" class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <input type="hidden" name="photo" value="{{ $article->photo }}">
                                                    <button type="submit" class="transparent fas fa-trash materialize-red-text" style="border: 0px"></button>
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
@endsection

@section('scripts')
    {{-- Data Tables --}}
    <script src="{{ asset('/extra-libs/Datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/dist/js/pages/datatable/datatable-basic.init.js') }}"></script>
@endsection