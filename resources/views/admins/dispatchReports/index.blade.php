@extends('admins.layouts.app')

@section('include')

@endsection

@section('title', '发货单信息')

@section('section')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>发货单信息</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">报表</li>
                        <li class="breadcrumb-item active">发货单信息</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row" style="margin-bottom: 5px;">
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="text" name="search" id="search" class="form-control" placeholder="发货单号/库位号" />
                            <div class="input-group-append">
                                <button class="btn btn-default" type="button" onclick="table.draw( false );">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                
<div class="col-md-1.1">
                <div class="input-group">
                    <td>
                      <!--   <button type="button" id="btn-export" class="btn btn-block btn-info" href="{{route('dispatchReport.export')}}" style="margin-left: 658px">导出</button> -->
                        <p class="box-header">
    <a class="btn btn-success" href="{{route('dispatchReport.export')}}">导出</a></p>
                    </td>
                </div>
            </div>
              
                </div>
                <table id="companiesLists" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>发货单号</th>
                        <th>客户名称</th>
                        <th>库位</th>
                        <th>打包员</th>
                        <th>打包时间</th>
                        <th>车辆</th>
                        <th>司机</th>
                        <th>装车时间</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!-- /.col -->
@endsection
@section('script')
    <script>
        // $('#btn-export').on('click', function(){

// alert(1);
  // 判断库位是否合法
   // window.location.href = "dispatchPrint/getPrint?datas="+datas;
   // window.open("dispatchReport/export");



              // $.ajax({
              //   url:"dispatchReport/export",
              //   type:'get',
              //   dataType:'json',
              //   headers:{
              //     Accept:"application/json",
              //     "Content-Type":"application/json"
              //   },
              //   processData:false,
              //   cache:false,
              //   timeout: 1000,
              //   beforeSend:function(){

              //   },
              //   success:function(data){
              //     if(data.length==0){
              //       $('<audio id="notifyAudio"><source src="/music/notify.ogg" type="audio/ogg"><source src="/music/notify.mp3" type="audio/mpeg"><source src="/music/notify.wav" type="audio/wav"></audio>').appendTo('body');
              //       $('#notifyAudio')[0].play();
              //       //发货单号红框提示,toast提示
              //       $("#location_no").addClass("is-invalid");
              //       Toast.fire({
              //         type: 'error',
              //         title: '库位非法或不存在！'
              //       });
              //       //清空发货单号
              //       $('#location_no').val('');
              //       return false;
              //     }else{
              //       //如果合法，给默认库位赋值，焦点回到库位框,发货单号成功提示
              //       $("#location_no").removeClass("is-invalid");
              //       $("#dispatch_no").focus();
              //     }
              //   },
              //   error:function(){
              //     alert("error");
              //     return false;
              //   }
              // });



        // });
        var table =
            $('#companiesLists').DataTable({
                language: {
                    "sProcessing": "处理中...",
                    "sLengthMenu": "显示 _MENU_ 项结果",
                    "sZeroRecords": "没有匹配结果",
                    "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
                    "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
                    "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
                    "sInfoPostFix": "",
                    "sSearch": "搜索:",
                    "sUrl": "",
                    "sEmptyTable": "表中数据为空",
                    "sLoadingRecords": "载入中...",
                    "sInfoThousands": ",",
                    "oPaginate": {
                        "sFirst": "首页",
                        "sPrevious": "上页",
                        "sNext": "下页",
                        "sLast": "末页"
                    },
                    "oAria": {
                        "sSortAscending": ": 以升序排列此列",
                        "sSortDescending": ": 以降序排列此列"
                    }
                },
                'paging'      : true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "serverSide": true,
                "bProcessing":true,
                "ajax":function(data,callback,settings){
                    var length = data.length;
                    var start = data.start;
                    var page = (data.start / data.length) + 1;
                    var searchKey = $('#search').val();

                    $.ajax({
                        headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
                        type: "POST",
                        url: "dispatchReport/getData",
                        data :{
                            draw : page,
                            start : start,
                            length : length,
                            searchKey : searchKey
                        },
                        success:function(result){
                            var returnData = {};
                            returnData.recordsTotal = result.recordsTotal;
                            returnData.recordsFiltered = result.recordsFiltered;
                            returnData.data = result.data;
                            callback(returnData);
                        }
                    })
                },
                "columns":[
                    { "data":"dispatch_no" },
                    { "data":"ccusname" },
                    { "data":"location_no" },
                    { "data":"packager_name" },
                    { "data":"out_created_at" },
                    { "data":"car_no" },
                    { "data":"driver_name" },
                    { "data":"car_created_at" }
                ]
            });
    </script>

@endsection