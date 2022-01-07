@extends('app')

@section('title', '単語詳細')

@section('content')
  @include('nav')
  <div class="container">
    <div class="card mt-3 mb-0 pb-1 pl-2 pr-2 light-blue lighten-1  text-white">
      単語詳細
      @include('words.detail')

      @foreach($word->tags as $tag)
        @if($loop->first)
          <span>
            関連タグ&ensp;
        @endif
        @if($loop->first)

        @endif
            <a class="text-dark white pl-1 pr-1 mr-2 rounded" href="{{ route('tags.show', ['name' => $tag->name]) }}" class="border p-1 mr-1 mt-1 text-muted">
              {{ $tag->name }}
            </a>
        @if($loop->last)
          </span>        
        @endif
      @endforeach      

    </div>

    <div class="card mt-3 mb-1 pl-2 pr-2 cyan lighten-1 text-white" style="color: white; max-width: 30rem;">
      @foreach($word->synonyms() as $synonym)
        @if($loop->first)
          同義語
        @endif      
        @include('words.card',['word'=>$synonym])
      @endforeach    
    </div>

    <div class="card mt-3 mb-1 pl-2 pr-2 teal lighten-1 text-white" style="color: white; max-width: 30rem;">
      @foreach($word->antonyms() as $antonym)
        @if($loop->first)
          対義語
        @endif
        @include('words.card',['word'=>$antonym])
      @endforeach
    </div>

    <div class="card mt-3 mb-1 pl-2 pr-2 green lighten-1 text-white" style="color: white; max-width: 30rem;">        
        発音が類似
    </div>

    <div class="card mt-3 mb-1 pl-2 pr-2 light-green lighten-1 text-white" style="color: white; max-width: 30rem;">    
      @foreach($common_syllables as $common_syllable)
        @if($loop->first)
          音節が一致
        @endif
        @include('words.card',['word'=>$common_syllable])
      @endforeach        
    </div>
  @endsection