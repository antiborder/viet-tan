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
          <span style=";font-size:1.2rem">関連タグ&ensp;</span>
        @endif
            <a class="text-dark white p-1 mr-2 rounded shadow" href="{{ route('tags.show', ['name' => $tag->name]) }}" style="font-size:1.2rem">
              {{ $tag->name }}
            </a>              

        @if($loop->last)
          </span>        
        @endif
      @endforeach            
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
      @endif
    @endforeach        

    @if($subscription === 'NORMAL')
      @foreach($common_syllables as $i => $common_syllable)
        @if($loop->first)
        <div class="card mt-3 mb-1 pb-1 pl-2 pr-2 border-success bg-transparent text-success" style="color: white; max-width: 30rem;border-width:2px">
        <span style=";font-size:1.2rem">同じ音節を含む単語</span> (全{{$common_syllables->count()}}件
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
        @if($i < config('const.SAME_SYLABLE_TRIAL'))
          @include('words.card',['word'=>$common_syllable])
        @endif
        @if($loop->last)
          @if($common_syllables->count() > config('const.SAME_SYLLABLE_TRIAL'))
            <div class="mt-2" data-toggle="modal" data-target="#recommend-normal" style="">
              <button class="success-color text-white border border-0 px-2 py-1 rounded">同じ音節を含む単語をもっと見る</button>
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
        @if($i < config('const.SAME_SYLABLE_GUEST'))
          @include('words.card',['word'=>$common_syllable])
        @endif
        @if($loop->last)
          @if($common_syllables->count() > config('const.SAME_SYLLABLE_GUEST'))
            <div class="mt-2" data-toggle="modal" data-target="#recommend-trial" style="">
              <button class="success-color text-white border border-0 px-2 py-1 rounded">同じ音節を含む単語をもっと見る</button>
            </div>          
          @endif        
          </div>
        @endif
      @endforeach                    
    @endif

    
  </div>

  <!-- recommend-trial modal -->
  <div class="modal fade rounded" id="recommend-trial" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body"> 
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button><br>
          <div class="m-2" style="text-align:center; font-size:1.2rem">この機能は会員専用です。</div>
          <div class="m-3" style="text-align:center; font-size:1.2rem" >
            <a href="{{ route('register')}}" class="border border-info text-info rounded px-3 py-2" >まずは無料登録</a>
          </div>
          <div class="m-4" style="text-align:center; font-size:1.2rem">
            <a href="{{ route('login') }}" class="border border-warning text-warning rounded px-3 py-2" >ログインする</a>
          </div>
        </div>
      </div>
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
@endsection