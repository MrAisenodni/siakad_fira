<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/images/logo-smp-nobg.png') }}">
    <title>Login | SIAKAD SMP</title>
    <link href="{{ asset('/dist/css/style.css') }}" rel="stylesheet">
    <!-- This page CSS -->
    <link href="{{ asset('/dist/css/pages/authentication.css') }}" rel="stylesheet">
    <!-- This page CSS -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="main-wrapper">
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
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background:url(../../assets/images/big/auth-bg.jpg) no-repeat center center;">
            <div class="auth-box">
                <div id="loginform">
                    <div class="logo">
                        <span class="db"><img src="{{ asset('/images/logo-smp.png') }}" alt="logo" /></span>
                        <h5 class="font-medium m-b-20">Masuk ke SIAKAD SMP</h5>
                    </div>
                    <!-- Form -->
                    <div class="row">
                        @if (session('error'))
                            <div class="col s12 center">
                                <div class="error" style="display: block">
                                    {{ session('error') }}
                                </div>
                            </div>
                        @endif
                        @if (session('status'))
                            <div class="col s12 center">
                                <div class="green-text" style="display: block">
                                    {{ session('status') }}
                                </div>
                            </div>
                        @endif
                        <form class="col s12" action="/login" method="POST">
                            @csrf
                            <!-- email -->
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="username" type="text" class="validate" name="username" value="{{ old('username') }}">
                                    <label for="username">Nama Pengguna</label>
                                    @error('username')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- pwd -->
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="password" type="password" class="validate" name="password">
                                    <label for="password">Kata Sandi</label>
                                    @error('password')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- pwd -->
                            {{-- <div class="row m-t-5">
                                <div class="col s7">
                                    <label>
                                        <input type="checkbox" />
                                        <span>Remember Me?</span>
                                    </label>
                                </div>
                                <div class="col s5 right-align"><a href="#" class="link" id="to-recover">Forgot Pwd?</a></div>
                            </div> --}}
                            <!-- pwd -->
                            <div class="row m-t-40">
                                <div class="col s12">
                                    <button class="btn-large w100 blue accent-4" type="submit">Masuk</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    {{-- <div class="center-align m-t-20 db">
                        <a href="#" class="btn indigo darken-1 tooltipped m-r-5" data-position="top" data-tooltip="Login with Facebook"><i class="fab fa-facebook-f"></i></a> <a href="#" class="btn orange darken-4 tooltipped" data-position="top" data-tooltip="Login with Facebook"><i class="fab fa-google-plus-g"></i></a>
                    </div>
                    <div class="center-align m-t-20 db">
                        Don't have an account? <a href="authentication-register1.html">Sign Up!</a>
                    </div> --}}
                </div>
                {{-- <div id="recoverform">
                    <div class="logo">
                        <span class="db"><img src="../../assets/images/logo-icon.png" alt="logo" /></span>
                        <h5 class="font-medium m-b-20">Recover Password</h5>
                        <span>Enter your Email and instructions will be sent to you!</span>
                    </div>
                    <div class="row">
                        <!-- Form -->
                        <form class="col s12" action="index.html">
                            <!-- email -->
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="email1" type="email" class="validate" required>
                                    <label for="email1">Email</label>
                                </div>
                            </div>
                            <!-- pwd -->
                            <div class="row m-t-20">
                                <div class="col s12">
                                    <button class="btn-large w100 red" type="submit" name="action">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div> --}}
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper scss in scafholding.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper scss in scafholding.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right Sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right Sidebar -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <script src="{{ asset('/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('/dist/js/materialize.min.js') }}"></script>
    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    <script>
    $('.tooltipped').tooltip();
    // ============================================================== 
    // Login and Recover Password 
    // ============================================================== 
    $('#to-recover').on("click", function() {
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
    });
    $(function() {
        $(".preloader").fadeOut();
    });
    </script>
</body>

</html>