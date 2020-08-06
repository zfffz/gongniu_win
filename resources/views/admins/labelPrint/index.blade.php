@extends('admins.layouts.app')

@section('include')

@endsection

@section('title', '箱标打印')
<link type="text/css" rel="styleSheet"  href="../css/111.css" />
@section('section')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>发货单打印</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">单据列表</li>
                        <li class="breadcrumb-item active">发货单列表</li>
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
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>销售类型</label>
                                <select class="form-control" required name="cSTName" id="cSTName" style="width: 100%;">
                                    <option value="" >请选择</option>
                                    <?php
                                    $jg=\Illuminate\Support\Facades\DB::table('SaleType')
                                        ->select('cSTCode as FInterID','cSTName as FName')
                                        ->get();
                                    foreach($jg as $k=>$v){
                                        echo ("<option value='$v->FInterID'>".$v->FName."</option>");
                                    }
                                    ?>
                                </select>
                        </div>
                    </div> 
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>发货单号</label>
                            <input class="form-control" name="cDLCode" id="cDLCode"/>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>部门</label>
                            <select class="form-control" required name="cDepartment" id="cDepartment" style="width: 100%;">
                                <option value="" >请选择</option>
                                <?php
                                $jg=\Illuminate\Support\Facades\DB::table('Department')
                                    ->select('cDepCode as FInterID','cDepName as FName')
                                    ->get();
                                foreach($jg as $k=>$v){
                                    echo ("<option value='$v->FInterID'>".$v->FName."</option>");
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <!-- Date range -->
                        <div class="form-group">
                          <label>日期</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                              </span>
                            </div>
                            <input type="text" class="form-control float-right" id="reservation" name="reservation">
                          </div>
                          <!-- /.input group -->
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>是否打印</label>
                            <select class="form-control" required name="status" id="status" style="width: 100%;">
                                <option value="" >请选择</option>
                                <option value="1" >是</option>
                                <option value="0" >否</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <td>
                                <button type="button" class="btn btn-block btn-primary" onclick="table.draw( false );">查询</button>
                            </td>
                        </div>
                    </div>
                    <div class="col-sm-2">    
                        <div class="input-group">
                            <td>
                                <button type="button" id="btn-submit" class="btn btn-block btn-success">发货单打印</button>
                            </td>
                        </div>
                    </div>

                </div>
                <table id="dispatchlist" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="5"><input type="checkbox" id="checkAll" class="checkAll" value=""></th>
                        <th>发货单号</th>
                        <th>发货日期</th>
                        <th>销售类型</th>
                        <th>部门</th>
                        <th>客户名称</th>
                        <th>客户简称</th>
                        <th>业务员</th>
                        <th>备注</th>
                        <th>制单人</th>
                        <th>发运方式</th>
                        <th>打印否</th>
                        <th>打印数</th>
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
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2000
});

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

    //table.draw( false );

    // $("td.details-control").css ({
    // "background": "yellow",
    // "cursor": "pointer"});
    // $("tr.shown td.details-control").css ({
    //     "background": "url('/image/details_close.png') no-repeat center center"
    // });


});


$('#btn-submit').on('click', function(){
    var inputs = $("#dispatchlist input[name='ckb-jobid']:checked ").prev();
    inputs=inputs.prevObject;

    var len = inputs.length;
    if(len == 0){
        Toast.fire({
            type: 'error',
            title: '请选择要打印的单据！'
        });
        return false;
    }else{
        var datas='';
        inputs.each(function () {
            datas = datas + $(this).val()+'|';
        });
        window.location.href = "dispatchPrint/getPrint?datas="+datas;

    };

});


// {{--function printpage(data2){--}}
//     {{--$.ajax({--}}
//         {{--url:"{{route('dispatchPrint.printpage')}}",--}}
//         {{--data: JSON.stringify(data2),--}}
//         {{--type:'post',--}}
//         {{--dataType:'json',--}}
//         {{--headers:{--}}
//             {{--Accept:"application/json",--}}
//             {{--"Content-Type":"application/json",--}}
//             {{--'X-CSRF-TOKEN' : '{{ csrf_token() }}'--}}
//         {{--},--}}
//         {{--processData:false,--}}
//         {{--cache:false,--}}
//         {{--timeout: 10000,--}}
//         {{--beforeSend: function() {--}}
//         {{--},--}}
//     {{--})--}}
// {{--}--}}


$('#checkAll').on('click', function () {
    if (this.checked) {
        $(this).attr('checked','checked')
        $("input[name='ckb-jobid']").each(function () {
            this.checked = true;
        });
    } else {
        $(this).removeAttr('checked')
        $("input[name='ckb-jobid']").each(function () {
            this.checked = false;
        });
    }
});

function childclick(){
    if ($(this).is(":checked") == false) {
        $("#checkAll").prop("checked", false);
    }
}



var table =
            $('#dispatchlist').DataTable({
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
               // "bProcessing":true,
                "ajax":function(data,callback,settings){
                    var length = data.length;
                    var start = data.start;
                    var page = (data.start / data.length) + 1;
                    var cSTcodeKey = $('#cSTName').val();
                    var cDLCodeKey = $('#cDLCode').val();
                    var dateKey = $('#reservation').val();
                    var cDepartmentKey = $('#cDepartment').val();
                    var status =$('#status').val();
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
                        type: "POST",
                        url: "dispatchPrint/getData",
                        data :{
                            draw : page,
                            start : start,
                            length : length,
                            cSTcodeKey : cSTcodeKey,
                            cDLCodeKey : cDLCodeKey,
                            dateKey : dateKey,
                            cDepartmentKey : cDepartmentKey,
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
                    {"data": null},
                    { "data":"cDLCode" ,"orderable": true},
                    { "data":"dDate","orderable": false },
                    { "data":"cSTName" ,"orderable": false},
                    { "data":"cDepCode" ,"orderable": false},
                    { "data":"cCusName" ,"orderable": false},
                    { "data":"cCusAbbName" ,"orderable": false},
                    { "data":"cPsn_Name" ,"orderable": false},
                    { "data":"cMemo" ,"orderable": false},
                    { "data":"cMaker" ,"orderable": false},
                    { "data":"cSCName" ,"orderable": false},
                    { "data":"status" ,"orderable": false},      //是否打印
                    { "data":"iprintCount" ,"orderable": false}   //打印次数
                ],

                columnDefs: [
                    {
                        targets: [0], // 目标列位置，下标从0开始
                        data:"cDLCode",
                        bSortable: false,//是否排序
                        render: function(id, type, data) { // 返回自定义内容
                            return '<input type="checkbox" onclick = childclick() name="ckb-jobid" value="' + data.cDLCode + '">';
                        }
                    }
                    //重点结束
                ],
            });


</script>
@endsection