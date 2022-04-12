<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KangooRouter (c)</title>
  @include('layouts.templates.scripts-head')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- REQUIRED SCRIPTS -->
  @include('layouts.templates.main-scripts')
  
  @include('layouts.templates.navbar')

  @include('layouts.templates.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        @yield('content')
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @include('layouts.templates.main-footer')
</div>
<!-- ./wrapper -->
</body>
</html>
