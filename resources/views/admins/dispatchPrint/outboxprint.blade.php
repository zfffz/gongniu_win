@extends('admins.layouts.app')

@section('include')

@endsection

@section('title', '外箱标打印')
<script src="/js/LodopFuncs.js"></script>
<object  id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0>
    <embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0></embed>
</object>

@section('section')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-3">
                    <h4>外箱标打印</h4>
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
            @foreach($data1 as $datas )
                <div class="card-body" >
                    <div id={{$datas->divid}} >
                        <div class="row">
                            <input class="col-md-2" type="hidden" id="ctns" value = {{ $datas->CTNS}} />
                        </div>
                        <div class="row"  >
                            <h5 class="col-md-12 col-sm-12 col-xs-12" style="font-family:黑体; font-size:15pt;">发货单号:{{ $datas->cDLCode}}</h5>
                            <h5 class="col-md-12 col-sm-12 col-xs-12" style="font-family:黑体; font-size:15pt; line-height:16pt">客户简称:{{ $datas->ccusabbname }}</h5>
                            <h5 class="col-md-12 col-sm-12 col-xs-12" style="font-family:黑体; font-size:15pt; line-height:16pt">收货地址:{{ $datas->cshipaddress }}</h5>
                            <h5 class="col-md-12 col-sm-12 col-xs-12" style="font-family:黑体; font-size:15pt; line-height:15pt">箱数:{{ $datas->CTNS }}</h5>
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
        $('#btn-submit').on('click', function(){
            LODOP=getLodop();
            LODOP.PRINT_INIT("打印控件功能演示_Lodop功能_无边线表格");
            LODOP.SET_PRINT_PAGESIZE(1,800,600,'');//定义纸张
            LODOP.SET_SHOW_MODE("LANDSCAPE_DEFROTATED",1);//横向时的正向显示
            LODOP.SET_PRINT_MODE("AUTO_CLOSE_PREWINDOW",1);//打印后自动关闭预览窗口
            var strBodyStyle = "<link href=\"http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css\" rel=\"stylesheet\"><style> .card{color: black}.table-bordered table,.table-bordered tbody tr th,.table-bordered tbody tr td{border: 1px solid  black; color: black/* 整体表格边框 */}</style>";
            //LODOP.ADD_PRINT_TABLE(50,10,"50%",220,document.getElementById("card").innerHTML);
            //LODOP.SET_PRINT_STYLEA(0,"Top2Offset",-40); //这句可让次页起点向上移
            //  LODOP.ADD_PRINT_BARCODE(Top,Left,Width,Height,QRCode,'$datas[0]->cDLCode');
            var m= $('#count').val();
            for(var j=1;j<=m;j++){
                var divid = 'div'+j;
                var printnum = $("#"+divid+ " input[id='ctns']").val();
                for(var i=1;i<=printnum;i++){
                    LODOP.ADD_PRINT_HTM(5, 5, '97%', '100%',strBodyStyle+"<body>"+document.getElementById(divid).innerHTML+"</body>");
                    LODOP.NewPageA();  //自动分页
                }
            }
            LODOP.PREVIEW();

        });


    </script>
@endsection