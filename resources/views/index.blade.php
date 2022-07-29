@extends('app')

@section('title', '【ベトナム語学習ツール】べとらん')

@section('twitter_card')
  <meta name="twitter:card" content="summary" />
  <meta name="twitter:site" content="@viet_learn" />
  <meta name="twitter:title" content="ベトナム語学習ツール【べとらん】" />
  <meta name="twitter:description" content="学習に役立つ便利ツール。がんばらないベトナム語のススメ。スキマ時間に自分のペースで進められる。優先順に整理された5000語。関連語・類似語が一目でわかる。学習のお供に。" />
  <meta name="twitter:image" content="https://vietnamese-learn.net/image/twitter-card.png" />
@endsection

@section('content')
  @include('nav')
  <div class="container" style="max-width:850px; font-family: 'Kosugi Maru', sans-serif;">
    <div class="card mt-3 mb-1 p-0">
      <div class="card-body p-1">
        <div class="h5 card-title m-0 py-1">
          <h1 class="sizable-text-small pt-4 mb-3" style="text-align:center; font-family: 'Kosugi Maru', sans-serif;">
            がんばらないベトナム語のススメ
            <br>
            <p class="sizable-text-large mt-2" >
              無料の<span class="text-nowrap">ベトナム語学習ツール</span><br>
              <span class="sizable-text-large mt-2" style="display:inline-block; color:#ffa726;">べとらん</span>
            </p>  
          </h1>

          
          @guest
            <a href="{{ route('register')}}" >
              <div class="card mb-3 py-3 px-3 text-white deep-orange lighten-1" style=" font-size:1.1rem; width: 150px;  text-align:center; margin:0 auto; font-family: 'Kosugi Maru', sans-serif;">
                無料登録
              </div>
            </a>          
          @endguest
        </div>
      </div>
    </div>
    <ul class="inline-block" style="list-style-type: none; padding-left:0; text-align:center" >
      <li style="display:inline-block">
        <a href="{{route('learn')}}" >
          <div class="large-icon card mt-3 mx-2 mb-2 p-2 orange lighten-1">
            <div class="h5 text-white" >
                単語学習
            </div>
            <div class="white rounded">
              <img src='/image/learn-icon.webp' style="height:120px">
              <div class="white text-dark" style="font-size: 1rem; height:70px">
              一日10分でOK。<br>単語毎の習熟度に<br>合わせて出題。
              </div>        
            </div>
          </div>
        </a>
      </li>
      <li style="display:inline-block">
        <a href="{{route('measure')}}"  >
          <div class="large-icon card mt-3 mx-2 mb-2 p-2 orange lighten-1">
            <div class="h5 text-white" >
                単語力測定
            </div>
            <div class="white rounded" style="">
              <img src='/image/measure-icon.webp' style="height:120px">
              <div class="white text-dark" style="font-size:1.0rem;  height:70px">
                2分間で実力チェック。<br>あなたの単語力は<br>????語です。
              </div>
            </div>
          </div>
        </a> 
      </li>
      <li style="display:inline-block">
        <a href="{{route('words.search')}}"  >
          <div class="large-icon card mt-3 mx-2 mb-2 p-2 orange lighten-1">
            <div class="h5 text-white" >
                あいまい検索
            </div>
            <div class="white rounded" style="">
              <img src='/image/search-icon.webp' style="height:120px">
              <div class="white text-dark" style="font-size:1.0rem;  height:70px">
                記憶があいまいでも大丈夫。<br>ベトナム語も漢越語もまとめて検索。
              </div>
            </div>
          </div>
        </a> 
      </li>
    </ul>
    
    <div class="card my-2 p-0">        
      <div class="card-body p-1">      
        <div class="h5 card-title m-0">
          <h3 class="sizable-text-middle pt-5" style="text-align:center; font-family: 'Kosugi Maru', sans-serif;">
            スキマ時間にクリックするだけ
          </h3>
        </div>
        <p class="sizable-text-small" style="text-align:center;">1日10分でOK。忙しい人にもおすすめ。</p>
        <div class="image-container">
          <div class="image-aligner" >
            <img class="pr-1" src="/image/learn-image.webp"style="height:250px;">
            <img class="pl-1" src="/image/result-image.webp"style="height:250px;">
          </div>
        </div>

        <div class="h5 card-title m-0">
          <h3 class="sizable-text-middle pt-5" style="text-align:center; font-family: 'Kosugi Maru', sans-serif;">
            自動でスケジュール管理
          </h3>
        </div>
        <p class="sizable-text-small" style="text-align:center;">単語毎の習熟度に合わせて出題。<br>余計な作業がないから学習が快適。</p>
        <div class="image-container">
          <div class="image-aligner" >
            <img class="pr-1" src="/image/schedule-image.webp"style="height:250px;">
            <img class="pl-1" src="/image/progress-image.webp"style="height:250px;">
          </div>
        </div>

        <div class="h5 card-title m-0">
          <h3 class="sizable-text-middle pt-5" style="text-align:center; font-family: 'Kosugi Maru', sans-serif;">
            優先順に整理された約5000語
          </h3>
        </div>
        <p class="sizable-text-small" style="text-align:center;">単語を関連付けて覚えるから忘れにくい。<br>よく使う重要な単語から学ぶので、<br>無駄がなく効率的。</p>
        <div class="image-container">
          <div class="image-aligner" >
            <img class="pr-1" src="/image/connection-image.webp"style="height:250px;">
            <img class="pl-1" src="/image/related-image.webp"style="height:250px;">
          </div>
        </div>
        <br>
        <br>
      </div>
    </div>

    <ul class="inline-block" style="list-style-type: none; padding-left:0; text-align:center" >
      <li style="display:inline-block">
        <a href="{{route('tags.categories')}}" >
          <div class="card orange lighten-1 m-2 p-1 small-icon">
            <div class="card white rounded shadow-none" style="width:100%; height:100%;">
              <div class="pb-3" >
                  タグから探す
              </div>
            <!-- <img src='' style="width:90px"> -->
            </div>
          </div>
        </a>
      </li>    
      <li style="display:inline-block">
        <a href="{{route('articles.level-table')}}" >
          <div class="card orange lighten-1 m-2 p-1 small-icon">
            <div class="card white rounded shadow-none" style="width:100%; height:100%;">
              <div class="pb-3" >
                単語レベル<br>一覧
              </div>
              <!-- <img src='' style="width:90px"> -->
            </div>
          </div>
        </a>
      </li> 
      @auth
        <li style="display:inline-block">
          <a href="{{ route('users.show', ['name'=>Auth::user()->name]) }}" >
      @endauth
      @guest
        <li style="display:inline-block" data-toggle="modal" data-target="#recommend-trial">
          <a>      
      @endguest
         <div class="card orange lighten-1 m-2 p-1 small-icon">
            <div class="card white rounded shadow-none" style="width:100%; height:100%;">
                学習状況
            </div>
            <!-- <img src='' style="width:90px"> -->
          </div>
        </a>
      </li>       
      <li style="display:inline-block" data-toggle="modal" data-target="#contact">
        <a href="/articles/level-table"  >
        <div class="card orange lighten-1 m-2 p-1 small-icon">
          <div class="card white rounded shadow-none" style="width:100%; height:100%;">
                ご意見<br>お問い合わせ
            </div>
            <!-- <img src='' style="width:90px"> -->
          </div>
        </a>
      </li>          

    <div class="card my-2 p-0">
      <div class="card-body text-center p-1">
        <p class="sizable-text-small mt-1" style="text-align:center;">単語カードの見方</p>          
          <img class="pl-1 mb-2 wide-image" src="/image/card-image.webp">
      </div>  
    </div>
    <h4 class="sizable-text-small mt-3 mb-0" style="text-align:left;"> 単語カードサンプル<br>
    <small class="text-muted">（単語をclick↓）</small></h4>
    @foreach($words as $word)
    <div>
    <div class="" style="">
      @include('words.card')
    </div>
    </div>
    @endforeach

  </div>

  @include('footer')
@endsection

<style>

  .sizable-text-small{
    font-size: calc(1.2rem + ((1vw - 0.64rem) * 0.7143));
  }
  .sizable-text-middle{
    font-size: calc(1.6rem + ((1vw - 0.64rem) * 1.13));
  }
  .sizable-text-large{
    font-size: calc(2.4rem + ((1vw - 0.64rem) * 2.1429));
  }  

  .image-container{
    display:flex; 
    overflow-x:auto;
  }

  .image-aligner{
    display:flex; 
    align-items:center;
    margin:auto;
  }

  .small-icon{
    color:#ffa726;
    width:150px; 
    height:70px; 
    text-align:center; 
    margin:0 auto; 
    font-size:1.3rem;
    font-family: 'Kosugi Maru', sans-serif; 
  }

  .large-icon{
    color:white; 
    width:250px; 
    height:240px; 
    text-align:center; 
    margin:0 auto; 
    font-family: 'Kosugi Maru', sans-serif;
  }

</style>