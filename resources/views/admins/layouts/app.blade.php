<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'BULL') - 上海公牛</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @yield('include')

</head>

<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
<div id="app" class="{{ route_class() }}-page">
    <div class="wrapper">
        @include('admins.layouts._header')
        @include('admins.layouts._sidebar')

        <div class="content-wrapper">

            @yield('section')

            <section class="content container-fluid">
                @yield('content')

            </section>
        </div>

        @include('admins.layouts._footer')
    </div>
</div>

<script src="{{ mix('js/app.js') }}"></script>

@yield('script')

<script>
    $(function(){
        $('.nav-sidebar a').each(function(){
            if(this.href === window.location.href){
                $(this).addClass('active');
                $(this).parent().parent().parent().addClass('active');
                $(this).parent().parent().parent().children(":first").addClass('active');
            }
        });
    });
</script>


</body>

</html>