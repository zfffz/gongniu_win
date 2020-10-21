@extends('admins.layouts.app')

@section('include')

@endsection

@section('title', '打印上海公牛箱标')
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
<!-- error_reporting(E_ALL ^ E_NOTICE)， -->

<div class="col-md-12">
        <div class="card" id="card">
            <style>table,th{border:none;height:13px} td{border: 1px solid #000;height:13px}</style>
            <input class="col-md-1" type="hidden" id="count" name="count" value={{$m}} />
            
            @foreach($data2 as $datas )       
               <div  id={{$datas[0]->divid}}>
                <table class="table table-hover table-bordered" style="width: 100%;border: 1px solid black">
                    <tbody>
                    <tr>
                        <th width=10%  style="font-family:黑体; font-size:11pt;line-height:15px">行</th>
                        
                        <th width=50%  style="font-family:黑体; font-size:11pt;line-height:15px">存货名称</th>
                    
                        <th width=15%  style="font-family:黑体; font-size:11pt;line-height:15px">数量</th>
             
                    </tr>
             

                       @foreach($datas[1] as $dats)
           

                        <tr>
                            <td width=10%  style="font-family:黑体; font-size:11pt;line-height:15px">{{ $dats->ROWNU }}</td>
                          
                            <td width=50%  style="font-family:黑体; font-size:11pt;line-height:15px">{{ $dats->cInvName }}</td>
                           
                            <td width=15%  style="font-family:黑体; font-size:11pt;line-height:15px">{{ ($dats->iQuantity)*1 }}</td>
                          
                        </tr>
                      
                         @endforeach
                    </tbody>
                </table>
            </div>
            @endforeach
        </div>
    </div>
<!--     </div> -->
    <!-- /.col -->

   
@endsection

@section('script')
    <script>
        $('#btn-submit').on('click', function(){
            LODOP=getLodop();
            LODOP.PRINT_INIT("打印控件功能演示_Lodop功能_无边线表格");
            LODOP.SET_PRINT_PAGESIZE(2,600,800,'A5');//定义纸张
            LODOP.SET_SHOW_MODE("LANDSCAPE_DEFROTATED",1);//横向时的正向显示
            LODOP.SET_PRINT_MODE("AUTO_CLOSE_PREWINDOW",1);//打印后自动关闭预览窗口
            var strBodyStyle = "<link href=\"http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css\" rel=\"stylesheet\"><style> .card{color: black}.table-bordered table,.table-bordered tbody tr th,.table-bordered tbody tr td{border: 1px solid  black; color: black/* 整体表格边框 */}</style>";
            // LODOP.SET_PRINT_MODE("FULL_HEIGHT_FOR_OVERFLOW",true);//高度溢出缩放
            //LODOP.ADD_PRINT_TABLE(50,10,"50%",220,document.getElementById("card").innerHTML);
            //LODOP.SET_PRINT_STYLEA(0,"Top2Offset",-40); //这句可让次页起点向上移
          //  LODOP.ADD_PRINT_BARCODE(Top,Left,Width,Height,QRCode,'$datas[0]->cDLCode');
            var m= $('#count').val();
// alert(m);
            // AddTitle();
        // var iCurLine=12;//标题行之后的数据从位置80px开始打印
            for(var j=1;j<=m;j++){
                var divid='div'+j;
                LODOP.ADD_PRINT_TABLE(5, 5, "RightMargin:0.4cm","BottomMargin:0.1cm",strBodyStyle+"<body>"+document.getElementById(divid).innerHTML+"</body>");
                
               // LODOP.ADD_PRINT_BARCODE(5,900,160, 80, 'Code93', cdlcode);
                // LODOP.ADD_PRINT_BARCODE(5,650,80, 80, 'QRCode', cdlcode);
              //  LODOP.SET_PRINT_STYLEA(0,"LinkedItem",-1);
                LODOP.NewPageA();  //自动分页
               // LODOP.ADD_PRINT_HTM(5, 5, '97%', '100%',strBodyStyle+"<body>"+document.getElementById("div1").innerHTML+"</body>");
               // iCurLine=iCurLine+85;//每行占25px
            }
            // LODOP.PRINT();
            LODOP.PREVIEW();
           // LODOP.PRINT_DESIGN();
        });

    </script>
@endsection