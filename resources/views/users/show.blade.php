@extends('app')

@section('title', $user->name."の学習状況")

@section('content')
  @include('nav')
  <div id="user" class="container" style="max-width:800px">
    <div class="card my-2">
      <div class="card-body">
        <div class="h5 card-title m-0">
            ユーザーID ：　{{ $user->name }}
        </div>
        <br>
        <div class="my-2" style="font-size:1.1rem" >
          　　Eメール ：　{{ $user->email}}
        </div>
        @php
        if($subscription === 'NORMAL'){
           $membership = '通常会員';
        }else if($subscription === 'TRIAL'){
          $membership = '無料会員';
        }
        @endphp
        <!-- 一時的に隠してる
          <div style="font-size:1.1rem; line-height:200%">
          　　会員プラン ：　{{$membership}}
          @if( $subscription === "TRIAL")
            <span class="m-3" style="text-align:center; font-size:1.2rem" >
              <a href="{{ route('stripe.subscription')}}" class="info-color text-white text-nowrap rounded ml-2 px-2 py-1" >通常会員に登録</a>
            </span>
          @endif
        </div>         -->
      </div>
    </div>

    <!-- 学習状況 -->
    <div class="card my-2">
      <div class="h5 card-title  mt-1 ml-1">学習状況</div>
      <table class="mt=0 mb-1">
        <tr>
          <th class="table-header">Level</th>
          <th class="table-header table-header-progress">進捗率</th>
          <th class="table-header">復習可</th>
          <th class="table-header">未習</th>

        </tr>
        @foreach($status as $s)
        <tr>
          <td class="table-text">{{$s['level']}}</td>
          <td class="text-center">
            <span class="progress">
              <span class="progress-bar bg-success text-dark" style="width:{{ $progress[$s['level']] }}%">
                　{{$progress[$s['level']]}}&#037;
              </span>
            </span >
          </td>
          <td class="table-text">{{$ready[$s['level']]}}</td>
          <td class="table-text">{{$unlearned[$s['level']]}}</td>
          <td class="text-center">
            <!-- Button trigger modal -->
            @php
              $modal = "modal".$s['level'];
              $label = "label".$s['level'];
            @endphp

            @if($learned[$s['level']] !==0)
              <a type="button" class="detail-btn success-btn-transparent" data-toggle="modal" data-target="{{'#'.$modal}}" style="color:#00C851">
                詳細
              </a>
            @else
              <a type="button" class="detail-btn muted-btn-transparent" style="color:#6c757d">
                詳細
              </a>
            @endif

          </td>
          <td>
            <a type="button" class="play-btn primary-btn-transparent"  href="{{'/learn/'.$s['level']}}">
            ▶
            </a>
          </td>
            <!-- Modal -->
          <div class="modal fade" id="{{$modal}}" tabindex="-1" role="dialog" aria-labelledby="{{$label}}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header" style="height:50px">
                  <h5 class="modal-title" id="{{$label}}" >Level {{$s['level']}}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div>直近の解答</div>

                  <div class="progress shadow-none" style="height:30px;margin-bottom:10px">

                  <!-- learned_nを配列にすればもう少しまとまる。 -->
                    @php
                      $individual = [0=>"red lighten-4", 1=>"amber lighten-4", 2=>"lime lighten-4", 3=>"green lighten-4", -1=>"blue-grey lighten-5"];
                    @endphp

                    <div class="{{'progress-bar text-dark '.$individual[3]}}" role="progressbar" style="{{'width:' . (int)($learned_3[$s['level']] / $s['total'] * 100) . '%; height: 30px;'}}"  aria-valuemin="0" aria-valuemax="100">{{$learned_3[$s['level']]}}</div>
                    <div class="{{'progress-bar text-dark '.$individual[2]}}" role="progressbar" style="{{'width:' . (int)($learned_2[$s['level']] / $s['total'] * 100) . '%; height: 30px;'}}" aria-valuemin="0" aria-valuemax="100">{{$learned_2[$s['level']]}}</div>
                    <div class="{{'progress-bar text-dark '.$individual[1]}}" role="progressbar" style="{{'width:' . (int)($learned_1[$s['level']] / $s['total'] * 100) . '%; height: 30px;'}}" aria-valuemin="0" aria-valuemax="100">{{$learned_1[$s['level']]}}</div>
                    <div class="{{'progress-bar text-dark '.$individual[0]}}" role="progressbar" style="{{'width:' . (int)($learned_0[$s['level']] / $s['total'] * 100) . '%; height: 30px;'}}" aria-valuemin="0" aria-valuemax="100">{{$learned_0[$s['level']]}}</div>
                    <div class="{{'progress-bar text-dark '.$individual[-1]}}"  role="progressbar" style="{{'width:' . (int)($unlearned[$s['level']] / $s['total'] * 100) . '%; height: 30px;'}}" aria-valuemin="0" aria-valuemax="100">{{$unlearned[$s['level']]}}</div>
                  </div>

                  <div><span class="confidence-btn {{$individual[3]}}">余裕♪</span>：　{{$learned_3[$s['level']]}}語</div>
                  <div><span class="confidence-btn {{$individual[2]}}">覚えた!</span>：　{{$learned_2[$s['level']]}}語</div>
                  <div><span class="confidence-btn {{$individual[1]}}">びみょう</span>：　{{$learned_1[$s['level']]}}語</div>
                  <div><span class="confidence-btn {{$individual[0]}}">まだ。</span>：　{{$learned_0[$s['level']]}}語</div>
                  <div><span class="confidence-btn {{$individual[-1]}}">未習</span>：　{{$unlearned[$s['level']]}}語</div>
                  <hr>
                  <div>合計：　{{$s['total']}}語</div>
                  <div>進捗率：　{{$progress[$s['level']]}}&#037;</div>

                </div>

              </div>
            </div>
          </div>

        </tr>
        @endforeach
      </table>
      <div class=" m-2 text-right">
        <a href="{{route('articles.level-table')}}" class="login-button level-table-btn">
          <small>単語レベル一覧</small>
        </a>
      </div>

    </div>

    @include('ads.horizontal')

    <!-- 学習予定 -->
    <div class="card my-2">
      <div class="h5 card-title  mt-1 ml-1">復習予定</div>
      <div class="card-body">
        <div class="overflow-auto" style="display:flex">
          <div class="label-vertical">
            <div class="word-number-label">[語]</div>
            @for ($i = 5; $i >= 0; $i--)
              <div class="word-number-label">{{ $i * 100 }}</div>
            @endfor
          </div>

          <div class="inner" style="display:flex; flex-flow: column;">
            <div class="graph schedule-graph">
              @for ($i = 1; $i <= 6; $i++)
                <hr class="word-number-rule" style="top: {{ $i * 25 }}px;">
              @endfor              

              <div class="schedule-bar" style="height: {{$ready_total/4}}px; margin-top: {{150-$ready_total/4}}px;"></div>
              @for($i=1;$i<=60;$i++)
                <div class="schedule-bar" style="height: {{$schedule[$i]/4}}px; margin-top: {{150-$schedule[$i]/4}}px;"></div>
              @endfor

            </div>
            <div class="label-horizontal"style="display: flex;">
              <div class="date-label">現在</div>
              @for($i=1;$i<=60;$i++)
                <div class="date-label">{{$i}} @if($i===1) 日後 @endif</div>
              @endfor
            </div>
          </div>
        </div>
      </div>
    </div>

    <a href="/learn/REVIEW_ALL" >
      <div class="reviewall-btn primary-btn">
        <div >
            復習のみでStart ▶
        </div>
      </div>
    </a>

    @include('ads.rectangle')

    @if($subscription === 'NORMAL')
    <div class="card my-2">
      <div class="card-body">
        <div class="h5 card-title  mt-1 ml-1">支払情報</div>
          <a href="{{route('stripe.portalsubscription', $user) }}" style="text-align:right;">
	          <div class="btn text-info border border-info shadow-none px-2 py-1" style="font-size:1.0rem" >お支払い情報確認</div>
          </a>
      </div>
    </div>

    @endif

  </div>

  @include('footer')
@endsection
