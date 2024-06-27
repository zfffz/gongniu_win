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
                    </form>
                </fieldset>
            </div>
        </div>
    </div>
@endsection