<html>
  <head>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/datatable-theme.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"/>
    <title>CRUD App | @yield('title')</title>
  </head>
  <body style="padding-top:50px;">
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="/brand">CRUD App</a>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-2 sidebar">
          <h3>Maintenance</h3>
          <ul class="nav nav-sidebar">
            <li class="active"><a href="/brand">Brand</a></li>
            <li><a href="/category">Category</a></li>
            <li><a href="#">Branch</a></li>
            <li><a href="/product">Product</a></li>
          </ul>
          <h3>Transaction</h3>
          <ul class="nav nav-sidebar">
            <li><a href="#">Inventory</a></li>
          </ul>
        </div>

        <div class="col-md-10" style="padding:25px;">
          @yield('error')
          @yield('content')
        </div>
      </div>
    </div>

    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/dataTables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.validate.js') }}" type="text/javascript"></script>
    @yield('js')
  </body>
</html>
