@extends('app')

@section('title', '単語一覧')

@section('content')
  @include('nav')
  <div class="container pb-1 bg-light pt-2">
    <!-- <div class="card mt-3 mb-1 pt-1 pl-2 pr-2 light-blue text-white" style="max-width: 30rem;"> -->
      @foreach($words as $word)
        @include('words.card')
      @endforeach
    <!-- </div> -->
  </div>
@endsection