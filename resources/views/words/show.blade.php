@extends('app')

@section('title', $word->name.'の意味・発音・関連語')

@section('content')
  @include('nav')
  <div class="container">
    <div class="card mt-3 mb-0 pb-2 pl-2 pr-2 border-warning bg-transparent text-warning" style="border-width:2px">
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

    @if($subscription === 'NORMAL')
      @foreach($common_syllables as $i => $common_syllable)
        @if($loop->first)
        <div class="card mt-3 mb-1 pb-1 pl-2 pr-2 border-success bg-transparent text-success" style="color: white; max-width: 30rem;border-width:2px">
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
        <div class="card mt-3 mb-1 pb-1 pl-2 pr-2 border-success bg-transparent text-success" style="color: white; max-width: 30rem;border-width:2px">
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
        <div class="card mt-3 mb-1 pb-1 pl-2 pr-2 border-success bg-transparent text-success" style="color: white; max-width: 30rem;border-width:2px">
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

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9067426465896411"
        crossorigin="anonymous"></script>
    <!-- square -->
    <ins class="adsbygoogle"
        style="display:block"
        data-ad-client="ca-pub-9067426465896411"
        data-ad-slot="5284563145"
        data-ad-format="horizontal"
        data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>    
  </div>

  @include('footer')
@endsection