<!DOCTYPE html>
<html>
<head>
  @include('layouts.header')
</head>
<body class="hold-transition layout-fixed layout-navbar-fixed sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto dashboard_li_a">
      <li class="nav-item dropdown">
        <a title="Logout" href="javascript:void(0)" data-toggle="modal" data-target="#logout" class="btn btn-block btn-md text-dark"><i style="font-size: 25px;" class="fas fa-sign-out-alt"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('layouts.sidebar')

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ $title ?? '' }}</h1>
        </div>
        </div>
      </div>
    </section>
    @yield('content')
  </div>

  <footer class="main-footer">
    <strong>Copyright &copy; @php echo date('Y'); @endphp {{\Config::get('app.name')}}.</strong> All rights reserved.
  </footer>

  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>
<div class="modal fade" id="logout">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Logout</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to logout?</p>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a href="{{url('logout')}}" type="button" class="btn btn-danger">Logout</a>
      </div>
    </div>
  </div>
</div>
@include('layouts.footer')
</body>
</html>
