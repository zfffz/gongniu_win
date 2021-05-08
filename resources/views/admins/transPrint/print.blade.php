@extends('admins.layouts.app')

@section('include')

@endsection

@section('title', '打印调运单')
<script src="/js/LodopFuncs.js"></script>
<object  id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0> 
       <embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0></embed>
</object>
@section('section')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-3">
                    <h4>打印调运单</h4>
                    <button type="button" id="btn-submit" class="btn btn-info btn-xs"><i class="fa fa-trash-o fa-print"></i>打印调运单</button>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card" id="card">
        <style>table,th{border:none;height:18px} td{border: 1px solid #000;height:18px}</style>    

            <div class="card-body">
                            <div class="row">
                                <span class="col-md-10 text-center"><h3 style="font-family:黑体; font-size:25px">调拨运输清单</h3></span>
                            </div> 
                            <div class="row">
                                <h5 class="col-md-3 col-sm-3 col-xs-3" style="font-family:黑体; font-size:11pt">运输单号:{{ $data[0]->ccode }}</h5>
                                <h5 class="col-md-3 col-sm-3 col-xs-3" style="font-family:黑体; font-size:11pt">调拨出仓库:{{ $data[0]->cWhName }}</h5>
                                <h5 class="col-md-3 col-sm-3 col-xs-3" style="font-family:黑体; font-size:11pt">制单日期:{{ $data[0]->billdate }}</h5>
                                <h5 class="col-md-3 col-sm-3 col-xs-3" style="font-family:黑体; font-size:11pt">司机:{{ $data[0]->cdriver }}</h5>
                                <h5 class="col-md-3 col-sm-3 col-xs-3" style="font-family:黑体; font-size:11pt">发运方式:{{ $data[0]->cSCName }}</h5>
                            </div>
                 <table class="table table-hover table-bordered" style="width: 100%;border: 1px solid black">
                        <tbody> 
                            <tr>
                                <th style="font-family:黑体; font-size:10pt">序号</th>
                                <th style="font-family:黑体; font-size:10pt">来源单号</th>
                                <th style="font-family:黑体; font-size:10pt">调拨日期</th>
                                <th style="font-family:黑体; font-size:10pt">DMS单号</th>
                                <th style="font-family:黑体; font-size:10pt">客户名称</th>
                                <th style="font-family:黑体; font-size:10pt">经手人</th>
                                <th style="font-family:黑体; font-size:10pt">金额</th>
                                <th style="font-family:黑体; font-size:10pt">表体备注</th>
                            </tr>
                            @foreach ($data[1] as $dats)

                                <tr>
                                    <td width="8%" style="font-family:黑体; font-size:10pt">{{ $dats->ROWNU }}</td>
                                    <td width="10%" style="font-family:黑体; font-size:10pt">{{ $dats->csocode }}</td>
                                    <td width="12%" style="font-family:黑体; font-size:10pt">{{ $dats->dTVDate }}</td>
                                    <td width="12%" style="font-family:黑体; font-size:10pt">{{ $dats->cDefine2 }}</td>
                                    <td width="12%" style="font-family:黑体; font-size:10pt;">{{ $dats->cDefine3 }}</td>
                                    <td width="8%" style="font-family:黑体; font-size:10pt">{{ $dats->cPersonName }}</td>
                                    <td width="7%" style="font-family:黑体; font-size:10pt">{{ $dats->amount*1 }}</td>
                                    <td width="15%" style="font-family:黑体; font-size:10pt">{{ $dats->bz }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                </table>
                <tfoot>
                    <div class="row">
                        <h5 class="col-md-4 col-sm-4 col-xs-4" style="font-family:黑体; font-size:11pt">司机：</h5>
                        <h5 class="col-md-4 col-sm-4 col-xs-4" style="font-family:黑体; font-size:11pt">送货日期：</h5>
                        <h5 class="col-md-4 col-sm-4 col-xs-4" style="font-family:黑体; font-size:11pt">签回人：</h5>
                    </div>
                </tfoot> 
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
        LODOP.SET_PRINT_PAGESIZE(2,0,0,'A4');//定义纸张
        LODOP.SET_SHOW_MODE("LANDSCAPE_DEFROTATED",1);//横向时的正向显示
        LODOP.SET_PRINT_MODE("AUTO_CLOSE_PREWINDOW",1);//打印后自动关闭预览窗口
        var strBodyStyle = "<link href=\"http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css\" rel=\"stylesheet\"><style> .card{color: black}.table-bordered table,.table-bordered tbody tr th,.table-bordered tbody tr td{border: 1px solid  black; color: black/* 整体表格边框 */}</style>";
        //LODOP.ADD_PRINT_TABLE(50,10,"50%",220,document.getElementById("card").innerHTML);
        //LODOP.SET_PRINT_STYLEA(0,"Top2Offset",-40); //这句可让次页起点向上移
        LODOP.ADD_PRINT_HTM(5, 3, '98%', '93%',strBodyStyle+"<body>"+document.getElementById("card").innerHTML+"</body>");
        
        LODOP.SET_PRINT_STYLEA(0,"LinkedItem",-1);
         LODOP.ADD_PRINT_HTM('20cm','10mm',300,'8mm',"<font style='font-size:10pt' format='Num'><span tdata='pageNO'>第##页</span>/<span tdata='pageCount'>共##页</span></font>"); //打印页码
         LODOP.SET_PRINT_STYLEA(0,"ItemType",1);
        LODOP.PREVIEW();
});

</script>
@endsection