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
      タグは検索からでも探せます<br>
        <button onclick="location.href='{{route("words.search")}}'" class="search-button shadow">
          検索から探す
        </button><br>
    </div>

    @include('ads.rectangle')

  </div>

  @include('footer')
@endsection

<style>

</style>