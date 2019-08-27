@extends('layouts.app')
@section('include')
    <link rel="stylesheet" href="/AdminLTE/plugins/select2/css/select2.min.css">
@endsection
@section('title', '扫码出库')

@section('header')
    <label style="margin-top:8px;margin-right:2px;">打包员</label>
    <select class="form-control select2">
        <option value="">请选择</option>
        <option>Alaska</option>
        <option>California</option>
        <option>Delaware</option>
        <option>Tennessee</option>
        <option>Texas</option>
        <option>Washington</option>
    </select>
@endsection

@section('content_header')

@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Block buttons -->
                    <div class="card">
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
                                    <input type="text" class="form-control form-control-lg" name="dispatch_no" autocomplete="off" value="">

                                </div>
                                <div class="form-group">
                                    <label>库位</label>
                                    <input type="text" class="form-control form-control-lg" name="location_no" autocomplete="off" value="">
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
                                <table class="table m-0">
                                    <thead>
                                    <tr>
                                        <th>发货单号</th>
                                        <th>库位</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>XSFH00123456</td>
                                        <td>A01</td>
                                        <td>
                                            <a href="javascript:void(0)" class="text-danger" data-toggle="tooltip"  title="删除" onclick=""><i class="far fa-trash-alt" ></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>XSFH00123456</td>
                                        <td>A01</td>
                                        <td>
                                            <a href="javascript:void(0)" class="text-danger" data-toggle="tooltip"  title="删除" onclick=""><i class="far fa-trash-alt" ></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>XSFH00123456</td>
                                        <td>A01</td>
                                        <td>
                                            <a href="javascript:void(0)" class="text-danger" data-toggle="tooltip"  title="删除" onclick=""><i class="far fa-trash-alt" ></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>XSFH00123456</td>
                                        <td>A01</td>
                                        <td>
                                            <a href="javascript:void(0)" class="text-danger" data-toggle="tooltip"  title="删除" onclick=""><i class="far fa-trash-alt" ></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>XSFH00123456</td>
                                        <td>A01</td>
                                        <td>
                                            <a href="javascript:void(0)" class="text-danger" data-toggle="tooltip"  title="删除" onclick=""><i class="far fa-trash-alt" ></i></a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <a href="javascript:void(0)" class="btn btn-danger float-left">清空</a>
                            <a href="javascript:void(0)" class="btn btn-primary float-right">上传</a>
                        </div>
                        <!-- /.card-footer -->
                    </div>


                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script src="/AdminLTE/plugins/select2/js/select2.full.min.js"></script>
    <script>
        $(function(){
            $('.select2').select2();
        })
    </script>
@endsection