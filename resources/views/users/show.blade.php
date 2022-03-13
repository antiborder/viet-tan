@extends('app')

@section('title', $user->name)

@section('content')
  @include('nav')
  <div class="container">
    <div class="card mt-3">
      <div class="card-body">
        <div class="h5 card-title m-0">
            ユーザーID　：　{{ $user->name }}
        </div>
        <br>
        <div>
          登録emailアドレス　：　{{ $user->email}}
        </div>
      </div>
    </div>
    <div class="card mt-3">
        <table>
          <tr>
            <th style="font-size:1.0rem;">Level</th>
            <th style="font-size:1.0rem;">進捗率</th>
            <th style="font-size:1.0rem;">復習可</th>
            <th style="font-size:1.0rem;">既習</th>
            <th style="font-size:1.0rem;">未習</th>
            <th style="font-size:1.0rem;">合計</th>
          </tr>
          @foreach($status as $s)
          <tr>
            <td style="font-size:1.1rem;">{{$s['level']}}</td>
            <td style="font-size:1.1rem;">{{$progress[$s['level']]}} &#037; </td>                       
            <td style="font-size:1.1rem;">{{$ready[$s['level']]}}</td>            
            <td style="font-size:0.8rem;">{{$learned[$s['level']]}}</td>
            <td style="font-size:0.8rem;">{{$unlearned[$s['level']]}}</td>
            <td style="font-size:0.8rem;">{{$s['total']}}</td>           

          </tr>           
          @endforeach
        </table>
    </div>
    <a href="/learn" >
      <div class="card mt-3 px-2 py-2 orange lighten-1 text-white" style="color: white; max-width:200px; font-size:1.2rem; text-align:center; margin-left:auto; font-family:ＭＳ Ｐゴシック;">
        <div >
            単語学習に進む ▶
        </div>
      </div>
    </a>    
  </div>
@endsection