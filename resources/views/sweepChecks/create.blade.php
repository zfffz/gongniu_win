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
              <input type="text" class="form-control" name="dispatch_no" id="dispatch_no" class="form control" autocomplete="off" maxlength="12" value=""  style="max-width: 186px" onkeypress = "if (event.keyCode = 13)  {getdispatchlistinfo()};"/>

              <!--       <input type="text"name="dispatch_no" id="dispatch_no" class="form control" onkeypress = "if (event.keyCode = 13)  {getdispatchlistinfo()};" /> -->
            </div>
          </div>

          <div class="col-sm-4 mb-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><strong>客户名称</strong></span>
              </div>
              <input type="text"name="ccusname" id="ccusname" class="form control" readonly/>
            </div>
          </div>

          <div class="col-sm-4 mb-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><strong>单据日期</strong></span>
              </div>
              <input type="text"name="ddate" id="ddate" class="form control" readonly/>
            </div>
          </div>


          <div class="col-sm-4 mb-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><strong>默认库位</strong></span>
              </div>
              <input type="text"name="position" id="position" class="form control" readonly/>
            </div>
          </div>

          <div class="col-sm-4 mb-3">
            <div class="input-group">
              <div class="input-group-prepend">
                 <span class="input-group-text"><strong>对货员</strong></span>
               <!--   <label style="margin-top: 2px;margin-right: 1px;">对货员</label> -->
               <!--  <span class="input-group-text"><strong>对  货  员</strong></span> -->
              </div>
               <select class="form-control" name="checker" id="checker" margin-left="100px" style="max-width: 186px" >

      <option value=""></option>
      @foreach ($checkers as $checker)
        <option value="{{ $checker->name }}">
          {{ $checker->name }}
        </option>
      @endforeach

    </select>
            </div>
          </div>    

           <div class="col-sm-2">    
                        <div class="input-group">
                            <td>
                                <button type="button" id="addRow" class="btn btn-block btn-primary" style="max-width: 150px">分组</button>
                            </td>
                        </div>
                    </div>      
<!--  <button type="button" id="addRow"  class="btn btn-block btn-primary"  style="width: 155px;">分组</button>
                   </label> -->
        </div>

      </form> 
        <!-- </div>
        < --><!-- div class="card-header border-transparent">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> 扫描结果:</span>
                </div>
                <input type="text"name="result" id="result" class="form control" value="" autocomplete="off" onkeypress = "if (event.keyCode = 13)  {getresultinfo()};"/>
            </div>
          </div> -->


          <div class="card-header border-transparent">
            <div class="input-group">
              <div class="input-group-prepend">
               <div class="navbar-nav ml-auto" >
                <span class="input-group-text" style="margin-left: 8px"> 扫描结果:</span>
              </div>
              <input type="text" class="form-control" name="result" id="result" autocomplete="off" value=""  style="max-width: 180px" onkeypress = "if (event.keyCode = 13)  {getresultinfo()};" />



<!-- <table id="example" class="display" cellspacing="0" width="100%"> -->


              <span class="input-group-text" style="margin-left: 105px"> 扫描规格:</span>

              <select class="form-control" required name="standards" id="standards" style="width: 100%;">
                <option value="0" >按支扫描</option>
                <option value="1" >按箱扫描</option>

              </select>
<label style="padding-right:138px;">
 </div>
 <div class="col-sm-2">    
                        <div class="input-group">
                            <td>
                                <button type="button" id="btn-print" class="btn btn-block btn-info" style="margin-left: 23px">拼箱箱标打印</button>
                            </td>
                        </div>
                    </div>

                    <select class="form-control" required name="fz" id="fz" style="max-width: 50px" disabled="disabled" >
                <option value="1" >A</option>
                <option value="2" >B</option>
                <option value="3" >C</option>
                <option value="4" >D</option>
                <option value="5" >E</option>
                <option value="6" >F</option>
                <option value="7" >G</option>
                <option value="8" >H</option>
                <option value="9" >I</option>
                <option value="10" >J</option>
                <option value="11" >K</option>
                <option value="12" >L</option>
                <option value="13" >M</option>
                <option value="14" >N</option>
                <option value="15" >O</option>
                <option value="16" >P</option>
                <option value="17" >Q</option>
                <option value="18" >R</option>
                <option value="19" >S</option>
                <option value="20" >T</option>
                <option value="21" >U</option>
                <option value="22" >V</option>
                <option value="23" >W</option>
                <option value="24" >X</option>
                <option value="25" >Y</option>
                <option value="26" >Z</option>
              </select>
            <!-- 
                <button type="button" id="addRow"  class="btn btn-block btn-primary"  style="width: 80px;">分组</button>
                   </label> -->


             <!-- <div class="col-sm-2">
                        <div class="form-group">
                            
                        </div>
                    </div> 
                  -->
                </div>



              </div>

 <form class="form-inline" role="form">
           
            <div class="col-sm-4 mb-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"  style="margin-left: 18px">总箱数</span>
              </div>
              <input type="text"name="CTNS" id="CTNS" class="form control" />
            </div>
          </div>
           <div class="col-sm-4 mb-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"  style="margin-left: 8px">整箱数量</span>
              </div>
              <input type="text"name="ZXSL" id="ZXSL" class="form control" disabled="disabled" />
            </div>
          </div>

        
           </form>

              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-bordered" id="dispatch_table" style="white-space:nowrap ; overflow:hidden ;">
                    <thead>
                      <tr>
                        <th>仓库名称</th>
                        <th>存货编码</th>
                        <th>存货名称</th>
                        <th>规格型号</th>
                        <th>单位</th>
                        <th>装箱规格</th>
                        <th>发货件数</th>
                        <th>发货数量</th>
                        <th id="yQuantity">验货数量</th>
                        <th id="zb">组别</th>
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
                <button onclick="batchSave()" class="btn btn-primary float-right">保存并打印</button>
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

    // var num = 1;//全局变量,分组A\B\C\D
    // $('#btn-print').on('click', function(){
    //   num=num+1;
    // })
//发货单号回车事件

function getdispatchlistinfo(){
  if(event.keyCode == 13){
    $('#ddate').val('');
    $('#ccusname').val('');
    $('#position').val('');
    $('#ZXSL').val('0');
    $('#CTNS').val('0');
    $('#result').val('');
    $('#standards').val('0');
    $('#fz').val('1');
    
    
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
    if(dispatch_no.length <6){
      Toast.fire({
        type: 'warning',
        title: '位数需大于五位！'
      });
      $('#dispatch_no').focus();
      $("#dispatch_no").addClass("is-invalid");
      return false;
    }

           
// var searchKey = $('#dispatch_no').val();
// $.ajax({
//   data:{searchKey:searchKey},
//   headers:{
//     'X-CSRF-TOKEN' : '{{ csrf_token() }}'
//   },
//   type: "post",
//   dataType: "json",
//   url:"getData",
//   success: function (result) {
//     $('#dispatch_no').val(result.cDLCode);
//     $('#ccusname').val(result.cCusName);
//     $('#ddate').val(result.dDate); 
//     $('#position').val(result.no);     
//   }
// })




           // $.ajax({
           //  url:'dispatch_data?dispatch_no='+dispatch_no,
  
           //  // url:"dispatch_data",
           //  type:'get',
           //  dataType:'json',
           //  headers:{
           //     // 'X-CSRF-TOKEN' : '{{ csrf_token() }}'
           //    Accept:"application/json",
           //    "Content-Type":"application/json"
           //  },
           //  processData:false,
           //  cache:false,
           //  timeout: 1000,

//验证发货单号存不存在
            var searchKey = $('#dispatch_no').val();
$.ajax({
  data:{searchKey:searchKey},
  headers:{
    'X-CSRF-TOKEN' : '{{ csrf_token() }}'
  },
  type: "post",
  // async:false,
  dataType: "json",
  url:"dispatch_data",
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
                                  // async:false,
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




var searchKey = $('#dispatch_no').val();

if (searchKey!='') {
$.ajax({
  data:{searchKey:searchKey},
  headers:{
    'X-CSRF-TOKEN' : '{{ csrf_token() }}'
  },
  type: "post",
  // async:false,
  dataType: "json",
  url:"getData",
  success: function (result) {
    $('#dispatch_no').val(result.cDLCode);
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
            'paging'      : false,
                        // "white-space":nowrap,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": false,
                        "info": true,
                        "autoWidth": false,
                        "serverSide": true,
                        "bProcessing":true,
                        "iDisplayLength":20,
                        

                        "ajax":function(data,callback,settings){
                          var length = data.length;
                          var start = data.start;
                          var page = (data.start / data.length) + 1;
                          var searchKey = $('#dispatch_no').val();

                          $.ajax({
                            headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
                            type: "POST",
                            // async:false,
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
                        "columns":[
                        { "data":"cWhName" },
                        { "data":"cInvCode" },
                        { "data":"cInvName" },
                        { "data":"cInvStd" },
                        { "data":"cComUnitName" },
                        { "data":"cinvDefine13" },
                        { "data":"iNum"}, 
                        // { "data":"kz"},     
                        {"data":"iQuantity"}
                        // {"data":"cinvcode","render": function(data,type,row,meta){
                        //     return '<input type="text" name=car_"'+data+'" id=car_"'+data+'" value= 0  >';
                        // }}

                        ],
                        columnDefs: [{
                    targets: 8,//自定义列的序号，从0开始

                    data: "cinvcode", //需要引用的数据列，一般是主键         
                    render: function(data, type, full){
                      var searchKey = $('#dispatch_no').val();
                      return '<input type="text" name="yQuantity"id="yQuantity" value=0  readonly style="width: 70px" oninput="fun();">';




                         // 

// onblur="getyQuantityinfo()";">';
// onkeypress = "if (event.keyCode = 13)  {getyQuantityinfo()};">';
                       }
                     },

                       {
                         targets: 9, //将第3列隐藏，从0开始计数
                       data: "cinvcode", //需要引用的数据列，一般是主键         
                    render: function(data, type, full){
                      var searchKey = $('#dispatch_no').val();
                      return '<select id="yw"  name="zb" id="zb"  disabled="disabled" style="width: 38px;" ><option value=" "> </option></select>';

                      // '<select id="yw"><option value=""></option><option value="A">A</option><option value="B">B</option><option value="C">C</option><option value="D">D</option><option value="E">E</option><option value="F">F</option><option value="G">G</option><option value="H">H</option></select>'

                         }
                              }


                     ]




                   



                   });

}
// var tb = document.getElementById("dispatch_table");

        }
      }


//组别下拉菜单选择事件
      function selectOnchang(obj){ 
var arr = []; //新增数组
 var zxs = $('#ZXSL').val();
var tb = document.getElementById("dispatch_table");
  for (i = 1 ; i < tb.rows.length ; i++)
    {
      
       var iNum = tb.rows[i].cells[6].innerHTML;   
       if  (parseFloat(iNum)<1)
       {
        var data = tb.rows[i].cells[9].firstChild.selectedIndex; //
        if (data!=0) {
          if (arr.indexOf(data)<0) {
              arr.push(data);
          }
      }
    }

    }

    $('#CTNS').val(parseFloat(zxs)+parseFloat(arr.length));

}


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
// var searchKey = $('#dispatch_no').val();
// $.ajax({
//   // data:{searchKey:searchKey},
//  headers:{
//                   Accept:"application/json",
//                   "Content-Type":"application/json"
//                 },
//   type: "post",
//   dataType: "json",
//   // url:"result_data",
//   url:''+url, 
                success:function(data){

                  if(data.status==0){
                    $('<audio id="notifyAudio"><source src="/music/notify.ogg" type="audio/ogg"><source src="/music/notify.mp3" type="audio/mpeg"><source src="/music/notify.wav" type="audio/wav"></audio>').appendTo('body');
                    $('#notifyAudio')[0].play();
                    //发货单号红框提示,toast提示
                    $("#result").addClass("is-invalid");
                    Toast.fire({
                      type: 'error',
                      title:  '发货单号：'+$('#dispatch_no').val()+'  不存在存货编码'+$('#result').val(),
                    });
                    //清空扫描结果
                    $('#result').val('');
                    return false;
                  }else{
                     $('#result').val(data.cInvCode);

                    //如果合法，焦点回到对应明细行验货数量上

                    $("#result").removeClass("is-invalid");

                    var tb = document.getElementById("dispatch_table");

            // alert("表格总行数="+tb.rows.length);
            for (i = 0 ; i < tb.rows.length ; i++)
            {
              var cinvcode = tb.rows[i].cells[1].innerHTML;
              var iNum = tb.rows[i].cells[6].innerHTML;
              var result = $('#result').val();
                    if (result==cinvcode&&parseFloat(iNum)<1)  //扫描结果等于明细存货编码且件数小于1

                    {

                 // 光标显示到对应行上的验货数量文本框内
                 tb.rows[i].style.backgroundColor='#FFFF00'; //淡黄色
                 tb.rows[i].cells[8].getElementsByTagName("input")[0].readOnly = false;

                 for (t = 1  ; t < tb.rows.length ; t++)//扫描新的结果原行的样式改变
                 {
                  if (t != i) 
                  {
                            // alert("123")
                            tb.rows[t].cells[8].getElementsByTagName("input")[0].readOnly = true;
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
                var yQuantity = tb.tBodies[0].rows[i-1].cells[8].firstChild;
                 var iQuantity = tb.rows[i].cells[7].innerHTML;
                 var iNum = tb.rows[i].cells[6].innerHTML;
                var cinvDefine13 = tb.rows[i].cells[5].innerHTML; 
                var standards = $('#standards').val();
                if(standards ==1)
                 {
                  yQuantity.value = parseInt(yQuantity.value) + (1*parseInt(cinvDefine13));
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
// alert(iQuantity);

            if(parseInt(yQuantity.value)==parseInt(iQuantity)&&parseFloat(iNum)<1) //验货数量等于数量且件数小于1
            {
              tb.rows[i].style.backgroundColor='#3CB371'; //桔黄色
              tb.rows[i].cells[8].getElementsByTagName("input")[0].readOnly = true;

   

       tb.rows[i].cells[9].firstChild.selectedIndex=num; 



 {     var arr = []; //新增数组
 var zxs = $('#ZXSL').val();
// var tb = document.getElementById("dispatch_table");
  // for (i = 1 ; i < tb.rows.length ; i++)
  //   {
      
       
       if  (parseFloat(iNum)<1)
       {
        var data = tb.rows[i].cells[9].firstChild.selectedIndex; //那个单元格的自己换
        if (data!=0) {
          if (arr.indexOf(data)<0) {
              arr.push(data);
          }
      }
    }

    // }
}
    $('#CTNS').val(parseFloat(zxs)+parseFloat(arr.length));



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
var num = 1;//全局变量,分组A\B\C\D
//拼箱打印事件
$('#btn-print').on('click', function(){
var tb = document.getElementById("dispatch_table");
 var sum=0;
 result = true;
     

    // var zb = $('#fz').text() ;

    // var myselect=document.getElementById("fz");
    //  var zb =myselect.options[index].text;

  //    var elem = document.getElementById("fz");
  //    var index=elem.selectedIndex;         
  //      alert(elem.options[index].value);
  //       alert(elem.options[index].id);
  // var zb =obj.options[obj.selectedIndex];
  // alert(obj);
  //点击判断每行分组是否有值，有值就加1
    for (i = 1 ; i < tb.rows.length ; i++)
    {
      var zb = tb.rows[i].cells[9].firstChild.selectedIndex;
       sum= sum + zb;
     }
      if(sum>0)
      {
         // num=num+1;






  $('#dispatch_no').blur();
  var ccusname = $('#ccusname').val();
  var dispatch_no = $('#dispatch_no').val();
  var ddate = $('#ddate').val();
  var position = $('#position').val();
  var checker = $('#checker').val();


  var tb = document.getElementById("dispatch_table");
  for (i = 1 ; i < tb.rows.length ; i++)
  {
    var cinvcode = tb.rows[i].cells[1].innerHTML;
    var yQuantity = tb.tBodies[0].rows[i-1].cells[8].firstChild.value;
    var iQuantity = tb.rows[i].cells[7].innerHTML;
    var iNum = tb.rows[i].cells[6].innerHTML;
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
                title: '明细为空！'
              });
              $('#dispatch_no').focus();
              return false;
            }

            var datas={};
            datas.dispatch_no = dispatch_no;
            datas.items = {};
            var t=0;
            var tb = document.getElementById("dispatch_table");
            for ( i=1;i<=length;i++){
              var yQuantity = tb.tBodies[0].rows[i-1].cells[8].firstChild.value;
    var iQuantity = tb.rows[i].cells[7].innerHTML;
    var iNum = tb.rows[i].cells[6].innerHTML;

    var fz =  tb.rows[i].cells[9].firstChild.selectedIndex
    // alert(parseInt(iQuantity));
    //   alert(parseInt(yQuantity));
    //   alert(parseFloat(iNum));
    // alert(parseInt(fz));
              if(parseInt(yQuantity)==parseInt(iQuantity)&&parseFloat(iNum)<1&&parseInt(fz)==(num))
              {
                datas.items[i] = {};
                
                datas.items[i].cInvName = tb.rows[i].cells[2].innerHTML;
               
                datas.items[i].iQuantity = tb.rows[i].cells[7].innerHTML;
                datas.items[i].zb = tb.tBodies[0].rows[i-1].cells[9].firstChild.value
                t=t+1;
               }
              }
              Swal.fire({
                title: '确认打印拼箱箱标吗?',
                text:'共'+t+'行明细',
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
                    url:"{{route('sweepCheck.print')}}",
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
                                     result = false;
                                  }
                                //上传成功提示
                                // Swal.fire({
                                //   toast: true,
                                //   position: 'top-end',
                                //   showConfirmButton: false,
                                //   timer: 2200,
                                //   type: 'success',
                                //   title: '保存成功'
                                // })
                                // $('<audio id="successAudio"><source src="/music/success.ogg" type="audio/ogg"><source src="/music/success.mp3" type="audio/mpeg"><source src="/music/success.wav" type="audio/wav"></audio>').appendTo('body');
                                // $('#successAudio')[0].play();

    // window.location.href = "lgetPrint?datas="+datas;

    // var zb = $('#fz').name();
    // var myselect=document.getElementById("fz");
    //  var zb =myselect.options[index].text;

     // var obj = document.getElementById("fz");
//分组信息
num=num+1;
  var zb = $("#fz option:checked").text();  
$('#fz').val(num);
    // alert(zb);
                      window.open("lgetPrint?datas="+dispatch_no+"&zb="+zb);
     // window.open("lgetPrint?datas="+dispatch_no);
                               result = true;
                              },
                              error: function() {
                                alert("error");
                              }
                            });
                }
                else
                {
                  $("#dispatch_no").focus();
                  return false;
                }
              })
              // alert(result);
            if(result){
                // return true;
 // window.open("lgetPrint?datas="+dispatch_no);
        //  var datas='';
        // inputs.each(function () {
        //     datas = datas + $(this).val()+'|';
        // });
      
     // window.open("http://www.baidu.com");
        // window.open = "dispatchPrint/lgetPrint?datas="+dispatch_no;
                    
                }
                else{
                    return false;
                }











      }
      else
      {
            Toast.fire({
            type: 'error',
            title: '未选择组别,请先选择组别！'
        });
        return false;
      }







    // var inputs = $("#dispatchlist input[name='ckb-jobid']:checked ").prev();
    // inputs=inputs.prevObject;

    // var len = inputs.length;
    // if(len == 0){
    //     Toast.fire({
    //         type: 'error',
    //         title: '请选择要打印的单据！'
    //     });
    //     return false;
    // }else{
    //     var datas='';
    //     inputs.each(function () {
    //         datas = datas + $(this).val()+'|';
    //     });
    //     window.location.href = "dispatchPrint/getPrint?datas="+datas;

    // };

});
//单元格回车事件（回车）
function fun(){

  // if(event.keyCode == 13){
    var i = event.srcElement.parentElement.parentElement.rowIndex; // 通过event.srcelement 获取激活事bai件du的对象 td
 var tb = document.getElementById("dispatch_table");
 var iNum = tb.rows[i].cells[6].innerHTML;
 var yQuantity = tb.tBodies[0].rows[i-1].cells[8].firstChild;
var iQuantity = tb.rows[i].cells[7].innerHTML;
                      if(parseInt(yQuantity.value)==parseInt(iQuantity))
                      {
                        tb.rows[i].cells[8].getElementsByTagName("input")[0].readOnly = true;
                        tb.rows[i].style.backgroundColor='#3CB371'; //桔黄色
                        tb.rows[i].cells[9].firstChild.selectedIndex=num; 
 $('#result').focus();

{ 
//总箱数联动
var arr = []; //新增数组
 var zxs = $('#ZXSL').val();
// var tb = document.getElementById("dispatch_table");
  for (i = 1 ; i < tb.rows.length ; i++)
    {
      
//        var iNum = tb.rows[i].cells[6].innerHTML;   
       if  (parseFloat(iNum)<1)
       {
        var data = tb.rows[i].cells[9].firstChild.selectedIndex; //
        if (data!=0) {
          if (arr.indexOf(data)<0) {
              arr.push(data);
          }
      }
    }

     }

    $('#CTNS').val(parseFloat(zxs)+parseFloat(arr.length));
  }


                        // tb.fireEvent("onchange");
                        $('#result').focus();
                        $('#result').val('');
                      }
                      else if(parseInt(yQuantity.value) >parseInt(iQuantity))
                      { 

                        Toast.fire({
                          type: 'error',
                          title:'验货数量:'+Number(yQuantity.value)+'不能大于发货数量:'+Number(iQuantity), 
                        });
                    // alert(yQuantity.value)
                    yQuantity.value=("0")


                  }
 // $('#result').focus();

                // }
              // }

            }
          







    // 
// alert(td);
// alert("行号：" + (td.parentElement.rowIndex + 1) + "，内容：zhi" + td.innertext);
    // alert(1);








//     var tb = document.getElementById("dispatch_table");
//     for (i = 1 ; i < tb.rows.length ; i++)
//     {
//       var cinvcode = tb.rows[i].cells[1].innerHTML;
//       var result = $('#result').val();
//                     // if (result==cinvcode)   //扫描结果等于存货编码
//                     //  {
//                       var yQuantity = tb.tBodies[0].rows[i-1].cells[8].firstChild;
//                       var iQuantity = tb.rows[i].cells[7].innerHTML;
//                       var iNum = tb.rows[i].cells[6].innerHTML;
//                       // alert(parseInt(yQuantity.value));
//                       // alert(parseInt(iQuantity));
//                       // alert(parseFloat(iNum));
//                       if(parseInt(yQuantity.value)==parseInt(iQuantity)&&parseFloat(iNum)<1)
//                       {
//                         tb.rows[i].cells[8].getElementsByTagName("input")[0].readOnly = true;
//                         tb.rows[i].style.backgroundColor='#FFA500'; //桔黄色
//                         tb.rows[i].cells[9].firstChild.selectedIndex=num; 


// { 
// //总箱数联动
// var arr = []; //新增数组
//  var zxs = $('#ZXSL').val();
// // var tb = document.getElementById("dispatch_table");
// //   // for (i = 1 ; i < tb.rows.length ; i++)
// //   //   {
      
// //        var iNum = tb.rows[i].cells[6].innerHTML;   
//        if  (parseFloat(iNum)<1)
//        {
//         var data = tb.rows[i].cells[9].firstChild.selectedIndex; //那个单元格的自己换
//         if (data!=0) {
//           if (arr.indexOf(data)<0) {
//               arr.push(data);
//           }
//       }
//     }

//     // }

//     $('#CTNS').val(parseFloat(zxs)+parseFloat(arr.length));
//   }


//                         // tb.fireEvent("onchange");
//                         $('#result').focus();
//                         $('#result').val('');
//                       }
//                       // alert(yQuantity.value);
//                       // alert(iQuantity);

//                       else if(parseInt(yQuantity.value) >parseInt(iQuantity))
//                       { 

//                         Toast.fire({
//                           type: 'error',
//                           title:'验货数量:'+Number(yQuantity.value)+'不能大于发货数量:'+Number(iQuantity), 
//                         });
//                     // alert(yQuantity.value)
//                     yQuantity.value=("0")


//                   }


//                 // }
//               }

//             }
//           }
//保存按钮事件
function batchSave(){
  $('#dispatch_no').blur();
  var ccusname = $('#ccusname').val();
  var dispatch_no = $('#dispatch_no').val();
  var ddate = $('#ddate').val();
  var position = $('#position').val();
  var checker = $('#checker').val();
   var CTNS = $('#CTNS').val();


  var tb = document.getElementById("dispatch_table");
  for (i = 1 ; i < tb.rows.length ; i++)
  {
    var cinvcode = tb.rows[i].cells[1].innerHTML;
      //var result = $('#result').val();
                   // if (result==cinvcode)   //扫描结果等于存货编码
                   // {
                    var yQuantity = tb.tBodies[0].rows[i-1].cells[8].firstChild.value;
                    var iQuantity = tb.rows[i].cells[7].innerHTML;
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

            if(checker == ''){
              Toast.fire({
                type: 'error',
                title: '对货员不能为空，请选择！'
              });
              $('#checker').focus();
              return false;
            }

            if(CTNS == ''){
              Toast.fire({
                type: 'error',
                title: '箱数不能为空！'
              });
              $('#CTNS').focus();
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
var ctns = $('#CTNS').val();

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
            datas.CTNS = CTNS;
            datas.items = {};
            var tb = document.getElementById("dispatch_table");
            for (var i=1;i<=length;i++){
              datas.items[i] = {};
                // var tdArr = trList.eq(i).find("td");
                
                
                datas.items[i].cWhName = tb.rows[i].cells[0].innerHTML;
                datas.items[i].cInvCode = tb.rows[i].cells[1].innerHTML;
                datas.items[i].cInvName = tb.rows[i].cells[2].innerHTML;
                datas.items[i].cInvStd = tb.rows[i].cells[3].innerHTML;
                datas.items[i].cComUnitName = tb.rows[i].cells[4].innerHTML;
                datas.items[i].cinvDefine13 = tb.rows[i].cells[5].innerHTML;
                datas.items[i].iNum = tb.rows[i].cells[6].innerHTML;
                datas.items[i].iQuantity = tb.rows[i].cells[7].innerHTML;
                datas.items[i].yQuantity = tb.tBodies[0].rows[i-1].cells[8].firstChild.value;
                // datas.items[i].zb = tb.rows[i].cells[8].innerHTML;
                datas.items[i].zb = tb.tBodies[0].rows[i-1].cells[9].firstChild.value;
              }
              Swal.fire({
                title: '确认保存数据并打印吗?',
                text:'共'+length+'条'+','+'共'+ctns+'箱',
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
                                 $('#CTNS').val('');
                                  $('#ZXSL').val('');
                                  $('#fz').val('1');
                                $('#dispatch_no').focus();
                              },
                              error: function() {
                                alert("error");
                              }
                            });



var dispatch_no = $('#dispatch_no').val();


                              $.ajax({
                                  url:'outboxPrint?datas='+dispatch_no,
                                  type:'post',
                                  async:false,
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
// alert(data.status);
                                    if(data.status==0){
                                      $('<audio id="notifyAudio"><source src="/music/notify.ogg" type="audio/ogg"><source src="/music/notify.mp3" type="audio/mpeg"><source src="/music/notify.wav" type="audio/wav"></audio>').appendTo('body');
                                      $('#notifyAudio')[0].play();
                                //发货单号红框提示,toast提示
                                // $("#dispatch_no").addClass("is-invalid");
                                 Toast.fire({
                                  type: 'error',
                                  title: "未对货,箱数为空,请先对货！"
                                });
                      result = false;

                                  }

             }
             });

  
    // alert(result);
     if(result){
                // return true;

        // var datas='';
        // inputs.each(function () {
        //     datas = datas + $(this).val()+'|';
        // });
        // window.open = "outboxPrint?datas="+datas;
        window.open("outboxPrint?datas="+dispatch_no);
                    
                }
                else{
                    return false;
                }


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

            }else{
              $("#result").focus();

            }

          })


        }


//分组点击事件
$('#addRow').on( 'click', function (){


   $('#dispatch_no').blur();
  var ccusname = $('#ccusname').val();
  var dispatch_no = $('#dispatch_no').val();
  var ddate = $('#ddate').val();
  var position = $('#position').val();
  var checker = $('#checker').val();


var tb = document.getElementById("dispatch_table");
  for (i = 1 ; i < tb.rows.length ; i++)
  {
    var cinvcode = tb.rows[i].cells[1].innerHTML;
      //var result = $('#result').val();
                   // if (result==cinvcode)   //扫描结果等于存货编码
                   // {




                    // 为了测试方便临时关闭
                    var yQuantity = tb.tBodies[0].rows[i-1].cells[8].firstChild.value;
                    var iQuantity = tb.rows[i].cells[7].innerHTML;
                      // alert(yQuantity)
                      // alert(iQuantity)
                      // if(parseInt(yQuantity) < parseInt(iQuantity))
                      // {
                      //   Toast.fire({
                      //     type: 'error',
                      //     title: '第'+i+'行存货编码:'+cinvcode+'未完全对货，请继续对货！'
                      //   });
                      //   $('#result').focus();
                        
                      //   return false;
                      // }



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
            'paging'      : false,
                        // "white-space":nowrap,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": false,
                        "info": true,
                        "autoWidth": false,
                        "serverSide": true,
                        "bProcessing":true,
                        "iDisplayLength":20,
                        

                        "ajax":function(data,callback,settings){
                          var length = data.length;
                          var start = data.start;
                          var page = (data.start / data.length) + 1;
                          var searchKey = $('#dispatch_no').val();

                          $.ajax({
                            headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
                            type: "POST",
                            url: "dispatchscf_data",
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
// var yQuantity = tb.tBodies[0].rows[i-1].cells[8].firstChild;
   var zxs=0;
//    for (i = 1 ; i < tb.rows.length ; i++)
//     {
      
// }
 for (i = 1 ; i < tb.rows.length ; i++)
    {
       var iNum = tb.rows[i].cells[6].innerHTML;
        var xg = tb.rows[i].cells[5].innerHTML;

       var cinvcode = tb.rows[i].cells[1].innerHTML;
        if (xg=='') 
 {
 Swal.fire({
  // <a href=">存货基础信息</a>
    // 'You can use <b>bold text</b>, ' +
    // '<a href="//sweetalert2.github.io">links</a> ' +
    // 'and other HTML tags',
                title: '确认继续对货?',
                html:'存货编码:'+cinvcode+'没有包装规格, 可在' +
                '<a href="//gongniu_win.test/admin/carton/'+cinvcode+'/edit" target="_blank">存货基础信息</a> ' +
                // '可在<a href="{{route('carton.index')}}">存货基础信息</a> ' +
                '中维护',
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
                if(n.value){}
                  else{
                    $('#dispatch_table tbody').html('');

              $('#ddate').val('');
              $('#dispatch_no').val('');
              $('#ccusname').val('');
              $('#position').val('');
              $('#result').val('');
              $('#CTNS').val('');
              $('#ZXSL').val('');
              $('#dispatch_no').focus();
                  }

})
//        var xg = tb.rows[i].cells[5].innerHTML;
// // tb.rows[i].style.backgroundColor='#90EE90'; 
// // alert(xg);
//  if (xg=='') 
//  {
//      Toast.fire({
//         type: 'warning',
//         title: '箱规有空值！'
//       });
 }
 if (parseFloat(iNum)<1) 

{
 
  tb.tBodies[0].rows[i-1].cells[8].firstChild.value="0";





}
      if ( parseFloat(iNum)>=1) //扫描结果等于明细存货编码

                    {      
                    
                   tb.tBodies[0].rows[i-1].cells[9].firstChild.disabled="disabled";   tb.rows[i].style.backgroundColor='#90EE90'; 

tb.tBodies[0].rows[i-1].cells[9].firstChild.style="background-color: LightGrey";

zxs =  zxs +parseFloat(iNum);

                 }



                // }
              }


$('#ZXSL').val(zxs);
$('#CTNS').val(zxs);


                            }
                          })
                        },
                        "columns":[
                        { "data":"cWhName" },
                        { "data":"cInvCode" },
                        { "data":"cInvName" },
                        { "data":"cInvStd" },
                        { "data":"cComUnitName" },
                        { "data":"cinvDefine13" },
                        { "data":"iNum"}, 
                        // { "data":"kz"},  
                        {"data":"iQuantity"}, 
                        {"data":null}
                        // {"data":"cinvcode","render": function(data,type,row,meta){
                        //     return '<input type="text" name=car_"'+data+'" id=car_"'+data+'" value= 0  >';
                        // }}

                        ],
                        columnDefs: [{
                    targets: 9,//自定义列的序号，从0开始

                    data: "cinvcode", //需要引用的数据列，一般是主键         
                    render: function(data, type, full){
                      var searchKey = $('#dispatch_no').val();
                      // return '<input type="checkbox" value="A" name="zb"id="zb"  >';
                      // return '<select><option value="已完成">已完成</option><option value="未完成">未完成</option></select>'''
                       return '<select id="yw" onchange="selectOnchang(this)"  style="width: 38px;"><option value=""></option><option value="A">A</option><option value="B">B</option><option value="C">C</option><option value="D">D</option><option value="E">E</option><option value="F">F</option><option value="G">G</option><option value="H">H</option></select>'

                       }
                     },

{
 targets: 8,//自定义列的序号，从0开始

                    data: "cinvcode", //需要引用的数据列，一般是主键         
                    render: function(data, type, full){
                      var searchKey = $('#dispatch_no').val();
                      // return '<input type="checkbox" value="A" name="zb"id="zb"  >';
                      // return '<select><option value="已完成">已完成</option><option value="未完成">未完成</option></select>'''
          return '<input type="text" name="yQuantity"id="yQuantity" value="' + data.iQuantity + '"  readonly style="width: 70px;" oninput="fun();">';


}}

                     ]
          



                   });


    
    } );
 



        //页面初始化，聚焦发货单号
            $('#dispatch_no').focus();
          

      </script>
      @endsection
