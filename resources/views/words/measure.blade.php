@extends('app')

@section('title', '単語力測定')

@section('content')
  @include('nav')
  
  <div class="container">
    <div>
      <measure 
        endpoint_to_get_word="{{ route('learn.random') }}"
        endpoint_to_record_learn="{{ route('learn.record') }}"
        time_limit = "{{config('const.TIME_LIMIT')}}"
        max_level = "{{config('const.MAX_LEVEL')}}"
      >
      </measure>
    </div>
  </div>


@endsection