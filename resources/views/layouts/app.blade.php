<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'liang') - 智慧门店</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @yield('include')
    <link rel="stylesheet" href="{{asset('AdminLTE/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('AdminLTE/plugins/toastr/toastr.min.css')}}">

</head>

<body class="hold-transition layout-top-nav">
<div id="app" class="{{ route_class() }}-page">
    <div class="wrapper">
        @include('layouts._header')

        <div class="content-wrapper">

            @yield('section')

            <section class="content container-fluid">
                @yield('content')

            </section>
        </div>

        @include('layouts._footer')
    </div>
</div>

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
<script src="/AdminLTE/dist/js/adminlte.min.js"></script>
<script src="/AdminLTE/plugins/toastr/toastr.min.js"></script>

@yield('script')

<script>

</script>


</body>

</html>