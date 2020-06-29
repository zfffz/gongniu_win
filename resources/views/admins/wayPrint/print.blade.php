@extends('admins.layouts.app')

@section('include')

@endsection

@section('title', '打印发运单')
<script src="/js/LodopFuncs.js"></script>
<object  id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0> 
       <embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0></embed>
</object>
@section('section')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-3">
                    <h4>打印发运单</h4>
                    <button type="button" id="btn-submit" class="btn btn-info btn-xs"><i class="fa fa-trash-o fa-print"></i>打印发运单</button>
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
                                <span class="col-md-12 text-center"><h3>发货运输清单</h3></span>
                            </div> 
                            <div class="row">
                                <h5 class="col-md-3">运输单号:{{ $data[0]->ccode }}</h5>
                                <h5 class="col-md-3">制单日期:{{ $data[0]->billdate }}</h5>
                                <h5 class="col-md-3">司机:{{ $data[0]->cdriver }}</h5> 
                                <h5 class="col-md-3">发运方式:{{ $data[0]->cSCName }}</h5>
                            </div>
                 <table class="table table-hover table-bordered" style="width: 100%;border: 1px solid black">
                        <tbody> 
                            <tr>
                                <th>序号</th>
                                <th>来源单号</th>
                                <th>发货日期</th>
                                <th>订单号</th>
                                <th>客户编码</th>
                                <th>客户简称</th>
                                <th>结算方式</th>
                                <th>金额</th>
                                <th>表体备注</th>
                            </tr>
                            @foreach ($data[1] as $dats)
                                <tr>
                                    <td>{{ $dats->ROWNU }}</td>
                                    <td>{{ $dats->csocode }}</td>
                                    <td>{{ $dats->ddate }}</td>
                                    <td>{{ $dats->csdcode }}</td>
                                    <td>{{ $dats->ccuscode }}</td>
                                    <td>{{ $dats->ccusabbname }}</td>
                                    <td>{{ $dats->cSSName }}</td>
                                    <td>{{ $dats->amount*1 }}</td>
                                    <td>{{ $dats->bz }}</td>                                    
                                </tr>
                            @endforeach
                        </tbody>
                </table>
                <tfoot>
                    <div class="row">
                        <h5 class="col-md-4">司机：</h5>
                        <h5 class="col-md-4">送货日期：</h5>
                        <h5 class="col-md-4">签回人：</h5> 
                    </div>
                    <div class="row">
                        <h5 class="col-md-4">当前是第<font tdata="PageNO" format="Num" color="blue">##</font>页</span>/共<font tdata="PageCount" format="Num" color="blue">##</font></span>页</h5>
                    </div>
                </tfoot> 
                </div>         
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
        LODOP.ADD_PRINT_HTM(5, 5, '97%', '100%',strBodyStyle+"<body>"+document.getElementById("card").innerHTML+"</body>");
        
        LODOP.SET_PRINT_STYLEA(0,"LinkedItem",-1);
        LODOP.PREVIEW();
});

</script>
@endsection