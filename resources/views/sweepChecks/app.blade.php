@extends('admins.layouts.app')

@section('include')
@endsection
@section('title', '扫码对货')

@section('header')

<div class="container">
  <div class="row justify-content-center bg-light" style="height: 30px">
    <div class="align-self-center">
     <h3 class="card-title text-center"><strong>扫码对货 </strong></h3>
   </div>
 </div>
</div>
@endsection



@section('content')
<div class="content">
  <div class="container" style="margin:0px;padding:0px;max-width:2000px">
    <div class="card">

      <div class="card-body" style="border-bottom: 1px solid rgba(0,0,0,.125);padding-bottom: 0.25rem;">
        <form class="form-inline" role="form">
          <div class="col-sm-4 mb-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><strong>发货单号</strong></span>
              </div>
              <input type="text" class="form-control" name="dispatch_no" id="dispatch_no" class="form control" autocomplete="off" value=""  style="max-width: 186px" onkeypress = "if (event.keyCode = 13)  {getdispatchlistinfo()};"/>

              <!--       <input type="text"name="dispatch_no" id="dispatch_no" class="form control" onkeypress = "if (event.keyCode = 13)  {getdispatchlistinfo()};" /> -->
            </div>
          </div>

          <span class="input-group-text" style="margin-left: 6px"> 扫描规格</span>

              <select class="form-control" required name="standards" id="standards" style="width: 52%;">
                <option value="0" >按件扫描</option>
                <option value="1" >按箱扫描</option>

              </select>
<!-- 
            </div> -->
 <div class="card-header border-transparent">
            <div class="input-group">
              <div class="input-group-prepend">
               <div class="navbar-nav ml-auto" >
            
                <span class="input-group-text" style="margin-left: -15px"> 扫描结果</span>
              </div>
              <input type="text" class="form-control" name="result" id="result" autocomplete="off" value=""  style="max-width: 186px" onkeypress = "if (event.keyCode = 13)  {getresultinfo()};" />
              </div>



              </div>
  </div>
    </div>
   <!--    </div> -->
          <div class="col-sm-4 mb-3" style="display:none;">
            <div class="input-group" style="display:none;">
              <div class="input-group-prepend" style="display:none;">
                <span class="input-group-text"  style="display:none;"><strong>客户名称</strong></span>
              </div>
              <input type="text"name="ccusname" id="ccusname"  style="display:none;" class="form control" readonly/>
            </div>
          </div>

          <div class="col-sm-4 mb-3"  style="display:none;">
            <div class="input-group"  style="display:none;">
              <div class="input-group-prepend"  style="display:none;">
                <span class="input-group-text"  style="display:none;"><strong>单据日期</strong></span>
              </div>
              <input type="text"name="ddate" id="ddate" style="display:none;" class="form control" readonly/>
            </div>
          </div>


          <div class="col-sm-4 mb-3" style="display:none;">
            <div class="input-group" style="display:none;">
              <div class="input-group-prepend" style="display:none;">
                <span class="input-group-text" style="display:none;"><strong>默认库位</strong></span>
              </div>
              <input type="text"name="position" id="position"  style="display:none;" class="form control" readonly/>
            </div>
          </div>

          <div class="col-sm-4 mb-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" style="display:none;"><strong>对  货  员</strong></span>
              </div>
              <input type="text"name="checker" id="checker" style="display:none;"class="form control" value="{{Auth::user()->name}}" readonly/>
            </div>
          </div>            
</form> 
    <!--     </div> -->

     
        <!-- </div>
        < --><!-- div class="card-header border-transparent">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> 扫描结果:</span>
                </div>
                <input type="text"name="result" id="result" class="form control" value="" autocomplete="off" onkeypress = "if (event.keyCode = 13)  {getresultinfo()};"/>
            </div>
          </div> -->


          <!-- <div class="card-header border-transparent">
            <div class="input-group">
              <div class="input-group-prepend">
               <div class="navbar-nav ml-auto" >
                <span class="input-group-text" style="margin-left: 1px"> 扫描结果</span>
              </div>
              <input type="text" class="form-control" name="result" id="result" autocomplete="off" value=""  style="max-width: 50px" onkeypress = "if (event.keyCode = 13)  {getresultinfo()};" /> -->


              <!-- <span class="input-group-text" style="margin-left: 1px"> 扫描规格</span>

              <select class="form-control" required name="standards" id="standards" style="width: 100%;">
                <option value="0" >按件扫描</option>
                <option value="1" >按箱扫描</option>

              </select>

            </div> -->
             <!-- <div class="col-sm-2">
                        <div class="form-group">
                            
                        </div>
                    </div> 
                  -->
               <!--  </div>



              </div> -->


<!--  </form>  -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-bordered" id="dispatch_table" style="white-space:nowrap ; overflow:hidden ;">
                    <thead>
                      <tr>
                        <th style="display:none;">仓库名称</th>
                        <th>存货编码</th>
                        <th>存货名称</th>
                        <th style="display:none;">规格型号</th>
                        <th style="display:none;">单位</th>
                        <th style="display:none;">装箱规格</th>
                        <th style="display:none;">发货件数</th>
                        <!--  style="display:none;" -->
                        <!--      <th>验货件数</th> -->
                        <th>发货数量</th>
                        <th id="yQuantity">验货数量</th>
                      </tr>
                    </thead>
                    <tbody id="table_body" >
                    </tbody>
                  </table>
                </div>

              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <button onclick="deleteTable()" class="btn btn-danger float-left">清空</button>
                <button onclick="batchSave()" class="btn btn-primary float-right">保存</button>
              </div>
              <!-- /.card-footer -->
            </div>

          </div>
        </div>




        <div class="float-right d-none d-sm-inline">

        </div>
        <!-- Default to the left -->
        <!-- <a onclick="javascript:history.back(-1);"><i class="fas fa-arrow-left"></i> </a> -->
        <div class="row no-print">
          <div class="col-12">
            <a href="javascript:history.back(-1);" class="btn btn-info"><i class="fas fa-arrow-left"></i> 返回</a>
          </div>
        </div>
        @endsection



        @section('script')
        <script>



    //提示基础设置
    const Toast = Swal.mixin({
      toast: true,
      position: 'middle-end',
      showConfirmButton: false,
      timer: 3000
    });


    // 发货单号不为空，扫描规格变化后聚焦扫描结果
    $('#standards').change(function(){
  if( $('#dispatch_no').val()!=''){
$('#standards').removeClass('is-invalid');
                // $('#location_no').val('');
                $('#result').focus();

      }
      else
        $('#dispatch_no').focus();
      
              });
//发货单号回车事件

function getdispatchlistinfo(){
  if(event.keyCode == 13){
    $('#ddate').val('');
    $('#ccusname').val('');
    $('#position').val('');
    $('#result').val('');
    $("#result").removeClass("is-invalid");
    var dispatch_no = $('#dispatch_no').val();
    if(dispatch_no == ''){
      Toast.fire({
        type: 'warning',
        title: '发货单号不能为空！'
      });
      $('#dispatch_no').focus();
      $("#dispatch_no").addClass("is-invalid");
      return false;
    }

           //验证发货单号存不存在
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
            timeout: 1000,
            beforeSend:function(){

            },
            success:function(data){
              if(data.status==0){
                $('<audio id="notifyAudio"><source src="/music/notify.ogg" type="audio/ogg"><source src="/music/notify.mp3" type="audio/mpeg"><source src="/music/notify.wav" type="audio/wav"></audio>').appendTo('body');
                $('#notifyAudio')[0].play();
                                //发货单号红框提示,toast提示
                                $("#dispatch_no").addClass("is-invalid");
                                Toast.fire({
                                  type: 'error',
                                  title: data.text
                                });
                                //清空发货单号
                                $('#dispatch_no').val('');

                                if( $('#dispatch_no').val()==''){
                                  $('#dispatch_no').focus();

                                    // return false;
                                  }

                                // $('#dispatch_no').focus();
                                 // $('#dispatch_no').val(data.cDLCode); 
                               }
                               else
                                 {$.ajax({
                                  url:'dispatchss_data?dispatch_no='+dispatch_no,
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
                                    if(data.status==1){
                                      $('<audio id="notifyAudio"><source src="/music/notify.ogg" type="audio/ogg"><source src="/music/notify.mp3" type="audio/mpeg"><source src="/music/notify.wav" type="audio/wav"></audio>').appendTo('body');
                                      $('#notifyAudio')[0].play();
                                //发货单号红框提示,toast提示
                                $("#dispatch_no").addClass("is-invalid");
                                Toast.fire({
                                  type: 'error',
                                  title: data.text
                                });
                                //清空发货单号
                                $('#dispatch_no').val('');
                                $('#ddate').val('');
                                $('#ccusname').val('');
                                $('#position').val('');
                                $('#result').val(''); 
                                $('#dispatch_table tbody').html('');                
                                $('#dispatch_no').focus();
                              }
                              else
                              {
                                // $('#result').focus();
                                // $('#dispatch_no').focus();
                                $("#dispatch_no").removeClass("is-invalid");
                                //取发货单表头信息
                                $('#result').focus();
                                $("#dispatch_no").removeClass("is-invalid");
                                //ALERT("CEUI")
                                
                              }

                            }

                          })





                             }
                           }
                         })

//验证是否扫描过
// $.ajax({
//   url:'dispatchss_data?dispatch_no='+dispatch_no,
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
//     if(data.status==1){
//       $('<audio id="notifyAudio"><source src="/music/notify.ogg" type="audio/ogg"><source src="/music/notify.mp3" type="audio/mpeg"><source src="/music/notify.wav" type="audio/wav"></audio>').appendTo('body');
//       $('#notifyAudio')[0].play();
//                                 //发货单号红框提示,toast提示
//                                 $("#dispatch_no").addClass("is-invalid");
//                                 Toast.fire({
//                                   type: 'error',
//                                   title: data.text
//                                 });
//                                 //清空发货单号
//                                 $('#dispatch_no').val('');
//                                 $('#ddate').val('');
//                                 $('#ccusname').val('');
//                                 $('#position').val('');
//                                 $('#result').val(''); 
//                                 $('#dispatch_table tbody').html('');                
//                                 $('#dispatch_no').focus();
//                               }
//                               else
//                               {
//                                 // $('#result').focus();
//                                 // $('#dispatch_no').focus();
//                                 $("#dispatch_no").removeClass("is-invalid");
//                                 //取发货单表头信息
//                                 ALERT("CEUI")

//                               }

//                             }

//                           })


var searchKey = $('#dispatch_no').val();
$.ajax({
  data:{searchKey:searchKey},
  headers:{
    'X-CSRF-TOKEN' : '{{ csrf_token() }}'
  },
  type: "post",
  dataType: "json",
  url:"getData",
  success: function (result) {
    $('#ccusname').val(result.cCusName);
    $('#ddate').val(result.dDate); 
    $('#position').val(result.no);     
  }
})
          //取发货单表体信息
          $("#dispatch_table").dataTable().fnDestroy();
          var table =
          $('#dispatch_table').DataTable({
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
                       'paging'  : false,
                        // "white-space":nowrap,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": false,
                        "info": true,
                        "autoWidth": false,
                        "serverSide": true,
                        "bProcessing":true,
                        "iDisplayLength":20,
                          // "bstateSave": false, 
                        

                        "ajax":function(data,callback,settings){
                          var length = data.length;
                          var start = data.start;
                          var page = (data.start / data.length) + 1;
                          var searchKey = $('#dispatch_no').val();

                          $.ajax({
                            headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
                            type: "POST",
                            url: "dispatchs_data",
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

// "columnDefs" :
//                     [{
//                         className: "hide_column",
//                         "targets": [2,5] //将第3列和第6列隐藏，从0开始计数
//                     }],

                        "columns":[
                        { "data":"cWhName" },
                        { "data":"cInvCode" },
                        { "data":"cInvName" },
                        { "data":"cInvStd" },
                        { "data":"cComUnitName" },
                        { "data":"cinvDefine13" },
                        { "data":"iNum"},     
                        { "data":"iQuantity"}
                        // {"data":"cinvcode","render": function(data,type,row,meta){
                        //     return '<input type="text" name=car_"'+data+'" id=car_"'+data+'" value= 0  >';
                        // }}

                        ],
                    //     columnDefs:
                    // [{
                        
                    //     targets: 2, //将第3列和第6列隐藏，从0开始计数
                    //     visible: false
                    // }],   
                        columnDefs: [{
                    targets: 8,//自定义列的序号，从0开始
                    data: "cinvcode", //需要引用的数据列，一般是主键         
                    render: function(data, type, full){
                      // $('td', row).eq(4).attr('style', 'word-break:break-all');
                      var searchKey = $('#dispatch_no').val();
                      return '<input type="text" name="yQuantity"id="yQuantity" value=0  style="max-width: 50px" value="{{ old('yQuantity') }}" readonly onkeypress = "if (event.keyCode = 13)  {getyQuantityinfo()};">';
                       }
                     },
{
                         targets: [0,3,4,5,6], //将第3列隐藏，从0开始计数
                        visible: false


}


                     ]



// {
             
//                     targets: 0,//自定义列的序号，从0开始
// data: "cinvcode", //需要引用的数据列，一般是主键         
//                     render: function(data, type, full){
//                     "visible": false,   // 列不可见
//                     }
//                     },
        //              columnDefs: [{
        //         targets: 1,
        //         visible: false
        //         // "searchable": false
        //     },
        //     {
        //         "targets": [ 3 ],
        //         "visible": false
        //     }
        // ]



                   });



        }
      }



// $("#dispatch_table").DataTable( {      
//   "columnDefs" :
//                     [{
                        
//                         "targets": [2,5] //将第3列和第6列隐藏，从0开始计数
//                         "visible": false
//                     }],   
// });




//扫描结果回车事件
function getresultinfo(){
  if(event.keyCode == 13){
    // var result  = $(this).val();
    var result = $('#result').val();
    var dispatch_no = $('#dispatch_no').val();
    var url = "result_data?dispatch_no="+dispatch_no+"&result="+result;
              //如果发货单号为空,不得离开当前焦点
              if( $('#dispatch_no').val()==''){
               Toast.fire({
                type: 'error',
                title: '发货单号为空，请先扫描发货单！'
              });

               $('#dispatch_no').focus();

             }
             //如果扫描结果为空,不得离开当前焦点
              if( $('#result').val()==''){
                //发货单号红框提示,toast提示
                    $("#result").addClass("is-invalid");
               Toast.fire({
                type: 'error',
                title: '扫描结果为空，请先扫描二维码！'
              });

               $('#result').focus();

             }
             else
             {

// 判断扫描结果是否合法
$.ajax({
                // var url = "result_data?dispatch_no="+dispatch_no+"&result="+result;
                url:''+url,               
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
                  if(data.status==0){
                    $('<audio id="notifyAudio"><source src="/music/notify.ogg" type="audio/ogg"><source src="/music/notify.mp3" type="audio/mpeg"><source src="/music/notify.wav" type="audio/wav"></audio>').appendTo('body');
                    $('#notifyAudio')[0].play();
                    //发货单号红框提示,toast提示
                    $("#result").addClass("is-invalid");
                    Toast.fire({
                      type: 'error',
                      title:  '发货单号：'+$('#dispatch_no').val()+'  不存在存货编码:'+$('#result').val(),
                    });
                    //清空扫描结果
                    $('#result').val('');
                    return false;
                  }else{
                    //如果合法，焦点回到对应明细行验货数量上
                    $("#result").removeClass("is-invalid");

                    var tb = document.getElementById("dispatch_table");

            // alert("表格总行数="+tb.rows.length);
            for (i = 0 ; i < tb.rows.length ; i++)
            {
              var cinvcode = tb.rows[i].cells[0].innerHTML;

              var result = $('#result').val();
                    if (result==cinvcode)  //扫描结果等于明细存货编码

                    {

                 // 光标显示到对应行上的验货数量文本框内
                 tb.rows[i].style.backgroundColor='#FFFF00'; //淡黄色
                 tb.rows[i].cells[3].getElementsByTagName("input")[0].readOnly = false;

                 for (t = 1  ; t < tb.rows.length ; t++)//扫描新的结果原行的样式改变
                 {
                  if (t != i) 
                  {
                            // alert("123")
                            tb.rows[t].cells[3].getElementsByTagName("input")[0].readOnly = true;
                    // alert(tb.rows[t].style.backgroundColor)
                     if (tb.rows[t].style.backgroundColor=="rgb(255, 255, 0)") //淡黄色
                     {

                      tb.rows[t].style.backgroundColor=''
                    }

                    else
                    {
                    }
                  }     
                }
                var yQuantity = tb.tBodies[0].rows[i-1].cells[3].firstChild;
                var iQuantity = tb.rows[i].cells[2].innerHTML; 
                // var cinvDefine13 = tb.rows[i].cells[2].innerHTML; 
                var cinvDefine13 = $('#dispatch_table').DataTable().row(i-1).data().cinvDefine13;
                var standards = $('#standards').val();
                if(standards ==1)
                 {yQuantity.value = parseInt(yQuantity.value) + (1*parseInt(cinvDefine13));
                 }
                 else if (standards ==0) {
                  yQuantity.value = parseInt(yQuantity.value) + 1;
                }
                if(Number(yQuantity.value) >Number(iQuantity))
                {             
                  Toast.fire({
                    type: 'error',
                    title:'验货数量:'+Number(yQuantity.value)+'不能大于发货数量:'+Number(iQuantity), 

                  });
                  if(standards ==1)
                   {yQuantity.value = parseInt(yQuantity.value) - (1*parseInt(cinvDefine13));
                   }
                   else if (standards ==0) {
                    yQuantity.value = parseInt(yQuantity.value) - 1;
                  }
                  
                }
                else
                {}

            if(yQuantity.value==iQuantity) //验货数量等于数量
            {
              tb.rows[i].style.backgroundColor='#90EE90';  //淡绿色
              tb.rows[i].cells[3].getElementsByTagName("input")[0].readOnly = true;
              $('#result').val('');
            }
            //清空扫描结果
            $('#result').val('');

            return; 

          }
          else
          {}

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
// function getyQuantityinfo(){
// var u = document.getElementById("dispatch_table");
// if (u.Value == null) {
//       var y = document.getElementById("yhm");
//       y.innerHTML = "用户名为空";
//     }

//单元格回车事件（回车）
function getyQuantityinfo(){

  if(event.keyCode == 13){
    var tb = document.getElementById("dispatch_table");
    for (i = 1 ; i < tb.rows.length ; i++)
    {
      // var cinvcode = tb.rows[i].cells[1].innerHTML;
      var result = $('#result').val();
                    // if (result==cinvcode)   //扫描结果等于存货编码
                    //  {
                      var yQuantity = tb.tBodies[0].rows[i-1].cells[3].firstChild;
                      var iQuantity = tb.rows[i].cells[2].innerHTML;
                      // alert(yQuantity.value);
                      // alert(iQuantity);
                      if(parseInt(yQuantity.value)==parseInt(iQuantity))
                      {
                        tb.rows[i].cells[3].getElementsByTagName("input")[0].readOnly = true;
                        tb.rows[i].style.backgroundColor='#90EE90';
                        $('#result').focus();
                        $('#result').val('');
                      }
                      // alert(yQuantity.value);
                      // alert(iQuantity);

                      else if(parseInt(yQuantity.value) >parseInt(iQuantity))
                      { 

                        Toast.fire({
                          type: 'error',
                          title:'验货数量:'+Number(yQuantity.value)+'不能大于发货数量:'+Number(iQuantity), 
                        });
                    // alert(yQuantity.value)
                    yQuantity.value=("0")


                  }


                // }
              }

            }
          }
//保存按钮事件
function batchSave(){
  $('#dispatch_no').blur();
  var ccusname = $('#ccusname').val();
  var dispatch_no = $('#dispatch_no').val();
  var ddate = $('#ddate').val();
  var position = $('#position').val();
  var checker = $('#checker').val();


  var tb = document.getElementById("dispatch_table");
  for (i = 1 ; i < tb.rows.length ; i++)
  {
    var cinvcode = tb.rows[i].cells[0].innerHTML;
      //var result = $('#result').val();
                   // if (result==cinvcode)   //扫描结果等于存货编码
                   // {
                    var yQuantity = tb.tBodies[0].rows[i-1].cells[3].firstChild.value;
                    var iQuantity = tb.rows[i].cells[2].innerHTML;
                      // alert(yQuantity)
                      // alert(iQuantity)
                      if(parseInt(yQuantity) < parseInt(iQuantity))
                      {
                        Toast.fire({
                          type: 'error',
                          title: '第'+i+'行存货编码:'+cinvcode+'未完全对货，请继续对货！'
                        });
                        $('#result').focus();
                        return false;
                      }



               // }
             }


             if(dispatch_no == ''){
              Toast.fire({
                type: 'error',
                title: '未完全对货，请继续对货！'
              });
              $('#result').focus();
              return false;
            }

            //发货单号提示
            if(dispatch_no == ''){
              Toast.fire({
                type: 'error',
                title: '请扫描发货单号！'
              });
              $('#dispatch_no').focus();
              return false;
            }


            if(ccusname == ''){
              Toast.fire({
                type: 'error',
                title: '客户名称不能为空！'
              });
              $('#dispatch_no').focus();
              return false;
            }

            var trList = $("#table_body").children("tr");

            var length = trList.length;

            if(length == 0){
              Toast.fire({
                type: 'error',
                title: '明细为空无法保存！'
              });
              $('#dispatch_no').focus();
              return false;
            }

            var datas={};
            datas.dispatch_no = dispatch_no;
            datas.ccusname = ccusname;
            datas.ddate = ddate;
            datas.position = position;
            datas.checker = checker;
            datas.items = {};
            var tb = document.getElementById("dispatch_table");
            var ts = $('#dispatch_table').DataTable()
            for (var i=1;i<=length;i++){
              datas.items[i] = {};
                // var tdArr = trList.eq(i).find("td");
                
                
  datas.items[i].cWhName = ts.row(i-1).data().cWhName;
  datas.items[i].cInvCode = tb.rows[i].cells[0].innerHTML;
  datas.items[i].cInvName = tb.rows[i].cells[1].innerHTML;
  datas.items[i].cInvStd = ts.row(i-1).data().cInvStd;
  datas.items[i].cComUnitName = ts.row(i-1).data().cComUnitName;
  datas.items[i].cinvDefine13 = ts.row(i-1).data().cinvDefine13;
  datas.items[i].iNum = ts.row(i-1).data().iNum;
  datas.items[i].iQuantity = tb.rows[i].cells[2].innerHTML;
  datas.items[i].yQuantity = tb.tBodies[0].rows[i-1].cells[3].firstChild.value;


                // datas.items[i].iNum = tb.rows[i].cells[6].innerHTML;
                // datas.items[i].iQuantity = tb.rows[i].cells[7].innerHTML;
                // datas.items[i].yQuantity = tb.tBodies[0].rows[i-1].cells[8].firstChild.value;
              }
              Swal.fire({
                title: '确认保存数据到系统吗?',
                text:'共'+length+'条',
                footer: '发货单号：'+$('#dispatch_no').val(),
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
                    url:"{{route('sweepCheck.store')}}",
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
                                Swal.fire({
                                  toast: true,
                                  position: 'top-end',
                                  showConfirmButton: false,
                                  timer: 2200,
                                  type: 'success',
                                  title: '保存成功'
                                })
                                $('<audio id="successAudio"><source src="/music/success.ogg" type="audio/ogg"><source src="/music/success.mp3" type="audio/mpeg"><source src="/music/success.wav" type="audio/wav"></audio>').appendTo('body');
                                $('#successAudio')[0].play();

                                $('#dispatch_table tbody').html(''); 
                                $('#ddate').val('');
                                $('#dispatch_no').val('');
                                $('#ccusname').val('');
                                $('#position').val('');
                                $('#result').val('');
                                $('#dispatch_no').focus();
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


        //清空按钮事件
        function deleteTable() {
          $('#result').blur();
          var trList = $("#table_body").children("tr");

          var length = trList.length;

          if(length == 0){
            return false;
          }

          Swal.fire({
            title: '确认清空吗?',
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

              $('#ddate').val('');
              $('#dispatch_no').val('');
              $('#ccusname').val('');
              $('#position').val('');
              $('#result').val('');
              $('#dispatch_no').focus();
// return false
            }else{
              $("#result").focus();

            }

          })


        }



        //页面初始化，聚焦发货单号
            $('#dispatch_no').focus();
          

      </script>
      @endsection
