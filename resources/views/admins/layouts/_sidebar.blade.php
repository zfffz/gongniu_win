<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 text-sm">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="/favicon.ico" class="brand-image" style="opacity: .8">
        <span class="brand-text font-weight-light">BULL公牛</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar text-sm">
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
                        <i class="nav-icon fa fa-home"></i>
                        <p>
                            首页
                        </p>
                    </a>
                    <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa fa-edit"></i>
                        <p>
                            业务工作
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                         <li class="nav-item">
                       <a href="{{route('dispatchPrint.index')}}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                            <p>发货单打印</p >
                             </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('sweepCheck.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>扫码对货</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('sweepOut.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>打包入库</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('sweepCar.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>扫码上车</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('wayBill.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>生成发运单</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('wayPrint.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>打印发运单</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('returnhouse.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>退回单</p>
                            </a>
                        </li>
                        </ul>
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
                     
                      
                        <!-- <li class="nav-item">
                            <a href="{{route('driver.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>司机</p>
                            </a>
                        </li> -->
                           <li class="nav-item">
                            <a href="{{route('carton.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>存货基础信息</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('customerLocation.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>客户默认库位</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            单据列表
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                       
                        <li class="nav-item">
                            <a href="{{route('sweepCheck.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>扫码对货</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('sweepOut.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>打包入库</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('sweepCar.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>扫码上车</p>
                            </a>
                        </li>
                         <li class="nav-item">
                            <a href="{{route('returnhouse.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>退回入库</p>
                            </a>
                        </li>
                        
                    </ul>
                </li>

                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>
                            报表
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('dispatchReport.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>发货单出库上车记录</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('stockReport.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>出入库记录</p>
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