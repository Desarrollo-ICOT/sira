<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

                    @if (session('success'))

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        });

                        Toast.fire({
                            icon: 'success',
                            title: '{{ session('success') }}'
                        });
                    @endif

                    @if (session('error'))

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        });

                        Toast.fire({
                            icon: 'error',
                            title: '{{ session('error') }}'
                        });
                    @endif
        });
    </script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('assets/img/logo_icot.png') }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">

    <title>SIRA</title>

    @laravelPWA

</head>

<body>
    @include('sweetalert::alert')
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
    @yield('content')
</body>

</html>
