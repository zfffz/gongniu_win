@extends('admins.layouts.app')

@section('include')

@endsection

@section('title', '打印上海公牛配货单')
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
           <div class="card-body" id={{$datas[0]->divid}}  >
                <div class="row">
                    <input class="col-md-2" type="hidden" id="cdlcode" value = {{ $datas[0]->cDLCode}} ></input>
                    <span class="col-md-10 text-center"><h3 style="font-family:黑体; font-size:25px">上海公牛配货单</h3></span>
                </div>
                <div class="row">
                    <h5 class="col-sm-4" style="font-family:黑体; font-size:11pt">发货单号:{{ $datas[0]->cDLCode}}</h5>
                    <h5 class="col-sm-3" style="font-family:黑体; font-size:11pt">客户编码:{{ $datas[0]->cCusCode }}</h5>
                    <h5 class="col-sm-2" style="font-family:黑体; font-size:11pt">区域仓库:{{ $datas[0]->no }}</h5>
                    <h5 class="col-sm-5" style="font-family:黑体; font-size:11pt">客户简称:{{ $datas[0]->ccusabbname }}</h5>
                    <h5 class="col-sm-7" style="font-family:黑体; font-size:11pt">收货地址:{{ $datas[0]->cshipaddress }}</h5>
                    <h5 class="col-sm-12" style="font-family:黑体; font-size:11pt">备注:{{ $datas[0]->cmemo }}</h5>
                </div>
                <table class="table table-hover table-bordered" style="width: 100%;border: 1px solid black">
                    <tbody>
                    <tr>
                        <th style="font-family:黑体; font-size:11pt">行</th>
                        <th style="font-family:黑体; font-size:11pt">仓库</th>
                        <th style="font-family:黑体; font-size:11pt">存货编码</th>
                        <th style="font-family:黑体; font-size:11pt">存货名称</th>
                        <th style="font-family:黑体; font-size:11pt">规格</th>
                        <th style="font-family:黑体; font-size:11pt">单位</th>
                        <th style="font-family:黑体; font-size:11pt">数量</th>
                        <th style="font-family:黑体; font-size:11pt">条码</th>
                    </tr>
                    @foreach ($datas[1] as $dats)
                        <tr>
                            <td width="5%" style="font-family:黑体; font-size:11pt">{{ $dats->ROWNU }}</td>
                            <td width="8%" style="font-family:黑体; font-size:11pt">{{ $dats->cWhName }}</td>
                            <td width="10%" style="font-family:黑体; font-size:11pt">{{ $dats->cInvcode }}</td>
                            <td width="28%" style="font-family:黑体; font-size:11pt">{{ $dats->cInvName }}</td>
                            <td width="7%" style="font-family:黑体; font-size:11pt">{{ $dats->cInvStd }}</td>
                            <td width="7%" style="font-family:黑体; font-size:11pt">{{ $dats->cComUnitName }}</td>
                            <td width="10%" style="font-family:黑体; font-size:11pt">{{ ($dats->iQuantity)*1 }}</td>
                            <td width="20%" style="font-family:黑体; font-size:11pt">{{ $dats->cInvDefine5 }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <tfoot>
                <div class="row">
                    <h5 class="col-md-4" style="font-family:黑体; font-size:11pt">当前是第<font tdata="PageNO" format="Num" color="blue">##</font>页</span>/共<font tdata="PageCount" format="Num" color="blue">##</font></span>页</h5>
                </div>
                </tfoot>
            </div>
            @endforeach
        </div>
    </div>
    </div>
    <!-- /.col -->
@endsection

@section('script')
    <script>
        $('#btn-submit').on('click', function(){
            LODOP=getLodop();
            LODOP.PRINT_INIT("打印控件功能演示_Lodop功能_无边线表格");
            LODOP.SET_PRINT_PAGESIZE(2,0,0,'A5');//定义纸张
            LODOP.SET_SHOW_MODE("LANDSCAPE_DEFROTATED",1);//横向时的正向显示
            LODOP.SET_PRINT_MODE("AUTO_CLOSE_PREWINDOW",1);//打印后自动关闭预览窗口
            var strBodyStyle = "<link href=\"http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css\" rel=\"stylesheet\"><style> .card{color: black}.table-bordered table,.table-bordered tbody tr th,.table-bordered tbody tr td{border: 1px solid  black; color: black/* 整体表格边框 */}</style>";
            //LODOP.ADD_PRINT_TABLE(50,10,"50%",220,document.getElementById("card").innerHTML);
            //LODOP.SET_PRINT_STYLEA(0,"Top2Offset",-40); //这句可让次页起点向上移
          //  LODOP.ADD_PRINT_BARCODE(Top,Left,Width,Height,QRCode,'$datas[0]->cDLCode');
            var m= $('#count').val();
            for(var j=1;j<=m;j++){
                var cdlcode = $("#"+j+ " input[id='cdlcode']").val();
                LODOP.ADD_PRINT_HTM(5, 5, '97%', '100%',strBodyStyle+"<body>"+document.getElementById(j).innerHTML+"</body>");
               // LODOP.ADD_PRINT_BARCODE(5,900,160, 80, 'Code93', cdlcode);
                LODOP.ADD_PRINT_BARCODE(5,650,80, 80, 'QRCode', cdlcode);
              //  LODOP.SET_PRINT_STYLEA(0,"LinkedItem",-1);
                LODOP.NewPageA();  //自动分页
               // LODOP.ADD_PRINT_HTM(5, 5, '97%', '100%',strBodyStyle+"<body>"+document.getElementById("div1").innerHTML+"</body>");
            }

            LODOP.PREVIEW();
           // LODOP.PRINT_DESIGN();
        });

    </script>
@endsection