@extends('app')

@section('title', $kanji->name)

@section('content')
  @include('nav')
  <div class="container">
    <div class="card mt-3">
      <div class="card-body">
        <h2 class="h4 card-title m-0">{{ $kanji->name }}</h2>
        <div class="card-text text-right">
          {{ $words->count() }}件
        </div>
      </div>
    </div>
    @foreach($words as $word)
      @include('words.card')
    @endforeach
  </div>
@endsection