@extends('admins.layouts.app')

@section('include')

@endsection

@section('title', '退货入库')

@section('section')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>退货入库</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">退货入库</li>
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
                            <i class="fas fa-globe"></i> 退货入库单
                            <small class="float-right">时间: {{$returnHouse->created_at}}</small>
                        </h4>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        单据编号
                        <address>
                            <strong>{{$returnHouse->no}}</strong><br>
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        入库员
                        <address>
                            <strong>{{$packager_name}}</strong><br>
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        发货单数量
                        <address>
                            <strong>{{$returnHouse->count}}</strong><br>
                        </address>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- Table row -->
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>发货单号</th>
                                <th>默认库位</th>
                                <th>状态</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($returnHouse->return_house_items as $returnhouse_item)
                                <tr>
                                    <td>{{$returnhouse_item->entry_id}}</td>
                                    <td>{{$returnhouse_item->dispatch_no}}</td>
                                    <td>{{$returnhouse_item->default_location_no}}</td>
                                    <td>{{$returnhouse_item->status == 0 ? '未装车':'已装车'}}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <div class="row no-print">
                    <div class="col-12">
                        <a href="{{route('returnhouse.index')}}" class="btn btn-danger"><i class="fas fa-arrow-left"></i> 返回</a>
                    </div>
                </div>
                <!-- /.row -->
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection
@section('script')
    <script>

    </script>

@endsection
