<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="/favicon.ico" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">上海公牛</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/image/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('root')}}" class="nav-link">
                        <i class="fa fa-home"></i>
                        <p>
                            首页
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa fa-cog"></i>
                        <p>
                            基础资料
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('storageLocation.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>库位</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('car.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>车辆</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('driver.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>司机</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>