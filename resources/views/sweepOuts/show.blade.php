@extends('admins.layouts.app')

@section('include')

@endsection

@section('title', '打包入库')

@section('section')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>打包入库</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">打包入库</li>
                        <li class="breadcrumb-item active">明细查看</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
                <!-- title row -->
                <div class="row">
                    <div class="col-12">
                        <h4>
                            <i class="fas fa-globe"></i> 打包入库单
                            <small class="float-right">时间: {{$sweepOut->created_at}}</small>
                        </h4>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        单据编号
                        <address>
                            <strong>{{$sweepOut->no}}</strong><br>
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        打包员
                        <address>
                            <strong>{{$packager_name}}</strong><br>
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        发货单数量
                        <address>
                            <strong>{{$sweepOut->count}}</strong><br>
                        </address>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- Table row -->
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped" id="maintable">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>发货单号</th>
                                <th>默认库位</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sweepOut->sweep_out_items as $sweepOut_item)
                                <tr>
                                    <td>{{$sweepOut_item->entry_id}}</td>
                                    <td>{{$sweepOut_item->dispatch_no}}</td>
                                    <td>{{$sweepOut_item->default_location_no}}</td>
                                    <td>{{$sweepOut_item->status == 0 ? '未装车':'已装车'}}</td>
                                    <td><a href="javascript:void(0);" onclick="deleteCurrentRow(this)" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></a></td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <div class="row no-print">
                    <div class="col-12">
                        <a href="{{route('sweepOut.index')}}" class="btn btn-danger"><i class="fas fa-arrow-left"></i> 返回</a>
                    </div>
                </div>
                <!-- /.row -->
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection
@section('script')
    <script>

  function deleteCurrentRow(obj) {
// const Toast = Swal.mixin({
//             toast: true,
//             position: 'top-end',
//             showConfirmButton: false,
//             timer: 2000
//         });

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

// alert(1);
    var x=obj.parentNode.parentNode.rowIndex;
//     alert(i);

// alert(x);
var tb = document.getElementById("maintable");

for (i=0;i<tb.rows.length;i++)
       {
        // alert(parseInt(tb.rows[i].rowIndex));
if (x==parseInt(tb.rows[i].rowIndex)){
        var searchKey = tb.rows[i].cells[1].innerHTML; 
 // alert(searchKey);
}


}
 myajax1=$.ajax({

              data:{searchKey:searchKey},
              headers:{
                  'X-CSRF-TOKEN' : '{{ csrf_token() }}'
              },
              type: "post",
              // async:false,
              dataType: "json",
              url:('delete/' + searchKey),
              success: function (result) {
                  // $('#dispatch_no').val(result.cDLCode);
                  // $('#ccusname').val(result.cCusName);
                  // $('#ddate').val(result.dDate);
                  // $('#position').val(result.no);
                   if(result.status ==0){
                                    Swal.fire(
                                        '提示',
                                        result.text,
                                        'error'
                                    )
                                }
                                else
                                {
                  location.reload();
              }
              }
          })


}
})
        }

    </script>

@endsection