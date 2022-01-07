@csrf
<div class="md-form">
  <label>単語</label>
  <input type="text" name="name" class="form-control" required value="{{ $word->name ?? old('name') }}">
  @for($i=0; $i < 8; $i++)
  @php
    $name_n = 'name' . $i;
  @endphp
  {{ $word->$name_n ?? null}}
@endfor
</div>

<div class="form-group">
  <label>漢字</label><br>
  <div style="display:inline-flex">
  @for($i=0; $i < 8; $i++)
    @php
      $kanji_n = 'kanji' . $i;
    @endphp
    <input type="text" name="{{'kanji'. $i}}" class="form-control mr-2" value="{{ $word->$kanji_n ?? null}}" size = "3" >
  @endfor
</div>

<div class="form-group">
  <label>意味</label>
  <textarea name="jp" class="form-control" rows="3" >{{ $word->jp ?? old('jp') }}</textarea>
</div>
<div class="form-group">
  <label>detail</label>
  <textarea name="detail" class="form-control" rows="3" >{{ $word->detail ?? old('detail') }}</textarea>
</div>

<div class="form-group">
  <label>レベル</label>
  <input type="text" name="level" class="form-control" value="{{ $word->level ?? old('level') }}">
</div>

<div class="form-group">
  <label>類義語</label> <br>
  @for($i = 0; $i < 5 ; $i++)
    <input class="mb-1" type="text" name="{{'synonym'. $i}}" class="form-control" value="{{$synonyms[$i]}}">
  @endfor
</div>
<div class="form-group">
  <label>対義語</label> <br>
  @for($i = 0; $i < 5 ; $i++)
    <input class="mb-1" type="text" name="{{'antonym'. $i}}" class="form-control" value="{{$antonyms[$i]}}">
  @endfor
</div>

<div class="form-group">
  <article-tags-input 
    :initial-tags='@json($tagNames ?? [])'
    :autocomplete-items='@json($allTagNames ?? [])'
  >
  </article-tags-input>
</div>