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
                        <li class="breadcrumb-item"><a href="{{route('car.index')}}">车辆</a></li>
                        <li class="breadcrumb-item active">{{ $car->id ? '修改': '新增' }}</li>
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
                <h3 class="card-title"><i class="fa fa-{{ $car->id ? 'edit': 'plus' }} text-primary"></i> {{ $car->id ? '修改': '新增' }}</h3>
            </div>
            @if($car->id)
                <form class="form-horizontal" role="form" action="{{ route('car.update', ['car' => $car->id]) }}" method="post">
                {{ method_field('PUT') }}
            @else
                <form class="form-horizontal" role="form" action="{{ route('car.store') }}" method="post">
                @endif
                    {{ csrf_field() }}
                        <!-- 注意这里多了 @change -->
                    <div class="card-body">
                        @include('shared._error')
                        <div class="form-group row">
                            <label class="col-sm-2 control-label label_required">车牌号</label>
                            <div class="col-sm-8">
                                <input type="text" {{ $car->id ? 'disabled': '' }} class="form-control" name="no" autocomplete="off" value="{{ old('no', $car->no) }}" required>
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
                    </div>
                    <div class="card-footer">
                        <a href="{{route('car.index')}}">
                            <button type="button" class="btn btn-default btn-flat"> 退出</button>
                        </a>
                        <button type="submit" class="btn btn-primary btn-flat float-right">保存</button>
                    </div>
                </form>
            </div>
        </div>
@endsection
