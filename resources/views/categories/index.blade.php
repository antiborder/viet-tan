@extends('app')

@section('title', 'カテゴリ一覧')

@section('content')
  @include('nav')

  <div class="container text-center" >

      <h4 class="pt-3 text-center">タグ分類</h4>

      <div>
        <ul class="category-card-list">
          @foreach($categories as $i=>$category)
            @include('categories.card')

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