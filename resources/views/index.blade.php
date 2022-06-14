@extends('app')

@section('title', '【ベトナム語学習サービス】べとらん')

@section('content')
  @include('nav')
  <div class="container">
    <div class="card my-3 p-0">
      <div class="card-body p-1">
        <div class="h5 card-title m-0 py-1">
          <h1 class="pt-4 mb-3" style="text-align:center;font-size: calc(2.4rem + ((1vw - 0.64rem) * 2.1429)); font-family: 'Kosugi Maru', sans-serif;">
            初心者から、話せる人に<br>
            <span style="font-size: calc(1.2rem + ((1vw - 0.64rem) * 0.7143));">
              ベトナム語学習サービス
              「 べとらん 」
            </span>
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
                2分間で実力チェック。<br>あなたの単語力は<br>????語。
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
    
    <div class="card mt-3 p-0">        
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
        <p style="text-align:center; font-size:calc(1.2rem + ((1vw - 0.64rem) * 0.7143))">単語を関連付けて覚えるから忘れにくい。<br>よく使う重要な単語から習得するので、<br>無駄がなく効率的。</p>
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


  </div>

  @include('footer')
@endsection