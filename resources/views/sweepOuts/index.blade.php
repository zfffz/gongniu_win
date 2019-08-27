@extends('layouts.app')
@section('include')
    <link rel="stylesheet" href="/AdminLTE/plugins/select2/css/select2.min.css">
@endsection
@section('title', '扫码出库')

@section('header')
    <label style="margin-top:8px;margin-right:10px;">打包员</label>
    <select class="form-control select2" name="packager">
        <option value="">请选择</option>
        @foreach ($packagers as $packager)
            <option value="{{ $packager->no }}">
                {{ $packager->name }}
            </option>
        @endforeach

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

            $('#dispatch_no').bind('input propertychange', function() {
                var dispatch_no = $(this).val();
                if(dispatch_no.length == 12){
                    //判断发货单号合法性，同时获取该单号的默认库位
                    $.ajax({
                        url:'sweepOut/dispatch_data?dispatch_no='+dispatch_no,
                        type:'get',
                        dataType:'json',
                        headers:{
                            Accept:"application/json",
                            "Content-Type":"application/json"
                        },
                        processData:false,
                        cache:false,
                        timeout: 1000,
                        beforeSend:function(){

                        },
                        success:function(data){
                            if(data.length==0){
                                alert('发货单号不存在');
                            }else{
                                $('#location_no_default').val(data[0].name);
                                alert($('#location_no_default').val());
                            }

                        },
                        error:function(){
                            alert("error");
                        }
                    });

                    //如果不合法，给出提示，并且清空发货单号框，焦点重新回到文本框

                    //如果合法，给默认库位赋值，焦点回到库位框
                }

            });

            $('#location_no').bind('input propertychange', function() {
                if($(this).val().length == 4){
                    //判断库位是否等于默认库位

                    //如果不是，弹出提示框，确定/取消
                    //确定：信息放入暂存区（库位普通字体），清空文本框，焦点回到发货单号
                    //取消：清空库位，焦点回到库位框

                    //如果是，信息放入暂存区（库位红色字体），清空文本框，焦点回到发货单号
                }

            });


        })
    </script>
@endsection