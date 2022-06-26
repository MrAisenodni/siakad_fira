<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/images/logo-smp-nobg.png') }}">
    <title>500 | Internal Server Error</title>
    <link href="{{ asset('/dist/css/style.css') }}" rel="stylesheet">
    <!-- This page CSS -->
    <link href="{{ asset('/dist/css/pages/error-pages.css') }}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <section id="wrapper" class="error-page">
        <div class="error-box">
            <div class="error-body center-align">
                <h1>404</h1>
                <h3>Internal Server Error!</h3>
                <p class="m-t-30 m-b-30">Sepertinya ada kesalahan pada server.</p>
                <a href="{{ url()->previous() }}" class="btn btn-round red waves-effect waves-light m-b-40">Kembali</a>
            </div>
        </div>
    </section>
    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <script src="{{ asset('/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('/dist/js/materialize.min.js') }}"></script>
</body>

</html>