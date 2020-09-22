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
                            <label class="col-sm-2 control-label label_required">存货编码</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="no" autocomplete="off" value="{{ old('cinvcode', $carton->cinvcode) }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label label_required">存货名称</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" autocomplete="off" value="{{ old('cinvname', $carton->cinvname) }}" required>
                            </div>
                        </div>
                     <!--    <div class="form-group row">
                            <label class="col-sm-2 control-label">备注</label>
                            <div class="col-sm-8">
                                <textarea type="text" class="form-control" name="note" autocomplete="off" required>{{ old('note', $storage_location->note) }}</textarea>
                            </div>
                        </div> -->
                    </form>
                </fieldset>
            </div>
        </div>
    </div>
@endsection