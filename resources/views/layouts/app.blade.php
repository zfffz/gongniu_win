<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>@yield('title', 'BULL') - 上海公牛</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @yield('include')
    <link rel="stylesheet" href="{{asset('AdminLTE/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('AdminLTE/plugins/toastr/toastr.min.css')}}">
</head>
<body class="hold-transition layout-top-nav">
    <div id="app" class="{{ route_class() }}-page"><div>
        <div class="wrapper">
            @include('layouts._header')

            <div class="content-wrapper">
                <div class="content-header">
                    <div class="container">
                        @yield('content_header')
                    </div>
                </div>

                <div class="content">
                    <div class="container">
                        @yield('content')
                    </div>
                </div>
            </div>

            @include('layouts._footer')
        </div>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="/AdminLTE/dist/js/adminlte.min.js"></script>
    <script src="/AdminLTE/plugins/toastr/toastr.min.js"></script>
        @yield('script')
    </div>
</body>
</html>
