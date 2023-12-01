

<html>
<head>
    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="shortcut icon" href="{{ asset('assets/img/logo_icot.png') }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <title>SIRA</title>

</head>

<body>

    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">

    @section('sidebar')
        @if (!Auth::guest())
            
            <!-- /#wrapper -->
        @else
            @yield('content')
        @endif
    </body>

    </html>
