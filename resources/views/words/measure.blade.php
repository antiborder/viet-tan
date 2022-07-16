@extends('app')

@section('title', '単語力測定')

@section('twitter_card')
  <meta name="twitter:card" content="summary" />
  <meta name="twitter:site" content="@viet_learn" />
  <meta name="twitter:title" content="【ベトナム語】単語力測定" />
  <meta name="twitter:description" content="たった2分間であなたの単語力を測定。腕試しに挑戦してみませんか？登録不要。あなたのベトナム語力は『????語』です。" />
  <meta name="twitter:image" content="https://vietnamese-learn.net/image/twitter-card-measure.png" />
@endsection

@section('content')
  @include('nav')
  
  <div class="container">
    <div>
      <measure 
        endpoint_to_get_word="{{ route('learn.random') }}"
        endpoint_to_record_learn="{{ route('learn.record') }}"
        time_limit = "{{config('const.TIME_LIMIT')}}"
        max_level = "{{config('const.MAX_LEVEL')}}"
      >
      </measure>
    </div>
  </div>


@endsection