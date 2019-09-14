<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}">
    <title>{{ config('website.title') }} | Login</title>
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    {!! Notify::render() !!}
    
</head>

<body ng-app="">
    <div class="main-wrapper">
        <div class="account-page">
            <div class="container">
                <h3 class="account-title">Login</h3>
                <div class="account-box">
                    <div class="account-wrapper">
                        <div class="account-logo">
                            <a href="index.html"><img src="{{ asset('assets/img/logo2.png') }}" alt="Preadmin"></a>
                        </div>
                        <form action="{{ route('attempt_login') }}" method="POST" autocomplete="off">
                            @csrf
                            @method('POST')
                            <div class="form-group form-focus">
                                <label class="control-label">Username or Email</label>
                                <input class="form-control floating" type="text" name="username" ng-model="username">
                            </div>
                            <div class="form-group form-focus">
                                <label class="control-label">Password</label>
                                <input class="form-control floating" type="password" name="password" ng-model="password">
                            </div>
                            <div class="form-group text-center">
                                <button class="btn btn-primary btn-block account-btn" type="submit" ng-disabled="!username || !password">Login</button>
                            </div>
                            <div class="text-center">
                                <a href="forgot-password.html">Forgot your password?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('assets/js/jquery-3.2.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/app.js') }}"></script>
    <!-- angularjs -->
    <script src="{{asset('js/angular.min.js')}}"></script>
</body>

</html>