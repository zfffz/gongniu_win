@extends('admins.layouts.app')

@section('title', '库位')

@section('section')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>库位</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">基础资料</li>
                        <li class="breadcrumb-item"><a href="{{route('storageLocation.index')}}">库位</a></li>
                        <li class="breadcrumb-item active">{{ $storage_location->id ? '修改': '新增' }}</li>
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
                <h3 class="card-title"><i class="fa fa-{{ $storage_location->id ? 'edit': 'plus' }} text-primary"></i> {{ $storage_location->id ? '修改': '新增' }}</h3>
            </div>
            @if($storage_location->id)
                <form class="form-horizontal" role="form" action="{{ route('storageLocation.update', ['storageLocation' => $storage_location->id]) }}" method="post">
                {{ method_field('PUT') }}
            @else
                <form class="form-horizontal" role="form" action="{{ route('storageLocation.store') }}" method="post">
                @endif
                    {{ csrf_field() }}
                        <!-- 注意这里多了 @change -->
                    <div class="card-body">
                        @include('shared._error')
                        <div class="form-group row">
                            <label class="col-sm-2 control-label label_required">库位编码</label>
                            <div class="col-sm-8">
                                <input type="text" {{ $storage_location->id ? 'disabled': '' }} class="form-control" name="no" autocomplete="off" value="{{ old('no', $storage_location->no) }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label label_required">库位名称</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" autocomplete="off" value="{{ old('name', $storage_location->name) }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">备注</label>
                            <div class="col-sm-8">
                                <textarea type="text" class="form-control" name="note" autocomplete="off">{{ old('note', $storage_location->note) }}</textarea>
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
