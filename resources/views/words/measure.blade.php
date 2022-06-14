@extends('app')

@section('title', '単語力測定')

@section('content')
  @include('nav')
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9067426465896411"
      crossorigin="anonymous"></script>
  <!-- Horizontal -->
  <ins class="adsbygoogle"
      style="display:block"
      data-ad-client="ca-pub-9067426465896411"
      data-ad-slot="5078046569"
      data-ad-format="horizontal"
      data-full-width-responsive="true"></ins>
  <script>
      (adsbygoogle = window.adsbygoogle || []).push({});
  </script>        
  
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

  @include('footer')        
@endsection