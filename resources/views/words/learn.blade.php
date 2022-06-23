@extends('app')

@section('title', '単語学習')

@section('content')
  @include('nav')

  <div class="container">
    <div>
      <learn
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
      </learn>


    </div>

  </div>

  <div id="divadsensedisplaynone1" style=" ">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9067426465896411"
        crossorigin="anonymous"></script>
    <!-- Horizontal -->
    <ins class="adsbygoogle"
        style="display:block; min-width:250px"
        data-ad-client="ca-pub-9067426465896411"
        data-ad-slot="5078046569"
        data-ad-format="horizontal"
        data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>                                  
  <div>  
  <div id="divadsensedisplaynone2" style=" ">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9067426465896411"
        crossorigin="anonymous"></script>
    <!-- Horizontal -->
    <ins class="adsbygoogle"
        style="display:block; min-width:250px"
        data-ad-client="ca-pub-9067426465896411"
        data-ad-slot="5078046569"
        data-ad-format="horizontal"
        data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>                                  
  <div>  

@endsection