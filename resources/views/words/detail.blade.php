<div class="text-dark card-plain mb-2  pt-0 pb-1 pl-1 pr-3 white shadow rounded">
  <div class=" card-body pt-2 pb-0 pl-0 d-flex flex-row">
    <div>
      <div class="d-flex flex-row">
        <div class="text-nowrap mr-1">
          <div style="height:40px"><p class="pt-2" style="line-height: 40px;text-align:right;width:70px;font-size:0.7rem">ベトナム語：&nbsp;</p></div>
          <div style="height:40px"><p style="line-height: 40px;text-align:right;width:70px;font-size:0.8rem">漢字：&nbsp;</p></div>
        </div>
        @foreach(array(0,1,2,3,4,5,6,7) as $i)
          @php
            $name = "name" . $i;
          @endphp
          @if($word->$name!==null)
          <div>
            <div class="mx-auto pr-2" style="height:40px; width:100%">
              <span class="card-title" style="height:40px; font-size:2rem">
                <a href="{{ route('words.show', ['word' => $word]) }}" class="viet-text text-dark  px-2 mx-n2 " style="font-size:95%; border-radius:10px;">
                  {{$word->$name}}
                </a>
              </span>
            </div>
            <div class="mx-auto" style="width:30px">
              @php
                $kanji_n = 'kanji' . $i;
              @endphp
              @if($word->$kanji_n != '')
              <a href="{{ route('kanjis.show', ['name' => $word->$kanji_n]) }}" class="kanji-text p-1 mr-1 mt-1 blue-text" style='font-size:1.5rem;'>
                {{$word->$kanji_n}}
              </a>
              @endif
            </div>
          </div>
          @endif
        @endforeach
      </div>

      @php
        $file_name = '/sound/word/'.$word->id.'.mp3';
      @endphp
      @if(file_exists(public_path().$file_name))
        <div class="m-2 pl-1 border border-secondary rounded" style="width:320px">
          <div class="text-secondary mb-0 pb-0" style="text-align:left;font-size:0.8rem">発音を確認</div>
          <div class="ml-3 mt-0 pt-0">
              <audio controls src={{$file_name}} class="ml-2" style="height:30px;width:280px;"><audio>
          </div>
        </div>
      @endif
      <div class="d-flex flex-row mt-2" style="white-space: pre-line;">
        <div class="pt-2" style="width:70px;text-align:right;font-size:0.8rem">意味：&nbsp;</div>
        <div class="normal-text" style="font-size:1.2rem">{{ $word->jp }}</div>
      </div>

      @php
        $search_word = implode("+", explode(" ", $word->name, 8) );
      @endphp
      <div class="mt-2 mb-2" style="width:190px">
        <a href={{'https://www.google.co.jp/search?q='.$search_word.'&tbm=isch'}} class="text-success" target="_blank" rel="noopener noreferrer">
          <div class="ml-2 mt-2 pl-1 d-flex flex-row border border-success rounded" style="width:180px">
            <div>
              <span class="mt-0 pt-0" style="font-size:0.8rem">単語のイメージを確認</span>
            </div>
            <div class="ml-2">
              <i class="fas fa-image" style="font-size:2.0rem"></i>
            </div>
          </div>
          <div class="text-black-50" style=" font-size:0.8rem;float:right;">※画像検索が開きます</div>
        </a>
      </div>
      <div class="normal-text d-flex flex-row pt-3">
        <div class="pt-1" style="width:50px;text-align:right;font-size:0.8rem">Level：&nbsp;</div>
        <div style="font-size:1.0rem">{{ $word->level }}</div>
      </div>
    </div>
  </div>

  <div class="card-body pt-0" >
    <!-- {{$word->no_diacritic}}<br>
    {{$word->simplified}} -->
    <div>
      {{ $word->detail }}
    </div>
  </div>
  <div class=" d-flex flex-row">
    @if( Auth::id() === $word->user_id )
      <!-- dropdown -->
      <div class="ml-auto d-flex flex-column-reverse">
        <div class="dropdown">
          <a class="text-black-50" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-v"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="{{ route("words.edit", ['word' => $word]) }}">
              <i class="fas fa-pen mr-1"></i>単語を更新する
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item text-danger" data-toggle="modal" data-target="#modal-delete-{{ $word->id }}">
              <i class="fas fa-trash-alt mr-1"></i>単語を削除する
            </a>
          </div>
        </div>
      </div>
      <!-- dropdown -->

      <!-- modal -->
      <div id="modal-delete-{{ $word->id }}" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="{{ route('words.destroy', ['word' => $word]) }}">
              @csrf
              @method('DELETE')
              <div class="modal-body">
                {{ $word->name }}を削除します。よろしいですか？
              </div>
              <div class="modal-footer justify-content-between">
                <a class="btn btn-outline-grey" data-dismiss="modal">キャンセル</a>
                <button type="submit" class="btn btn-danger">削除する</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- modal -->
    @endif
  </div>

</div>

<style>
  .sizable-text-small{
    font-size: calc(1.2rem + ((1vw - 0.64rem) * 0.7143));
  }
  .sizable-text-middle{
    font-size: calc(1.6rem + ((1vw - 0.64rem) * 1.13));
  }
  .sizable-text-large{
    font-size: calc(2.4rem + ((1vw - 0.64rem) * 2.1429));
  }
</style>