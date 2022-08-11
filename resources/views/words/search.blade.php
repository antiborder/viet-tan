@extends('app')

@section('title', $title)

@section('content')
  @include('nav')

  <div class="container" style="max-width:800px">
    <div class="card white pl-2 py-2 mt-2 mb-3 text-dark " style="max-width: 30rem;">
      <div class="pt-1" style="">
        <form class="form-inline" action="{{url('/search')}}">
          <div class="form-group">
            <input type="text" name="keyword" value="{{$keyword ?? null}}" class="form-control" placeholder="キーワードを入力">
          </div>
          <input type="submit" value="検索" class="btn text-white py-1 btn-sm" style="font-size:large; background-color:#ffc700; font-family: 'Kosugi Maru', sans-serif;" >

        </form>
      </div>
      <div class="text-right">
        <button data-toggle="modal" data-target="#search-description" class="white border border-success text-success rounded mx-2 pb-1 px-2" style="font-family: 'Kosugi Maru', sans-serif;">
          <small>あいまい検索について</small>
        </button>
      </div>
    </div>

    <p class="pb-0 mb-0">{{$msg}}</p>

    @foreach($words_name_exact ?? null as $word)
      @if($loop->first)
        <div class="card mt-3 mb-1 pb-1 pl-2 pr-2 orange lighten-1 text-white " style=" max-width: 30rem;border-width:2px">
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
          <span style="font-size:1.2rem">発音が似てる単語</span>
      @endif
      @include('words.card',['word'=>$word])
      @if($loop->last)
        </div>
        @include('ads.horizontal')
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
        @include('ads.horizontal')
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

    <div class="my-3" style="">
      <button onclick="location.href='{{route("tags.categories")}}'" class="search-button shadow">
        タグから探す
      </button>
    </div>

    <div class="my-2">
      @include('ads.rectangle')
    </div>

    <a href="{{route('index')}}" >
      <div class="pb-1 normal-text orange text-white lighten-1 text-center rounded shadow" style="max-width:450px" >
        <div>
          <div style="display:inline-block">1日10分でOK。</div>
          <div style="display:inline-block">スキマ時間にクリックするだけ。</div>
        </div>
        <div class="white rounded mb-1 mx-2" style="color:#ffa726;">
          <div class="h3 mb-n1" >
            <div class="mr-n1 " style="display:inline-block">ベトナム語学習の</div>
            <div class="" style="display:inline-block">無料ツール</div>
          </div>
          <small class="">べとらん Homeに戻る</small>
        </div>
      </div>
    </a>
  </div>

  <!-- about search -->
<div class="modal fade" id="search-description" tabindex="-1" role="dialog" aria-hidden="true" >
  <div class="modal-dialog  " style="max-width:950px;">
    <div class="rounded p-1 modal-content text-center"  >
      <div class="text-right">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button><br>
      </div>
      <div class="border border-dark mx-1" style="display:inline-block;">
          <img class="border m-1" src="/image/search-description1.webp" style="height:300px; width:300px;" alt='あいまい検索 使用例'>
          <img class="border m-1" src="/image/search-description2.webp" style="height:300px; width:300px;" alt='声調記号などが違ってもヒットします 発音が似ている単語もヒットします 混同しやすい単語の整理にも便利です'>
          <img class="border m-1" src="/image/search-description3.webp" style="height:300px; width:300px;" alt='ベトナム語だけでなく 日本語 漢越語 関連タグ もヒットします'>
      </div>
      <div class="text-center">
        <p>
          追加機能のご要望やご意見等がありましたら、<br>
          <button type="button" class="border border-2 border-primary white rounded" data-dismiss="modal" aria-label="Close" style="display:inline-block;">
            <span data-toggle="modal" data-target="#contact">
              <a class="text-primary">
                お問合せフォーム
              </a>
            </span>
          </button>
          から遠慮なくご連絡ください。
        </p>
        <button type="button" class="border border-2 border-muted text-muted  white rounded" data-dismiss="modal" aria-label="Close" style="width:100px; display:inline-block;">
          <span aria-hidden="true">Close</span>
        </button>
      </div>
    </div>
  </div>
</div>

  @include('footer')
@endsection