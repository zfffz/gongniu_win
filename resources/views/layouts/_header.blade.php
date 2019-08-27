<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-light navbar-white">
    <div class="container">
        <a href="#" class="navbar-brand">
            <img src="/AdminLTE/dist/img/logo.png" alt="AdminLTE Logo" class="brand-image"
                 style="opacity: .8">
        </a>

        <ul class="navbar-nav">

        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                    <img src="{{ Auth::user()->avatar?Auth::user()->avatar:'/AdminLTE/dist/img/user2-160x160.jpg' }}" class="user-image" alt="User Image">
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right">


                    <a class="dropdown-item"  tabindex="-1" href="#"><i class="fa fa-user"></i> 个人中心</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" id="logout" tabindex="-1" href="#">
                        <form action="{{ route('logout') }}" method="POST">
                            {{ csrf_field() }}
                            <button class="btn btn-block btn-danger" type="submit" name="button">退出</button>
                        </form>
                    </a>
                </div>
            </li>
        </ul>


    </div>
</nav>
<!-- /.navbar -->