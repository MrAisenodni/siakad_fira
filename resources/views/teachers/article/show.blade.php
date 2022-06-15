@extends('layouts.main')

@section('title', $menu->title)

@section('styles')
@endsection

@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <h5 class="card-title">Detail {{ $menu->title }}</h5>
                        <div class="row">
                            <div class="input-field col s6">
                                <input id="title" type="text" name="title" value="{{ old('title', $article->title) }}" disabled>
                                <label for="title">Judul</label>
                            </div>
                            <div class="input-field col s3">
                                <input id="category" type="text" name="category" value="{{ old('category', $article->category->name) }}" disabled>
                                <label for="category">Kategori</label>
                            </div>
                            <div class="input-field col s3">
                                <input id="tag" type="text" name="tag" value="@if ($article->tag_id) {{ $article->tag->name }} @else - @endif" disabled>
                                <label for="tag">Tag</label>
                            </div>
                            <div class="input-field col s12">
                                <p>Deskripsi</p>
                                <textarea id="mymce" name="description" disabled>{!! old('description', $article->description) !!}</textarea>
                            </div>
                            <div class="file-field input-field col s12">
                                <div class="btn">
                                    <span>Unggah Foto</span>
                                    <input type="file" name="photo" id="photo" value="{{ old('photo') }}" disabled>
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" disabled>
                                </div>
                            </div>
                            <div class="input-field col s12">
                                <input id="author" type="text" name="author" value="{{ old('author', $article->author) }}" disabled>
                                <label for="author">Penulis</label>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col s12" style="text-align: right">
                                <a class="waves-effect waves-light btn btn-round blue strong" href="{{ $menu->url }}">KEMBALI</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Tinymce --}}
    <script src="{{ asset('/libs/tinymce/tinymce.min.js') }}"></script>
    
    {{-- Form --}}
    <script src="{{ asset('/dist/js/form.js') }}"></script>
    @include('scripts.tinymce')
@endsection