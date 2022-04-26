<nav class="navbar navbar-dark navbar-expand orange lighten-1 pb-0">

  <a class="navbar-brand" href="/"><i class="far fa-sticky-note mr-1"></i>　</a>

  <ul class="navbar-nav ml-auto">

  <form class="form-inline mr-4" action="{{url('/search')}}">
    <div class="input-group input-group-lg">
      <div class="form-group mb-2">
        <div class="">
          <input type="text" name="keyword" value="{{$keyword ?? null}}" class="form-control rounded-0" placeholder="検索" style="max-width:100px; min-width:50px">
        </div>
      </div>
      <input type="submit" value="&#xf002;" class="fas text-white border-white rounded-right shadow-none" style="background:transparent; height:40px">
    </div>
  </form>  

    @guest {{--この行を追加--}}
    <li class="nav-item">
      <a class="nav-link" href="{{ route('register') }}">ユーザー登録</a> {{--この行を変更--}}
    </li>
    @endguest {{--この行を追加--}}

    @guest {{--この行を追加--}}
    <li class="nav-item">
       <a class="nav-link" href="{{ route('login') }}">ログイン</a> {{--この行を編集--}}
    </li>
    @endguest {{--この行を追加--}}
      
    @auth {{--この行を追加--}}
    <li class="nav-item">
      <a class="nav-link" href="{{ route('users.show', ['name'=>Auth::user()->name]) }}" ><i class="fas fa-pen mr-1"></i>学習状況</a>
    </li>
    @endauth {{--この行を追加--}}
    
    @auth {{--この行を追加--}}
    <!-- Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
         aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-user-circle"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-right dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
        <button class="dropdown-item" type="button"
                onclick="location.href=''">
          マイページ
        </button>
        <div class="dropdown-divider"></div>
        <button form="logout-button" class="dropdown-item" type="submit">
          ログアウト
        </button>
      </div>
    </li>
    <form id="logout-button" method="POST" action="{{ route('logout') }}"> {{--この行を編集--}}
      @csrf {{--この行を追加--}}
    </form>
    <!-- Dropdown -->
    @endauth {{--この行を追加--}}

  </ul>

</nav>