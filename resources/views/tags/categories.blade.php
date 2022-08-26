@extends('app')

@section('title', 'カテゴリ一覧')

@section('content')
  @include('nav')

  <div class="container text-center" >

      <h4 class="pt-3 text-center">タグ分類</h4>

      <div>
        <ul class="category-card-list">
          @foreach($categories as $i=>$category)
            <div class="category-card">
              <a class="text-dark text-left ml-1" href="{{ route('tags.category', ['name' => $category]) }}" style=" position:absolute; font-size:1.2rem; top: 0; left: 0; width: 100%; height: 100%;">
                {{config('const.CATEGORIES')[$category]['NAME']}}
                <img class="mt-3"src="{{'/image/'.config('const.CATEGORIES')[$category]['IMAGES'][0]}}" style="height:120px; position:absolute; left:10px; top:30px">
              </a>
            </div>
            @if($i===4 ||$i===10)
              <div class="category-ad-card">
                @include('ads.rectangle')
              </div>
            @endif
          @endforeach
        </ul>
      </div>
      <div class=" my-3 text-center">
        タグは検索からでも探せます<br>
        <a href='{{ route("words.search") }}' >
          <div class="search-button-normal search-button">
            検索から探す
          </div>
        </a>
      </div>

      @include('ads.horizontal')

  </div>

  @include('footer')
@endsection