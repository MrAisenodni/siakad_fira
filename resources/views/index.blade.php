@extends('layouts.main')

@section('title', $menu->title)

@section('styles')
    <link href="{{ asset('/dist/css/pages/dashboard1.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Title and breadcrumb -->
    <!-- ============================================================== -->
    
    <!-- ============================================================== -->
    <!-- Container fluid scss in scafholding.scss -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Family School Summery -->
        <!-- ============================================================== -->
        @if (session()->get('srole') == 'teacher' || session()->get('srole') == 'admin')
        <div class="row">
            <div class="col l3 m6 s12">
                <div class="card danger-gradient card-hover">
                    <div class="card-content">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h2 class="white-text m-b-5">
                                    @if ($cf_student)
                                        {{ $cf_student }}/{{ $c_student }}
                                    @else
                                        0/{{ $c_student }}
                                    @endif
                                </h2>
                                <h6 class="white-text op-5 light-blue-text">Siswa Perempuan</h6>
                            </div>
                            <div class="ml-auto">
                                <span class="white-text display-6"><i class="material-icons">face</i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col l3 m6 s12">
                <div class="card info-gradient card-hover">
                    <div class="card-content">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h2 class="white-text m-b-5">
                                    @if ($cm_student)
                                        {{ $cm_student }}/{{ $c_student }}
                                    @else
                                        0/{{ $c_student }}
                                    @endif
                                </h2>
                                <h6 class="white-text op-5">Siswa Laki-Laki</h6>
                            </div>
                            <div class="ml-auto">
                                <span class="white-text display-6"><i class="material-icons">person</i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             
            <div class="col l3 m6 s12">
                <div class="card warning-gradient card-hover">
                    <div class="card-content">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h2 class="white-text m-b-5">
                                    @if ($cf_teacher)
                                        {{ $cf_teacher }}/{{ $c_teacher }}
                                    @else
                                        0/{{ $c_teacher }}
                                    @endif
                                </h2>
                                <h6 class="white-text op-5 text-darken-2">Guru Perempuan</h6>
                            </div>
                            <div class="ml-auto">
                                <span class="white-text display-6"><i class="material-icons">face</i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col l3 m6 s12">
                <div class="card success-gradient card-hover">
                    <div class="card-content">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h2 class="white-text m-b-5">
                                    @if ($cm_teacher)
                                        {{ $cm_teacher }}/{{ $c_teacher }}
                                    @else
                                        0/{{ $c_teacher }}
                                    @endif
                                </h2>
                                <h6 class="white-text op-5">Guru Laki-Laki</h6>
                            </div>
                            <div class="ml-auto">
                                <span class="white-text display-6"><i class="material-icons">person</i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        <!-- ============================================================== -->
        <!-- Payment Student Summery -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col l3 m6 s12">
                <div class="card danger-gradient card-hover">
                    <div class="card-content">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h2 class="white-text m-b-5">
                                    @if ($c_blunas)
                                        {{ $c_blunas }}/{{ $c_payment }}
                                    @else
                                        @if ($c_payment)
                                            0/{{ $c_payment }}
                                        @else
                                            0/0
                                        @endif
                                    @endif
                                </h2>
                                <h6 class="white-text op-5 light-blue-text">SPP Belum Lunas</h6>
                            </div>
                            <div class="ml-auto">
                                <span class="white-text display-6"><i class="material-icons">remove_circle_outline</i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col l3 m6 s12">
                <div class="card warning-gradient card-hover">
                    <div class="card-content">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h2 class="white-text m-b-5">
                                    @if ($c_lunas)
                                        {{ $c_lunas }}/{{ $c_payment }}
                                    @else
                                        @if ($c_payment)
                                            0/{{ $c_payment }}
                                        @else
                                            0/0
                                        @endif
                                    @endif
                                </h2>
                                <h6 class="white-text op-5">SPP Lunas</h6>
                            </div>
                            <div class="ml-auto">
                                <span class="white-text display-6"><i class="material-icons">add_circle_outline</i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             
            <div class="col l6 m6 s12">
                <div class="card success-gradient card-hover">
                    <div class="card-content">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h2 class="white-text m-b-5">
                                    @if ($s_lunas->total != null)
                                        Rp {{ number_format($s_lunas->total, 0, ',', '.') }},-
                                    @else
                                        Rp 0,-
                                    @endif
                                </h2>
                                @if (session()->get('srole') == 'teacher' || session()->get('srole') == 'admin')
                                    <h6 class="white-text op-5 text-darken-2">Total Pemasukan SPP</h6>
                                @else
                                    <h6 class="white-text op-5 text-darken-2">Total SPP Belum Lunas</h6>
                                @endif
                            </div>
                            <div class="ml-auto">
                                <span class="white-text display-6"><i class="material-icons">receipt</i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col l12 m12 s12">
                <div class="card">
                    <div class="card-content">
                        <h4 class="card-title">Berita Terbaru</h4>
                        <ul class="search-listing">
                            @if ($articles)
                                @foreach ($articles as $article)
                                    <li>
                                        <h4><a 
                                            @if (session()->get('srole') == 'admin')
                                                href="/studi/pengumuman/{{ $article->id }}/edit"
                                            @else
                                                href="/studi/pengumuman/{{ $article->id }}"
                                            @endif
                                        >{{ $article->title }}</a></h4>
                                        <a class="search-links"
                                            @if (session()->get('srole') == 'admin')
                                                href="/studi/pengumuman/{{ $article->id }}/edit"
                                            @else
                                                href="/studi/pengumuman/{{ $article->id }}"
                                            @endif
                                        >{{ $article->category->name }}</a>
                                        <p>{!! $article->description !!}</p>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                        {{-- <ul class="pagination m-t-20">
                            <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
                            @if ($articles)
                                @for ($i = 1; $i <= $articles->count()/5; $i++)
                                    <li class="active"><a href="{{ url()->current() }}?page=">1</a></li>
                                    <li class="waves-effect"><a href="{{ url()->current() }}?page={{ $i }}">{{ $i }}</a></li>
                                @endfor
                            @endif
                            <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
                        </ul> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('/libs/chartist/dist/chartist.min.js') }}"></script>
    <script src="{{ asset('/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}"></script>
    <script src="{{ asset('/extra-libs/sparkline/sparkline.js') }}"></script>
    <script src="{{ asset('/dist/js/pages/dashboards/dashboard1.js') }}"></script>
@endsection