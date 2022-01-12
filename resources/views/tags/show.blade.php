@extends('app')

@section('title', $tag->name)

@section('content')
  @include('nav')
  <div class="container">
    <div class="card my-3">
      <div class="card-body">
        <span class="h4 card-title m-0">{{ $tag->name }}</span>　タグに該当
      </div>
      <div class="card-text text-right mb-1 mr-2">
        {{ $tag->words->count() }}件
      </div>
    </div>
    @foreach($tag->words as $word)
      @include('words.card')
    @endforeach
  </div>
@endsection