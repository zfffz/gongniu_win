@extends('admins.layouts.app')

@section('include')

@endsection

@section('title', '生成调运单')
<link type="text/css" rel="styleSheet"  href="../css/111.css" />
@section('section')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>生成调运单</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">单据列表</li>
                        <li class="breadcrumb-item active">调拨单列表</li>
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
                    <div class="col-sm-1.8">
                        <div class="form-group">
                            <label>司机</label>
                                <select class="form-control" required name="driver_id" id="driver_id" style="width: 23mm;">
                                    <option value="" >请选择</option>
                                     @foreach($drivers as $driver)
                                    <option value="{{$driver->id}}">{{$driver->name}}</option>
                                      @endforeach

                                </select>
                        </div>
                    </div>
                    <div class="col-sm-1.8">
                        <div class="form-group">
                            <label>状态</label>
                                <select class="form-control" required name="status" id="status" style="width: 23mm;">
                                    <option value="0" >未生成</option>
                                    <option value="1" >已生成</option>
                                </select>
                        </div>
                    </div>
                     <div class="col-sm-2">
                        <div class="form-group">
                            <label>调拨出仓库</label>
                                <select class="form-control" required name="houseout" id="houseout"  style="width: 33mm;">
                                    <option value="" >请选择</option>
                                     @foreach($warehouses as $warehouse)
                                    <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                      @endforeach

                                </select>
                        </div>
                    </div>


                    <div class="col-sm-2.5">
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
                        <div class="input-group">
                            <label>查询</label>
                            <td>
                                <button type="button"  id="btn-submit1"  class="btn btn-block btn-primary" >查询</button>
                            </td>
                        </div>
                    </div>
                    <div class="col-sm-1.8">
                        <div class="form-group">
                            <label>发运方式</label>
                                <select class="form-control" required name="cSCName" id="csccode" style="width: 23mm;">
                                    <option value="" >请选择</option>
                                     @foreach($fyfs as $fyfss)
                                    <option value="{{$fyfss->id}}">{{$fyfss->name}}</option>
                                      @endforeach

                                </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <label>创建</label>
                            <td>
                                <button type="button" id="btn-submit" class="btn btn-block btn-success">生成调运单</button>
                            </td>
                        </div>
                    </div>

                </div>
                <table id="companiesLists" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>选择</th>
                        <th>展开</th>
                        <th>单据编号</th>
                        <th>车牌号</th>
                        <th>司机</th>
                        <th>创建日期</th>
                        <th>创建时间</th>
                        <th>是否生成</th>
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
    $('#driver_id').select2({
        theme: 'bootstrap4'
    });


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

    table.draw( false ) ;

    //
//点击加号事件
    $('#companiesLists tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        //console.log(row.data().id);
// alert(1);
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            var dispatch_no;
            $.ajax({
                headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
                type: "POST",
                url: "transVouch/getTransVouch",//调拨单号
                data :{
                    dispatch_no : row.data().id
                },
                dataType:"json",
                success:function(result){
                    dispatch_no = result;
                    row.child( format(dispatch_no) ).show();
                    tr.addClass('shown');

                }
    });



        }
    });

    $('#companiesLists tbody').on('click', 'td.rows-select', function () {
        var td = $(this).attr('class');
        var tr = $(this).closest('tr');
        if ( td.indexOf("rows-select-down") >= 0 ) {
            $(this).addClass("rows-select-up").removeClass("rows-select-down");
            tr.removeClass('down');
        }
        else {
            $(this).addClass("rows-select-down").removeClass("rows-select-up");
            tr.addClass('down');
        }
    });

});

//生成调运单事件
$('#btn-submit').on('click', function(){

    var csccode = $('#csccode').val();
// alert(csccode);
    if(csccode == ''){
        // alert(1);
        Toast.fire({
            type: 'error',
            title: '生成调运单需选择发运方式！'
        });
        $('#csccode').addClass('is-invalid');
        $('#csccode').focus();
          return false;
}


  var csccode = $('#csccode').val();
    var datas={};
    datas.sweep_cars={};
  datas.csccode = csccode;
    //console.log(datas.sweep_cars);
    var str;
    var inputs =  $("#companiesLists td[class*='rows-select-down'] input").prev();
    inputs=inputs.prevObject;
    var len = inputs.length;
    // alert(len);
    if(len>0){
        for (var i=0;i<len;i++){

                datas.sweep_cars[i] = inputs[i].value;

        };
    }else{
        Toast.fire({
            type: 'error',
            title: '请选择要传输的单据！'
        });
        return false;
    };
    //alert(len);
    // console.log(inputs);
     //console.log(datas);

    Swal.fire({
        title: '确认生成调运单?',
        text:'共'+len+'条',
        //footer: '打包员'+$('#packager option:selected').text()+'  库位'+$('#location_no').val(),
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

                    url:"{{route('transVouch.store')}}",
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
                        //alert(111);
                        //console.log(t);
                        if(t.status == 1){
                            $('<audio id="notifyAudio"><source src="/music/notify.ogg" type="audio/ogg"><source src="/music/notify.mp3" type="audio/mpeg"><source src="/music/notify.wav" type="audio/wav"></audio>').appendTo('body');
                            $('#notifyAudio')[0].play();
                            //上传失败提示
                        Swal.fire({
                          type: 'error',
                          title: t.title,
                          text: t.text
                        });
                            return false;
                        }
                        //上传成功提示
                        Swal.fire({
                            type: 'success',
                            title: t.title,
                            text: t.text
                        });
                        $('<audio id="successAudio"><source src="/music/success.ogg" type="audio/ogg"><source src="/music/success.mp3" type="audio/mpeg"><source src="/music/success.wav" type="audio/wav"></audio>').appendTo('body');
                        $('#successAudio')[0].play();
                        table.draw( false );
                    },
                    error: function() {
                        alert("error");
                    }
                });
            }else{
                $("#dispatch_no").focus();
                return false;
            }
        });

});


function format ( d ) {
     //var str = d ;
     //console.log(d);
     var str = '';
    $.each(d, function(key, val) {
        str =str+'<tr><td>'+val.dispatch_no+'</td><td>'+val.transportno+'</td></tr>';
        });

return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<th>调拨单号</th><th>调运单号</td>'+

        '</tr>'+ str +'</table>';
};

 // window.onload = function () {
 //    var car_id = $('#car_id').val();
 //    if(car_id == ''){
 //        Toast.fire({
 //            type: 'error',
 //            title: '请选择车牌！'
 //        });
 //        $('#car_id').addClass('is-invalid');
 //        $('#car_id').focus();
 //        return false;
 //    }
 //    $('#car_id').focus();
 // }
 // table.draw( false ) ;
//查询点击事件
$('#btn-submit1').on('click', function(){
    // function txtblur(event){ //当前元素失去焦点
        $("#driver_id").removeClass("is-invalid");
        $("#housein").removeClass("is-invalid");
        $("#houseout").removeClass("is-invalid");
var driver_id = $('#driver_id').val();
var housein = $('#housein').val();
var houseout = $('#houseout').val();
    if(driver_id == ''){
        Toast.fire({
            type: 'error',
            title: '请选择司机！'
        });
        $('#driver_id').addClass('is-invalid');
        $('#driver_id').focus();
        return false;
    }
    if(houseout == ''){
        Toast.fire({
            type: 'error',
            title: '请选择调拨出仓库！'
        });
        $('#houseout').addClass('is-invalid');
        $('#houseout').focus();
        return false;
    }
     if(csccode == ''){
        Toast.fire({
            type: 'error',
            title: '请选择发运方式！'
        });
        $('#csccode').addClass('is-invalid');
        $('#csccode').focus();
        return false;
    }







    else{
  
        table.draw( false ) ;
    }
        });

//      $('#companiesLists tbody').on('click', 'td.details-control', function () {
//         var tr = $(this).closest('tr');
//         var row = table.row( tr );
//         //console.log(row.data().id);
// // alert(1);
//         if ( row.child.isShown() ) {
//             // This row is already open - close it
//             row.child.hide();
//             tr.removeClass('shown');
//         }
//         else {
//             var dispatch_no;
//             $.ajax({
//                 headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
//                 type: "POST",
//                 url: "wayBill/getDispatchData",//发货单号
//                 data :{
//                     dispatch_no : row.data().id
//                 },
//                 dataType:"json",
//                 success:function(result){
//                     dispatch_no = result;
//                     row.child( format(dispatch_no) ).show();
//                     tr.addClass('shown');

//                 }
//     });
//         }
//     });



 //   window.onload = function () {
 //    var car_id = $('#car_id').val();
 //    if(car_id == ''){
 //        Toast.fire({
 //            type: 'error',
 //            title: '请选择车牌！'
 //        });
 //        $('#car_id').addClass('is-invalid');
 //        $('#car_id').focus();
 //        return false;
 //    }
 // }

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
                "destroy":true,

                "createdRow": function (row, data, dataIndex) {
                // row : tr dom
                // data: row data
                // dataIndex:row data's index
                // if (data[4] == "A") {
                     $(row).addClass(' down ');
                // }
                },// 行属性处理

                "ajax":function(data,callback,settings){
                    var length = data.length;
                    var start = data.start;
                    var page = (data.start / data.length) + 1;
                    var driveridKey = $('#driver_id').val();
                    var dateKey = $('#reservation').val();
                    var housein = $('#housein').val();
                    var houseoutKey = $('#houseout').val();
                    var statusKey = $('#status').val();
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
                        type: "POST",
                        // async:false,
                        url: "transVouch/getData",
                        data :{
                            draw : page,
                            start : start,
                            length : length,
                            driveridKey : driveridKey,
                            dateKey : dateKey,
                            housein : housein,
                            houseoutKey : houseoutKey,
                            statusKey : statusKey
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
                    {   "data":"id",
                        "class":"rows-select rows-select-down",
                        "width":"35px",
                        "orderable":      false,//是否排序
                        "visible": true ,//是否显示

                        "render": function(data,type,row,meta){
                            return '<input type="hidden" name="car_'+data+'" id="car_'+data+'" value="'+data+'"  >';
                        }
                    },
                    {
                        "class":          'details-control',
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": '',
                        "width": "35px"
                    },
                    {

                        "orderable":      false,
                        "defaultContent": '',
                        "data":"no"
                    },
                    { "data":"car_name" ,"orderable": false},
                    { "data":"drive_name","orderable": false },
                    { "data":"c_date" ,"orderable": false},
                    { "data":"c_time" ,"orderable": false},
                    { "data":"status" ,"orderable": false}
                ]

            });
//      $('#companiesLists tbody').on('click', 'td.details-control', function () {
//         var tr = $(this).closest('tr');
//         var row = table.row( tr );
//         //console.log(row.data().id);
// // alert(1);
//         if ( row.child.isShown() ) {
//             // This row is already open - close it
//             row.child.hide();
//             tr.removeClass('shown');
//         }
//         else {
//             var dispatch_no;
//             $.ajax({
//                 headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
//                 type: "POST",
//                 // async:false,
//                 url: "wayBill/getDispatchData",//发货单号
//                 data :{
//                     dispatch_no : row.data().id
//                 },
//                 dataType:"json",
//                 success:function(result){
//                     dispatch_no = result;
//                     row.child( format(dispatch_no) ).show();
//                     tr.addClass('shown');

//                 }
//     });
//         }
//     });



//          $('#companiesLists tbody').on('click', 'td.rows-select', function () {
//         var td = $(this).attr('class');
//         var tr = $(this).closest('tr');
//         if ( td.indexOf("rows-select-down") >= 0 ) {
//             $(this).addClass("rows-select-up").removeClass("rows-select-down");
//             tr.removeClass('down');
//         }
//         else {
//             $(this).addClass("rows-select-down").removeClass("rows-select-up");
//             tr.addClass('down');
//         }
//     });


</script>

@endsection

