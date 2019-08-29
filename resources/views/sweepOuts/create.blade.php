@extends('layouts.app')
@section('include')
    <link rel="stylesheet" href="/AdminLTE/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{asset('AdminLTE/plugins/sweetalert2/sweetalert2.min.css')}}">
@endsection
@section('title', '扫码出库')

@section('header')
    <a href="#" class="navbar-brand">
        <img src="/AdminLTE/dist/img/logo.png" alt="AdminLTE Logo" class="brand-image"
             style="opacity: .8;margin-left:0px;margin-right:0px;">
    </a>
    <ul class="navbar-nav ml-auto">
        <label style="margin-top: 8px;margin-right: 10px;">打包员</label>
        <select class="form-control select2" name="packager">
            <option value=""></option>
            @foreach ($packagers as $packager)
                <option value="{{ $packager->no }}">
                    {{ $packager->name }}
                </option>
            @endforeach

        </select>
    </ul>


@endsection

@section('content_header')

@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Block buttons -->
                    <div class="card" style="margin-top: -15px;">
                        <div class="card-header">
                            <h3 class="card-title text-center">打包出库</h3>
                        </div>
                        <form class="form-horizontal" role="form" action="{{ route('sweepOut.store') }}" method="post">
                            {{ csrf_field() }}
                            @include('shared._error')
                            <div class="card-body">
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <h4>有错误发生：</h4>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li><i class="glyphicon glyphicon-remove"></i> {{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label>发货单号</label>
                                    <input type="text" class="form-control form-control-lg" name="dispatch_no" id="dispatch_no" autocomplete="off" value="">
                                    <input type="hidden" name="location_no_default" id="location_no_default" value="">

                                </div>
                                <div class="form-group">
                                    <label>库位</label>
                                    <input type="text" class="form-control form-control-lg" name="location_no" id="location_no" autocomplete="off" value="">
                                </div>



                            </div>
                            {{--<div class="card-footer">--}}
                                {{----}}
                            {{--</div>--}}
                        </form>
                    </div>

                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">暂存区</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0" id="dispatch_table">
                                    <thead>
                                    <tr>
                                        <th>发货单号</th>
                                        <th>库位</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <button onclick="deleteTable()" class="btn btn-danger float-left">清空</button>
                            <a href="javascript:void(0)" class="btn btn-primary float-right">上传</a>
                        </div>
                        <!-- /.card-footer -->
                    </div>


                </div>
            </div>

        </div>
    </div>
@endsection

@section('footer')
    <div class="float-right d-none d-sm-inline">

    </div>
    <!-- Default to the left -->
    <a onclick="javascript:history.back(-1);"><i class="fas fa-arrow-left"></i> </a>
@endsection

@section('script')
    <script src="/AdminLTE/plugins/select2/js/select2.full.min.js"></script>
    <script src="/AdminLTE/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script>
//        const Toast = Swal.mixin({
//            toast: true,
//            position: 'top-end',
//            showConfirmButton: false,
//            timer: 3000
//        });
        //添加成功提示
        Swal.fire({
            type: 'warning',
            title: '请选择打包员！'
        });
    </script>
@endsection