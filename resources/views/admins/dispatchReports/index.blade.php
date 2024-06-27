@extends('admins.layouts.app')

@section('include')

@endsection

@section('title', '发货单信息')
<link type="text/css" rel="styleSheet"  href="../css/111.css" />
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
                   <!--  <div class="col-sm-4">
                        <div class="input-group">
                            <input type="text" name="search" id="search" class="form-control" placeholder="发货单号/库位号" />
                            <div class="input-group-append">
                                <button class="btn btn-default" type="button" onclick="table.draw( false );">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div> -->

 <div class="col-md-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><strong>发货单号</strong></span>
              </div>
              <input type="text" class="form-control"  required name="dispatch_no" id="dispatch_no" class="form control" autocomplete="off" maxlength="12"/>

              <!--       <input type="text"name="dispatch_no" id="dispatch_no" class="form control" onkeypress = "if (event.keyCode = 13)  {getdispatchlistinfo()};" /> -->
            </div>
          </div>


            <div class="col-md-1.5">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><strong>库位</strong></span>
                        <!--   <label style="margin-top: 2px;margin-right: 1px;">对货员</label> -->
                        <!--  <span class="input-group-text"><strong>对  货  员</strong></span> -->
                    </div>
                 <select class="form-control" required name="position" id="position">
                                <option value="" >请选择</option>
                                <?php
                                $jg=\Illuminate\Support\Facades\DB::table('zzz_storage_locations')
                                    ->select('id','no')
                                    ->get();
                                foreach($jg as $k=>$v){
                                    echo ("<option value='$v->no'>".$v->no."</option>");
                                }
                                ?>
                            </select>
                </div>
            </div>
  <div class="col-md-1.5">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" style="margin-left: 8px"><strong>状态</strong></span>
                        <!--   <label style="margin-top: 2px;margin-right: 1px;">对货员</label> -->
                        <!--  <span class="input-group-text"><strong>对  货  员</strong></span> -->
                    </div>
                    <select class="form-control" required name="iscar" id="iscar" style="max-width: 296px" />
<option value="" >请选择</option>
                        <option value="0" >未装车</option>
                        <option value="1" >已装车</option>

                    </select>
                </div>
            </div>
          
  <div class="col-md-1.5">
                <div class="input-group">
                   <span class="input-group-text" style="margin-left: 8px"><strong>日期</strong></span>
                    <div class="input-group-prepend">
                         <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                              </span>


         
                            </div>
                            <input type="text" class="form-control float-right" id="reservation" name="reservation">
                        
                          <!-- /.input group -->
                        </div>
                    </div>


          


            <div class="col-md-1.1">
                <div class="input-group">
                    <td>
                        <button type="button" id="btn-query" class="btn btn-block btn-info" style="margin-left: 8px" onclick="table.draw( false );">查询</button>
                    </td>
                </div>
            </div>




                    
                
<div class="col-md-1.1">
                <div class="input-group">
                    <td>
                      <!--   <button type="button" id="btn-export" class="btn btn-block btn-info" href="{{route('dispatchReport.export')}}" style="margin-left: 658px">导出</button> -->
    <!--                     <p class="box-header">
    <a class="btn btn-success" style="margin-left: 8px" 
    >导出</a></p> -->
      <button type="button" id="btn-export" style="margin-left: 8px" class="btn btn-success">导出</button>
  <!--     href="{{route('dispatchReport.export')}}" -->
                    </td>
                </div>
            </div>
              
                </div>
                <table id="companiesLists" class="table table-bordered table-striped" style="table-layout:fixed;">
                    <thead>
                    <tr>
                        <th style="width: 4% !important;">序号</th>
                        <th style="width: 12% !important;">发货单号</th>
                        <th style="width: 9% !important;">日期</th>
                        <th style="width: 4% !important;">库位</th>
                        <th style="width: 25% !important;">客户简称</th>
                        <th style="width: 38% !important;">发货地址</th>
                        <th style="width: 8% !important;">默认库位</th>

                        <th style="width: 6% !important;">状态</th>
                        
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
        $(function () {

    $('#reservation').daterangepicker({
        locale: {
        format: 'YYYY-MM-DD',
        applyLabel: '确定',
        cancelLabel: '取消',
        fromLabel: "开始时间",
        toLabel: "结束时间",
        customRangeLabel: "自定义",
        daysOfWeek: ["日","一","二","三","四","五","六"],
        monthNames: ["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"]
        }         
    });
});

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
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "serverSide": true,
                "iDisplayLength":20,
                // "bProcessing":true,
                "ajax":function(data,callback,settings){
                    var length = data.length;
                    var start = data.start;
                    var page = (data.start / data.length) + 1;
                    var dateKey = $('#reservation').val();
                     var dispatch_no = $('#dispatch_no').val();
                    var location_no = $('#position').val();
                    var status = $('#iscar').val();
                    // var cDepartmentKey = $('#cDepartment').val();
                    // var cWhCodeKey = $('#cWhCode').val();
                    // var status =$('#status').val();

                    $.ajax({
                        headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
                        type: "POST",
                        url: "dispatchReport/getData",
                        data :{
                            draw : page,
                            start : start,
                            length : length,
                            // cSTcodeKey : cSTcodeKey,
                            // cDLCodeKey : cDLCodeKey,
                            dateKey : dateKey,
                            dispatch_no : dispatch_no,
                            location_no : location_no,
                            status : status
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
                 { "data":"ROWNU" },
                    { "data":"dispatch_no" },
                    { "data":"dDate" },
                    { "data":"location_no" },
                    { "data":"cCusAbbName" },
                    { "data":"cShipAddress" },
                    { "data":"default_location_no" },

                    { "data":"status" }
                    // { "data":"car_created_at" } 
                ]
            });

            $('#btn-export').on('click', function(){

  var dateKey = $('#reservation').val();
                     var dispatch_no = $('#dispatch_no').val();
                    var location_no = $('#position').val();
                    var status = $('#iscar').val();

$.ajax({
  data:{  
    dateKey : dateKey,
    dispatch_no : dispatch_no,
    location_no : location_no,
    status : status
     },
  headers:{
    'X-CSRF-TOKEN' : '{{ csrf_token() }}'
  },
  type: "post",
  // async:false,
  dataType: "json",
  url:'{{route('dispatchReport.export')}}',
            // beforeSend:function(){

            // },
            success:function(data){
                // alert(data);
                location.href = data.data;
            }
        });
                 });
    </script>

@endsection