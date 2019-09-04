@extends('layouts.app')
@section('include')
    <link rel="stylesheet" href="{{asset('AdminLTE/plugins/sweetalert2/sweetalert2.min.css')}}">
@endsection
@section('title', '扫码上车')

@section('header')
    <ul class="navbar-nav">
        <label style="margin-top: 8px;margin-right: 10px;white-space:nowrap">车牌号</label>
        <select class="form-control select2" name="car_id" id="car_id">
            <option value="">沪ADH081</option>

        </select>
    </ul>

    <ul class="navbar-nav ml-auto">

        <label style="margin-top: 8px;margin-right: 10px;white-space:nowrap">司机</label>
        <select class="form-control select2" name="driver_id" id="driver_id">
            <option value="">唐立诚</option>

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
                            <div class="card-body">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg" name="dispatch_no" id="dispatch_no" autocomplete="off" value="" placeholder="发货单号">
                                    <input type="hidden" name="location_no_default" id="location_no_default" value="">
                                </div>
                            </div>
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
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody id="table_body">
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <button onclick="deleteTable()" class="btn btn-danger float-left">清空</button>
                            <button onclick="batchSave()" class="btn btn-primary float-right">上传</button>
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
    <script src="/AdminLTE/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        function checkRow(dispatch_no){
            //添加之前检查发货单是否重复录入
            var trList = $("#table_body").children("tr");

            var length = trList.length;

            for (var i=0;i<length;i++){
                var tdArr = trList.eq(i).find("td");
                if(dispatch_no == tdArr.eq(0).html()){
                    $('#notifyAudio')[0].play();
                    Toast.fire({
                        type: 'error',
                        title: '发货单号'+dispatch_no+'已存在，不允许重复录入！'
                    });
                    $("#dispatch_no").val("");
                    $("#dispatch_no").focus();
                    return false;
                }

            }
            return true;
        }

        function addRow(type){
            var dispatch_no = $('#dispatch_no').val();

            //直接添加入列表
            var trcomp="<tr>" +
                '<td>'+dispatch_no+'</td>'+
                '<td class="text-right py-0 align-middle"><a href="javascript:void(0)" class="btn btn-danger btn-sm" data-toggle="tooltip"  title="删除" onclick="deleteCurrentRow(this)"><i class="fas fa-trash" ></i></a></td>'
            "</tr>";
            $("#dispatch_table").append(trcomp);
            //清空发货单号
            $("#dispatch_no").val("");

            $("#dispatch_no").focus();

            //添加成功提示
            Toast.fire({
                type: 'success',
                title: '添加成功！'
            });
            $('#successAudio')[0].play();
        }

        function deleteCurrentRow(obj) {
            $('#dispatch_no').blur();
            Swal.fire({
                title:"请输入口令",
                input:"text",
                inputAttributes:{
                    autocapitalize:"off"
                },
                showCancelButton: true,
                focusConfirm: false,
                allowEnterKey:false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                showLoaderOnConfirm:true,
                preConfirm:function(t){
                    return fetch("checkPass?password=".concat(t)).then(
                        function(t){
                            if(!t.ok)throw new Error(t.statusText);
                            return t.json()
                        }).catch(function(t){
                        Swal.showValidationMessage("Request failed: ".concat(t))
                    })
                },
                allowOutsideClick:function(){
                    return!Swal.isLoading()
                }
            }).then(
                function(n){
                    if(n.value.status == 'success'){
                        var tr=obj.parentNode.parentNode;

                        var tbody=tr.parentNode;
                        tbody.removeChild(tr);
                        $("#dispatch_no").focus();
                    }else{
                        $('#notifyAudio')[0].play();
                        Toast.fire({
                            type: 'error',
                            title: '口令错误！'
                        });
                        $("#dispatch_no").focus();
                    }
                })
        }

        function deleteTable() {
            $('#dispatch_no').blur();
            var trList = $("#table_body").children("tr");

            var length = trList.length;

            if(length == 0){
                return false;
            }

            Swal.fire({
                title:"请输入口令",
                input:"text",
                inputAttributes:{
                    autocapitalize:"off"
                },
                showCancelButton: true,
                focusConfirm: false,
                allowEnterKey:false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                showLoaderOnConfirm:true,
                preConfirm:function(t){
                    return fetch("checkPass?password=".concat(t)).then(
                        function(t){
                            if(!t.ok)throw new Error(t.statusText);
                            return t.json()
                        }).catch(function(t){
                        Swal.showValidationMessage("Request failed: ".concat(t))
                    })
                },
                allowOutsideClick:function(){
                    return!Swal.isLoading()
                }
            }).then(
                function(n){
                    if(n.value.status == 'success'){
                        $('#dispatch_table tbody').html('');
                        $("#dispatch_no").focus();
                    }else{
                        $('#notifyAudio')[0].play();
                        Toast.fire({
                            type: 'error',
                            title: '口令错误！'
                        });
                        $("#dispatch_no").focus();
                    }
                })
        }

        $(function(){
            $('<audio id="successAudio"><source src="/music/success.ogg" type="audio/ogg"><source src="/music/success.mp3" type="audio/mpeg"><source src="/music/success.wav" type="audio/wav"></audio>').appendTo('body');
            $('<audio id="successAudio"><source src="/music/notify.ogg" type="audio/ogg"><source src="/music/notify.mp3" type="audio/mpeg"><source src="/music/notify.wav" type="audio/wav"></audio>').appendTo('body');

            $('#dispatch_no').keydown(function(event) {
                if(event.keyCode == 13){
                    var dispatch_no = $(this).val();
                    if(dispatch_no.length >= 12){
                        //判断发货单号是否重复录入
                        var result = checkRow(dispatch_no);
                        if(!result){
                            return false;
                        }

                        //判断发货单号合法性，同时获取该单号的默认库位
                        $.ajax({
                            url:'dispatch_data?dispatch_no='+dispatch_no,
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
                                    $('#notifyAudio')[0].play();
                                    $("#dispatch_no").addClass("is-invalid");
                                    Toast.fire({
                                        type: 'error',
                                        title: '发货单未出库！'
                                    });
                                    //清空发货单号
                                    $('#dispatch_no').val('');
                                }else{
                                    //如果合法
                                    $("#dispatch_no").removeClass("is-invalid");
                                    addRow();
                                }

                            },
                            error:function(){
                                alert("error");
                            }
                        });
                    }else{

                    }
                }

            });

        })

    </script>
@endsection