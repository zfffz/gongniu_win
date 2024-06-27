@extends('admins.layouts.app')

@section('include')

@endsection

@section('title', '客户默认库位')

@section('section')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>客户默认库位</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">基础资料</li>
                        <li class="breadcrumb-item active">客户默认库位</li>
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
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="text" name="search" id="search" class="form-control" placeholder="客户编码/库位编码/创建人/修改人" />
                            <div class="input-group-append">
                                <button class="btn btn-default" type="button" onclick="table.draw( false );">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <a href="{{route('customerLocation.create')}}" class="btn btn-info btn-flat float-right">
                            <i class="fa fa-plus"></i> 新增
                        </a>&nbsp;&nbsp;
                    </div>
                </div>
                <table id="companiesLists" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>客户编码</th>
                        <th>客户名称</th>
                        <th>仓库编码</th>
                        <th>仓库名称</th>
                        <th>创建人</th>
                        <th>创建时间</th>
                        <th>修改人</th>
                        <th>修改时间</th>
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
        function deleteCurrentRow(id) {
            $('#dispatch_no').blur();
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
                        // 调用删除接口，用 id 来拼接出请求的 url
                        axios.delete('customerLocation/' + id)
                            .then(function () {
                                // 请求成功之后重新加载页面
                                location.reload();
                            })
                    }else{
                        return false;
                    }
                })
        }

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
                "ajax":function(data,callback,settings){
                    var length = data.length;
                    var start = data.start;
                    var page = (data.start / data.length) + 1;
                    var searchKey = $('#search').val();

                    $.ajax({
                        headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
                        type: "POST",
                        url: "customerLocation/getData",
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
                    { "data":"customer_no" },
                    { "data":"customer_name" },
                    { "data":"location_no" },
                    { "data":"location_name" },
                    { "data":"create_name" },
                    { "data":"created_at" },
                    { "data":"edit_name" },
                    { "data":"updated_at" },
                    {"data":"id"}
                ],
                columnDefs: [{
                    targets: 8,//自定义列的序号，从0开始
                    data: "id", //需要引用的数据列，一般是主键         
                    render: function(data, type, full){
                        return '<div class="text-center py-0 align-middle">' +
                            '<div class="btn-group">' +
                            '<a href="customerLocation/'+data+'" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a>' +
                            '<a href="customerLocation/'+data+'/edit" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a>' +
                            '<a href="javascript:void(0);" onclick="deleteCurrentRow('+data+')" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></a>' +
                            '</div>' +
                            '</div>';


                    }
                }
                ]
            });
    </script>

@endsection
