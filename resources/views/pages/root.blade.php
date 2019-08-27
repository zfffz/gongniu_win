@extends('layouts.app')
@section('title', '首页')

@section('content_header')

@endsection

@section('header')
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
            <img src="{{ Auth::user()->avatar?Auth::user()->avatar:'/AdminLTE/dist/img/user2-160x160.jpg' }}" class="user-image" alt="User Image">
            {{ Auth::user()->name }} <span class="caret"></span>
        </a>

        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item"  tabindex="-1" href="#"><i class="fa fa-user"></i> 个人中心</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" id="logout" tabindex="-1" href="#">
                <form action="{{ route('logout') }}" method="POST">
                    {{ csrf_field() }}
                    <button class="btn btn-block btn-danger" type="submit" name="button">退出</button>
                </form>
            </a>
        </div>
    </li>

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
                            <a class="btn-block" href="{{route('sweepOut.index')}}">
                                <button type="button" class="btn btn-primary btn-block btn-flat btn-lg">打包出库</button>
                            </a>
                            <a class="btn-block" href="{{route('sweepOut.index')}}">
                                <button type="button" class="btn btn-danger btn-block btn-flat btn-lg">扫码上车</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop