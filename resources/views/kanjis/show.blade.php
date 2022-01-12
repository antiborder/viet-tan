@extends('app')

@section('title', $kanji->name)

@section('content')
  @include('nav')
  <div class="container">
    <div class="card my-3">
      <div class="card-body">
        <span class="h3 card-title m-0" style='font-family:"UD デジタル 教科書体 N-R", "BIZ UDゴシック Regular";'>{{ $kanji->name }}</span>　を含む単語
      </div>
      <div class="card-text text-right mb-1 mr-2">
        {{ $words->count() }}件
      </div>
    </div>
    @foreach($words as $word)
      @include('words.card')
    @endforeach
  </div>
@endsection