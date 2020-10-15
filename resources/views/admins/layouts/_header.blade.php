Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom text-sm">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>

        <li class="nav-item dropdown">

        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                <img src="{{ Auth::user()->avatar?Auth::user()->avatar:'/image/user2-160x160.jpg' }}" class="user-image-sm">
                {{ Auth::user()->name }} <span class="caret"></span>
            </a>




<div class="dropdown-menu" aria-labelledby="navbarDropdown">
             
                <a class="dropdown-item" href="{{ url(config('administrator.uri')) }}">
                  <i class="fas fa-tachometer-alt mr-2"></i>
                  管理后台
                </a>
                <div class="dropdown-divider"></div>
          
              <a class="dropdown-item"  href="{{ route('user.show', Auth::user()->no) }}"><i class="far fa-user mr-2"></i> 
              个人中心
               </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" id="logout"  href="#">
                    <form action="{{ route('logout') }}" method="POST">
                        {{ csrf_field() }}
                        <button class="btn btn-block btn-danger" type="submit" name="button">退出</button>
                    </form>
                </a>
 </div>
 </li>



          
         
        </li>
    </ul>
</nav>
<!-- /.navbar