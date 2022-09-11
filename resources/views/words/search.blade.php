@extends('app')

@section('title', $title)

@section('content')
  @include('nav')

  <div class="container container-search">
    <div class="card-search">
      <div class="pt-1">
        <form class="form-inline" action="{{url('/search')}}">
          <div class="form-group">
            <input type="text" name="keyword" value="{{$keyword ?? null}}" class="form-control" placeholder="キーワードを入力">
          </div>
          <input type="submit" value="検索" class="search-button search-button-card-search">
        </form>
      </div>
      <div class="text-right">
        <button data-toggle="modal" data-target="#search-description" class="success-btn-transparent mx-2 pb-1 px-2">
          <small>あいまい検索について</small>
        </button>
      </div>
    </div>

    <p class="search-message">{{$msg}}</p>

    @foreach($words_name_exact ?? null as $word)
      @if($loop->first)
      <div class="grouping-square grouping-square-orange-filled text-white">
          <span class="grouping-label">ベトナム語が一致</span>
      @endif
      @include('words.card',['word'=>$word])
      @if($loop->last)
        </div>
      @endif
    @endforeach

    @foreach($words_name_similar ?? null as $word)
      @if($loop->first)
        <div class="grouping-square grouping-square-ornage">
          <span class="grouping-label">アルファベットが同じ単語</span>
      @endif
      @include('words.card',['word'=>$word])
      @if($loop->last)
        </div>
      @endif
    @endforeach

    @foreach($words_name_simplified ?? null as $word)
      @if($loop->first)
        <div class="grouping-square grouping-square-info">
          <span class="grouping-label">発音が似てる単語</span>
      @endif
      @include('words.card',['word'=>$word])
      @if($loop->last)
        </div>
        @include('ads.horizontal')
      @endif
    @endforeach

    @foreach($words_name_syllables ?? null as $word)
      @if($loop->first)
        <div class="grouping-square grouping-square-success">
          <span class="grouping-label">同じ音節を含む単語</span>
      @endif
      @include('words.card',['word'=>$word])
      @if($loop->last)
        </div>
      @endif
    @endforeach

    @foreach($words_jp as $word)
      @if($loop->first)
      <div class="grouping-square grouping-square-orange-filled text-white">
        <span class="grouping-label">意味が該当</span>
      @endif
      @include('words.card',['word'=>$word])
      @if($loop->last)
        </div>
        @include('ads.horizontal')
      @endif
    @endforeach


    @foreach($words_kanji as $word)
      @if($loop->first)
        <div class="grouping-square grouping-square-orange">
        <span class="grouping-label">漢字(漢越語) が該当</span>
      @endif
      @include('words.card',['word'=>$word])
      @if($loop->last)
        </div>
      @endif
    @endforeach

    @foreach($tags as $tag)
      @if($loop->first)
      <div class="grouping-square grouping-square-orange">
        <span class="grouping-label">関連タグ</span>
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

    <div class="tag-search-btn-block">
      <a href='{{ route("tags.categories")}}' >
        <div class="search-button-normal search-button">
          タグから探す
        </div>
      </a>
    </div>

    <div class="my-2">
      @include('ads.rectangle')
    </div>

    <a href="{{route('index')}}" >
      <div class="self-ad-outer-square">
        <div>
          <div class="d-inline-block">1日10分でOK。</div>
          <div class="d-inline-block">スキマ時間にクリックするだけ。</div>
        </div>
        <div class="self-ad-inner-square">
          <div class="h3 mb-n1" >
            <div class="mr-n1 d-inline-block">がんばらない</div>
            <div class="d-inline-block">ベトナム語のすすめ</div>
          </div>
          <small>べとらん Homeに戻る</small>
        </div>
      </div>
    </a>
  </div>

  <!-- about search -->
  <div class="modal fade" id="search-description" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="rounded p-1 modal-content text-center">
        <div class="text-right">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button><br>
        </div>
        <div class="search-description-image-container">
            <img class="search-description-image" src="/image/search-description1.webp" alt='あいまい検索 使用例'>
            <img class="search-description-image" src="/image/search-description2.webp" alt='声調記号などが違ってもヒットします 発音が似ている単語もヒットします 混同しやすい単語の整理にも便利です'>
            <img class="search-description-image" src="/image/search-description3.webp" alt='ベトナム語だけでなく 日本語 漢越語 関連タグ もヒットします'>
        </div>
        <div class="text-center">
          <p>
            追加機能のご要望やご意見等がありましたら、<br>
            <button type="button" class="border border-2 border-primary white rounded d-inline-block" data-dismiss="modal" aria-label="Close">
              <span data-toggle="modal" data-target="#contact">
                <a class="text-primary">
                  お問合せフォーム
                </a>
              </span>
            </button>
            から遠慮なくご連絡ください。
          </p>
          <button type="button" class="border muted-btn-transparent modal-close-btn" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">Close</span>
          </a>
        </div>
      </div>
    </div>
  </div>

  @include('footer')
@endsection