@extends('admins.layouts.app')

@section('title', '车辆')

@section('section')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>车辆</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">基础资料</li>
                        <li class="breadcrumb-item"><a href="{{route('storageLocation.index')}}">车辆</a></li>
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
                            <label class="col-sm-2 control-label label_required">车牌号</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="no" autocomplete="off" value="{{ old('no', $car->no) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">车辆型号</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="model" autocomplete="off" value="{{ old('model', $car->model) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">备注</label>
                            <div class="col-sm-8">
                                <textarea type="text" class="form-control" name="note" autocomplete="off">{{ old('note', $car->note) }}</textarea>
                            </div>
                        </div>
                    </form>
                </fieldset>
            </div>
        </div>
    </div>
@endsection