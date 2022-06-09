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
        subscription = "{{$subscription}}"        
        initial_level = "{{$level}}"
        time_limit = "{{config('const.TIME_LIMIT')}}"
        max_level = "{{config('const.MAX_LEVEL')}}"
        trial_level= "{{config('const.TRIAL_LEVEL')}}"
        guest_level= "{{config('const.GUEST_LEVEL')}}"
      >
      </question>
    </div>
  </div>

  
@endsection