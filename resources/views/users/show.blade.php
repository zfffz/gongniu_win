@extends('layouts.app')
@section('include')

@endsection
@section('title', '个人信息')

@section('header')
    <a href="#" class="navbar-brand">
        <img src="/image/logo.png" alt="AdminLTE Logo" class="brand-image"
             style="opacity: .8;margin-left:0px;margin-right:0px;">
    </a>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                <img src="{{ Auth::user()->avatar?Auth::user()->avatar:'/image/user2-160x160.jpg' }}" class="user-image" alt="User Image">
                {{ Auth::user()->name }} <span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item"  tabindex="-1"  href="{{ route('user.show', Auth::user()->no) }}"><i class="fa fa-user"></i> 个人中心</a>
                <a class="dropdown-item"  tabindex="-1" href="{{ route('sweepOut.index') }}"><i class="fas fa-bars"></i> 任务列表</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" id="logout" tabindex="-1" href="#">
                    <form action="{{ route('logout') }}" method="POST">
                        {{ csrf_field() }}
                        <button class="btn btn-block btn-danger" type="submit" name="button">退出</button>
                    </form>
                </a>
            </div>
        </li>
    </ul>


@endsection

@section('content_header')

@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="card ">
                        <img class="card-img-top" src="https://cdn.learnku.com/uploads/images/201709/20/1/PtDKbASVcz.png?imageView2/1/w/600/h/600" alt="{{ $user->name }}">
                        <div class="card-body">
                            <h5><strong>个人简介</strong></h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                            <hr>
                            <h5><strong>注册于</strong></h5>
                            <p>January 01 1901</p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection

@section('footer')
    <div class="float-right d-none d-sm-inline">

    </div>
    <!-- Default to the left -->
    <a onclick="javascript:history.back(-1);"><i class="fas fa-arrow-left"></i> </a>
@endsection

@section('script')
    <script>


    </script>
@endsection