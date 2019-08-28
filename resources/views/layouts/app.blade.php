<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BULL') - 上海公牛</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @yield('include')
    <link rel="stylesheet" href="{{asset('AdminLTE/dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition layout-top-nav">
    <div id="app" class="{{ route_class() }}-page">
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
        @yield('script')
</body>
</html>
