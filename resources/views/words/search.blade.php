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

    @foreach($words_name_exact ?? null as $word)
      @if($loop->first)
        <div class="card mt-3 mb-1 pb-1 pl-2 pr-2 border-warning bg-transparent text-warning" style="color: white; max-width: 30rem;border-width:2px">
          <span style=";font-size:1.2rem">完全に一致</span>
      @endif
      @include('words.card',['word'=>$word])
      @if($loop->last)
        </div>
      @endif
    @endforeach

    @foreach($words_name_similar ?? null as $word)
      @if($loop->first)
        <div class="card mt-3 mb-1 pb-1 pl-2 pr-2 border-warning bg-transparent text-warning" style="color: white; max-width: 30rem;border-width:2px">
          <span style=";font-size:1.2rem">だいたい同じ単語</span>
      @endif
      @include('words.card',['word'=>$word])
      @if($loop->last)
        </div>
      @endif
    @endforeach

    @foreach($words_name_simplified ?? null as $word)
      @if($loop->first)
        <div class="card mt-3 mb-1 pb-1 pl-2 pr-2 border-info bg-transparent text-info" style="color: white; max-width: 30rem;border-width:2px">
          <span style=";font-size:1.2rem">似てる単語</span>
      @endif
      @include('words.card',['word'=>$word])
      @if($loop->last)
        </div>
      @endif
    @endforeach

    @foreach($words_name_syllables ?? null as $word)
      @if($loop->first)
        <div class="card mt-3 mb-1 pb-1 pl-2 pr-2 border-success bg-transparent text-success" style="color: white; max-width: 30rem;border-width:2px">
          <span style=";font-size:1.2rem">同じ音節を含む単語</span>
      @endif
      @include('words.card',['word'=>$word])
      @if($loop->last)
        </div>
      @endif
    @endforeach
                



    <div class="card mt-3 mb-1 pl-2 pr-2 teal lighten-1 text-white" style="color: white; max-width: 30rem;">    
    @foreach($words_jp as $word)
      @if($loop->first)
        意味が該当する単語
      @endif
      @include('words.card',['word'=>$word])
    @endforeach    
    </div>

    <div class="card mt-3 mb-1 pl-2 pr-2 green lighten-1 text-white" style="color: white; max-width: 30rem;">    
    @foreach($words_kanji as $word)
      @if($loop->first)
        漢字(漢越語) が該当する単語
      @endif
      @include('words.card',['word'=>$word])
    @endforeach    
    </div>

    <div class="card mt-3 mb-1 pb-0 pl-2 pr-2 light-green lighten-1 text-white" style="color: white; max-width: 30rem;">    
    @foreach($tags as $tag)
      @if($loop->first)
        該当するタグ
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