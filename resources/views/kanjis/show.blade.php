@extends('app')

@section('title', $kanji->name)

@section('content')
  @include('nav')
  <div class="container" style="max-width:850px">
    <div class="card my-3 centered-block">
      <div class="card-body">
        漢字　<span class="kanji-text h3 card-title m-0">{{ $kanji->name }}</span>　を含む単語
      </div>
      <div class="text-right">
        <a href="{{route('articles.han-nom')}}" class="white border border-success text-success rounded mx-2 mb-2 pb-1 px-2" style="display:inline-block;">
          <small>漢字表記について</small>
        </a>                        
      </div>      
    </div>
    <div class="centered-block">
      <span style="font-size:1.4rem">{{ $words->count() }}</span> 件が該当
    </div>

    <div class="centered-block">
      <p class="sample-click-text">　↓ベトナム語をclick！</p>      
      @if($subscription === 'NORMAL')

        @foreach($words as $i => $word)
          @include('words.card')
          @if($i===9 || $i===21 || $i===35)
            @include('ads.horizontal')
          @endif        
        @endforeach

      @elseif($subscription === 'TRIAL')
        @foreach($words as $i => $word)
          @if($i < config('const.KANJI_WORD_TRIAL'))
            @include('words.card')
            @if($i===9 || $i===21 || $i===35)
              @include('ads.horizontal')
            @endif        
          @endif
        @endforeach
        @if( $words->count() > config('const.KANJI_WORD_TRIAL'))
          <div class="mt-2 shadow" data-toggle="modal" data-target="#recommend-normal" style="">
          <button class="success-color text-white border border-0 px-2 py-1 rounded">「{{ $kanji->name }}」の関連語をもっと見る</button>
          </div>
        @endif     

      @elseif($subscription === 'GUEST')
        @foreach($words as $i => $word)
          @if($i < config('const.KANJI_WORD_GUEST'))
            @include('words.card')
            @if($i===9 || $i===21 || $i===35)
              @include('ads.horizontal')
          @endif        
          @endif
        @endforeach
        @if( $words->count() > config('const.KANJI_WORD_GUEST'))
          <div class="mt-2 shadow" data-toggle="modal" data-target="#recommend-trial" style="">
            <button class="success-color text-white border border-0 px-2 py-1 rounded">「{{ $kanji->name }}」の関連語をもっと見る</button>
          </div>
        @endif
      @endif
    </div>
    
    <div class="centered-block">
    @include('ads.rectangle')
    </div>
  </div>

  
  @include('footer')  
@endsection