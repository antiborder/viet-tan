@extends('app')

@section('title', $word->name.'の意味・発音・関連語')
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
    <div class="card my-2 mb-0 pb-2 pl-2 pr-2 border-warning bg-transparent text-warning" style="border-width:2px; max-width:30rem">
      <span style=";font-size:1.2rem">単語詳細</span>
      @include('words.detail')

      @foreach($word->tags as $tag)
        @if($loop->first)
          <span class="mt-1">
          <span style="font-size:1.2rem">関連タグ&ensp;</span>
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
        <div class="card mt-3 mb-1 pb-1 pl-2 pr-2 border-primary bg-transparent text-primary" style="color: white; max-width: 30rem;border-width:2px">        
        <span style=";font-size:1.2rem">類義語</span>
      @endif      
      @include('words.card',['word'=>$synonym])
      @if($loop->last)
        </div>
      @endif
    @endforeach    
    
    @foreach($word->antonyms()->sortBy('level') as $antonym)
      @if($loop->first)
        <div class="card mt-3 mb-1 pb-1 pl-2 pr-2 border-danger bg-transparent text-danger" style="color: white; max-width: 30rem;border-width:2px">        
        <span style=";font-size:1.2rem">対義語</span>
      @endif
      @include('words.card',['word'=>$antonym])
      @if($loop->last)
        </div>
      @endif
    @endforeach
    
    @foreach($similar_pronuciations as $similar_pronuciation)
      @if($loop->first)
        <div class="card mt-3 mb-1 pb-1 pl-2 pr-2 border-info bg-transparent text-info" style="color: white; max-width: 30rem;border-width:2px">
          <span style=";font-size:1.2rem">発音が似てる単語</span>
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
        <div class="card my-2 mb-1 pb-1 pl-2 pr-2 border-success bg-transparent text-success" style="color: white; max-width: 30rem;border-width:2px">
        <span style=";font-size:1.2rem">同じ音節を含む単語</span> (全{{$common_syllables->count()}}件)
        @endif
        @include('words.card',['word'=>$common_syllable])
        @if($loop->last)
          </div>
        @endif
      @endforeach        
      
    @elseif($subscription === 'TRIAL')
      @foreach($common_syllables as $i => $common_syllable)
        @if($loop->first)
        <div class="card my-2 mb-1 pb-1 pl-2 pr-2 border-success bg-transparent text-success" style="color: white; max-width: 30rem;border-width:2px">
        <span style="font-size:1.2rem">同じ音節を含む単語<span class="text-dark" style="font-size:1.0rem"> (全{{$common_syllables->count()}}件)</span></span>
        @endif
        @if($i < config('const.SAME_SYLLABLE_TRIAL'))
          @include('words.card',['word'=>$common_syllable])
        @endif
        @if($loop->last)
          @if($common_syllables->count() > config('const.SAME_SYLLABLE_TRIAL'))
            <div class="mt-2" data-toggle="modal" data-target="#recommend-normal" style="">
              <button class="success-color text-white border border-0 px-2 py-1 rounded shadow" style="font-family: 'Kosugi Maru', sans-serif;">同じ音節を含む単語をもっと見る</button>
            </div>          
          @endif        
          </div>
        @endif
      @endforeach                
    @elseif($subscription === 'GUEST')
      @foreach($common_syllables as $i => $common_syllable)
        @if($loop->first)
        <div class="card my-2 mb-1 pb-1 pl-2 pr-2 border-success bg-transparent text-success" style="color: white; max-width: 30rem;border-width:2px">
        <span style="font-size:1.2rem">同じ音節を含む単語<span class="text-dark" style="font-size:1.0rem"> (全{{$common_syllables->count()}}件)</span></span>
        @endif
        @if($i < config('const.SAME_SYLLABLE_GUEST'))
          @include('words.card',['word'=>$common_syllable])
        @endif
        @if($loop->last)
          @if($common_syllables->count() > config('const.SAME_SYLLABLE_GUEST'))
            <div class="mt-2" data-toggle="modal" data-target="#recommend-trial" style="">
              <button class="success-color text-white border border-0 px-2 py-1 rounded shadow" style="font-family: 'Kosugi Maru', sans-serif;">同じ音節を含む単語をもっと見る</button>
            </div>          
          @endif        
          </div>
        @endif
      @endforeach                    
    @endif

    <a href="{{route('index')}}" >
      <div class="pb-1 normal-text orange text-white lighten-1 text-center rounded shadow" style="max-width:450px" >
        <div>
          <div style="display:inline-block">1日10分でOK。</div>
          <div style="display:inline-block">スキマ時間にクリックするだけ。</div>
        </div>
        <div class="white rounded mb-1 mx-2" style="color:#ffa726;">
          <div class="h3 mb-n1" >
            <div class="mr-n1 " style="display:inline-block">ベトナム語学習の</div>
            <div class="" style="display:inline-block">無料ツール</div>
          </div>
          <small class="">べとらん Homeに戻る</small>
        </div>
      </div>
    </a>
        
    <div class="my-2">
      @include('ads.rectangle')
    </div>

  </div>

  @include('footer')
@endsection