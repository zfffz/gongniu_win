@extends('admins.layouts.app')

@section('title', '存货基础信息')

@section('section')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>存货基础信息</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">基础资料</li>
                        <li class="breadcrumb-item"><a href="{{route('carton.index')}}">存货基础信息</a></li>
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
                                <input type="text" class="form-control" name="no" autocomplete="off" value="{{ old('no', $carton[0]->no) }}" required>
                            </div>
                        </div>
                         
                        <div class="form-group row">
                            <label class="col-sm-2 control-label label_required">存货名称</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" autocomplete="off" value="{{ old('name', $carton[0]->name) }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label label_required">条形码</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="cinvdefine5" autocomplete="off" value="{{ old('cinvdefine5', $carton[0]->cinvdefine5) }}" required>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label class="col-sm-2 control-label label_required">箱规</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="cInvDefine13" autocomplete="off" value="{{ old('cInvDefine13', $carton[0]->cInvDefine13) }}" required>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label class="col-sm-2 control-label label_required">单位净重</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="iInvWeight" autocomplete="off" value="{{ old('iInvWeight', $carton[0]->iInvWeight) }}" required>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label class="col-sm-2 control-label label_required">整箱毛重</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="fGrossW" autocomplete="off" value="{{ old('fGrossW', $carton[0]->fGrossW) }}" required>
                            </div>
                        </div>
                    
                    </form>
                </fieldset>
            </div>
        </div>
    </div>
@endsection