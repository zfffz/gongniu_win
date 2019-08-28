@extends('layouts.app')
@section('include')
    <link rel="stylesheet" href="/AdminLTE/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{asset('AdminLTE/plugins/sweetalert2/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{asset('AdminLTE/plugins/toastr/toastr.min.css')}}">
@endsection
@section('title', '扫码出库')

@section('header_left')
    <select class="form-control select2" name="packager">
        <option value="">打包员</option>
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
    <script src="/AdminLTE/plugins/toastr/toastr.min.js"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        function addRow(type){
            //直接添加入列表
            var trcomp="<tr>" +
                '<td>'+$('#dispatch_no').val()+'</td>'+
                '<td class="'+type+'">'+$('#location_no').val()+'</td>'+
                '<td><a href="javascript:void(0)" class="text-danger" data-toggle="tooltip"  title="删除" onclick="deleteCurrentRow(this)"><i class="far fa-trash-alt" ></i></a></td>'
            "</tr>";
            $("#dispatch_table").append(trcomp);
            //清空发货单号、库位
            $("#dispatch_no").removeClass("is-valid");
            $("#dispatch_no").val("");

            $("#location_no").val("");

            $("#dispatch_no").focus();

            //添加成功提示
            Toast.fire({
                type: 'success',
                title: '添加成功！'
            });
            $('#chatAudio')[0].play();
        }

        function deleteCurrentRow(obj) {
            Swal.fire({
                title: '确认删除吗?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '确定',
                cancelButtonText: '取消'
            }).then((result) => {
                if (result.value) {
                var tr=obj.parentNode.parentNode;

                var tbody=tr.parentNode;
                tbody.removeChild(tr);

            }else{


            }
        })
        }

        function deleteTable() {
            Swal.fire({
                title: '确认清空列表吗?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '确定',
                cancelButtonText: '取消'
            }).then((result) => {
                if (result.value) {
                $('#dispatch_table tbody').html('');

            }else{


            }
        })
        }

        $(function(){
            $('<audio id="chatAudio"><source src="/music/notify.ogg" type="audio/ogg"><source src="/music/notify.mp3" type="audio/mpeg"><source src="/music/notify.wav" type="audio/wav"></audio>').appendTo('body');


            $('.select2').select2();
            //聚焦发货单号
            $('#dispatch_no').focus();

            $('#dispatch_no').blur(function(){
                var dispatch_no = $(this).val();
                if(dispatch_no.length < 12){
                    $('#dispatch_no').focus();
                }

            });



            $('#dispatch_no').bind('input propertychange', function() {
                var dispatch_no = $(this).val();
                if(dispatch_no.length >= 12){
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
                        timeout: 3000,
                        beforeSend:function(){

                        },
                        success:function(data){
                            if(data.length==0){
                                //发货单号红框提示,toast提示
                                $("#dispatch_no").addClass("is-invalid");
                                Toast.fire({
                                    type: 'error',
                                    title: '发货单号非法或不存在！'
                                });
                                //清空发货单号
                                $('#dispatch_no').val('');
                            }else{
                                //如果合法，给默认库位赋值，焦点回到库位框,发货单号成功提示
                                $("#dispatch_no").removeClass("is-invalid");
                                $("#dispatch_no").addClass("is-valid");
                                $('#location_no_default').val(data[0].name);
                                //焦点跳转到库位
                                $('#location_no').focus();
                            }

                        },
                        error:function(){
                            alert("error");
                        }
                    });
                }

            });

            $('#location_no').bind('input propertychange', function() {
                var location_no = $(this).val();
                //发货单号不能为空，如果为空，直接清空库位，跳转到发货单号框
                if( $('#dispatch_no').val()==''){
                    $("#dispatch_no").addClass("is-invalid");
                    Toast.fire({
                        type: 'error',
                        title: '请先扫发货单号！'
                    });
                    $('#location_no').val('');
                    $('#dispatch_no').focus();
                }


                //判断库位是否等于默认库位
                //如果不等于，弹窗提示
                if(location_no.length >=4){
                    if(location_no != $('#location_no_default').val()){
                        Swal.fire({
                            title: '非默认库位，确定添加吗?',
                            text: "默认库位"+$('#location_no_default').val(),
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: '确定',
                            cancelButtonText: '取消'
                        }).then((result) => {
                            if (result.value) {
                                addRow('text-danger');

                            }else{
                            $('#location_no').val('');

                            }
                        })
                    }else{
                        addRow('text-success');
                    }
                }

            });


        })
    </script>
@endsection