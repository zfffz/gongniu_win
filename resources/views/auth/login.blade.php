<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'BULL') - 登录</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('AdminLTE/dist/css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="{{asset('AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>

<body class="hold-transition login-page">
<div id="app" class="{{ route_class() }}-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>BULL</b>公牛</a>
        </div>

        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">{{ __('Login') }}</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" placeholder="{{ __('Name') }}" required autofocus>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fa fa-user"></span>
                                </div>
                            </div>
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Password') }}" required autofocus>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3 float-right">
                            <div class="icheck-primary float-right">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('Login') }}</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <button type="button" class="btn btn-danger btn-block btn-flat">清空</button>
                        </div>
                    </div>
                    <p class="text-muted text-center">V1.0</p>
                    <div class="form-group">
                        <div class="text-center">
                            <p class="text-muted">技术支持：信息中心-上海业务模块</p>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
<script src="/AdminLTE/dist/js/adminlte.min.js"></script>


</body>

</html>