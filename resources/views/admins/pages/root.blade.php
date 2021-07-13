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
                <!--     <div class="overlay dark">
                        {{--<i class="fas fa-3x fa-sync-alt"></i>--}}
                    </div> -->
                    <!-- end loading -->
                    <div class="inner">
                        <h3>{{ $CHECK[0]->count }}</h3>

                        <p>日已对货</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-balance-scale"></i>
                    </div>
                    <a href="{{route('sweepCheck.index')}}" class="small-box-footer">
                        明细 <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-4">
                <div class="small-box bg-primary">
                  <!--   <div class="overlay dark">
                        {{--<i class="fas fa-3x fa-sync-alt"></i>--}}
                    </div> -->
                    <!-- end loading -->
                  
                    <div class="inner">
                        <h3>{{ $OUT[0]->count }}</h3>

                        <p>日已扫单</p>
                    </div>
              
                    <div class="icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <a href="{{route('sweepOut.index')}}" class="small-box-footer">
                        明细 <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-4">
                <!-- small card -->
                <div class="small-box bg-success">
                   <!--  <div class="overlay dark">
                        {{--<i class="fas fa-3x fa-sync-alt"></i>--}}
                    </div> -->
                    <div class="inner">
                        <h3>{{ $CAR[0]->count }}</h3>
                        <p>日已装车</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <a href="{{route('sweepCar.index')}}" class="small-box-footer">
                        明细 <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-4">
                <!-- small card -->
                <div class="small-box bg-danger">
                  <!--   <div class="overlay dark">
                        {{--<i class="fas fa-3x fa-sync-alt"></i>--}}
                    </div> -->
                    <div class="inner">
                        <h3>{{ $transport[0]->count }}</h3>

                        <p>日已发运</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-road"></i>
                    </div>
                    <a href="{{route('wayPrint.index')}}" class="small-box-footer">
                        明细 <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-4">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $CHECKM[0]->count }}</h3>
                        <p>月已对货</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-balance-scale"></i>
                    </div>
                    <a href="{{route('sweepCheck.index')}}" class="small-box-footer">
                        明细 <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-4">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $OUTM[0]->count }}</h3>
                        <p>月已扫单</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <a href="{{route('sweepOut.index')}}" class="small-box-footer">
                        明细 <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-4">
                <!-- small card -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $CARM[0]->count }}</h3>
                        <p>月已装车</p>
                    </div>
                    <div class="icon">
                         <i class="fas fa-truck"></i>
                    </div>
                    <a href="{{route('sweepCar.index')}}" class="small-box-footer">
                        明细 <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-4">
                <!-- small card -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $transportM[0]->count }}</h3>

                        <p>月已发运</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-road"></i>
                    </div>
                     <a href="{{route('wayPrint.index')}}" class="small-box-footer">
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