<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/images/favicon.png') }}">
    <title>@yield('title') | SIAKAD SMP</title>
    <!-- chartist CSS -->
    <link href="{{ asset('/libs/chartist/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css') }}" rel="stylesheet">
    <link href="{{ asset('/dist/css/style.css') }}" rel="stylesheet">
    <!-- This page CSS -->
    @yield('styles')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="main-wrapper" id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="loader">
                <div class="loader__figure"></div>
                <p class="loader__label">Mohon Tunggu...</p>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        @include('layouts.header')
        <!-- ============================================================== -->
        <!-- Sidebar scss in sidebar.scss -->
        <!-- ============================================================== -->
        @include('layouts.navbar')
        <!-- ============================================================== -->
        <!-- Sidebar scss in sidebar.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper scss in scafholding.scss -->
        <!-- ============================================================== -->
        @yield('content')
        <!-- ============================================================== -->
        <!-- Container fluid scss in scafholding.scss -->
        <!-- ============================================================== -->
        <footer class="center-align m-b-30">Hak Cipta Milik <a href="https://mraisenodni.github.io/">Safira</a>.</footer>
    </div>
        @yield('sidebar')
    </div>
    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <script src="{{ asset('/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('/dist/js/materialize.min.js') }}"></script>
    <script src="{{ asset('/libs/perfect-scrollbar/dist/js/perfect-scrollbar.jquery.min.js') }}"></script>
    <!-- ============================================================== -->
    <!-- Apps -->
    <!-- ============================================================== -->
    <script src="{{ asset('/dist/js/app.js') }}"></script>
    <script src="{{ asset('/dist/js/app.init.js') }}"></script>
    <script src="{{ asset('/dist/js/app-style-switcher.js') }}"></script>
    <!-- ============================================================== -->
    <!-- Custom js -->
    <!-- ============================================================== -->
    <script src="{{ asset('/dist/js/custom.js') }}"></script>
    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    @yield('scripts')
</body>

</html>