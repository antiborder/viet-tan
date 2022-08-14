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
          <input type="submit" value="検索" class="btn text-white py-1 btn-sm" style="font-size:large; background-color:#ffc700;" >

        </form>
      </div>
      <div class="text-right">
        <button data-toggle="modal" data-target="#search-description" class="white border border-success text-success rounded mx-2 pb-1 px-2">
          <small>あいまい検索について</small>
        </button>
      </div>
    </div>

    <p class="pb-0 mb-0">{{$msg}}</p>

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

    <div class="my-3" style="">
      <button onclick="location.href='{{route("tags.categories")}}'" class="search-button shadow">
        タグから探す
      </button>
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
            <div class="mr-n1 d-inline-block">ベトナム語学習の</div>
            <div class="d-inline-block">無料ツール</div>
          </div>
          <small>べとらん Homeに戻る</small>
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

<style>

  /* 8/28以降削除可 */

  .self-ad-outer-square{
    max-width: 450px;    
    background-color:#ffa726;
    color:white;
    text-align:center;        
    padding-bottom: 0.25rem;
    border-radius: 10px;
  }

  .self-ad-inner-square{
    background-color: white;
    color: #ffa726;
    margin: 0 0.5rem 0.25rem 0.5rem;
  }
  
  .grouping-square{
      color:#ffa726;
      margin:0.75rem 0 0.25rem 0rem;
      padding: 0 0.5rem 0.25rem 0.5rem ;
      border: 2px solid #ffa726;
      border-radius:10px 10px 10px 10px ;
      max-width:30rem;
  }

  .grouping-square-orange-filled{
    color:white;
    background-color:#ffa726;
  }

  .grouping-square-orange{
    color:#ffa726;
    border: 2px solid #ffa726;
  }
  .grouping-square-primary{
    color:#0275d8;
    border: 2px solid #0275d8;
  }
  .grouping-square-danger{
    color:#d9534f;
    border: 2px solid #d9534f;
  }
  .grouping-square-info{
    color:#5bc0de;
    border: 2px solid #5bc0de;
  }
  .grouping-square-success{
    color:#5cb85c;
    border: 2px solid #5cb85c;
  }

  .grouping-label{
    font-size:1.2rem;
  }

</style>