<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'liang') - 注册</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('AdminLTE/dist/css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="{{asset('AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">

</head>

<body class="hold-transition layout-top-nav login-page">
<div id="app" class="{{ route_class() }}-page">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-light navbar-white border-bottom">
            <div class="container">
                <a href="index3.html" class="navbar-brand">
                    <img src="/AdminLTE/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light">智慧门店</span>
                </a>

                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="#" class="nav-link">联系我们</a>
                    </li>
                </ul>
                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="{{route('login')}}" class="nav-link">登录</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('register')}}" class="nav-link">注册</a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- /.navbar -->

        <div class="login-box">
            <div class="login-logo">
                <a href="../../index2.html"><b>R</b> 智慧门店</a>
            </div>
            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">{{ __('Register') }}</p>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group has-feedback{{ $errors->has('name') ? ' has-error' : '' }}">
                            @if ($errors->has('name'))
                                <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>{{ $errors->first('name') }}</label>
                                </br>
                            @endif
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="name" placeholder="{{ __('Name') }}" required>
                                <div class="input-group-append input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group has-feedback{{ $errors->has('mobile') ? ' has-error' : '' }}">
                            @if ($errors->has('mobile'))
                                <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>{{ $errors->first('mobile') }}</label>
                                </br>
                            @endif

                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="mobile" placeholder="{{ __('Mobile') }}" required>
                                <div class="input-group-append input-group-text">
                                    <span class="fas fa-mobile"></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                            @if ($errors->has('password'))
                                <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>{{ $errors->first('password') }}</label>
                                </br>
                            @endif
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" name="password" placeholder="{{ __('Password') }}" required>
                                <div class="input-group-append input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group has-feedback">
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" name="password_confirmation" placeholder="{{ __('Confirm Password') }}" required>
                                <div class="input-group-append input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group has-feedback{{ $errors->has('captcha') ? ' has-error' : '' }}">
                            <div class="row">
                                <div class="col-6">
                                    @if ($errors->has('captcha'))
                                        <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>{{ $errors->first('captcha') }}</label>
                                    @endif
                                    <input type="text" class="form-control" name="captcha" placeholder="验证码" required>
                                </div>
                                <!-- /.col -->
                                <div class="col-6">
                                    <img class="thumbnail captcha mt-3 mb-2" src="{{ captcha_src('flat') }}" onclick="this.src='/captcha/flat?'+Math.random()" title="点击图片重新获取验证码">
                                </div>
                                <!-- /.col -->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="remember">
                                    <label for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('Register') }}</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>


                    <p class="mb-1">
                        <a href="#">{{ __('Forgot Your Password?') }}</a>
                    </p>
                    <p class="mb-0">
                        <a href="register.html" class="text-center">{{ __('Register a new membership') }}</a>
                    </p>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
        <!-- /.login-box -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Anything you want
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2014-2018 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
        </footer>
    </div>
</div>

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
<script src="/AdminLTE/dist/js/adminlte.min.js"></script>


</body>

</html>