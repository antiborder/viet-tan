@extends('app')

@section('title', $user->name)

@section('content')
  @include('nav')
  <div class="container">
    <div class="card mt-3">
      <div class="card-body">
        <h2 class="h5 card-title m-0">
            ユーザーID　：　
            <a href="{{ route('users.show', ['name' => $user->name]) }}" class="text-dark">
                {{ $user->name }}
            </a>
        </h2>
      </div>
      <div class="card-body">
        <div class="card-text">
          <a href="" class="text-muted">
            10 フォロー
          </a>
          <a href="" class="text-muted">
            10 フォロワー
          </a>
        </div>
      </div>
    </div>
    <div class="card mt-3">
        <table>
          <tr>
            <th>Level</th><th>Ready</th><th>Learned</th><th>Unlearned</th><th>Total</th>
          </tr>
          @foreach($status as $s)
          <tr>
            <td>{{$s['level']}}</td>
            <td>{{$ready[$s['level']]}}</td>            
            <td>{{$learned[$s['level']]}}</td>
            <td>{{$unlearned[$s['level']]}}</td>
            <td>{{$s['total']}}</td>           
          </tr>           
          @endforeach
        </table>
    </div>
  </div>
@endsection