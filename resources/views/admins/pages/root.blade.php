@extends('admins.layouts.app')

@section('include')

@endsection

@section('title', '首页')

@section('section')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>首页</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">首页</li>
                        <li class="breadcrumb-item active">任务列表</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="row">
            <div class="col-lg-3 col-4">
                <div class="small-box bg-info">
                    <div class="overlay dark">
                        {{--<i class="fas fa-3x fa-sync-alt"></i>--}}
                    </div>
                    <!-- end loading -->
                    <div class="inner">
                        <h3>50</h3>

                        <p>月未出库</p>
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
                <div class="small-box bg-info">
                    <div class="overlay dark">
                        {{--<i class="fas fa-3x fa-sync-alt"></i>--}}
                    </div>
                    <!-- end loading -->
                    <div class="inner">
                        <h3>150</h3>

                        <p>月已出库</p>
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

                        <p>月未装车</p>
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
                        <p>日待出库</p>
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
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>150</h3>
                        <p>日已出库</p>
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
                        <p>日已装车</p>
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

                        <p>日未装车</p>
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
    <!-- /.col -->
@endsection
@section('script')
    <script>

    </script>

@endsection