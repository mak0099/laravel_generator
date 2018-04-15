<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Laravel Generator</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  @yield('before_style')
  <link rel="stylesheet" href="{{asset('public/asset/bootstrap/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('public/asset/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('public/asset/css/AdminLTE.min.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{asset('public/asset/css/skins/_all-skins.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/asset/css/style.css')}}">
  @yield('after_style')
</head>
<body class="hold-transition skin-purple sidebar-mini">
<div class="wrapper">

  @include('partials/header')
  <!-- Left side column. contains the logo and sidebar -->
  @include('partials/sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      @yield('content_header')
    </section>

    <!-- Main content -->
    <section class="content">
      @yield('content')

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @include('partials/footer')

  @include('partials/control_sidebar')
</div>
<!-- ./wrapper -->
@yield('before_script')
<!-- jQuery 2.2.3 -->
<script src="{{asset('public/asset/plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="{{asset('public/asset/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('public/asset/js/app.min.js')}}"></script>    
@yield('after_script')
<script type="text/javascript">
$(document).ready(function(){
  setTimeout(function(){
    $('.flash-message').slideUp();
  }, 3000);
  $('input').focusin(function(){
    $('.flash-message').delay(3000).slideUp();
  });
 })
</script>
</body>
</html>
