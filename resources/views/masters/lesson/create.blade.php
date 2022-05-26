@extends('layouts.main')

@section('title', $menu->title)

@section('styles')
    {{-- Prism --}}
    <link href="{{ asset('/extra-libs/prism/prism.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <h5 class="card-title">Tambah {{ $menu->title }}</h5>
                        <form method="POST" action="{{ str_replace("/create", "", $menu->url) }}">
                            @csrf
                            <div class="row">
                                <div class="input-field col s3">
                                    <input id="code" type="text" placeholder="Kode" name="code" value="{{ old('code') }}">
                                    <label for="code">Kode</label>
                                </div>
                            </div>
                            @error('code')
                                <div class="error">{{ $message }}</div>
                            @enderror
                            <div class="row">
                                <div class="input-field col s6">
                                    <input id="name" type="text" placeholder="Nama" name="name" value="{{ old('name') }}">
                                    <label for="name">Nama</label>
                                </div>
                            </div>
                            @error('name')
                                <div class="error">{{ $message }}</div>
                            @enderror
                            <div class="row">
                                <div class="input-field col s3">
                                    <input id="kkm" type=