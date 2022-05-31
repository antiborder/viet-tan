@extends('app')

@section('title', '【ベトナム語学習サービス】Viet Learn')

@section('content')
  @include('nav')
  <div class="container">

    
    <div class="card mt-3 p-0">
      <div class="card-body p-1">
        <div class="h5 card-title m-0">
          <h1 class="pt-5" style="text-align:center;font-size: calc(2.4rem + ((1vw - 0.64rem) * 2.1429)); font-family: 'Kosugi Maru', sans-serif;">
            初心者から、話せる人に<br>
            <span style="font-size: calc(1.2rem + ((1vw - 0.64rem) * 0.7143));">
              ベトナム語学習サービス
              「 Viet Learn 」
            </span>
          </h1>
          <a href="{{ route('register')}}" >
            <div class="card mt-3 mb-5 py-3 px-3 text-white orange lighten-1" style=" font-size:1.0rem; width: 150px;  text-align:center; margin:0 auto; font-family: 'Kosugi Maru', sans-serif;">
              <div >
                無料登録
              </div>
            </div>
          </a>          
          
        </div>
        


        <div class="h5 card-title m-0">
          <h3 class="pt-5" style="text-align:center;font-size: calc(1.6rem + ((1vw - 0.64rem) * 0.7143)); font-family: 'Kosugi Maru', sans-serif;">
            スキマ時間にクリックするだけ
          </h3>
        </div>
        <p style="text-align:center;font-size:calc(1.2rem + ((1vw - 0.64rem) * 0.7143))">1日10分でOK。忙しい人にもおすすめ。</p>
        <div style="display:flex; overflow-x:auto ">
          <div style="display:flex; align-items:center;margin:auto" >
            <img src="image/learn-image.png"style="height:250px;">
            <img src="image/result-image.png"style="height:250px;">
          </div>
        </div>

        <div class="h5 card-title m-0">
          <h3 class="pt-5" style="text-align:center;font-size: calc(1.6rem + ((1vw - 0.64rem) * 0.7143)); font-family: 'Kosugi Maru', sans-serif;">
            自動でスケジュール管理
          </h3>
        </div>
        <p style="text-align:center; font-size:calc(1.2rem + ((1vw - 0.64rem) * 0.7143))">単語毎の習熟度に合わせて出題。<br>余計な作業がないから学習が快適。</p>
        <div style="display:flex; overflow:scroll ">
          <div style="display:flex; align-items:center;margin:auto" >
            <img src="image/schedule-image.png"style="height:250px;">
            <img src="image/progress-image.png"style="height:250px;">
          </div>
        </div>

        <div class="h5 card-title m-0">
          <h3 class="pt-5" style="text-align:center;font-size: calc(1.6rem + ((1vw - 0.64rem) * 0.7143)); font-family: 'Kosugi Maru', sans-serif;">
            優先順に整理された約5000語
          </h3>
        </div>
        <p style="text-align:center; font-size:calc(1.2rem + ((1vw - 0.64rem) * 0.7143))">単語間を関連付けて覚えるから忘れにくい。<br>よく使う重要な単語から習得するので、<br>無駄がなく効率的。</p>
        <div style="display:flex; overflow-x:scroll ">
          <div style="display:flex; align-items:center;margin:auto" >
            <img src="image/connection-image.png"style="height:250px;">
            <img src="image/related-image.png"style="height:250px;">
          </div>
        </div>
        <br>
        <br>


      </div>
    </div>
    




    <a href="learn" >
      <div class="card mt-5 mb-1 px-2 py-4 h4 primary-color text-white" style="color: white; width: 200px;  text-align:center; margin:0 auto; font-family:ＭＳ Ｐゴシック;">
        <div >
            単語学習
        </div>
      </div>
    </a>


    <a href="search" >
      <div class="card mt-5 mb-1 px-2 py-4 h4 default-color text-white" style="color: white; width: 200px;  text-align:center;  margin:0 auto; font-family:MS UI Gothic;">
        <div >
            あいまい検索
        </div>
      </div>
    </a>


</div>

@endsection

