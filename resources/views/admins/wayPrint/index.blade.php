@extends('admins.layouts.app')

@section('include')

@endsection

@section('title', '打印发运单')
<link type="text/css" rel="styleSheet"  href="../css/111.css" />
<script src="../js/LodopFuncs.js"></script>
<object  id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0> 
       <embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0></embed>
</object>
@section('section')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>打印发运单</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">单据列表</li>
                        <li class="breadcrumb-item active">发运单列表</li>
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
                            <label>司机</label>
                                <select class="form-control" required name="driver_name" id="driver_name" style="width: 100%;">
                                    <option value="" >请选择</option>
                                    @foreach ($drivers as $driver)
                                        <option value="{{ $driver->name }}">
                                            {{ $driver->name }}
                                        </option>
                                    @endforeach
                                </select>
                        </div>
                    </div>    
                    <div class="col-sm-3">
                        <!-- Date range -->
                        <div class="form-group">
                          <label>时间</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                              </span>
                            </div>
                            <input type="text" class="form-control float-right" id="daterange" name="daterange">
                          </div>
                          <!-- /.input group -->
                        </div>
                    </div>
                    <div class="col-sm-1">    
                        <div class="input-group">
                            <label>查询</label>
                            <td>
                                <button type="button" class="btn btn-block btn-primary" onclick="table.draw( false );">查询</button>
                            </td>
                        </div>
                    </div>
                    <div class="col-sm-2">    
                        <div class="input-group">
                            <label>Date range:</label>
                            <td>
                                <button type="button" id="btn-submit" class="btn btn-block btn-success">生成发运单</button>
                            </td>
                        </div>
                    </div>

                </div>
                <table id="companiesLists" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>发运单号</th>
                        <th>司机</th>
                        <th>地址</th>
                        <th>制单人</th>
                        <th>制单时间</th>
                        <th>打印次数</th>
                        <th>操作</th>
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
    $('#driver_name').select2({
        theme: 'bootstrap4'
    });

    $('#daterange').daterangepicker({
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

    table.draw( false );

    // $('#companiesLists tbody').on('click', 'td.rows-select', function () {
    //     var td = $(this).attr('class');
    //     var tr = $(this).closest('tr');                
    //     if ( td.indexOf("rows-select-down") >= 0 ) {            
    //         $(this).addClass("rows-select-up").removeClass("rows-select-down");
    //         tr.removeClass('down');
    //     }
    //     else {
    //         $(this).addClass("rows-select-down").removeClass("rows-select-up");
    //         tr.addClass('down');
    //     }
    // });
});


$('#btn-submit').on('click', function(){
    var datas={};
    datas.sweep_cars={};
    //console.log(datas.sweep_cars);
    var str;
    var inputs =  $("#companiesLists td[class='rows-select sorting_1 rows-select-down'] input").prev();
    inputs=inputs.prevObject;
    var len = inputs.length;
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
        title: '确认生成发运单?',
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
                    url:"{{route('wayBill.store')}}",
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

                        // $('#dispatch_table tbody').html('');
                        // $("#dispatch_no").focus();
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
        str =str+'<tr><td>'+val.dispatch_no+'</td></tr>';
        }); 

return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>发货单号:</td>'+
 
        '</tr>'+ str +'</table>';
};

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
                    var driverKey = $('#driver_name').val();
                    var dateKey = $('#daterange').val();
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
                        type: "POST",
                        url: "wayPrint/getData",
                        data :{
                            draw : page,
                            start : start,
                            length : length,
                            driverKey : driverKey,
                            dateKey : dateKey
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
                    // {   "data":"id",
                    //     "class":"rows-select",
                    //     "width":"40px",
                    //     "visible": true ,//是否显示
                    //     "orderable": false,//是否排序
                    //     "render": function(data,type,row,meta){
                    //         return '<input type="hidden" name="transport_'+data+'" id="transport_'+data+'" value="'+data+'"  >';
                    //     }
                    // },
                    { "data":"ccode" ,"orderable": false},
                    { "data":"cdriver","orderable": false },
                    { "data":"ccusadd","orderable": false },
                    { "data":"cmaker","orderable": false },
                    { "data":"billdate" ,"orderable": false},
                    { "data":"iPrintCount" ,"orderable": false},
                    {
                    targets: 6,//自定义列的序号，从0开始
                    data: "id", //需要引用的数据列，一般是主键         
                    render: function(data, type, full){
                        return '<div class="text-center py-0 align-middle">' +
                            '<div class="btn-group">' +
                            '<a href="wayPrint/'+data+'/getPrint" target="_blank" class="btn btn-info btn-xs"><i class="fa fa-trash-o fa-eye"></i>打印显示</a>' +
                            '</div>' +
                            '</div>';
                        }
                    }
                ]              

            });


</script>
@endsection