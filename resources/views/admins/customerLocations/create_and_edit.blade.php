@extends('admins.layouts.app')

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
                        <li class="breadcrumb-item"><a href="{{route('customerLocation.index')}}">客户默认库位</a></li>
                        <li class="breadcrumb-item active">{{ $customer_location->id ? '修改': '新增' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-{{ $customer_location->id ? 'edit': 'plus' }} text-primary"></i> {{ $customer_location->id ? '修改': '新增' }}</h3>
            </div>
            @if($customer_location->id)
                <form class="form-horizontal" role="form" action="{{ route('customerLocation.update', ['customerLocation' => $customer_location->id]) }}" method="post">
                {{ method_field('PUT') }}
            @else
                <form class="form-horizontal" role="form" action="{{ route('customerLocation.store') }}" method="post">
                @endif
                    {{ csrf_field() }}
                        <!-- 注意这里多了 @change -->
                    <div class="card-body">
                        @include('shared._error')
                        <div class="form-group row">
                            <label class="col-sm-2 control-label label_required">客户</label>
                            <div class="col-sm-8">
                                <select class="form-control" required name="customer_no" id="customer_no" style="width: 100%;">
                                    @if($customer_location->customer_no)
                                        <option value="{{$customer_location->customer_no}}" selected>{{$customer_name}}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label label_required">默认库位</label>
                            <div class="col-sm-8">
                                <select class="form-control" required name="location_id" id="location_id" style="width: 100%;">
                                    <option value="" hidden disabled {{ $customer_location->location_id ? '' : 'selected' }}>请选择</option>
                                    @foreach ($storage_locations as $storage_location)
                                        <option value="{{ $storage_location->id }}" {{ $customer_location->location_id == $storage_location->id ? 'selected' : '' }}>
                                            {{ $storage_location->no }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">备注</label>
                            <div class="col-sm-8">
                                <textarea type="text" class="form-control" name="note" autocomplete="off">{{ old('note', $customer_location->note) }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{route('storageLocation.index')}}">
                            <button type="button" class="btn btn-default btn-flat"> 退出</button>
                        </a>
                        <button type="submit" class="btn btn-primary btn-flat float-right">保存</button>
                    </div>
                </form>
            </div>
        </div>
@endsection
@section('script')
    <script>
        $(function(){
            $('#location_id').select2({
                theme: 'bootstrap4'
            });

            // ajax 分页查询
            $("#customer_no").select2({
                theme: 'bootstrap4',
                placeholder: "搜索客户",
                minimumInputLength: 2,//最少输入多少个字符后开始查询
                language: {
                    inputTooShort: function () {
                        return "至少输入2个字符。。。";
                    }
                },
                ajax: {
                    type:'GET',
                    url: "{{route('customerLocation.getCustomerData')}}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        var page = params.page || 1;
                        var start = ((page-1)*10);
                        return {
                            code: params.term, // search term 请求参数 ， 请求框中输入的参数
                            draw: page,
                            length: 10,
                            start: start
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.data,
                            pagination: {
                                more: (params.page * 10) < data.recordsTotal
                            }
                        };
                    },
                    cache: true
                },
                templateResult: function (repo) {
                    if (repo.loading) {
                        return repo.text;
                    } else {
                        return repo.id+' '+repo.text;      //选中 显示的名称
                    }
                },
                templateSelection: function (item) {
                    $("#customer_no").val(item.id);
                    return item.id+' '+item.text;
                }
            });

        })
    </script>
@endsection