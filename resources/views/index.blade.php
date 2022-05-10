@extends('app')

@section('title', '検索')

@section('content')
  @include('nav')

  <div class="container">
    <a href="learn" >
      <div class="card mt-5 mb-1 px-2 py-4 h3 orange lighten-1 text-white" style="color: white; width: 200px;  text-align:center; margin:0 auto; font-family:ＭＳ Ｐゴシック;">
        <div >
            単語学習
        </div>
      </div>
    </a>


    <a href="search" >
      <div class="card mt-5 mb-1 px-2 py-4 h4 orange lighten-1 text-white" style="color: white; width: 200px;  text-align:center;  margin:0 auto; font-family:MS UI Gothic;">
        <div >
            あいまい検索
        </div>
      </div>
    </a>

  </div>

@endsection

