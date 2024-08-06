@extends('admins.layouts.app')

@section('include')

@endsection

@section('title', '扫码签回')
<link type="text/css" rel="styleSheet"  href="../css/111.css" />
@section('section')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>扫码签回</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">单据列表</li>
                        <!-- <li class="breadcrumb-item active">发货单列表</li> -->
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
                <div class="col-md-2">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><strong>单据编号</strong></span>
              </div>
              <!-- <input type="text" class="form-control" name="ccode" id="ccode" class="form control" autocomplete="off" maxlength="12" style="max-width: 180px" value="" /> -->
              <input type="text" class="form-control" name="ccode" id="ccode" autocomplete="off" value=""  style="max-width: 180px" onkeypress = "if (event.keyCode = 13)  {getydhinfo()};" />
              <!--       <input type="text"name="dispatch_no" id="dispatch_no" class="form control" onkeypress = "if (event.keyCode = 13)  {getdispatchlistinfo()};" /> -->
            </div>
          </div>
          <div class="col-md-2">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><strong>司机</strong></span>
              </div>
              <input type="text"name="cdriver" id="cdriver" class="form control" style="max-width: 96px"readonly/>
            </div>
          </div>
                    
            <div class="col-md-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><strong> 扫描结果</strong></span>
                    </div>
                    <input type="text" class="form-control" name="csocode" id="csocode" autocomplete="off" value=""  style="max-width: 180px" onkeypress = "if (event.keyCode = 13)  {getresultinfo()};" />
                    <!--       <input type="text"name="dispatch_no" id="dispatch_no" class="form control" onkeypress = "if (event.keyCode = 13)  {getdispatchlistinfo()};" /> -->
                </div>
            </div>
            <div class="col-md-2">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><strong>总单数</strong></span>
              </div>
              <input type="text"name="icount" id="icount" class="form control" style="max-width: 96px"readonly/>
            </div>
          </div>
          <div class="col-md-2">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><strong>已签回</strong></span>
              </div>
              <input type="text"name="sign" id="sign" class="form control" value="0" style="max-width: 96px"readonly/>
            </div>
          </div>
                    <div class="col-sm-1">    
                        <div class="input-group">
                            
                            <td>
                                <button type="button"  id="btn-submit1"  class="btn btn-block btn-success" disabled="true">签回</button>
                            </td>
                        </div>
                    </div>
                 
                  
                 

                </div>
                <table id="companiesLists" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>序号</th>
                        <th>单据编号</th>
                        <!-- <th>客户编码</th> -->
                        <th>客户简称</th>
                        <th>是否签回</th>
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
    table.draw( false );
});

//扫描结果回车事件
function getresultinfo(){
  if(event.keyCode == 13){

    // var result  = $(this).val();
    var csocode = $('#csocode').val();
    var ccode = $('#ccode').val();
    var url = "signBack/csocode_data?ccode="+ccode+"&csocode="+csocode;
              //如果发货单号为空,不得离开当前焦点
              if( $('#ccode').val()==''){
               Toast.fire({
                type: 'error',
                title: '发运单号为空，请先输入发运单号！'
              });

               $('#ccode').focus();
               $('<audio id="notifyAudio"><source src="/music/notify.ogg" type="audio/ogg"><source src="/music/notify.mp3" type="audio/mpeg"><source src="/music/notify.wav" type="audio/wav"></audio>').appendTo('body');
               $('#notifyAudio')[0].play();
               return false;
             }
        
             //如果扫描结果为空,不得离开当前焦点
              if( $('#csocode').val()==''){
                $('<audio id="notifyAudio"><source src="/music/notify.ogg" type="audio/ogg"><source src="/music/notify.mp3" type="audio/mpeg"><source src="/music/notify.wav" type="audio/wav"></audio>').appendTo('body');
                $('#notifyAudio')[0].play();
                //发货单号红框提示,toast提示
                    $("#csocode").addClass("is-invalid");
               Toast.fire({
                type: 'error',
                title: '扫描结果为空，请先扫描二维码！'
              });

               $('#csocode').focus();
               

             }
             else
             {

// 判断扫描结果是否合法
$.ajax({
                // var url = "result_data?dispatch_no="+dispatch_no+"&result="+result;
                url:''+url,               
                type:'post',
                dataType:'json',
                headers:{
                  Accept:"application/json",
                  "Content-Type":"application/json",
                  'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                },
                processData:false,
                cache:false,
                timeout: 1000,
                beforeSend:function(){

                },

                success:function(data){

                  if(data.status==0){
                    $('<audio id="notifyAudio"><source src="/music/notify.ogg" type="audio/ogg"><source src="/music/notify.mp3" type="audio/mpeg"><source src="/music/notify.wav" type="audio/wav"></audio>').appendTo('body');
                    $('#notifyAudio')[0].play();
                    //发货单号红框提示,toast提示
                    $("#csocode").addClass("is-invalid");
                    Toast.fire({
                      type: 'error',
                      title:  '发运单号：'+$('#ccode').val()+'  不存在发货单号'+$('#csocode').val(),
                    });
                    //清空扫描结果
                    $('#csocode').val('');
                    return false;
                  }else{
                     $('#csocode').val(data.csocode); //验证的结果重新赋值了，所以前端不用处理只输缩略的问题

                    //如果合法，焦点回到对应明细行验货数量上

                    $("#csocode").removeClass("is-invalid");

                    var tb = document.getElementById("companiesLists");

             //alert("表格总行数="+tb.rows.length);
            for (i = 1 ; i < tb.rows.length ; i++)
            {
              var cdlcode = tb.rows[i].cells[1].innerHTML;
               var issign = tb.rows[i].cells[3].innerHTML;
              var csocode = $('#csocode').val();
            //   alert(parseFloat(issign));
                    if (cdlcode==csocode&&parseFloat(issign)==0)  //扫描结果等于明细发货单号且未扫描过

                    {
                        $('<audio id="successAudio"><source src="/music/success.ogg" type="audio/ogg"><source src="/music/success.mp3" type="audio/mpeg"><source src="/music/success.wav" type="audio/wav"></audio>').appendTo('body');
                     $('#successAudio')[0].play();

            
                 // 光标显示到对应行上的验货数量文本框内
                 tb.rows[i].style.backgroundColor='#FFFF00'; //淡黄色
               
                 var issign = tb.rows[i].cells[3].innerHTML;
               
                    tb.rows[i].cells[3].innerHTML = 1;
                    var sign = $('#sign').val();
              
                    $('#sign').val(parseFloat(sign)+1);
                    var icount= $('#icount').val();
                    var signafter = $('#sign').val();
                    // alert(signafter);
                    if(signafter==icount){
                        // alert(11);
                        // $("#btn-submit1").removeClass("is-invalid");
                        $('#btn-submit1').prop('disabled', false); // 启用按钮
                    }

            //清空扫描结果
            $('#csocode').val('');

            return; 

          }
        
          else if (cdlcode==csocode&&parseFloat(issign)!=0)
          {
            $('<audio id="notifyAudio"><source src="/music/notify.ogg" type="audio/ogg"><source src="/music/notify.mp3" type="audio/mpeg"><source src="/music/notify.wav" type="audio/wav"></audio>').appendTo('body');
                    $('#notifyAudio')[0].play();
            Toast.fire({
                      type: 'error',
                      title:  '发货单号：'+$('#csocode').val()+'  已扫描过,请勿重复扫描'
                    });
                    $('#csocode').val('');

                    return; 
                }
                else{

                }

      }      

    }
    
  },
  error:function(){
    alert("登录超时");
    return false;
  }
});
}
}
}





//签回事件
$('#btn-submit1').on('click', function(){
    var sign = $('#sign').val();
   
    var icount= $('#icount').val();
    

    // if(sign!=icount){
    //     Toast.fire({
    //         type: 'error',
    //         title: '请选择要传输的单据！'
    //     });
    //     return false;       
    // };
    //考虑一下短位怎么办,短位后台处理


           


    Swal.fire({
        title: '是否确认签回单据?',
        text:'',
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


                var ccode= $('#ccode').val(); 
                // alert(ccode);
                $.ajax({
                    url:"{{route('signBack.store')}}",
                    data:JSON.stringify(ccode),
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
                    success:function(t){
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
                      
                        if(t.status == 0){
                        //上传成功提示
                        Swal.fire({
                            type: 'success',
                            title: t.title,
                            text: t.text
                        });
                        $('<audio id="successAudio"><source src="/music/success.ogg" type="audio/ogg"><source src="/music/success.mp3" type="audio/mpeg"><source src="/music/success.wav" type="audio/wav"></audio>').appendTo('body');
                        $('#successAudio')[0].play();
                        table.draw( false ) ;
                        $('#ccode').val('');
                        $("#ccode").focus();
                        // $('#icount').val('');
                        $('#btn-submit1').prop('disabled', true);
                    }
                    },
                    error:function(){
                        alert("error");
                    }
                });
            }else{
                $("#csocode").focus();
                return false;
            }
        });

});


             




//删行事件
function deleteCurrentRow(button) {
    var rowIndex = $(button).closest('tr').index();//动态获取所在的行

    // console.log(rowIndex);
    //获取所在的行有问题，最好取序号，再试试
    // var row = $(button).closest('tr'); //获取所在的行
   
    var i=rowIndex+1;    //获取所在的行
    // console.log(row1);
    var tb = document.getElementById("companiesLists");
    var issign1 = tb.rows[i].cells[3].innerHTML;//获取是否签到
    // console.log(issign1);
    var rowCount = tb.rows.length;
    // console.log(rowCount);
   if (rowCount <=2) {
    $('<audio id="notifyAudio"><source src="/music/notify.ogg" type="audio/ogg"><source src="/music/notify.mp3" type="audio/mpeg"><source src="/music/notify.wav" type="audio/wav"></audio>').appendTo('body');
                    $('#notifyAudio')[0].play();
                  Swal.fire({
                          type: 'error',
                          title: '最后一行，不能删除',
                          text: ''
                        });
                            return false;
   } ;
    
            // $('#dispatch_no').blur();
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
                          // 判断是否需要显示错误提示
                    //   if (issign1  == 1) {
                        
                    //      Toast.fire({
                    //      type: 'error',
                    //       title: '该行的发货单已经签回，无法删除！'
                    //      });
                    //          return;   
                    //   }
             
                        
                        // 发送删除请求
                    //     $.ajax({
                    //     headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
                    //     type: "POST",
                    //     // async:false,
                    //     url: "signBack/delete",
                    //     data :{
                           
                    //         ccodeKey : ccodeKey,
                    //         csocodeKey : csocodeKey
                    //     },                       
                    //     success:function(result){
                    //         var returnData = {};
                    
                    //     }
                    // })   
                    var csocodeKey = $(button).find('i').data('id'); //获取了按钮所在行的发货单号
                    // alert(csocodeKey);
                    var ccodeKey = $('#ccode').val();
                    $.ajax({
                    url:"{{route('signBack.destroy')}}",
                    //data:JSON.stringify(ccodeKey),
                     data:JSON.stringify({ csocodeKey: csocodeKey, ccodeKey: ccodeKey }),
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
                    success:function(t){
                        if(t.status == 1){
                            $('<audio id="notifyAudio"><source src="/music/notify.ogg" type="audio/ogg"><source src="/music/notify.mp3" type="audio/mpeg"><source src="/music/notify.wav" type="audio/wav"></audio>').appendTo('body');
                            $('#notifyAudio')[0].play();
                            //删除失败提示
                        Swal.fire({
                          type: 'error',
                          title: t.title,
                          text: t.text
                        });
                            return false;
                        }
                      
                        if(t.status == 0){
                        //删除成功提示
                        Swal.fire({
                            type: 'success',
                            title: t.title,
                            text: t.text
                        });
                        $('<audio id="successAudio"><source src="/music/success.ogg" type="audio/ogg"><source src="/music/success.mp3" type="audio/mpeg"><source src="/music/success.wav" type="audio/wav"></audio>').appendTo('body');
                        $('#successAudio')[0].play();

                        
                        // table.draw( false ) ;
                        // $('#ccode').val('');
                        // $("#ccode").focus();
                        // // $('#icount').val('');
                        // $('#btn-submit1').prop('disabled', true);
                    }
                    },
                    error:function(){
                        alert("error");
                    }
                });

                   if (issign1  == 1) {
                    
                    var sign = $('#sign').val();
                     $('#sign').val(parseFloat(sign)-1);
                    //      Toast.fire({
                    //      type: 'error',
                    //       title: '该行的发货单已经签回，无法删除！'
                    //      });
                    //          return;   
                       };
                        var tr=button.parentNode.parentNode;

                        var tbody=tr.parentNode;
                        tbody.removeChild(tr);

                        var tab = document.getElementById("companiesLists") ;
                        var rows = tab.rows.length-1 ;
                        // alert(rows);
                        $('#icount').val(rows);

                        // var sign = $('#sign').val();
              
                    // $('#sign').val(parseFloat(sign)+1);
                    var icount= $('#icount').val();
                    var signafter = $('#sign').val();
                    // alert(signafter);
                    if(signafter==icount){
                        // alert(11);
                        // $("#btn-submit1").removeClass("is-invalid");
                        $('#btn-submit1').prop('disabled', false); // 启用按钮
                    }


                        $("#csocode").focus();
                    }else{
                        $("#csocode").focus();
                    }
                })
        }


//查询回车事件
function getydhinfo(){
    if(event.keyCode == 13){
        $('#btn-submit1').prop('disabled', true);
// $('#btn-submit').on('click', function(){
    // function txtblur(event){ //当前元素失去焦点
var ccode = $('#ccode').val();
    if(ccode == ''){
        Toast.fire({
            type: 'error',
            title: '请输入发运单号！'
        });
        $('#ccode').addClass('is-invalid');
        $('#ccode').focus();
       
        $('<audio id="notifyAudio"><source src="/music/notify.ogg" type="audio/ogg"><source src="/music/notify.mp3" type="audio/mpeg"><source src="/music/notify.wav" type="audio/wav"></audio>').appendTo('body');
        $('#notifyAudio')[0].play();
        return false;
    }
    else{
        $('#csocode').focus();
        myajax1=$.ajax({
              data:{ccode:ccode},
              headers:{
                  'X-CSRF-TOKEN' : '{{ csrf_token() }}'
              },
              type: "post",
              async:false,
              dataType: "json",
              url:"signBack/getData1",
              success: function (result) {
                  $('#cdriver').val(result.cdriver);
                //   $('#ccusname').val(result.cCusName);
                //   $('#ddate').val(result.dDate);
                //   $('#position').val(result.no);
              }
          })
          $('<audio id="successAudio"><source src="/music/success.ogg" type="audio/ogg"><source src="/music/success.mp3" type="audio/mpeg"><source src="/music/success.wav" type="audio/wav"></audio>').appendTo('body');
          $('#successAudio')[0].play();
         table.draw( false ) ;
    }
      

        // var searchKey = $('#ccode').val();
    }};
// if (searchKey!='') {
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
                "bProcessing":true,
                "destroy":true,
                "iDisplayLength":5000,
                //  "order": [[2, "asc"]],


                "createdRow": function (row, data, dataIndex) {
             
                     $(row).addClass(' down ');
           
                },// 行属性处理

                "ajax":function(data,callback,settings){
                    var length = data.length;
                    var start = data.start;
                    var page = (data.start / data.length) + 1;
                    var ccodeKey = $('#ccode').val();
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
                        type: "POST",
                        url: "signBack/getData",
                        data :{
                            draw : page,
                            start : start,
                            length : length,
                            ccodeKey : ccodeKey
                        },                       
                        success:function(result){
                            var returnData = {};
                            // alert(result.recordsTotal);
                            returnData.recordsTotal = result.recordsTotal;
                            returnData.recordsFiltered = result.recordsFiltered;
                            returnData.data = result.data;
                            callback(returnData);
                            $('#icount').val(result.recordsTotal);//总单数取总行数
                            $('#sign').val(0);//查询成功后签回数清零
                        }
                    })                    
                },

                "columns":[  
                    {   "data":"ROWNU","orderable": false
                    },
                    { "data":"csocode" ,"orderable": false},
                    { "data":"ccusabbname" ,"orderable": false},
                    { "data":"issign" , 
                        "width":"65px",
                        "orderable": false,//是否排序                        
                        "visible": true ,//是否显示
                       },
                    {
                     "data": null,
                     "orderable": false,
                     "render": function (data, type, row) {
                        // alert(data.csocode);
                      return '<button class="btn btn-danger btn-sm btn-delete" href="javascript:void(0)" onclick="deleteCurrentRow(this)"><i class="fas fa-trash-Alt" data-id="' + data.csocode + '"></i></button>';
            }
        }
                 
                ]

            })

        // }
  




</script>

@endsection

