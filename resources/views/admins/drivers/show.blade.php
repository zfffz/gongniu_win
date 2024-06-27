@extends('admins.layouts.app')

@section('title', '司机')

@section('section')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>司机</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">基础资料</li>
                        <li class="breadcrumb-item"><a href="{{route('storageLocation.index')}}">司机</a></li>
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
                            <label class="col-sm-2 control-label label_required">姓名</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="no" autocomplete="off" value="{{ old('no', $driver->name) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">手机号</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="model" autocomplete="off" value="{{ old('model', $driver->mobile) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">备注</label>
                            <div class="col-sm-8">
                                <textarea type="text" class="form-control" name="note" autocomplete="off">{{ old('note', $driver->note) }}</textarea>
                            </div>
                        </div>
                    </form>
                </fieldset>
            </div>
        </div>
    </div>
@endsection