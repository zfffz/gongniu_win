@extends('admins.layouts.app')

@section('include')

@endsection

@section('title', '打包出库')

@section('section')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>打包出库</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">单据列表</li>
                        <li class="breadcrumb-item active">打包出库</li>
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
                            <input type="text" name="search" id="search" class="form-control" placeholder="打包员/创建日期" />
                            <div class="input-group-append">
                                <button class="btn btn-default" type="button" onclick="table.draw( false );">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="companiesLists" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>单据编号</th>
                        <th>打包员</th>
                        <th>发货单数量</th>
                        <th>创建时间</th>
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
                        axios.delete('sweepOut/' + id)
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
                "ordering": true,
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
                        url: "sweepOut/getData",
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
                    { "data":"id" },
                    { "data":"packager_name" },
                    { "data":"count" },
                    { "data":"created_at" },
                    {"data":"id"}
                ],
                columnDefs: [{
                    targets: 4,//自定义列的序号，从0开始
                    data: "id", //需要引用的数据列，一般是主键         
                    render: function(data, type, full){
                        return '<div class="text-center py-0 align-middle">' +
                            '<div class="btn-group btn-group-sm">' +
                            '<a href="sweepOut/'+data+'" class="btn btn-info"><i class="fas fa-eye"></i></a>' +
                            '<a href="javascript:void(0);" onclick="deleteCurrentRow('+data+')" class="btn btn-danger"><i class="fas fa-trash"></i></a>' +
                            '</div>' +
                            '</div>';


                    }
                }
                ]
            });
    </script>

@endsection