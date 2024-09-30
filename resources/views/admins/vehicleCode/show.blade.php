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
                        <li class="breadcrumb-item active">查看</li>
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
                <h3 class="card-title"><i class="fa fa-eye text-primary"></i> 查看</h3>
            </div>

            <div class="card-body">
                <fieldset disabled="disabled">
                    <form class="form-horizontal" role="form">
                    
                        <div class="form-group row">
                            <label class="col-sm-2 control-label label_required">车销编号</label>
                            <div class="col-sm-8">
                                <select class="form-control" required name="cxno" id="cxno" style="width: 100%;">
                                    <option value="" hidden disabled {{ $vehicle_code->cxno ? '' : 'selected' }}>请选择</option>
                                    @if($vehicle_code->cxno)
                                        <option value="{{ $vehicle_code->cxno }}" selected>{{$vehicle_code->cxno}}</option>
                                        </option>
                                        @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label label_required">对应客户编码</label>
                            <div class="col-sm-8">
                                <select class="form-control" required name="fccode" id="fccode" style="width: 100%;">
                                    @if($vehicle_code->fccode)
                                        <option value="{{$vehicle_code->fccode}}" selected>{{$vehicle_code->fccode}}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label label_required">对应客户名称</label>
                            <div class="col-sm-8">
                                <select class="form-control" required name="fccode" id="fccode" style="width: 100%;">
                                    @if($vehicle_code->fccode)
                                        <option value="{{$vehicle_code->fccode}}" selected>{{$customer_name}}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
     
                    </form>
                </fieldset>
            </div>
        </div>
    </div>
@endsection