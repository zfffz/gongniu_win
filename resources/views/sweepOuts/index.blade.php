<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>任务列表 - 上海公牛</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @yield('include')
</head>
<body class="hold-transition layout-top-nav">
<div id="app" class="{{ route_class() }}-page">
    <div class="wrapper">
        <div class="card card-success maximized-card" style="height: 112px; width: 255.75px; transition: all 0.15s ease 0s;">
            <div class="card-header">
                <h3 class="card-title text-center">任务列表</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" onclick="javascript:history.back(-1);"><i class="fas fa-reply"></i>
                    </button>
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-4">
                        <div class="small-box bg-info">
                            <div class="overlay dark">
                                {{--<i class="fas fa-3x fa-sync-alt"></i>--}}
                            </div>
                            <!-- end loading -->
                            <div class="inner">
                                <h3>150</h3>

                                <p>月出库</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="#" class="small-box-footer">
                                明细 <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-4">
                        <!-- small card -->
                        <div class="small-box bg-success">
                            <div class="overlay dark">
                                {{--<i class="fas fa-3x fa-sync-alt"></i>--}}
                            </div>
                            <div class="inner">
                                <h3>150</h3>
                                <p>月装车</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="#" class="small-box-footer">
                                明细 <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-4">
                        <!-- small card -->
                        <div class="small-box bg-danger">
                            <div class="overlay dark">
                                {{--<i class="fas fa-3x fa-sync-alt"></i>--}}
                            </div>
                            <div class="inner">
                                <h3>0</h3>

                                <p>月未出库</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                            <a href="#" class="small-box-footer">
                                明细 <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-4">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>150</h3>
                                <p>日出库</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="#" class="small-box-footer">
                                明细 <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-4">
                        <!-- small card -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>150</h3>
                                <p>日装车</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="#" class="small-box-footer">
                                明细 <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-4">
                        <!-- small card -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>0</h3>

                                <p>日未出库</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                            <a href="#" class="small-box-footer">
                                明细 <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <strong>Copyright &copy; 2019 BULL</strong>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ mix('js/app.js') }}"></script>
@yield('script')
</body>
</html>