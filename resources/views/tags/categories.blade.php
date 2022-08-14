@extends('app')

@section('title', 'カテゴリ一覧')

@section('content')
  @include('nav')

  <div class="container text-center" >

      <h4 class="pt-3 text-left">タグ分類</h4>
      <ul class="inline-block" style="max-width:900px; list-style-type: none; padding-left:0; text-align:center">

        @foreach($categories as $i=>$category)

          <div class=" white m-2 p-1 rounded shadow text-left" style=" width:280px; height:230px; position:relative; display:inline-block">
            <a class="text-dark text-left ml-1" href="{{ route('tags.category', ['name' => $category]) }}" style=" position:absolute; font-size:1.2rem; top: 0; left: 0; width: 100%; height: 100%;">
              {{config('const.CATEGORIES')[$category]['NAME']}}
              <img class="mt-3"src="{{'/image/'.config('const.CATEGORIES')[$category]['IMAGES'][0]}}" style="height:120px; position:absolute; left:10px; top:30px">
            </a>
          </div>
          @if($i===4 ||$i===10)
            <div class=" white m-1 p-1 rounded shadow text-left" style=" width:280px; height:230px; position:relative; display:inline-block">
              @include('ads.rectangle')
            </div>
          @endif
        @endforeach
        
      </ul>
      <div class=" my-3 text-center" style="">
        タグは検索からでも探せます<br>
          <button onclick="location.href='{{route("words.search")}}'" class="search-button shadow">
            検索から探す
          </button><br>
      </div>

      @include('ads.horizontal')

  </div>

  @include('footer')
@endsection