@extends('app')

@section('title', '関連タグ一覧')

@section('content')
  @include('nav')
  <div class="container">
    <h4 class="pt-3">タグ一覧</h4>
        @foreach($tags as $tag)
            <span class="d-inline-block white m-1 p-1 rounded shadow">
                <a class="text-dark" href="{{ route('tags.show', ['name' => $tag->name]) }}" style="font-size:1.2rem">
                {{ $tag->name }}
                </a>              
            </span>
        @endforeach      

  </div>
@endsection