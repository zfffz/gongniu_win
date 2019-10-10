@extends('layouts.app')
@section('include')
@endsection
@section('title', '打包出库')

@section('header')
    <a class="navbar-brand">
        <img src="/image/logo.png" alt="AdminLTE Logo" class="brand-image"
             style="opacity: .8;margin-left:0px;margin-right:0px;">
    </a>
    <ul class="navbar-nav ml-auto" >
        <label style="margin-top: 8px;margin-right: 10px;white-space:nowrap">打包员</label>
        <select class="form-control" name="packager" id="packager">
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
                    <div class="card" style="margin-top: -19px;">
                        <div class="card-header">
                            <h3 class="card-title text-center">打包出库</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-lg" name="dispatch_no" id="dispatch_no" autocomplete="off" value="" placeholder="发货单号">
                                {{--默认库位编码--}}
                                <input type="hidden" name="location_no_default" id="location_no_default" value="">

                            </div>
                            <div class="form-group">
                                {{--库位编码--}}
                                <input type="text" class="form-control form-control-lg" name="location_no" id="location_no" autocomplete="off" value="" placeholder="库位">
                            </div>
                        </div>
                    </div>

                    <div class="card" style="margin-top: -8px;">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">暂存区</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fas fa-minus"></i>
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
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        function batchSave(){
            $('#dispatch_no').blur();
            var packager = $('#packager').val();

            //打包员提示
            if(packager == ''){
                Toast.fire({
                    type: 'error',
                    title: '请选择打包员！'
                });
                $('#packager').addClass('is-invalid');
                $('#packager').focus();
                return false;
            }
            var trList = $("#table_body").children("tr");

            var length = trList.length;

            if(length == 0){
                Toast.fire({
                    type: 'error',
                    title: '空数据无法提交！'
                });
                $('#dispatch_no').focus();
                return false;
            }

            var datas={};
            datas.packager = packager;
            datas.items = {};
            for (var i=0;i<length;i++){
                datas.items[i] = {};
                var tdArr = trList.eq(i).find("td");
                datas.items[i].dispatch_no = tdArr.eq(0).html();
                datas.items[i].location_no = tdArr.eq(1).html();
            }

            Swal.fire({
                title: '确认上传暂存区数据到系统吗?',
                text:'共'+length+'条',
                footer: '打包员'+$('#packager option:selected').text(),
                type: 'question',
                focusConfirm: false,
                allowEnterKey:false,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '确定',
                cancelButtonText: '取消'
            }).then(
                function(n){
                    if(n.value){
                        $.ajax({
                            url:"{{route('sweepOut.store')}}",
                            data:JSON.stringify(datas),
                            type:'post',
                            dataType:'json',
                            headers:{
                                Accept:"application/json",
                                "Content-Type":"application/json",
                                'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                            },
                            processData:false,
                            cache:false,
                            timeout: 10000,
                            beforeSend: function() {
                            },
                            success:function(t){
                                if(t.status == 0){
                                    $('<audio id="notifyAudio"><source src="/music/notify.ogg" type="audio/ogg"><source src="/music/notify.mp3" type="audio/mpeg"><source src="/music/notify.wav" type="audio/wav"></audio>').appendTo('body');
                                    $('#notifyAudio')[0].play();
                                    //上传失败提示
                                    Toast.fire({
                                        type: 'error',
                                        title: t.text
                                    });
                                    return false;
                                }
                                //上传成功提示
                                Toast.fire({
                                    type: 'success',
                                    title: '上传成功,共'+length+'条！'
                                });
                                $('<audio id="successAudio"><source src="/music/success.ogg" type="audio/ogg"><source src="/music/success.mp3" type="audio/mpeg"><source src="/music/success.wav" type="audio/wav"></audio>').appendTo('body');
                                $('#successAudio')[0].play();

                                $('#dispatch_table tbody').html('');
                                $("#dispatch_no").focus();
                            },
                            error: function() {
                                alert("error");
                            }
                        });
                    }else{
                        $("#dispatch_no").focus();
                        return false;
                    }
                })
        }

        function checkRow(dispatch_no){
            // 添加之前检查当前发货单是否重复录入
            var trList = $("#table_body").children("tr");

            var length = trList.length;

            for (var i=0;i<length;i++){
                var tdArr = trList.eq(i).find("td");
                if(dispatch_no == tdArr.eq(0).html()){
                    Toast.fire({
                        type: 'error',
                        title: '发货单号'+dispatch_no+'已存在，不允许重复录入！'
                    });
                    $("#dispatch_no").val("");
                    $("#location_no").val("");
                    $("#dispatch_no").focus();
                    return false;
                }

            }
            return true;
        }



        function addRow(type){
            var dispatch_no = $('#dispatch_no').val();
            var location_no = $('#location_no').val();

            //直接添加入列表
            var trcomp="<tr>" +
                '<td>'+dispatch_no+'</td>'+
                '<td class="'+type+'">'+location_no+'</td>'+
                '<td class="text-right py-0 align-middle"><a href="javascript:void(0)" class="btn btn-danger btn-sm" data-toggle="tooltip"  title="删除" onclick="deleteCurrentRow(this)"><i class="fas fa-trash" ></i></a></td>'
            "</tr>";
            $("#dispatch_table").append(trcomp);
            //清空发货单号、库位
            $("#dispatch_no").removeClass("is-valid");
            $("#location_no").removeClass("is-invalid");
            $("#dispatch_no").val("");

            $("#location_no").val("");

            $("#dispatch_no").focus();

            //添加成功提示
            Toast.fire({
                type: 'success',
                title: '添加成功！'
            });
            $('<audio id="successAudio"><source src="/music/success.ogg" type="audio/ogg"><source src="/music/success.mp3" type="audio/mpeg"><source src="/music/success.wav" type="audio/wav"></audio>').appendTo('body');
            $('#successAudio')[0].play();
        }

        function deleteCurrentRow(obj) {
            $('#dispatch_no').blur();
            Swal.fire({
                title: '确认删除吗?',
                type: 'warning',
                showCancelButton: true,
                focusConfirm: false,
                allowEnterKey:false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '确定',
                cancelButtonText: '取消'
            }).then(
                function(n){
                    if(n.value){
                        var tr=obj.parentNode.parentNode;

                        var tbody=tr.parentNode;
                        tbody.removeChild(tr);
                        $("#dispatch_no").focus();
                    }else{
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
                title: '确认清空列表吗?',
                type: 'warning',
                showCancelButton: true,
                focusConfirm: false,
                allowEnterKey:false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '确定',
                cancelButtonText: '取消'
            }).then(
                function(n){
                    if(n.value){
                        $('#dispatch_table tbody').html('');
                        $("#dispatch_no").focus();
                    }else{
                        $("#dispatch_no").focus();
                    }
                })
        }

        $(function() {
            //车牌号提示
            Toast.fire({
                type: 'warning',
                title: '请选择打包员！'
            });
            //聚焦打包员
            $('#packager').focus();

            // 每次聚焦发货单号检查打包员：不允许为空
            $('#dispatch_no').focus(function(){
                if($('#packager').val()==''){
                    Toast.fire({
                        type: 'warning',
                        title: '请选择打包员！'
                    });
                    $('#packager').focus();
                    return false;
                }
            });

//            $('#dispatch_no').blur(function(){
//                var dispatch_no = $(this).val();
//                if(dispatch_no.length < 12){
//                    $('#dispatch_no').focus();
//                }
//
//            });

            $('#location_no').focus(function(){
                if($('#dispatch_no').val()==''){
                    $('#dispatch_no').focus();
                }
            });

            $('#packager').change(function(){
                $('#packager').removeClass('is-invalid');
                $('#dispatch_no').focus();
            });

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
                                    $('<audio id="notifyAudio"><source src="/music/notify.ogg" type="audio/ogg"><source src="/music/notify.mp3" type="audio/mpeg"><source src="/music/notify.wav" type="audio/wav"></audio>').appendTo('body');
                                    $('#notifyAudio')[0].play();
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

                                    $('#location_no_default').val(data[0].no);
                                    //焦点跳转到库位
                                    $('#location_no').focus();
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

            $('#location_no').keydown(function(event) {
                if(event.keyCode == 13){
                    var location_no = $(this).val();
                    //发货单号不能为空，如果为空，直接清空库位，跳转到发货单号框
                    if( $('#dispatch_no').val()==''){
                        $("#dispatch_no").addClass("is-invalid");
                        $('<audio id="notifyAudio"><source src="/music/notify.ogg" type="audio/ogg"><source src="/music/notify.mp3" type="audio/mpeg"><source src="/music/notify.wav" type="audio/wav"></audio>').appendTo('body');
                        $('#notifyAudio')[0].play();
                        Toast.fire({
                            type: 'error',
                            title: '请先扫发货单号！'
                        });
                        $('#location_no').val('');
                        $('#dispatch_no').focus();
                        return false;
                    }

                    //如果库位为空,直接报错提示
                    if( $('#location_no').val()==''){
                        $("#location_no").addClass("is-invalid");
                        $('<audio id="notifyAudio"><source src="/music/notify.ogg" type="audio/ogg"><source src="/music/notify.mp3" type="audio/mpeg"><source src="/music/notify.wav" type="audio/wav"></audio>').appendTo('body');
                        $('#notifyAudio')[0].play();
                        Toast.fire({
                            type: 'error',
                            title: '请扫库位号！'
                        });
                        $('#location_no').focus();
                        return false;
                    }

                    //判断库位是否等于默认库位
                    //如果不等于，弹窗提示
                    if(location_no != $('#location_no_default').val()){
                        Swal.fire({
                            title: '非默认库位，确定添加吗?',
                            text: "默认库位"+$('#location_no_default').val(),
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: '确定',
                            cancelButtonText: '取消',
                            focusConfirm: false,
                            allowEnterKey:false
                        }).then(
                            function(n){
                                if(n.value){
                                    addRow('text-danger');
                                }else{
                                    $('#location_no').val('');
                                }
                            })
                    }else{
                        $("#location_no").removeClass("is-invalid");
                        addRow('text-success');
                    }
                }
            });
        })
    </script>
@endsection