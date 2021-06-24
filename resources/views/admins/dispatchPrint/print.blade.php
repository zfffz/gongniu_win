@extends('admins.layouts.app')

@section('include')

@endsection

@section('title', '打印上海公牛发货单')
<script src="/js/LodopFuncs.js"></script>
<object  id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0>
    <embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0></embed>
</object>

@section('section')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-3">
                    <h4>打印</h4>
                    <button type="button" id="btn-submit" class="btn btn-info btn-xs"><i class="fa fa-trash-o fa-print"></i>打印</button>
                    <input id="printstatus" type="hidden" />
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card" id="card">
            <style>table,th{border:none;height:18px} td{border: 1px solid #000;height:18px}</style>
            <input class="col-md-1" type="hidden" id="count" name="count" value={{$n}} />
            @foreach($data2 as $datas )
           <div class="card-body" >
               <div id={{$datas[0]->divid}} >
                  <div class="row">
                      <input class="col-md-2" type="hidden" id="cdlcode" value = {{ $datas[0]->cDLCode}} />

                      @if($datas[0]->bj==0)
                      <span class="col-md-10 text-center"><h3 style="font-family:黑体; font-size:25px">上海公牛电器发货单</h3></span>
                     @else
                    @endif

                    @if($datas[0]->bj==-1)
                     <span class="col-md-10 text-center"><h3 style="font-family:黑体; font-size:25px">上海公牛电器发货单-1</h3></span>
                     @else
                    @endif

                    @if($datas[0]->bj==-2)
                    <span class="col-md-10 text-center"><h3 style="font-family:黑体; font-size:25px">上海公牛电器发货单-2</h3></span>
                     @else
                     @endif



                      <p class="col-md-10 text-center"  style="font-family:黑体; font-size:10.5pt; line-height:4px ">地址、电话:上海市春中路368号 60899198 </p>
                  </div>
                  <div class="row"  >
                    <h5 class="col-md-6 col-sm-6 col-xs-6" style="font-family:黑体; font-size:10.5pt; line-height:2.5pt;white-space: nowrap;">客户简称:{{ $datas[0]->ccusabbname }}</h5>
                    <h5 class="col-md-3 col-sm-3 col-xs-3" style="font-family:黑体; font-size:10.5pt; line-height:2.5pt;white-space: nowrap;">客户编码:{{ $datas[0]->cCusCode }}</h5>
                      <h5 class="col-md-3 col-sm-3 col-xs-3" style="font-family:黑体; font-size:10.5pt; line-height:2.5pt;white-space: nowrap;">发货单号:{{ $datas[0]->cDLCode}}</h5>
                       <h5 class="col-md-9 col-sm-9 col-xs-9" style="font-family:黑体; font-size:10.5pt; line-height:4.5pt;white-space: nowrap;text-overflow:ellipsis;">收货地址:{{ $datas[0]->cshipaddress }}</h5>
                      <h5 class="col-md-3 col-sm-3 col-xs-3" style="font-family:黑体; font-size:10.5pt; line-height:4.5pt;white-space: nowrap;">发货日期:{{ $datas[0]->dDate }}</h5>
                     
                      
                      
                      <h5 class="col-md-3 col-sm-3 col-xs-3" style="font-family:黑体; font-size:10.5pt; line-height:2.5pt;white-space: nowrap;">联系人:{{ $datas[0]->ccontactname }}</h5>
                     
                      <h5 class="col-md-3 col-sm-3 col-xs-3" style="font-family:黑体; font-size:10.5pt; line-height:2.5pt;white-space: nowrap;">手机:{{ $datas[0]->cmobilephone }}</h5>
                      <h5 class="col-md-3 col-sm-3 col-xs-3" style="font-family:黑体; font-size:10.5pt; line-height:2.5pt;white-space: nowrap;">电话:{{ $datas[0]->cofficephone }}</h5>
                      <h5 class="col-md-3 col-sm-3 col-xs-3" style="font-family:黑体; font-size:10.5pt; line-height:2.5pt;white-space: nowrap;">业务员:{{ $datas[0]->cpersonname }}</h5>
                      <h5 class="col-md-3 col-sm-3 col-xs-3" style="font-family:黑体; font-size:10.5pt; line-height:2.5pt;white-space: nowrap;">发运方式:{{ $datas[0]->cscname }}</h5>
                      <h5 class="col-md-6 col-sm-6 col-xs-6" style="font-family:黑体; font-size:10.5pt; line-height:2.5pt;white-space: nowrap;">结算方式:{{ $datas[0]->cssname }}</h5>
                      <h5 class="col-md-3 col-sm-3 col-xs-3" style="font-family:黑体; font-size:10.5pt; line-height:2.5pt;white-space: nowrap;">订单号:{{ $datas[0]->csocode }}</h5>
                      <h5 class="col-md-9 col-sm-9 col-xs-9" style="font-family:黑体; font-size:10.5pt; line-height:2.5pt;white-space: nowrap;">备注:{{ $datas[0]->cmemo }}</h5>
                      <h5 class="col-md-3 col-sm-3 col-xs-3" style="font-family:黑体; font-size:10.5pt; line-height:2.5pt;white-space: nowrap;">区域仓库:{{ $datas[0]->no }}</h5>
                  </div>
               </div>
               <div   id={{$datas[0]->tableid}} >
                <table class="table table-hover table-bordered" style="width: 100%;line-height:0.2pt;border: 1px solid black;word-break:break-all">
                    <tbody>
                    <tr>
          <th style="font-family:黑体; font-size:10.5pt ; line-height:3.8pt;">行</th>
          <th style="font-family:黑体; font-size:10.5pt ; line-height:3.8pt;">仓库</th>
      {{--<th style="font-family:黑体; font-size:10.5pt ; line-height:3.8pt;">存货编码</th>--}}
          <th style="font-family:黑体; font-size:10.5pt ; line-height:3.8pt;">规格</th>
          <th style="font-family:黑体; font-size:10.5pt ; line-height:3.8pt">存货编码</th>
          <th style="font-family:黑体; font-size:10.5pt ; line-height:3.8pt">存货名称</th>
          <th style="font-family:黑体; font-size:10.5pt ; line-height:3.8pt">数量</th>
          <th style="font-family:黑体; font-size:10.5pt ; line-height:3.8pt">单位</th>
         
           @if($datas[0]->noprice==1)
 
           @else
          <th style="font-family:黑体; font-size:10.5pt ; line-height:3.8pt">单价</th>
          <th style="font-family:黑体; font-size:10.5pt ; line-height:3.8pt">金额</th>
          @endif
          <!-- <th style="font-family:黑体; font-size:11pt ; line-height:initial">条码</th> -->
                    </tr>

                    @foreach ($datas[1] as $dats)
                        <tr>
                            <td width="5.9%" style="font-family:黑体; font-size:11pt;line-height:3.8pt;word-wrap: break-word;">{{ $dats->ROWNU }}</td>
                              <td width="8%" style="font-family:黑体; font-size:10.3pt;line-height:6.8pt;word-wrap: break-word; ">{{ ($dats->cWhName) }}</td>
                            <td width="8.9%" style="font-family:黑体; font-size:10.2pt; line-height:6.8pt;word-wrap: break-word;">{{ $dats->cInvStd }}</td>
                            <td width="9.5%" style="font-family:黑体; font-size:11pt;line-height:3.8pt ;word-wrap: break-word;">{{ $dats->cInvcode }}</td>
                            <td width="34.7%" style="font-family:黑体; font-size:10.5pt;line-height:8.8pt;word-wrap: break-word;">{{ $dats->cInvName }}</td>
                            <td width="6.5%" style="font-family:黑体; font-size:10.3pt;line-height:3.8pt;word-wrap: break-word;">{{ ($dats->iQuantity*1) }}</td>
                            <td width="6%" style="font-family:黑体; font-size:11pt;line-height:3.8pt;word-wrap: break-word;">{{ $dats->cComUnitName }}</td>

                            @if($datas[0]->noprice==1)
 
                             @else
                            <td width="8%" style="font-family:黑体; font-size:10.3pt;line-height:3.8pt;word-wrap: break-word;">{{ $dats->iTaxUnitPrice }}</td>
                            <td width="10.2%" style="font-family:黑体; font-size:10.3pt;line-height:3.8pt;word-wrap: break-word; ">{{ ($dats->isum) }}</td>
                             @endif
                          
                            
                            <!-- <td width="6%" style="font-family:黑体; font-size:11pt; line-height:3.8pt;word-wrap: break-word;">{{ $dats->cInvDefine5 }}</td> -->
                        </tr>
                    @endforeach
                    <tr>
                        <td width="5.9%" colspan="1" style="font-family:黑体; font-size:11pt;line-height:1.5pt">合计</td>
                         <td width="8%" colspan="1"></td>
                        <td width="8.9%" colspan="1"></td>
                        <td width="9.5%" colspan="1"></td>
                        <td width="34.7%" colspan="1"></td>
                        <td width="6.5%" style="font-family:黑体; font-size:10.3pt ;line-height:1.5pt" ><font  tdata="Sum" format="###" tindex="6" >######</font></td>
                        <td width="6%" colspan="1"></td>
                        @if($datas[0]->noprice==1)
 
                             @else
                        <td width="8%" colspan="1"></td>
                        <td width="10.2%" style="font-family:黑体; font-size:10.3pt ;line-height:1.4pt" ><font  tdata="Sum" format="###0.00" tindex="9" >######</font></td>
                         @endif
                        <!-- <td width="6%" colspan="1"></td> -->
                    </tr>
                    </tbody>
                </table>
               </div>
               <div  id={{$datas[0]->pageid}}>
                 <div class="row" >
                   <h5 class="col-md-3 col-sm-3 col-xs-3" style="font-family:黑体; font-size:10.5pt; line-height:1.5pt">制单人:{{ $datas[0]->cmaker }}</h5>
                   <h5 class="col-md-3 col-sm-3 col-xs-3" style="font-family:黑体; font-size:10.5pt; line-height:1.5pt">制单时间:{{ $datas[0]->createtime }}</h5>
                   <h5 class="col-md-3 col-sm-3 col-xs-3" style="font-family:黑体; font-size:10.5pt; line-height:1.5pt">审核人:{{ $datas[0]->cverifier }}</h5>
                   <h5 class="col-md-3 col-sm-3 col-xs-3" style="font-family:黑体; font-size:10.5pt; line-height:1.5pt">审核日期:{{ $datas[0]->dverifydate }}</h5>
                   <h5 class="col-md-3 col-sm-3 col-xs-3" style="font-family:黑体; font-size:10.5pt; line-height:1.5pt">配货员签字：</h5>
                   <h5 class="col-md-3 col-sm-3 col-xs-3" style="font-family:黑体; font-size:10.5pt; line-height:1.5pt">对货员签字：</h5>
                   <h5 class="col-md-3 col-sm-3 col-xs-3" style="font-family:黑体; font-size:10.5pt; line-height:1.5pt">打包员签字：</h5>
                   <h5 class="col-md-3 col-sm-3 col-xs-3" style="font-family:黑体; font-size:10.5pt; line-height:1.5pt">客户签字:</h5>
                   <h5 class="col-md-3 col-sm-3 col-xs-3" style="font-family:黑体; font-size:10.5pt; line-height:1.5pt">白联:留存</h5>
                   <h5 class="col-md-3 col-sm-3 col-xs-3" style="font-family:黑体; font-size:10.5pt; line-height:1.5pt">红联:仓库</h5>
                   <h5 class="col-md-3 col-sm-3 col-xs-3" style="font-family:黑体; font-size:10.5pt; line-height:1.5pt">蓝联:回单</h5>
                   <h5 class="col-md-3 col-sm-3 col-xs-3" style="font-family:黑体; font-size:10.5pt; line-height:1.5pt">黄联:客户</h5>
               </div>
               </div>
            </div>
            @endforeach
        </div>
    </div>
    </div>
    <!-- /.col -->
@endsection

@section('script')
    <script>
       const Toast = Swal.mixin({
      toast: true,
      position: 'middle-end',
      showConfirmButton: false,
      timer: 3000
    });
        $('#btn-submit').on('click', function(){
            // var printcount= $('#printstatus').val();
            // if (printcount > 0) {
            //     var m= $('#count').val();
             var m= $('#count').val();
                var datas ={};
                datas.items = {};
                for(var j=1;j<=m;j++) {
                    var divid = 'div' + j;
                    var cdlcode = $("#" + divid + " input[id='cdlcode']").val();
                    datas.items[j-1]={};
                    datas.items[j-1].cdlcode = cdlcode;
                }
// alert(datas);
            $.ajax({
                    url:"{{route('dispatchPrint.checkprint1')}}",
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
                    timeout: 3000,
                    success:function(t){
                        if(t.status==0){
                            //发货单号红框提示,toast提示
                             $('<audio id="notifyAudio"><source src="/music/notify.ogg" type="audio/ogg"><source src="/music/notify.mp3" type="audio/mpeg"><source src="/music/notify.wav" type="audio/wav"></audio>').appendTo('body');
                             $('#notifyAudio')[0].play();
                             // $("#dispatch_no").addClass("is-invalid");
                             // alert(t.text);
                            Toast.fire({
                                type: 'error',
                                title: t.text
                            });
                            // document.getElementById("select").click();
                            //清空发货单号
                            // $('#dispatch_no').val('');
                            // $("#dispatch_no").focus();
                            // result = false;
                        }else{
 $.ajax({
                    url:"{{route('dispatchPrint.checkprint2')}}",
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
                    timeout: 3000,
                    success:function(t){
                    }
  })
 LODOP=getLodop();
            LODOP.PRINT_INIT("打印控件功能演示_Lodop功能_无边线表格");
            // LODOP.SET_PRINT_MODE("HIDE_PBUTTIN_PREVIEW",1);
            // LODOP.SET_SHOW_MODE("HIDE_QBUTTIN_PREVIEW",0);
            // LODOP. SET_SHOW_MODE("HIDE_QBUTTIN_PREVIEW",true);
            // LODOP. SET_SHOW_MODE("PREVIEW_NO_MINIMIZE",true);
            // LODOP.SET_SHOW_MODE("SETUP_ENABLESS","11111111100000");
            LODOP.SET_SHOW_MODE ("PREVIEW_NO_MINIMIZE",true);//不让最小化
            LODOP.SET_PRINT_PAGESIZE(1,'240mm','139.50mm','');//定义纸张
            LODOP.SET_SHOW_MODE("LANDSCAPE_DEFROTATED",1);//横向时的正向显示
            LODOP.SET_PRINT_MODE("AUTO_CLOSE_PREWINDOW",1);//打印后自动关闭预览窗口
            var strBodyStyle = "<link href=\"http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css\" rel=\"stylesheet\"><style> .card{color: black}.table-bordered table,.table-bordered tbody tr th,.table-bordered tbody tr td{border: 1px solid  black; color: black/* 整体表格边框 */}</style>";
            //LODOP.ADD_PRINT_TABLE(50,10,"50%",220,document.getElementById("card").innerHTML);
            //LODOP.SET_PRINT_STYLEA(0,"Top2Offset",-40); //这句可让次页起点向上移
          //  LODOP.ADD_PRINT_BARCODE(Top,Left,Width,Height,QRCode,'$datas[0]->cDLCode');
            var m= $('#count').val();
            for(var j=1;j<=m;j++){
               var divid = 'div'+j;
               var tableid = 'table'+j;
               var pageid ='page'+j;
                var cdlcode = $("#"+divid+ " input[id='cdlcode']").val();
                var printtime = new Date();
                LODOP.ADD_PRINT_HTM(5, '8mm', "RightMargin:1.4cm", '100%',strBodyStyle+"<body>"+document.getElementById(divid).innerHTML+"</body>");
                LODOP.ADD_PRINT_TABLE('52.4mm','8mm', "RightMargin:1.4cm",'BottomMargin:9mm',strBodyStyle+"<body>"+document.getElementById(tableid).innerHTML+"</body>");
                // LODOP.SET_PRINT_MODE("FULL_HEIGHT_FOR_OVERFLOW",true);//高度溢出缩放
                LODOP.SET_PRINT_STYLEA(0,"Offset2Top",'-50.4mm'); //设置次页开始的上边距偏移量，解决table第二页不顶格的问题
                LODOP.ADD_PRINT_HTM('0.4mm', '8mm', "RightMargin:3cm", '100%', strBodyStyle+"<body>"+document.getElementById(pageid).innerHTML+"</body>");
                 // LODOP.ADD_PRINT_HTM('0.4mm', '10mm', "RightMargin:3cm", '100%','<style>*{background:#000}</style>'+strBodyStyle+"<body>"+document.getElementById(pageid).innerHTML+"</body>");
                LODOP.SET_PRINT_STYLEA(0,"LinkedItem",-1);//以上内容紧跟在前一个对象之后
              //  LODOP.SET_PRINT_STYLEA(0,"ItemType",1);
        //        LODOP.ADD_PRINT_HTM('12cm', 5, '97%', '100%',strBodyStyle+"<body>"+document.getElementById(pageid).innerHTML+"</body>");
    
                LODOP.ADD_PRINT_HTM("95%",'8mm',650,'3mm',"<font style='font-size:10pt' format='Num'><span tdata='pageNO'>第##页</span>/<span tdata='pageCount'>共##页</span></font>"); //打印页码
                LODOP.SET_PRINT_STYLEA(0,"ItemType",1);//设置上面的为页眉页脚，每页固定位置输出
                // LODOP.SET_PRINT_STYLEA(0,"LineSpacing",13);
           //     LODOP.SET_PRINT_STYLEA(0,"LinkedItem",1);
                LODOP.ADD_PRINT_BARCODE(19,750,80, 80, 'QRCode', cdlcode);  //打印发货单二维码
                LODOP.ADD_PRINT_TEXT(5,'8mm','50mm','5mm',printtime.toLocaleString( ));
                LODOP.NewPageA();  //自动分页
               // LODOP.ADD_PRINT_HTM(5, 5, '97%', '100%',strBodyStyle+"<body>"+document.getElementById("div1").innerHTML+"</body>");
            }
              if (LODOP.CVERSION) CLODOP.On_Return=function(TaskID,Value){
                document.getElementById('printstatus').value=Value;
                if (document.getElementById('printstatus').value >0){
                    $('#printstatus').change();
                
                }
                if(document.getElementById('printstatus').value ==0){
                   $.ajax({
                    url:"{{route('dispatchPrint.checkprint3')}}",
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
                    timeout: 3000,
                    success:function(t){
                    }
  })
                }
            };
            // alert()
            LODOP.PREVIEWB();
 $('#printstatus').change(function(){
            var printcount= $('#printstatus').val();
            if (printcount > 0) {
                var m= $('#count').val();
                var datas ={};
                datas.items = {};
                for(var j=1;j<=m;j++) {
                    var divid = 'div' + j;
                    var cdlcode = $("#" + divid + " input[id='cdlcode']").val();
                    datas.items[j-1]={};
                    datas.items[j-1].cdlcode = cdlcode;
                }
// alert(datas);
                $.ajax({
                    url:"{{route('dispatchPrint.updPrintstatus')}}",
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
                    timeout: 1000,
                    success:function(t){
                        //插入成功
                        if (t.FTranType ==0 ){//这里的FTranType对应后台数组的FTranType，判断要用“==”
                            alert(t.FText);   //t.FTranType ==0 插入失败，可能是发货单号不存在等原因
                            //插入失败，则添加插入失败的提示音（判断t.FText)
                        }
                    },
                    error:function(){
                        //系统错误，有可能是后台php语法错误，sql语句运行错误等
                        // alert("error");
                        //disLoad();
                    }
                });
            }
        });
                          // window.open("dispatchPrint/getPrint?datas="+datas);
                            //如果合法
                            // $("#dispatch_no").removeClass("is-invalid");
                            // result = true;
                        }
                    },
                    // error:function(){
                    //     alert("error");
                        // result = false;
                    // }
                });
      
           
          
             // window.close();
             b=document.getElementById('btn-submit');
b.disabled="disabled";
             // .disabled="disabled"
        });
       
    </script>
@endsection