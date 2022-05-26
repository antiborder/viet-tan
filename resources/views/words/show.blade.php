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

    @foreach($common_syllables as $common_syllable)
      @if($loop->first)
      <div class="card mt-3 mb-1 pb-1 pl-2 pr-2 border-success bg-transparent text-success" style="color: white; max-width: 30rem;border-width:2px">
      <span style=";font-size:1.2rem">同じ音節を含む単語</span>
      @endif
      @include('words.card',['word'=>$common_syllable])
      @if($loop->last)
        </div>
      @endif
    @endforeach        
    
  </div>
@endsection