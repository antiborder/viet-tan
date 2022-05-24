<div class="card mt-0 mb-1 pt-1 pb-1 pl-2 pr-3  white rounded" style="max-width: 30rem;">
  <div class="d-flex flex-row">
    <div class="pl-1" style ="width:50%">
      <div class="d-flex flex-row">
        @foreach(array(0,1,2,3,4,5,6,7) as $i)
          @php
            $name = "name" . $i;
          @endphp
          @if($word->$name!==null)
            <div class="pt-1">
              <div class="mx-auto" style="width:100%">

                <span class="h4 card-title">      
                  <a class="text-dark yellow lighten-3 px-2 mx-n1" style="border-radius: 8px" href="{{ route('words.show', ['word' => $word]) }}">
                    {{$word->$name}}
                  </a>
                </span>
              </div>
              <div class="mx-auto " style="width:2.5rem">
                @php
                  $kanji_n = 'kanji' . $i;  
                @endphp        
                @if($word->$kanji_n != '')
                <a href="{{ route('kanjis.show', ['name' => $word->$kanji_n]) }}" class="p-1 mr-1 mt-1 blue-text" style=' font-size:1.5rem'> 
                  <!-- font-family:"UD デジタル 教科書体 N-R", "BIZ UDゴシック Regular"; -->
                  {{$word->$kanji_n}}
                </a>          
                @endif
              </div>
            </div>
          @endif
        @endforeach    
      </div>
      <div class="d-flex flex-column-reverse" >
        <div class="text-dark small mt-2 ml-0 card-text">
          Lv.{{$word->level}}
        </div>
      </div>
    </div>
    <div class="card-body pt-2 border-left border-light" style="width:50%" >
      <div class="text-dark card-text" style="white-space: pre-line;">{{ $word->jp }}</div>
        
      
      <div class="d-flex flex-row-reverse">
        @if( Auth::id() === $word->user_id )
          <!-- dropdown -->
          <div class="ml-auto card-text d-flex flex-column-reverse">
            
            <div class="dropdown">
              <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v"></i>
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

