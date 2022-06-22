@extends('app')

@section('title', $tag->name)

@section('content')
  @include('nav')
  <div class="container" style="max-width:800px" >
    <div class="card my-3" style="max-width:30rem">
      <div class="card-body">
        <span class="h4 card-title m-0">{{ $tag->name }}</span>　タグに該当
      </div>
    </div>
    <div class="mb-1 mr-2" style="font-size:1.1rem">
      <span style="font-size:1.4rem"> {{ $tag->words->count() }}</span> 件が該当
    </div>    

    @if( $subscription==="NORMAL" )
      @foreach($tag->words->sortBy('level') as $i => $word)
        @include('words.card')
          @if($i===9 || $i===21 || $i===35)
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9067426465896411"
                crossorigin="anonymous"></script>
            <!-- Horizontal -->
            <ins class="adsbygoogle"
                style="display:block"
                data-ad-client="ca-pub-9067426465896411"
                data-ad-slot="5078046569"
                data-ad-format="horizontal"
                data-full-width-responsive="true"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>        
          @endif
      @endforeach

    @elseif( $subscription==="TRIAL")
      @foreach($tag->words->sortBy('level') as $i => $word)
        @if($i < config('const.TAG_WORD_TRIAL'))
          @include('words.card')
          @if($i===9 || $i===21 || $i===35)
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9067426465896411"
                crossorigin="anonymous"></script>
            <!-- Horizontal -->
            <ins class="adsbygoogle"
                style="display:block"
                data-ad-client="ca-pub-9067426465896411"
                data-ad-slot="5078046569"
                data-ad-format="horizontal"
                data-full-width-responsive="true"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>        
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
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9067426465896411"
                crossorigin="anonymous"></script>
            <!-- Horizontal -->
            <ins class="adsbygoogle"
                style="display:block"
                data-ad-client="ca-pub-9067426465896411"
                data-ad-slot="5078046569"
                data-ad-format="horizontal"
                data-full-width-responsive="true"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>        
          @endif          
        @endif
      @endforeach
      @if( $tag->words->count() > config('const.TAG_WORD_GUEST'))
        <div class="mt-2" data-toggle="modal" data-target="#recommend-trial" style="">
          <button class="success-color text-white border border-0 px-2 py-1 rounded shadow ">「{{ $tag->name }}」の関連語をもっと見る</button>
        </div>
      @endif
    @endif
    <div class=" my-5 text-center" style="">
      <button onclick="location.href='{{route("tags.categories")}}'" class="text-white mx-1 px-3 py-1 border-0 rounded shadow" style="background-color:#ffc700; font-family: 'Kosugi Maru', sans-serif;">
        他のタグも見る
      </button>
    </div>    

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9067426465896411"
        crossorigin="anonymous"></script>
    <!-- square -->
    <ins class="adsbygoogle"
        style="display:block"
        data-ad-client="ca-pub-9067426465896411"
        data-ad-slot="5284563145"
        data-ad-format="rectangle"
        data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    
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