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
  <div id='top' class="container container-top">
    <div class="card mt-3 mb-1 p-0">
      <div class="card-body p-1">
        <div class="h5 card-title m-0 py-1">
          <h1 class="catch-text1">
            がんばらないベトナム語のススメ
            <br>
            <p class="catch-text2" >
              無料の<span class="part2">ベトナム語学習ツール</span><br>
              <span  class="part3" >べとらん</span>
            </p>
          </h1>

          @guest
            <div class="text-center">
              <a href="{{ route('register')}}" >
                <div class="btn-signup btn-signup-top">
                  無料登録
                </div>
              </a>
            </div>
          @endguest
        </div>
      </div>
    </div>

    <div class="menu-block1">
      <ul class="large-icon-list">
        <li class="d-inline-block">
          <a href="{{route('learn')}}" >
            <div class="large-icon">
              <div class="h5 text-white" >
                  単語学習
              </div>
              <div class="white rounded">
                <img src='/image/learn-icon.webp' class="large-icon-image">
                <div class="large-icon-text">
                一日10分でOK。<br>
                単語毎の習熟度に<br>
                合わせて出題。
                </div>
              </div>
            </div>
          </a>
        </li>
        <li class="d-inline-block">
          <a href="{{route('measure')}}"  >
            <div class="large-icon">
              <div class="h5 text-white" >
                  単語力測定
              </div>
              <div class="white rounded">
                <img src='/image/measure-icon.webp' class="large-icon-image">
                <div class="large-icon-text">
                  2分間で実力チェック。<br>
                  あなたの単語力は<br>
                  ????語です。
                </div>
              </div>
            </div>
          </a>
        </li>
        <li class="d-inline-block">
          <a href="{{route('words.search')}}"  >
            <div class="large-icon">
              <div class="h5 text-white" >
                  あいまい検索
              </div>
              <div class="white rounded">
                <img src='/image/search-icon.webp' class="large-icon-image">
                <div class="large-icon-text">
                  記憶があいまいでも大丈夫。<br>
                  ベトナム語も漢越語もまとめて検索。
                </div>
              </div>
            </div>
          </a>
        </li>
      </ul>
    </div>
    <div class="card my-2 p-0">
      <div class="card-body p-1">
        <div class="h5 card-title m-0">
          <h3 class="sizable-text-middle pt-5 text-center" >
            スキマ時間にクリックするだけ
          </h3>
        </div>
        <p class="sizable-text-small text-center">
          1日10分でOK。忙しい人にもおすすめ。
        </p>
        <div class="image-container">
          <div class="image-aligner" >
            <img class="feature-image pr-1" src="/image/learn-image.webp">
            <img class="feature-image pl-1" src="/image/result-image.webp">
          </div>
        </div>

        <div class="h5 card-title m-0">
          <h3 class="sizable-text-middle pt-5 text-center">
            自動でスケジュール管理
          </h3>
        </div>
        <p class="sizable-text-small text-center">
          単語毎の習熟度に合わせて出題。<br>
          余計な手間がないから学習が快適。
        </p>
        <div class="image-container">
          <div class="image-aligner" >
            <img class="feature-image pr-1" src="/image/schedule-image.webp">
            <img class="feature-image pl-1" src="/image/progress-image.webp">
          </div>
        </div>

        <div class="h5 card-title m-0">
          <h3 class="sizable-text-middle pt-5 text-center">
            優先順に整理された約5000語
          </h3>
        </div>
        <p class="sizable-text-small text-center">
          単語を関連付けて覚えるから忘れにくい。<br>
          よく使う重要な単語から学ぶので、<br>
          無駄がなく効率的。
        </p>
        <div class="image-container">
          <div class="image-aligner" >
            <img class="feature-image pr-1" src="/image/connection-image.webp">
            <img class="feature-image pl-1" src="/image/related-image.webp">
          </div>
        </div>
        <br>
        <br>
      </div>
    </div>

    <div class="card new-func-border">
      <div class="card-body p-1 text-center">
        <h3 class="sizable-text-middle pt-1 text-center new-func-tytle">
          新機能『方言設定』
        </h3>
        <p class="sizable-text-small text-center">
          北部方言と南部方言の出題をON/OFFできます。<br>
          ログイン後、『学習状況』下部の『方言設定』よりご利用ください。<br>
        </p>
      </div>
    </div>

    <div class="card my-4 p-0">
      <div class="card-body p-1 text-center">
        <p class="m-0">
          お知らせ
        </p>
        <div>
          <table class="info-table text-small">
            <tr><td class="info-date">2022.10.13</td><td>単語の意味詳細を追加しました。</td></tr>
            <tr><td class="info-date">2022.10.17</td><td>単語データベースを更新しました。</td></tr>
            <tr><td class="info-date">2022.10.31</td><td>関連タグに検索用のkeywordを追加しました。</td></tr>
            <tr><td class="info-date">2022.11.18</td><td>学習状況に方言設定を追加しました。</td></tr>
          </table>
        </div>
      </div>
    </div>

    <div class="menu-block2">
      <ul class="small-icon-list">
        <li class="d-inline-block">
          <a href="{{route('categories.index')}}" >
            <div class="small-icon">
              <div class="small-icon-inner-square">
                <div>
                  <div class="small-icon-table">
                    <div class="small-icon-lable">
                      タグから<br>探す
                    </div>
                  </div>
                  <img src='/image/tag-icon.webp' class="small-icon-image">
                </div>
              </div>
            </div>
          </a>
        </li>
        <li class="d-inline-block">
          <a href="{{route('articles.level-table')}}" >
            <div class="small-icon">
              <div class="small-icon-inner-square">
                <div>
                  <div class="small-icon-table">
                    <div class="small-icon-lable">
                    単語レベル<br>一覧
                    </div>
                  </div>
                  <img src='/image/level-table-icon.webp' class="small-icon-image">
                </div>
              </div>
            </div>
          </a>
        </li>
        @auth
          <li class="d-inline-block">
            <a href="{{ route('users.show', ['name'=>Auth::user()->name]) }}" >
        @endauth
        @guest
          <li class="d-inline-block" data-toggle="modal" data-target="#recommend-trial">
            <a>
        @endguest
          <div class="small-icon">
              <div class="small-icon-inner-square">
                <div >
                  <div class="small-icon-table">
                    <div class="small-icon-lable">
                      学習状況
                    </div>
                  </div>
                  <img src='/image/progress-icon.webp' class="small-icon-image">
                </div>
              </div>
            </div>
          </a>
        </li>
        <li class="d-inline-block" data-toggle="modal" data-target="#contact">
          <a href="/articles/level-table"  >
            <div class="small-icon">
              <div class="small-icon-inner-square">
                <div>
                  <div class="small-icon-table">
                    <div class="small-icon-lable">
                      ご意見<br>お問い合わせ
                    </div>
                  </div>
                  <img src='/image/contact-icon.webp' class="small-icon-image">
                </div>
              </div>

            </div>
          </a>
        </li>
      </ul>
    </div>

    <div class="card my-2 p-0">
      <div class="card-body text-center p-1">
        <p class="sizable-text-small mt-1 text-center">単語カードの見方</p>
          <img class="pl-1 mb-2 wide-image" src="/image/card-image.webp">
      </div>
    </div>
    <div class="">
      <h4 class="sizable-text-small text-center mt-3 mb-0" >
        単語カードサンプル
      </h4>
      <p class="sample-click-text">単語↓をclick</p>
      <div>
        @foreach($words as $word)
        <div class="word-card-box">
          @include('words.card')
        </div>
        @endforeach
      </div>
    </div>

  </div>

  @include('footer')
@endsection
