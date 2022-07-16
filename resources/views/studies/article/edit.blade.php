@extends('layouts.main')

@section('title', $menu->title)

@section('styles')
    {{-- Prism --}}
    <link href="{{ asset('/extra-libs/prism/prism.css') }}" rel="stylesheet">
    
    {{-- Select2 --}}
    <link href="{{ asset('/libs/select2/dist/css/select2.css') }}" rel="stylesheet">
    
    {{-- Datepicker --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('/libs/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">
@endsection

@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <h5 class="card-title">Ubah {{ $menu->title }}</h5>
                        @if (session('status'))
                            <div class="success-alert-bar p-15 m-t-10 m-b-10 red white-text" style="display: block">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ str_replace("/edit", "", url()->current()) }}" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <input type="hidden" name="old_photo" value="{{ $article->photo }}">
                            <div class="row">
                                <div class="input-field col s6">
                                    <input id="title" type="text" placeholder="Jadwal UTS" name="title" value="{{ old('title', $article->title) }}">
                                    <label for="title">Judul <span class="materialize-red-text">*</span></label>
                                    @error('title')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s3">
                                    <select id="category" name="category" class="disabled select2">
                                        <option value="" selected>--- SILAHKAN PILIH ---</option>
                                        @if ($categories)
                                            @foreach ($categories as $category)
                                                <option @if(old('category', $article->category_id) == $category->id) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="category" class="active">Kategori <span class="materialize-red-text">*</span></label>
                                    @error('category')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s3">
                                    <select id="tag" name="tag" class="disabled select2">
                                        <option value="" selected>--- SILAHKAN PILIH ---</option>
                                        @if ($tags)
                                            @foreach ($tags as $tag)
                                                <option @if(old('tag', $article->tag_id) == $tag->id) selected @endif value="{{ $tag->id }}">{{ $tag->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="tag" class="active">Tag</label>
                                    @error('tag')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s12">
                                    <p>Deskripsi <span class="materialize-red-text">*</span></p>
                                    <textarea id="mymce" name="description">{!! old('description', $article->description) !!}</textarea>
                                    @error('description')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col s12" style="text-align: center">
                                        <img class="img-preview img-fluid" alt="Foto Profil" style="max-width: 100%; max-height: 50px" @if ($article->photo) src="{{ asset($article->photo) }}" @endif>
                                    </div>
                                </div>
                                <div class="file-field input-field col s12">
                                    <div class="btn">
                                        <span>Unggah Foto</span>
                                        <input type="file" name="photo" id="photo" value="{{ old('photo', $article->photo) }}">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text">
                                    </div>
                                    @error('photo')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s6">
                                    <select id="status" name="status" class="">
                                        <option @if(old('status', $article->status) == 'new') selected @endif value="new" selected>Baru</option>
                                        <option @if(old('status', $article->status) == 'publish') selected @endif value="publish">Terbit</option>
                                        <option @if(old('status', $article->status) == 'draft') selected @endif value="draft">Arsip</option>
                                    </select>
                                    <label for="status">Status</label>
                                    @error('status')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-field col s6">
                                    <input id="author" type="text" placeholder="Safira" name="author" value="{{ old('author', $article->author) }}">
                                    <label for="author">Penulis <span class="materialize-red-text">*</span></label>
                                    @error('author')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col s12" style="text-align: right">
                                    <a class="waves-effect waves-light btn btn-round blue strong" href="{{ $menu->url }}">KEMBALI</a>
                                    <button class="waves-effect waves-light btn btn-round green strong" type="submit">SIMPAN</button>
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
    {{-- Prism --}}
    <script src="{{ asset('/extra-libs/prism/prism.js') }}"></script>
    
    {{-- Select2 --}}
    <script src="{{ asset('/libs/select2/dist/js/select2.min.js') }}"></script>

    {{-- Datepicker --}}
    <script src="{{ asset('/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('/libs/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker-custom.js') }}"></script>
    
    {{-- Tinymce --}}
    <script src="{{ asset('/libs/tinymce/tinymce.min.js') }}"></script>
    
    {{-- Form --}}
    <script src="{{ asset('/dist/js/form.js') }}"></script>
    @include('scripts.tinymce')
    @include('scripts.datepicker')
    @include('scripts.select2')
@endsection