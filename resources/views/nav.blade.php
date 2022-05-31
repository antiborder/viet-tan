<nav class="navbar navbar-dark navbar-expand-md orange lighten-1 p-1 pb-0">

   <!-- Logo -->
  <a href="/" class="navbar-brand ml-1  " style="font-size:1.0rem">vietnamese-learn.net</a>
  
  <!-- 検索 -->
  <form class="form-inline pt-2" action="{{url('/search')}}">
    <div class="input-group input-group-lg">
    
      <div class="form-group ml-0 mb-2">
        <input type="text" name="keyword" value="{{$keyword ?? null}}" class="form-control rounded" placeholder="検索" style="max-width:90px; min-width:40px;">
      </div>
      <input type="submit" value="&#xf002;" class="fas text-white orange lighten-1 border-white rounded-right shadow-none" style=" height:40px; position:relative; right:3px;">                    
      
    </div>
  </form>


  
  <!--Humberger -->
    <button class="navbar-dark navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon border border-muted border-2 rounded px-2 py-1 "></span>
    </button>  
 

  <!-- menu list-->
  <div class="collapse navbar-collapse" id="navbarSupportedContent" style="width:300px;margin: 0 auto;">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="learn" >単語学習</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="search">あいまい検索</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="category">関連タグ</a>
      </li>

      @guest
        <li class="nav-item">
          <a class="nav-link" href="{{ route('login') }}">ログイン</a>
        </li>
      @endguest

      @guest
      <li class="nav-item">
        <span class="">
          <a href="{{ route('register')}}"class="text-white border border-white rounded px-2 py-1 mt-2 ml-1" style="font-size:1.0rem">無料登録</a>
        </span>
      </li>
      @endguest      

      @auth
        <li class="nav-item">
          <a class="nav-link" href="{{ route('users.show', ['name'=>Auth::user()->name]) }}">学習状況</a>
        </li>
        <li class="nav-item">
          <button form="logout-button" class="py-2 bg-transparent border border-0 text-white" type="submit">
            ログアウト
          </button>
          <form id="logout-button" method="POST" action="{{ route('logout') }}">
            @csrf
          </form>        
        </li>      
      @endauth

    </ul>
  </div>  




</nav>