@extends('app')

@section('title', $word->name.'の意味・発音・関連語 @ がんばらないベトナム語のススメ【べとらん】')
@section('twitter_card')
  <meta name="twitter:card" content="summary" />
  <meta name="twitter:site" content="@viet_learn" />
  <meta name="twitter:title" content="ベトナム語 {{$word->name}}" />
  <meta name="twitter:description" content="{{$word->name}} の意味・発音・関連語" />
  <meta name="twitter:image" content="https://vietnamese-learn.net/image/twitter-card.png" />
@endsection

@section('content')
  @include('nav')
  <div class="container" style="max-width:800px">
    <div class="grouping-square grouping-square-orange">
      <span class="grouping-label">単語詳細</span>
      @include('words.detail')

      @foreach($word->tags as $tag)
        @if($loop->first)
          <span class="mt-1">
          <span class="grouping-label">関連タグ&ensp;</span>
        @endif
          <span class="mx-1">
            @include('tags.card',['tag'=>$tag])
          </span>
        @if($loop->last)
          </span>
        @endif
      @endforeach
    </div>
    <div class="my-2" style="height:200px">
      @include('ads.horizontal')
    </div>

    @foreach($word->synonyms()->sortBy('level') as $synonym)
      @if($loop->first)
        <div class="grouping-square grouping-square-primary">
        <span class="grouping-label">類義語</span>
      @endif
      @include('words.card',['word'=>$synonym])
      @if($loop->last)
        </div>
      @endif
    @endforeach

    @foreach($word->antonyms()->sortBy('level') as $antonym)
      @if($loop->first)
        <div class="grouping-square grouping-square-danger">
        <span class="grouping-label">対義語</span>
      @endif
      @include('words.card',['word'=>$antonym])
      @if($loop->last)
        </div>
      @endif
    @endforeach

    @foreach($similar_pronuciations as $similar_pronuciation)
      @if($loop->first)
      <div class="grouping-square grouping-square-info">
          <span class="grouping-label">発音が似てる単語</span>
      @endif
      @include('words.card',['word'=>$similar_pronuciation])
      @if($loop->last)
        </div>

        @include('ads.horizontal')
      @endif
    @endforeach

    @if($subscription === 'NORMAL')
      @foreach($common_syllables as $i => $common_syllable)
        @if($loop->first)
        <div class="grouping-square grouping-square-success">
          <span class="grouping-label">
            同じ音節を含む単語
          </span> 
          (全{{$common_syllables->count()}}件)
        @endif
        @include('words.card',['word'=>$common_syllable])
        @if($loop->last)
          </div>
        @endif
      @endforeach

    @elseif($subscription === 'TRIAL')
      @foreach($common_syllables as $i => $common_syllable)
        @if($loop->first)
          <div class="grouping-square grouping-square-success">
            <span class="grouping-label">
              同じ音節を含む単語
              <span class="text-dark" style="font-size:1.0rem"> (全{{$common_syllables->count()}}件)</span>
            </span>
        @endif
        @if($i < config('const.SAME_SYLLABLE_TRIAL'))
          @include('words.card',['word'=>$common_syllable])
        @endif
        @if($loop->last)
          @if($common_syllables->count() > config('const.SAME_SYLLABLE_TRIAL'))
            <div class="mt-2" data-toggle="modal" data-target="#recommend-normal">
              <button class="success-color text-white border border-0 px-2 py-1 rounded shadow">
                同じ音節を含む単語をもっと見る
              </button>
            </div>
          @endif
          </div>
        @endif
      @endforeach
    @elseif($subscription === 'GUEST')
      @foreach($common_syllables as $i => $common_syllable)
        @if($loop->first)
        <div class="grouping-square grouping-square-success">
            <span class="grouping-label">
              同じ音節を含む単語
              <span class="text-dark" style="font-size:1.0rem"> 
                (全{{$common_syllables->count()}}件)</span>
            </span>
        @endif
        @if($i < config('const.SAME_SYLLABLE_GUEST'))
          @include('words.card',['word'=>$common_syllable])
        @endif
        @if($loop->last)
          @if($common_syllables->count() > config('const.SAME_SYLLABLE_GUEST'))
            <div class="mt-2" data-toggle="modal" data-target="#recommend-trial">
              <button class="success-color text-white border border-0 px-2 py-1 rounded shadow">
                同じ音節を含む単語をもっと見る
              </button>
            </div>
          @endif
          </div>
        @endif
      @endforeach
    @endif

    <a href="{{route('index')}}" >
      <div class="self-ad-outer-square">
        <div>
          <div class="d-inline-block">1日10分でOK。</div>
          <div class="d-inline-block">スキマ時間にクリックするだけ。</div>
        </div>
        <div class="self-ad-inner-square">
          <div class="h3 mb-n1" >
            <div class="mr-n1 d-inline-block">がんばらない</div>
            <div class="d-inline-block">ベトナム語のすすめ</div>
          </div>
          <small>べとらん Homeに戻る</small>
        </div>
      </div>
    </a>

    <div class="my-2">
      @include('ads.rectangle')
    </div>

  </div>

  @include('footer')
@endsection