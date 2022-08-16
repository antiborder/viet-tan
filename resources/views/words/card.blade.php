<div class="card-word">
  <div class="d-flex flex-row">
    <div class="upper-left-half">
      <div class="d-flex flex-row">
        <!-- 音節数によるfont-size調整 -->
        @if($word->name3=='')
          @php $name_font_size = '100%'; @endphp
        @else
          @php $name_font_size = '75%'; @endphp
        @endif

        @foreach(array(0,1,2,3,4,5,6,7) as $i)
          @php
            $name = "name" . $i;
          @endphp
          @if($word->$name!==null)
            <div class="pt-1">
              <div>
                <span class="h4 card-title">
                  <a href="{{ route('words.show', ['word' => $word]) }}" class="viet-text word-name" style="font-size:{{$name_font_size}};" >
                    {{$word->$name}}
                  </a>
                </span>
              </div>
              <div class="kanji-box">
                @php
                  $kanji_n = 'kanji' . $i;
                @endphp
                @if($word->$kanji_n != '')
                <a href="{{ route('kanjis.show', ['name' => $word->$kanji_n]) }}" class="kanji-text kanji">
                  {{$word->$kanji_n}}
                </a>
                @endif
              </div>
            </div>
          @endif
        @endforeach
      </div>

    </div>
    <div class="right-half" >
      <div class="normal-text jp">{{ $word->jp }}</div>
    </div>
  </div>
  <div class="d-flex flex-row">
    <div class="lower-left-half">
      <div class="normal-text text-dark text-left small mt-1 card-text">
        Lv.{{$word->level}}
      </div>
    </div>
    <div class="right-half" >
      <div class="d-flex flex-row-reverse">
        @if( Auth::id() === $word->user_id )
          <!-- dropdown -->
          <div class="ml-auto card-text d-flex flex-column-reverse">

            <div class="dropdown">
              <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="text-muted fas fa-ellipsis-v"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ route('words.edit', ['word' => $word]) }}">
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
  </div>
</div>

