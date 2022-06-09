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
        <input type="submit" value="検索" class="btn text-white  pt-1 pb-1 btn-sm" style="font-size: large; background-color:#ffc700;">
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
        <div class="card mt-3 mb-1 pb-2 pl-2 pr-2 border-warning bg-transparent text-warning" style="color: white; max-width: 30rem;border-width:2px;">    
        <span style=";font-size:1.2rem">関連タグ</span>
          <div class="card-text line-height">
      @endif
        <span class="mx-1">
            @include('tags.card',['tag'=>$tag])
        </span>
      @if($loop->last)
          </div>
        </div>        
      @endif
    @endforeach      

    <div class=" my-3" style="">
      <button onclick="location.href='{{route("tags.categories")}}'" class="text-white mx-1 px-3 py-1 border-0 rounded shadow" style="background-color:#ffc700;">
        <strong>タグから探す</strong>
      </button>
    </div>    

    @if($result==='FAIL')
      <div class="mt-5 white rounded shadow">
        <div class="text-center">
          <img src="/image/search1.jpg" style="height:300px; width:300px" alt='あいまい検索 使用例'>
          <img src="/image/search2.jpg" style="height:300px; width:300px" alt='声調記号などが違ってもヒットします 発音が似ている単語もヒットします 混同しやすい単語の整理にも便利です'>
          <img src="/image/search3.jpg" style="height:300px; width:300px" alt='ベトナム語だけでなく 日本語 漢越語 関連タグ もヒットします'>
        </div>
      </div>
    @endif        
  </div>

@endsection