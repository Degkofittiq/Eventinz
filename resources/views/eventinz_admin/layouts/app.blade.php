<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>EvenTinz | Admin Area</title>
  <link rel="icon" href="{{ asset('eventinz_logo.png') }}" type="image/png">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('AdminTemplate/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('AdminTemplate/dist/css/adminlte.min.css') }}">
  <style>
    .nav-link.active{
      background-color: transparent !important;
      border: 1px solid white !important;
      color: white !important;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  @include('eventinz_admin/layouts/header')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->

  @include('eventinz_admin/layouts/sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <a onclick="goBack()" class="btn btn-default mx-2 my-1">Go Back</a>
        @yield('content_admin')
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
      {{-- <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-6">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>

                  <p class="card-text">
                    Some quick example text to build on the card title and make up the bulk of the card's
                    content.
                  </p>

                  <a href="#" class="card-link">Card link</a>
                  <a href="#" class="card-link">Another link</a>
                </div>
              </div>

              <div class="card card-primary card-outline">
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>

                  <p class="card-text">
                    Some quick example text to build on the card title and make up the bulk of the card's
                    content.
                  </p>
                  <a href="#" class="card-link">Card link</a>
                  <a href="#" class="card-link">Another link</a>
                </div>
              </div><!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
            <div class="col-lg-6">
              <div class="card">
                <div class="card-header">
                  <h5 class="m-0">Featured</h5>
                </div>
                <div class="card-body">
                  <h6 class="card-title">Special title treatment</h6>

                  <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
              </div>

              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h5 class="m-0">Featured</h5>
                </div>
                <div class="card-body">
                  <h6 class="card-title">Special title treatment</h6>

                  <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
              </div>
            </div>
            <!-- /.col-md-6 -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div> --}}
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  @include('eventinz_admin/layouts/footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

{{-- {{ asset('AdminTemplate/xxxxxxxxxxxxx') }} --}}
<!-- jQuery -->
<script src="{{ asset('AdminTemplate/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('AdminTemplate/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('AdminTemplate/dist/js/adminlte.min.js') }}"></script>


{{-- Script Go back --}}
<script>
  function goBack() {
      window.history.back();
  }
</script>
{{-- End Script Go back --}}

<script>
  document.addEventListener('DOMContentLoaded', function() {
      setTimeout(function() {
          let successAlert = document.getElementById('success-alert');
          if (successAlert) {
              successAlert.style.display = 'none';
          }

          let errorAlert = document.getElementById('error-alert');
          if (errorAlert) {
              errorAlert.style.display = 'none';
          }
      }, 5000); // Le message disparaîtra après 5 secondes (5000 ms)
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
      setTimeout(function() {
          // Sélectionner tous les éléments avec la classe 'alert'
          let alerts = document.querySelectorAll('.alert');

          // Parcourir chaque alerte et les masquer
          alerts.forEach(function(alert) {
              alert.style.display = 'none';
          });
      }, 7000); // Le message disparaîtra après 7 secondes (7000 ms)
  });
</script>
</body>
</html>