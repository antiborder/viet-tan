<!--  動作確認後に削除予定 
  
@extends('app')

@section('title', '単語一覧')

@section('content')
  @include('nav')
  <div class="container pb-1 bg-light pt-2">

      @foreach($words as $word)
        @include('words.card')
      @endforeach

  </div>
@endsection -->
