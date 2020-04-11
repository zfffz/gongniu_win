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
                        <li class="breadcrumb-item"><a href="{{route('driver.index')}}">司机</a></li>
                        <li class="breadcrumb-item active">{{ $driver->id ? '修改': '新增' }}</li>
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
                <h3 class="card-title"><i class="fa fa-{{ $driver->id ? 'edit': 'plus' }} text-primary"></i> {{ $driver->id ? '修改': '新增' }}</h3>
            </div>
            @if($driver->id)
                <form class="form-horizontal" role="form" action="{{ route('driver.update', ['driver' => $driver->id]) }}" method="post">
                {{ method_field('PUT') }}
            @else
                <form class="form-horizontal" role="form" action="{{ route('driver.store') }}" method="post">
                @endif
                    {{ csrf_field() }}
                        <!-- 注意这里多了 @change -->
                    <div class="card-body">
                        @include('shared._error')
                        <div class="form-group row">
                            <label class="col-sm-2 control-label label_required">姓名</label>
                            <div class="col-sm-8">
                                <input type="text" {{ $driver->id ? 'disabled': '' }} class="form-control" name="name" autocomplete="off" value="{{ old('name', $driver->name) }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">手机号</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="mobile" autocomplete="off" value="{{ old('mobile', $driver->mobile) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">备注</label>
                            <div class="col-sm-8">
                                <textarea type="text" class="form-control" name="note" autocomplete="off">{{ old('note', $driver->note) }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{route('driver.index')}}">
                            <button type="button" class="btn btn-default btn-flat"> 退出</button>
                        </a>
                        <button type="submit" class="btn btn-primary btn-flat float-right">保存</button>
                    </div>
                </form>
            </div>
        </div>
@endsection
