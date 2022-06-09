<nav class="navbar navbar-dark navbar-expand-lg orange lighten-1 p-1 pb-0">

   <!-- Logo -->
  <a href="{{route('index')}}" class="navbar-brand ml-1  " style="font-size:1.0rem">vietnamese-learn.net</a>
  
  <!-- 検索 -->
  <form class="form-inline pt-2" action="{{url('/search')}}">
    <div class="input-group input-group-lg">
    
      <div class="form-group ml-0 mb-2">
        <input type="text" name="keyword" value="{{$keyword ?? null}}" class="form-control rounded" placeholder="検索" style="max-width:90px; min-width:40px;">
      </div>
      <input type="submit" value="&#xf002;" class="fas text-white border border-0 rounded-right " style=" height:38px; position:relative; right:3px; background-color:#ffc700;">                    
      
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
        <a class="nav-link" href="{{route('learn')}}" >単語学習</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('words.search')}}">あいまい検索</a>
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
            <a href="{{ route('login') }}" class="text-white border border-white rounded px-2 py-1 mt-1 mx-1" style="font-size:0.9rem">ログイン</a>
          </span>
        </li>
      @endguest

      @guest
      <li class="nav-item">
        <span class="">
          <a href="{{ route('register')}}" class="text-white deep-orange lighten-1 rounded px-2 py-1 mx-1 mt-1 " style="font-size:1.0rem">無料登録</a>
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
        <div class="m-2" style="text-align:center; font-size:1.2rem">この機能は会員専用です。</div>
        <div class="m-3" style="text-align:center; font-size:1.2rem" >
          <a href="{{ route('register')}}" class="deep-orange lighten-1 text-white rounded px-3 py-2" >無料登録する</a>
        </div>
        <div class="m-4" style="text-align:center; font-size:1.2rem">
          <a href="{{ route('login') }}" class=" rounded px-3 py-2" style="color:#ffa726;border-color:#ffa726;border-style:solid" >ログインする</a>
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
        <div class="m-2" style="text-align:center; font-size:1.2rem">この機能は通常会員専用です。</div>
        <div class="m-3" style="text-align:center; font-size:1.2rem" >
          <a href="{{ route('stripe.subscription')}}" class="deep-orange lighten-1 text-white rounded px-3 py-2" >本登録する</a>
        </div>
      </div>
    </div>
  </div>
</div>        

<!-- contact-modal -->
<div class="modal fade rounded" id="contact" tabindex="-1" role="dialog" aria-hidden="true">
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
          <input
              class="mt-2"
              name="email"
              value="{{ old('email') }}"
              placeholder="メールアドレス"
              type="text"
              style="width:100%">
          @if ($errors->has('email'))
              <p class="error-message">{{ $errors->first('email') }}</p>
          @endif
          <br>
          <input class="mt-2" name="title" value="{{ old('title') }}" type="text" placeholder="タイトル" style="width:100%">
          @if ($errors->has('title'))
              <p class="error-message">{{ $errors->first('title') }}</p>
          @endif              

          <textarea class=" my-2" name="body" placeholder="メッセージ" style="width:100%; height:200px">
            {{ old('body') }}
          </textarea>
          @if ($errors->has('body'))
              <p class="error-message">{{ $errors->first('body') }}</p>
          @endif
          <br>

          <button class="btn btn-success py-1 px-2" type="submit" name="action" value="submit" style="font-size:1.0rem">
              送信
          </button>
        </form>
      </div>
    </div>
  </div>
</div>