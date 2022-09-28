@extends('app')

@section('title', $tag->name)

@section('content')
  @include('nav')
  <div class="container" style="max-width:800px" >
    <div class="card my-3 centered-block">
      <div class="card-body">
        <span class="h4 card-title m-0">{{ $tag->name }}</span>　タグに該当
      </div>
    </div>

    <div class="centered-block form-group">
      <form method="POST" action="{{ route('tags.update', $tag->name) }}">
        @method('POST')
        @csrf
        <label>keywords:</label>
        <textarea name="keywords" class="form-control" rows="3" >{{ $tag->keywords ?? old('keywords') }}</textarea>
        <input type="hidden" name="name" value="{{ $tag->name ?? old('name') }}" >
        <button type="submit" class="btn blue-gradient btn-block">更新する</button>
      </form>
    </div>

    <div class="centered-block">
      <span style="font-size:1.4rem"> {{ $tag->words->count() }}</span> 件が該当
    </div>

    <div class="centered-block">
        @foreach($tag->words->sortBy('level') as $i => $word)
          @include('words.card')
        @endforeach
    </div>
    <div class="centered-block">
      <form method="POST" action="{{ route('tags.delete', $tag->name) }}">
        @csrf
        @method('DELETE')
        <div class="">
          <button type="submit" class="btn btn-danger">削除する</button>
        </div>
      </form>
    </div>

  </div>

  @include('footer')
@endsection