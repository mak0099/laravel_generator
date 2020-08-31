<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Asset Management | Log in</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="{{asset('asset/bootstrap/css/bootstrap.min.css')}}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset('asset/css/AdminLTE.min.css')}}">
        <!-- iCheck -->
        <link rel="stylesheet" href="{{asset('asset/plugins/iCheck/square/blue.css')}}">
        <link rel="stylesheet" href="{{asset('asset/css/style.css')}}">

    </head>
    <body class="hold-transition login-page" style="background: url(public/asset/img/background.jpg) no-repeat; background-size: 100% 100%; overflow: hidden">
        <div class="login-box">
            
            <!-- /.login-logo -->
            <div class="login-box-body">
                <div class="login-logo">
                <div style="width: 150px; margin: 0 auto">
                    <img src="{{asset('asset/img/logo.png')}}" class="img-circle img-responsive" alt="User Image">
                </div>
                <a href="{{route('index')}}"><b>Asset</b>Management</a>
            </div>
                <p class="login-box-msg">Sign in to start your session</p>
                @include('partials/messages')
                <form action="{{route('login')}}" method="post">
                    {{csrf_field()}}
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="Username" name="username" autofocus autocomplete="off">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Password" name="password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <!--          <div class="checkbox icheck">
                                        <label>
                                          <input type="checkbox"> Remember Me
                                        </label>
                                      </div>-->
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <!--    <div class="social-auth-links text-center">
                      <p>- OR -</p>
                      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
                        Facebook</a>
                      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
                        Google+</a>
                    </div>-->
                <!-- /.social-auth-links -->

                <!--    <a href="#">I forgot my password</a><br>
                    <a href="register.html" class="text-center">Register a new membership</a>-->

            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->

        <!-- jQuery 2.2.3 -->
        <script src="{{asset('asset/plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="{{asset('asset/bootstrap/js/bootstrap.min.js')}}"></script>
        <!-- iCheck -->
        <script src="{{asset('asset/plugins/iCheck/icheck.min.js')}}"></script>
        <script>
$(function () {
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });
});
        </script>
    </body>
</html>
