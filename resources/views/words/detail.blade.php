<div class="card-plain mb-2  pt-0 pb-1 pl-1 pr-3 white rounded">
  <div class="card-body d-flex flex-row">
    <div style ="width:50%">
    <div class="d-flex flex-row">
        @foreach(array(0,1,2,3,4,5,6,7) as $i)
          <div>
            <div class="mx-auto pr-2" style="width:100%">
              @php
                $name = "name" . $i;
              @endphp
              <span class="h4 card-title">      
                <a class="text-dark" href="{{ route('words.show', ['word' => $word]) }}">
                  {{$word->$name}}
                </a>
              </span>
            </div>
            <div class="mx-auto" style="width:30px">
              @php
                $kanji_n = 'kanji' . $i;  
              @endphp        
              @if($word->$kanji_n != '')
              <a href="{{ route('kanjis.show', ['name' => $word->$kanji_n]) }}" class="p-1 mr-1 mt-1 text-muted">
                {{$word->$kanji_n}}
              </a>          
              @endif
            </div>
          </div>
        @endforeach    
      </div>
    </div>
    <div class="card-body pt-0" style="width:50%">
      <div class="text-dark card-text">
        {{ $word->jp }}
      </div>
    </div>
    <div class="card-body pt-0" style="width:50%">
      <div class="text-dark card-text">
        {{ $word->detail }}
      </div>
    </div>    
  </div>

  <div class="d-flex flex-row">
    <div class="text-dark small ml-4 card-text">
      Lv.{{ $word->level }}
    </div>

    @if( Auth::id() === $word->user_id )
      <!-- dropdown -->
      <div class="ml-auto card-text d-flex flex-column-reverse">
        
        <div class="dropdown">
          <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
  .name-table{
    border-collapse: separate;
    border-spacing: 10px  0px;
  }
</style>