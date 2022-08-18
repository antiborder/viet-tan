<div id="card-detail" class="card-plain">
  <div class=" card-body pt-2 pb-0 pl-0 d-flex flex-row">
    <div>
      <div class="d-flex flex-row">
        <div class="text-nowrap mr-1">
          <p class="label-text-vn">ベトナム語：&nbsp;</p>
          <p class="label-text-kanji">漢字：&nbsp;</p>
        </div>
        @foreach(array(0,1,2,3,4,5,6,7) as $i)
          @php
            $name = "name" . $i;
          @endphp
          @if($word->$name!==null)
          <div>
            <div class="viet-text detail-word-text">
                {{$word->$name}}
            </div>
            <div class="detail-kanji-box">
              @php
                $kanji_n = 'kanji' . $i;
              @endphp
              @if($word->$kanji_n != '')
              <a href="{{ route('kanjis.show', ['name' => $word->$kanji_n]) }}" class="kanji-text detail-kanji-text">
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
        <div class="pronunciation-block">
          <div class="pronunciation-text">
            発音を確認
          </div>
          <div class="ml-1 mt-0 pt-0">
              <audio controls src={{$file_name}} class="pronunciation-control"><audio>
          </div>
        </div>
      @endif
      <div class="jp-block d-flex flex-row">
        <div class="label-text-jp">意味：&nbsp;</div>
        <div class="text-jp">{{ $word->jp }}</div>
      </div>

      @php
        $search_word = implode("+", explode(" ", $word->name, 8) );
      @endphp
      <div class="image-block">
        <a href={{'https://www.google.co.jp/search?q='.$search_word.'&tbm=isch'}} class="text-success" target="_blank" rel="noopener noreferrer">
          <div class="image-block-square d-flex flex-row">
            <div>
              <span class="image-text">単語のイメージを確認</span>
            </div>
            <div class="ml-2">
              <i class="fas fa-image image-icon"></i>
            </div>
          </div>
          <div class="image-annotation">※画像検索が開きます</div>
        </a>
      </div>
      <div class="d-flex flex-row pt-3 w-100">
        <div class="level-label">
          Level：&nbsp;
        </div>
        <div>{{ $word->level }}</div>
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