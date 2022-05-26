@extends('app')

@section('title', $title)

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
        <div class="card mt-3 mb-1 pb-1 pl-2 pr-2 orange lighten-1 text-white " style="color: white; max-width: 30rem;border-width:2px">
          <span style=";font-size:1.2rem">ベトナム語が一致</span>
      @endif
      @include('words.card',['word'=>$word])
      @if($loop->last)
        </div>
      @endif
    @endforeach

    @foreach($words_name_similar ?? null as $word)
      @if($loop->first)
        <div class="card mt-3 mb-1 pb-1 pl-2 pr-2 border-warning bg-transparent text-warning" style="color: white; max-width: 30rem;border-width:2px">
          <span style=";font-size:1.2rem">アルファベットが同じ単語</span>
      @endif
      @include('words.card',['word'=>$word])
      @if($loop->last)
        </div>
      @endif
    @endforeach

    @foreach($words_name_simplified ?? null as $word)
      @if($loop->first)
        <div class="card mt-3 mb-1 pb-1 pl-2 pr-2 border-info bg-transparent text-info" style="color: white; max-width: 30rem;border-width:2px">
          <span style=";font-size:1.2rem">発音が似てる単語</span>
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
                




    @foreach($words_jp as $word)
      @if($loop->first)
        <div class="card mt-3 mb-1 pb-1 pl-2 pr-2 orange lighten-1 text-white" style="color: white; max-width: 30rem;">          
        <span style=";font-size:1.2rem">意味が該当</span>
      @endif
      @include('words.card',['word'=>$word])
      @if($loop->last)
        </div>
      @endif      
    @endforeach    
    
    @foreach($words_kanji as $word)
      @if($loop->first)
        <div class="card mt-3 mb-1 pb-1 pl-2 pr-2 border-warning bg-transparent text-warning" style="color: white; max-width: 30rem;border-width:2px;">      
        <span style=";font-size:1.2rem">漢字(漢越語) が該当</span>
      @endif
      @include('words.card',['word'=>$word])
      @if($loop->last)
        </div>
      @endif
    @endforeach    


    @foreach($tags as $tag)
      @if($loop->first)
        <div class="card mt-3 mb-1 pb-1 pl-2 pr-2 border-warning bg-transparent text-warning" style="color: white; max-width: 30rem;border-width:2px;">    
        <span style=";font-size:1.2rem">関連タグ</span>
          <div class="card-text line-height">
      @endif
            <a class="text-dark white pl-1 pr-1 mr-2 rounded shadow" href="{{ route('tags.show', ['name' => $tag->name]) }}" style="font-size:1.2rem">
              {{ $tag->name }}
            </a>
      @if($loop->last)
          </div>
        </div>        
      @endif
    @endforeach      

  </div>
@endsection