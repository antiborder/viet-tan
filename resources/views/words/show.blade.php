@extends('app')

@section('title', '単語詳細')

@section('content')
  @include('nav')
  <div class="container">
    <div class="card mt-3 mb-0 pb-1 pl-2 pr-2 light-blue lighten-1  text-white">
      単語詳細
      @include('words.detail')


    </div>

    <div class="card mt-3 mb-1 pl-2 pr-2 orange lighten-1 text-white" style="color: white; max-width: 30rem;">
      @foreach($word->synonyms() as $synonym)
        @if($loop->first)
          同義語
        @endif      
        @include('words.card',['word'=>$synonym])
      @endforeach    
    </div>

    <div class="card mt-3 mb-1 pl-2 pr-2 orange lighten-1 text-white" style="color: white; max-width: 30rem;">
      @foreach($word->antonyms() as $antonym)
        @if($loop->first)
          対義語
        @endif
        @include('words.card',['word'=>$antonym])
      @endforeach
    </div>

    <div class="card mt-3 mb-1 pl-2 pr-2 orange lighten-1 text-white" style="color: white; max-width: 30rem;">        
      @foreach($similar_pronuciations as $similar_pronuciation)
        @if($loop->first)
          発音が類似
        @endif
        @include('words.card',['word'=>$similar_pronuciation])
      @endforeach        
    </div>

    <div class="card mt-3 mb-1 pl-2 pr-2 orange lighten-1 text-white" style="color: white; max-width: 30rem;">    
      @foreach($common_syllables as $common_syllable)
        @if($loop->first)
          音節が一致
        @endif
        @include('words.card',['word'=>$common_syllable])
      @endforeach        
    </div>
  </div>
@endsection