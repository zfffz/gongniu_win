<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BULL') - 登录</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>

<body class="hold-transition login-page">
<div id="app" class="{{ route_class() }}-page"></div>
<div class="login-box">
    <div class="login-logo">
        <img src="/image/logo.png" alt="AdminLTE Logo" class="brand-image">
    </div>

    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">{{ __('Login') }}</p>

            <form method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <div class="input-group mb-3">
                    <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="name" placeholder="{{ __('Name') }}" required autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text input-lg">
                            <span class="fa fa-user"></span>
                        </div>
                    </div>
                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                    @endif
                </div>

                <div class="input-group mb-3">
                    <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="password" placeholder="{{ __('Password') }}" required autofocus>
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

                <div class="input-group mb-3 float-right">
                    <div class="icheck-primary float-right">
                        <input type="checkbox" id="remember">
                        <label for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <button id="login" type="submit" class="btn btn-primary btn-block">{{ __('Login') }}</button>
                </div>

                <div class="input-group mb-3">
                    <button type="button" class="btn btn-danger btn-block" onclick="delCookies()">清空</button>
                </div>
                <div class="text-center">
                    <p class="text-muted">技术支持：上海业务模块</p>
                </div>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>

<script>
    $(function () {

        initView();

        $("#login").click(function () {
            if ($("#remember").is(":checked")) {
                setCookie("cookie_name", $("#name").val());
                setCookie("cookie_password", $("#password").val());
                setCookie("remember", true);
            } else {
                delCookie("cookie_name");
                delCookie("cookie_password");
                delCookie("remember");
            }


            window.location.reload()
        });
    });

    function initView() {
        if (getCookie("cookie_name")) {
            $("#name").val(getCookie("cookie_name"));
        }
        if (getCookie("cookie_password")) {
            $("#password").val(getCookie("cookie_password"));
        }
        if (getCookie("remember")) {
            $("#remember").attr("checked", getCookie("remember"));
        }
        $("#name").focus(function () {
            this.select();
        });
        $("#password").focus(function () {
            this.select();
        });
    }

    /**
     * 写入cookie
     * @param name  cookie 名
     * @param value  cookie 值
     */
    function setCookie(name, value) {
        var Days = 30; //此 cookie 将被保存 30 天
        var exp = new Date();
        exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000);
        document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString();
    }
    /**
     * 删除cookie
     * @param name
     */
    function delCookie(name) {
        var exp = new Date();
        exp.setTime(exp.getTime() - 1);
        var cval = getCookie(name);
        if (cval != null) document.cookie = name + "=" + cval + ";expires=" + exp.toGMTString();
    }

    function delCookies(){
        delCookie("cookie_name");
        delCookie("cookie_password");
        delCookie("remember");
        $('#name').val('');
        $('#password').val('');
    }

    /**
     * 读取cookie
     * @param name
     * @returns
     */
    function getCookie(name) {
        var arr = document.cookie.match(new RegExp("(^| )" + name + "=([^;]*)(;|$)"));
        if (arr != null)
            return unescape(arr[2]);
        return null;
    }
</script>


</body>

</html>