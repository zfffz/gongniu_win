@extends('admins.layouts.app')

@section('title', '车销对应客户')

@section('section')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>车销对应客户</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">基础资料</li>
                        <li class="breadcrumb-item"><a href="{{route('vehicleCode.index')}}">车销对应客户</a></li>
                        <li class="breadcrumb-item active">{{ $vehicle_code->id ? '修改': '新增' }}</li>
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
                <h3 class="card-title"><i class="fa fa-{{ $vehicle_code->id ? 'edit': 'plus' }} text-primary"></i> {{ $vehicle_code->id ? '修改': '新增' }}</h3>
            </div>
            @if($vehicle_code->id)
                <form class="form-horizontal" role="form" action="{{ route('vehicleCode.update', ['vehicleCode' => $vehicle_code->id]) }}" method="post">
                {{ method_field('PUT') }}
                  <input name="edit_id" id="edit_id" type="hidden" value="1">
            @else
                <form class="form-horizontal" role="form" action="{{ route('vehicleCode.store') }}" method="post">
                @endif
                    {{ csrf_field() }}
                        <!-- 注意这里多了 @change -->
                    <div class="card-body">
                        @include('shared._error')
          
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">车销编号</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" {{ $vehicle_code->id ? 'disabled': '' }}  name="cxno" autocomplete="off" value="{{ old('cxno',$vehicle_code->cxno) }}">
                            </div>
                        </div>

                        <!-- <div class="form-group row">
                            <label class="col-sm-2 control-label label_required">对应客户编码</label>
                            <div class="col-sm-8">

                                <select class="form-control" {{ $vehicle_code->id ? 'disabled': '' }}  required name="fccode" id="fccode" style="width: 100%;">

                                    @if($vehicle_code->fccode)
                                        <option value="{{$vehicle_code->fccode}}" selected>{{$vehicle_code->fccode}}</option>
                                    @endif
                                </select>
                            </div>
                        </div> -->
                        <div class="form-group row">
                            <label class="col-sm-2 control-label label_required">对应客户编码</label>
                            <div class="col-sm-8">
                                <select class="form-control" {{ $vehicle_code->id  }}  required name="fccode" id="fccode" style="width: 100%;">                
                                    @if($vehicle_code->fccode)
                                        <option value="{{$vehicle_code->fccode}}" selected>{{$customer_name}}</option>
                                    @endif
                                </select>
                            </div>
                        </div>

            

<!--                      
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">对应客户编码</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="fccode" autocomplete="off" value="{{ old('fccode',$vehicle_code->fccode) }}">
                            </div>
                        </div> -->
                    </div>
                    <div class="card-footer">
                        <a href="{{route('vehicleCode.index')}}">
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
            $("#fccode").select2({
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
                    url: "{{route('vehicleCode.getCustomerData')}}",
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
                    $("#fccode").val(item.id);
                    return item.id+' '+item.text;
                }
            });

        })
    </script>
@endsection
