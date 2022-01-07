@extends('app')

@section('title', '検索')

@section('content')
  @include('nav')
  <div class="container">
    <div class="col-sm-4" style="padding:20px 0; padding-left:0px;">
      <form class="form-inline" action="{{url('/search')}}">
        <div class="form-group">
          <input type="text" name="keyword" value="{{$keyword ?? null}}" class="form-control" placeholder="">
        </div>
        <input type="submit" value="検索" class="btn btn-info light-blue lighten-1 pt-1 pb-1 btn-sm" style="font-size: large; ">
      </form>
    </div>
    <p>{{$msg}}</p>    
    <div class="card mt-3 mb-1 pl-2 pr-2 cyan lighten-1 text-white" style="color: white; max-width: 30rem;">
      @foreach($words_name ?? null as $word)
        @if($loop->first)
          ベトナム語が該当
        @endif
        @include('words.card',['word'=>$word])
      @endforeach
    </div>

    <div class="card mt-3 mb-1 pl-2 pr-2 teal lighten-1 text-white" style="color: white; max-width: 30rem;">    
    @foreach($words_jp as $word)
      @if($loop->first)
        意味が該当
      @endif
      @include('words.card',['word'=>$word])
    @endforeach    
    </div>

    <div class="card mt-3 mb-1 pl-2 pr-2 green lighten-1 text-white" style="color: white; max-width: 30rem;">    
    @foreach($words_kanji as $word)
      @if($loop->first)
        漢越語が該当
      @endif
      @include('words.card',['word'=>$word])
    @endforeach    
    </div>

    <div class="card mt-3 mb-1 pb-0 pl-2 pr-2 light-green lighten-1 text-white" style="color: white; max-width: 30rem;">    
    @foreach($tags as $tag)
      @if($loop->first)
        タグが該当
      @endif
      @if($loop->first)
        <div class="card-text line-height">
      @endif
          <a class="text-dark white pl-1 pr-1 mr-2 rounded" href="{{ route('tags.show', ['name' => $tag->name]) }}" class="border p-1 mr-1 mt-1 text-muted">
            {{ $tag->name }}
          </a>
      @if($loop->last)
        </div>
      @endif
    @endforeach      
    </div>
  </div>
@endsection