<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-light navbar-white">
    <div class="container">
        <a href="#" class="navbar-brand">
            <img src="/AdminLTE/dist/img/logo.png" alt="AdminLTE Logo" class="brand-image"
                 style="opacity: .8;margin-left:0px;margin-right:0px;">
        </a>

        <ul class="navbar-nav">
            @yield('header_left')
        </ul>
        <ul class="navbar-nav ml-auto">
            @yield('header')
        </ul>
    </div>
</nav>