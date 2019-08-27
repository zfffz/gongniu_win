@extends('layouts.app')
@section('title', '首页')

@section('content_header')

@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Block buttons -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-center">工作台</h3>
                        </div>
                        <div class="card-body">
                            <button type="button" class="btn btn-primary btn-block btn-flat btn-lg">打包出库</button>
                            <button type="button" class="btn btn-danger btn-block btn-flat btn-lg">扫码上车</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@stop