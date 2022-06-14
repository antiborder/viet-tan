@extends('app')

@section('title', $kanji->name)

@section('content')
  @include('nav')
  <div class="container">
    <div class="card my-3">
      <div class="card-body">
        <span class="h3 card-title m-0" style='font-family:"UD デジタル 教科書体 N-R", "BIZ UDゴシック Regular";'>{{ $kanji->name }}</span>　を含む単語
      </div>
    </div>
    <div class="mb-1 mr-2" style="font-size:1.1rem">
      <span style="font-size:1.4rem">{{ $words->count() }}</span> 件が該当
    </div>

    @if($subscription === 'NORMAL')

      @foreach($words as $i => $word)
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

    @elseif($subscription === 'TRIAL')
      @foreach($words as $i => $word)
        @if($i < config('const.KANJI_WORD_TRIAL'))
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
      @if( $words->count() > config('const.KANJI_WORD_GUEST'))
        <div class="mt-2 shadow" data-toggle="modal" data-target="#recommend-trial" style="">
          <button class="success-color text-white border border-0 px-2 py-1 rounded">「{{ $kanji->name }}」の関連語をもっと見る</button>
        </div>
      @endif
    @endif

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
  </div>

  
  @include('footer')  
@endsection