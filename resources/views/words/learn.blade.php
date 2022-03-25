@extends('app')

@section('title', '単語学習')

@section('content')
  @include('nav')

  <div class="container">
    <div>

      <question 
        endpoint_to_get_word="{{ route('learn.random') }}"
        endpoint_to_record_learn="{{ route('learn.record') }}"
        user_name = "{{ $user_name }}"
        initial_level = "{{$level}}"
      >
      </question>
    </div>
  </div>

@endsection