<html>

<head>
  <!-- Scripts -->

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">


  <title>aREs</title>


</head>

<body>

<link href="{{ asset('css/welcome.css') }}" rel="stylesheet">

  @section('sidebar')
  @if (!Auth::guest())
  <div class="d-flex" id="wrapper">


    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="sidebar-heading"> <span class="font-weight-bold"><img src="{{ asset('assets/img/logo.png') }}" width="80PX" /> DieTTrack +</span> </div>
      <div class="list-group list-group-flush">
        <a id="menu_home" href="/home" class="list-group-item list-group-item-action bg-light"><i class="fa fa-home"></i> Inicio</a>
        <a id="menu_home" href="/residents" class="list-group-item list-group-item-action bg-light"><i class="fa fa-user"></i> Residentes</a>
        <a id="menu_trolleys" id="menu_trolleys" href="/trolleys" class="list-group-item list-group-item-action bg-light"><i class="fa fa-shopping-cart fa-fw"></i> Gestión de carros</a>
        <a id="menu_label" href="/label" class="list-group-item list-group-item-action bg-light"><i class="fa fa-print"></i> Impresión etiquetas</a>
        <a id="menu_history" href="/history" class="list-group-item list-group-item-action bg-light"><i class="fa fa-history"></i> Histórico</a>
        <a href="{{ route('residents.create') }}" id="btnAlta" class="btn btn-success btn-lg"> Alta residente</a>
        <a class="btn btn-danger btn-lg" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
          <i class="fa fa-power-off"></i> Cerrar sesión
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>

      </div>
    </div>

    <!-- /#sidebar-wrapper -->
    <!-- Page Content -->
    <div id="page-content-wrapper">
      <div class="container-fluid">
        <style>
          a.btn:hover {
            -webkit-transform: scale(1.1);
            -moz-transform: scale(1.1);
            -o-transform: scale(1.1);
          }

          a.btn {
            -webkit-transform: scale(0.8);
            -moz-transform: scale(0.8);
            -o-transform: scale(0.8);
            -webkit-transition-duration: 0.5s;
            -moz-transition-duration: 0.5s;
            -o-transition-duration: 0.5s;
          }

          body {
            margin: 0;
            font-family: "Nunito", sans-serif;
            font-size: 0.9rem;
            font-weight: 400;
            line-height: 1.6;
            color: #212529;
            text-align: left;
            background-color: #f8fafc;
       
          }
        </style>
        @yield('content')
       
      </div>
    </div>
    <!-- /#page-content-wrapper -->
  </div>
  <!-- /#wrapper -->
  @else
  @yield('content')

  @endif
</body>



</html>