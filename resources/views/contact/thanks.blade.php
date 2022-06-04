@extends('app')

@section('title', "送信完了")

@section('content')
  @include('nav')

  <div class="container">
    <div class="card mt-3">
      <div class="card-body">
        <span class="mb-3">
        {{ __('送信が完了しました。') }}
        <h5 class="mt-2 mb-0">
            　メールアドレス：
        </h5>
            　　{{$inputs['email']}}
        <h5 class="mt-2 mb-0">
            　タイトル：
        </h5>
            　　{{$inputs['title']}}
        <h5 class="mt-2">
            　メッセージ：
        </h5>
            　　{{$inputs['body']}}
        </div>

        <div class="mt-3 pb-2" style="text-align:center">
        
            <a type="button" href="/" class="btn btn-info orange lighten-1 rounded p-1 mt-2 text-nowrap" style="width: 240px; font-size: 1.3rem;">
              Topページに戻る
            </a>
            <br>Thank you!
        </div>
      </div>
    </div>
  </div>        
@endsection

