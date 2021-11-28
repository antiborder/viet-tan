@extends('app')

@section('title', '単語詳細')

@section('content')
  @include('nav')
  <div class="container">
    @include('words.detail')

    @foreach($word->tags as $tag)
      @if($loop->first)
        関連タグ
      @endif
      @if($loop->first)
        <div class="card-text line-height">
      @endif
          <a href="{{ route('tags.show', ['name' => $tag->name]) }}" class="border p-1 mr-1 mt-1 text-muted">
            {{ $tag->name }}
          </a>
      @if($loop->last)
        </div>
      @endif
    @endforeach      

    @foreach($word->synonyms() as $synonym)
      @if($loop->first)
        同義語
      @endif      
      @include('words.card',['word'=>$synonym])
    @endforeach    

    @foreach($word->antonyms() as $antonym)
      @if($loop->first)
        対義語
      @endif
      @include('words.card',['word'=>$antonym])
    @endforeach    

    @foreach($common_syllables as $common_syllable)
      @if($loop->first)
        音節が共通する語
      @endif
      @include('words.card',['word'=>$common_syllable])
    @endforeach        
  </div>

@endsection