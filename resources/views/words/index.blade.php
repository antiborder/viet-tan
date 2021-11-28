@extends('app')

@section('title', '単語一覧')

@section('content')
  @include('nav') {{--この行を追加--}}
  <div class="container">
    @php
      //session(['nameB' => 39]);
      Cookie::queue('key', 39, 10);

    @endphp
    {{Cookie::get('key')}}
    {{'test'}}
    @foreach($words as $word) {{--この行を追加--}} 
      @include('words.card') {{-- この行を追加 --}}      
    @endforeach {{--この行を追加--}}
  </div>
@endsection