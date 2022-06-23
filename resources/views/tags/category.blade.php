@extends('app')

@section('title', '関連タグ一覧')

@section('content')
  @include('nav')

  <div class="container text-center" style="line-height:200%; ">
    <div class=" white my-2 py-2 rounded shadow" style="width:220px; display:inline-block; margin:0 auto;">
      <img src="{{'/image/'.$category['IMAGES'][0]}}" style="height:100px;">
    </div>
    <h4 class="p-1" >「{{$category['NAME']}}」に関連するタグ一覧</h4>
    
    <div class="mt-2">
      @foreach($tags as $i => $tag)
        <span class="d-inline-block m-2">
        @include('tags.card',['tag'=>$tag])
        </span><br>

        @if($i===11)
          @include('ads.horizontal')
        @endif

      @endforeach      
    </div>

    <div class=" my-5 text-center" style="">
        <button onclick="location.href='{{route("words.search")}}'" class="text-white mx-1 px-3 py-1 border-0 rounded shadow" style="background-color:#ffc700; font-family:'Kosugi Maru', sans-serif;">
          タグは検索からでも探せます
        </button>
    </div>              

    @include('ads.rectangle')

  </div>

  @include('footer')    
@endsection