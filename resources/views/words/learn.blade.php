@extends('app')

@section('title', '単語学習')

@section('content')
  @include('nav')
  <!-- @php
    phpinfo()
  @endphp -->
  <div class="container">
    <div>

      <question 
        endpoint="{{ route('words.random') }}"
      >
      </question>

@endsection