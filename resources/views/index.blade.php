@extends('app')

@section('title', '【ベトナム語学習サービス】べとらん')

@section('content')
  @include('nav')
  <div class="container" style="max-width:850px">
    <div class="card my-3 p-0">
      <div class="card-body p-1">
        <div class="h5 card-title m-0 py-1">
          <h1 class="pt-4 mb-3" style="text-align:center; font-size: calc(1.2rem + ((1vw - 0.64rem) * 0.7143)); font-family: 'Kosugi Maru', sans-serif;">
            初心者から、話せる人に
            <br>
            <p class="mt-2" style="font-size: calc(2.4rem + ((1vw - 0.64rem) * 2.1429));">
              完全無料の<span class="text-nowrap">ベトナム語学習サービス</span><br>
              <span class="mt-2" style="display:inline-block; font-size: calc(2.4rem + ((1vw - 0.64rem) * 2.1429); color:#ffa726;">べとらん</span>
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
          <div class="card mt-3 mx-2 mb-3 px-2 py-2 h5 orange lighten-1 text-white" style="color:white; width:250px; height:240px; text-align:center; margin:0 auto; font-family: 'Kosugi Maru', sans-serif; ">
            <div class="pb-2" >
                単語学習
            </div>
            <div class="white rounded" style="">
              <img src='/image/learn-icon.webp' style="width:140px">
              <div class="white text-dark" style="font-size: 1rem; height:70px">
              一日10分でOK。<br>単語毎の習熟度に<br>合わせて出題。
              </div>        
            </div>
          </div>
        </a>
      </li>
      <li style="display:inline-block">
        <a href="{{route('measure')}}"  >
          <div class="card mt-3 mx-2 mb-3 px-2 py-2 h5 orange lighten-1 text-white" style="color:white; width:250px; height:240px; text-align:center; margin:0 auto; font-family: 'Kosugi Maru', sans-serif;">
            <div class="pb-2" >
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
          <div class="card mt-3 mx-2 mb-3 px-2 py-2 h5 orange lighten-1 text-white" style="color:white; width:250px; height:240px; text-align:center; margin:0 auto; font-family: 'Kosugi Maru', sans-serif;">
            <div class="pb-2" >
                あいまい検索
            </div>
            <div class="white rounded" style="">
              <img src='/image/search-icon.webp' style="width:140px">
              <div class="white text-dark" style="font-size:1.0rem;  height:70px">
                記憶があいまいでも大丈夫。<br>ベトナム語も漢越語もまとめて検索。
              </div>
            </div>
          </div>
        </a> 
      </li>
    </ul>
    
    <div class="card my-3 p-0">        
      <div class="card-body p-1">      
        <div class="h5 card-title m-0">
          <h3 class="pt-5" style="text-align:center;font-size: calc(1.6rem + ((1vw - 0.64rem) * 0.7143)); font-family: 'Kosugi Maru', sans-serif;">
            スキマ時間にクリックするだけ
          </h3>
        </div>
        <p style="text-align:center;font-size:calc(1.2rem + ((1vw - 0.64rem) * 0.7143))">1日10分でOK。忙しい人にもおすすめ。</p>
        <div style="display:flex; overflow-x:auto ">
          <div style="display:flex; align-items:center;margin:auto" >
            <img class="pr-1" src="/image/learn-image.webp"style="height:250px;">
            <img class="pl-1" src="/image/result-image.webp"style="height:250px;">
          </div>
        </div>

        <div class="h5 card-title m-0">
          <h3 class="pt-5" style="text-align:center;font-size: calc(1.6rem + ((1vw - 0.64rem) * 0.7143)); font-family: 'Kosugi Maru', sans-serif;">
            自動でスケジュール管理
          </h3>
        </div>
        <p style="text-align:center; font-size:calc(1.2rem + ((1vw - 0.64rem) * 0.7143))">単語毎の習熟度に合わせて出題。<br>余計な作業がないから学習が快適。</p>
        <div style="display:flex; overflow-x:auto ">
          <div style="display:flex; align-items:center;margin:auto" >
            <img class="pr-1" src="/image/schedule-image.webp"style="height:250px;">
            <img class="pl-1" src="/image/progress-image.webp"style="height:250px;">
          </div>
        </div>

        <div class="h5 card-title m-0">
          <h3 class="pt-5" style="text-align:center;font-size: calc(1.6rem + ((1vw - 0.64rem) * 0.7143)); font-family: 'Kosugi Maru', sans-serif;">
            優先順に整理された約5000語
          </h3>
        </div>
        <p style="text-align:center; font-size:calc(1.2rem + ((1vw - 0.64rem) * 0.7143))">単語を関連付けて覚えるから忘れにくい。<br>よく使う重要な単語から学ぶので、<br>無駄がなく効率的。</p>
        <div style="display:flex; overflow-x:auto ">
          <div style="display:flex; align-items:center;margin:auto" >
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

    <div class="card my-3 p-0">
      <div class="card-body text-center p-1">
        <p class="h4 mt-1" style="text-align:center; font-size:calc(1.4rem + ((1vw - 0.64rem) * 0.8143));">単語カードの見方</p>          
          <img class="pl-1 mb-2" src="/image/card-image.webp" style="text-align:center; width:calc(280px + ((100vw - 350px) * 0.2))">
      </div>  
    </div>
    <h4 class="h4" style="text-align:left; font-size:calc(1.4rem + ((1vw - 0.64rem) * 0.8143));"> 単語カードサンプル<small>（単語をclick↓）</small></h4>
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
  .small-icon{
    color:#ffa726;
    width:150px; 
    height:70px; 
    text-align:center; 
    margin:0 auto; 
    font-size:1.3rem;
    font-family: 'Kosugi Maru', sans-serif; 

  }
</style>