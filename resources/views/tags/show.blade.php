@extends('app')

@section('title', $tag->name)

@section('content')
  @include('nav')
  <div class="container" style="max-width:800px" >
    <div class="card my-3 centered-block">
      <div class="card-body">
        <p>
          <span class="h4 card-title">{{ $tag->name }}</span>　タグに該当
        </p>
      </div>
    </div>

    <div class="centered-block">
      <span style="font-size:1.4rem"> {{ $tag->words->count() }}</span> 件が該当
    </div>

    <div class="centered-block">
      <p class="sample-click-text">　↓ベトナム語をclick！</p>
      @if( $subscription==="NORMAL" )
        @foreach($tag->words->sortBy('level') as $i => $word)
          @include('words.card')
            @if($i===9 || $i===21 || $i===35)
              @include('ads.horizontal')
            @endif
        @endforeach

      @elseif( $subscription==="TRIAL")
        @foreach($tag->words->sortBy('level') as $i => $word)
          @if($i < config('const.TAG_WORD_TRIAL'))
            @include('words.card')
            @if($i===9 || $i===21 || $i===35)
              @include('ads.horizontal')
            @endif
          @endif
        @endforeach
        @if( $tag->words->count() > config('const.TAG_WORD_TRIAL'))
          <div class="mt-2" data-toggle="modal" data-target="#recommend-normal" style="">
          <button class="success-color text-white border border-0 px-2 py-1 rounded shadow">「{{ $tag->name }}」の関連語をもっと見る</button>
          </div>
        @endif

      @elseif( $subscription==="GUEST" )
        @foreach($tag->words->sortBy('level') as $i => $word)
          @if($i < config('const.TAG_WORD_GUEST'))
            @include('words.card')
            @if($i===9 || $i===21 || $i===35)
              @include('ads.horizontal')
            @endif
          @endif
        @endforeach
        @if( $tag->words->count() > config('const.TAG_WORD_GUEST'))
          <div class="mt-2" data-toggle="modal" data-target="#recommend-trial" style="">
            <a class="success-color text-white border border-0 px-2 py-1 rounded shadow ">「{{ $tag->name }}」の関連語をもっと見る</a>
          </div>
        @endif
      @endif
    </div>

    <div class="tag-search-btn-block">
      <a href='{{ route("categories.index")}}' >
        <div class="search-button-normal search-button">
          他のタグも見る
        </div>
      </a>
    </div>

    <div class="card my-3 centered-block">
      <div class="card-body">
        <p class="mb-0">
          <label class="text-muted">{{ $tag->name }}タグのkeyword:</label><br>
          {{$tag->keywords}}
        </p>
      </div>
    </div>

    <div class="centered-block">
      @include('ads.rectangle')
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
          <div class="m-2" style="text-align:center; font-size:1.2rem">この機能はノーマル会員専用です。</div>
          <div class="m-3" style="text-align:center; font-size:1.2rem" >
            <a href="{{ route('stripe.subscription')}}" class="border border-info text-info rounded px-3 py-2" >登録画面へ</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('footer')
@endsection