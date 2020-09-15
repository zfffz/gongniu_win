@extends('admins.layouts.app')

@section('title', '箱规')

@section('section')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>箱规</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">基础资料</li>
                        <li class="breadcrumb-item"><a href="{{route('carton.index')}}">箱规</a></li>
                        <li class="breadcrumb-item active">{{ $carton->id ? '修改': '新增' }}</li>
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
                <h3 class="card-title"><i class="fa fa-{{ $carton->id ? 'edit': 'plus' }} text-primary"></i> {{ $carton->id ? '修改': '新增' }}</h3>
            </div>
            @if($carton->id)
                <form class="form-horizontal" role="form" action="{{ route('carton.update', ['carton' => $carton->id]) }}" method="post">
                {{ method_field('PUT') }}
            @else
                <form class="form-horizontal" role="form" action="{{ route('carton.store') }}" method="post">
                @endif
                    {{ csrf_field() }}
                        <!-- 注意这里多了 @change -->
                    <div class="card-body">
                        @include('shared._error')
                        <div class="form-group row">
                            <label class="col-sm-2 control-label label_required">存货编码</label>
                            <div class="col-sm-8">
                                <input type="text" {{ $carton->id ? 'disabled': '' }} class="form-control" name="no" autocomplete="off" value="{{ old('no', $carton->no) }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label label_required">存货名称</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" autocomplete="off" value="{{ old('name', $carton->name) }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">箱规</label>
                            <div class="col-sm-8">
                                <textarea type="text" class="form-control" name="note" autocomplete="off">{{ old('note', $carton->note) }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{route('carton.index')}}">
                            <button type="button" class="btn btn-default btn-flat"> 退出</button>
                        </a>
                        <button type="submit" class="btn btn-primary btn-flat float-right">保存</button>
                    </div>
                </form>
            </div>
        </div>
@endsection
