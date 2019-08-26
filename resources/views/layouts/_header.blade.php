<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-light navbar-white">
    <div class="container">
        <a href="#" class="navbar-brand">
            <img src="/AdminLTE/dist/img/logo.png" alt="AdminLTE Logo" class="brand-image"
                 style="opacity: .8">
        </a>

        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-cogs"></i>  仓库扫码 <span class="caret"></span>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" tabindex="-1" href="#"><i class="fas fa-store-alt"></i> 打包出库</a>
                    <a class="dropdown-item" tabindex="-1" href="#"><span class="fa fa-users"></span> 扫码上车</a>
                    <div class="divider"></div>
                </div>
            </li>
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
                    <a class="dropdown-item" tabindex="-1" href="#"><i class="fa fa-cogs"></i> 编辑资料</a>
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