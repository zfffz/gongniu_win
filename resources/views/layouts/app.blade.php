<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BULL') - 上海公牛</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @yield('include')
</head>
<body class="hold-transition layout-top-nav layout-navbar-fixed layout-footer-fixed">
<div id="app" class="{{ route_class() }}-page">
    <div class="wrapper">
        @include('layouts._header')

        <div class="content-wrapper" style="background:#fff;">

            <div>
                @yield('content')
            </div>
        </div>

        @include('layouts._footer')
    </div>
</div>
<script src="{{ mix('js/app.js') }}"></script>
@yield('script')
</body>
</html>