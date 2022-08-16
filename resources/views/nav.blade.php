<nav id="nav" class="navbar navbar-dark navbar-expand-xl orange lighten-1 px-1 pt-1 pb-0">

   <!-- Logo -->
  <a href="{{route('index')}}" class="navbar-brand">べとらん</a>

  <!-- 検索 -->
  <form class="form-inline pt-2" action="{{url('/search')}}">
    <div class="input-group input-group-lg">

      <div class="form-group ml-0 mb-2">
        <input type="text" name="keyword" value="{{$keyword ?? null}}" class="form-control nav-search-form" placeholder="検索">
      </div>
      <input type="submit" value="&#xf002;" class="fas nav-search-btn">

    </div>
  </form>





  <!--Humberger -->
    <button class="navbar-dark navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon border border-muted border-2 rounded px-2 py-1 "></span>
    </button>


  <!-- menu list-->
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="{{route('index')}}" >Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('learn')}}" >単語学習</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('measure')}}" >単語力測定</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('words.search')}}" >あいまい検索</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('tags.categories')}}">タグから探す</a>
      </li>
      @auth
        <li class="nav-item">
          <a class="nav-link" href="{{ route('users.show', ['name'=>Auth::user()->name]) }}">学習状況</a>
        </li>
      @endauth

      @guest
        <li class="nav-item" data-toggle="modal" data-target="#recommend-trial">
          <a class="nav-link">学習状況</a>
        </li>
      @endguest

      <li class="nav-item" data-toggle="modal" data-target="#contact">
        <a class="nav-link" >ご意見・お問い合せ</a>
      </li>

      @guest
        <li class="nav-item">
          <span>
            <a href="{{ route('login') }}" class="nav-text-login">ログイン</a>
          </span>
        </li>
      @endguest

      @guest
      <li class="nav-item">
        <span>
          <a href="{{ route('register')}}" class="nav-text-signup">無料登録</a>
        </span>
      </li>
      @endguest

      @auth
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

<!-- recommend-trial modal -->
<div class="modal fade rounded" id="recommend-trial" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button><br>
        <div class="m-2 text-center">この機能は会員専用です。</div>
        <div class="text-center" >
          <a href="{{ route('register')}}" class="btn-recommend signup-button">
            無料登録する
          </a>
        </div>
        <div class="text-center">
          <a href="{{ route('login') }}" class="btn-recommend login-button">
            ログインする
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- recommend-normal modal -->
<div class="modal fade rounded" id="recommend-normal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button><br>
        <div class="m-2 text-center">この機能は通常会員専用です。</div>
        <div class="text-center">
          <a href="{{ route('stripe.subscription')}}" class="btn-recommend signup-button" >本登録する</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- contact-modal -->
<div class="modal fade rounded" id="contact" tabindex="-1" role="dialog" aria-hidden="true" >
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button><br>
        Viet-Learnをご利用頂きありがとうございます。<br>
        ご不明点やご意見がございましたら、フォームよりご連絡ください。
        <form method="POST" action="{{ route('contact.send') }}">
          @csrf
          <input class="mt-2 w-100" name="email" value="{{ old('email') }}" placeholder="メールアドレス" type="text" >
          @if ($errors->has('email'))
              <p class="error-message">{{ $errors->first('email') }}</p>
          @endif
          <br>
          <input class="mt-2 w-100" name="title" value="{{ old('title') }}" type="text" placeholder="タイトル">
          @if ($errors->has('title'))
              <p class="error-message">{{ $errors->first('title') }}</p>
          @endif

          <textarea class="my-2 w-100 contact-textarea " name="body" placeholder="メッセージ">
            {{ old('body') }}
          </textarea>
          @if ($errors->has('body'))
              <p class="error-message">{{ $errors->first('body') }}</p>
          @endif
          <br>

          <button class="btn btn-success py-1 px-2" type="submit" name="action" value="submit">
              送信
          </button>
        </form>
      </div>
    </div>
  </div>
</div>