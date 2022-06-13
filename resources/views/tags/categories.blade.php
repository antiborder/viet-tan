@extends('app')

@section('title', '関連タグ一覧')

@section('content')
  @include('nav')

  <div class="container text-center" >

      <h4 class="pt-3">タグ分類</h4>
      <ul class="inline-block" style="max-width:900px; list-style-type: none; padding-left:0; text-align:center">

        @foreach($categories as $category)

          <div class=" white m-2 p-1 rounded shadow text-left" style=" width:250px; height:150px; position:relative; display:inline-block">
            <a class="text-dark" href="{{ route('tags.category', ['name' => $category]) }}" style=" position:absolute; font-size:1.2rem; top: 0; left: 0; width: 100%; height: 100%;">  
              {{config('const.CATEGORIES')[$category]['NAME']}}
            </a>   

            <img class="mt-2"src="{{'/image/'.config('const.CATEGORIES')[$category]['IMAGES'][0]}}" style="height:100px; position:absolute; top:30px">
          
          </div>

        @endforeach     
        
      </ul>
      <div class=" my-3 text-center" style="">
        <button onclick="location.href='{{route("tags.categories")}}'" class="text-white mx-1 px-3 py-1 border-0 rounded shadow" style="background-color:#ffc700;">
          <strong>タグは検索からでも見つかります</strong>
        </button>
      </div>          

  </div>
  

@endsection