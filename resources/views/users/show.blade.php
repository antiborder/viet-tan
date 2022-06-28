@extends('app')

@section('title', $user->name."の学習状況")

@section('content')
  @include('nav')
  <div class="container" style="max-width:800px">
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
        <!-- <div style="font-size:1.1rem; line-height:200%">
          　　会員プラン ：　{{$membership}}
          @if( $subscription === "TRIAL")
            <span class="m-3" style="text-align:center; font-size:1.2rem" >
              <a href="{{ route('stripe.subscription')}}" class="info-color text-white text-nowrap rounded ml-2 px-2 py-1" >通常会員に登録</a>
            </span>            
          @endif
        </div>         -->
      </div>
    </div>
    <div class="card my-2">
      <div class="h5 card-title  mt-1 ml-1">学習状況</div>
      <table class="mt=0 mb-1">
        <tr>
          <th style="font-size:1.0rem; text-align:center">Level</th>
          <th style="font-size:1.0rem; text-align:center; min-width:70px">進捗率</th>
          <th style="font-size:1.0rem; text-align:center">復習可</th>
          <th style="font-size:1.0rem; text-align:center">未習</th>
          
        </tr>
        @foreach($status as $s)
        <tr>
          <td style="font-size:1.1rem; text-align:center">{{$s['level']}}</td>
          @php
            $style1 = "width:".$progress[$s['level']];
            $style2 = "%; color:black";
          @endphp
          <td style="text-align:right">
            <span class="progress">
              <span class="progress-bar bg-success" style="{{$style1.$style2}}">  
                　{{$progress[$s['level']]}}&#037;
              </span> 
            </span >
          </td>
          <td style="font-size:1.2rem; text-align:center">{{$ready[$s['level']]}}</td>            
          <td style="font-size:1.2rem; text-align:center">{{$unlearned[$s['level']]}}</td>
          <td style="font-size:0.8rem; text-align:center">           
            <!-- Button trigger modal -->
            @php
              $modal = "modal".$s['level'];
              $label = "label".$s['level'];
            @endphp

            @if($learned[$s['level']] !==0)
              <a type="button" class="text-success border border-success rounded px-1 pt-1 " data-toggle="modal" data-target="{{'#'.$modal}}" style="font-size:1.0rem; height:30px;max-width:60px">
              &nbsp;詳細&nbsp;
              </a>
            @else 
            <a type="button" class="border text-muted border-muted rounded px-1 pt-1 " style="font-size:1.0rem; height:30px;max-width:60px">
              &nbsp;詳細&nbsp;
              </a>
            @endif

          </td>
          <td style="font-size:0.8rem; max-width:45px ;">           
            <a type="button" class="text-primary border border-primary rounded px-1 pt-1"  href="{{'/learn/'.$s['level']}}" style="font-size:1.0rem; height:30px;text-align:left">
            &nbsp;&nbsp;&nbsp;▶&nbsp;&nbsp;&nbsp;
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

                  <div class="progress shadow-none" style="height:30px;"> 

                  <!-- learned_nを配列にすれば少しきれいになる。 -->
                    @php
                      $individual = [0=>"red lighten-4", 1=>"amber lighten-4", 2=>"lime lighten-4", 3=>"green lighten-4", -1=>"blue-grey lighten-5"];
                    @endphp

                    <div class="{{'progress-bar text-dark '.$individual[3]}}" role="progressbar" style="{{'width:' . (int)($learned_3[$s['level']] / $s['total'] * 100) . '%; height: 30px;'}}"  aria-valuemin="0" aria-valuemax="100">{{$learned_3[$s['level']]}}</div>                    
                    <div class="{{'progress-bar text-dark '.$individual[2]}}" role="progressbar" style="{{'width:' . (int)($learned_2[$s['level']] / $s['total'] * 100) . '%; height: 30px;'}}" aria-valuemin="0" aria-valuemax="100">{{$learned_2[$s['level']]}}</div>                    
                    <div class="{{'progress-bar text-dark '.$individual[1]}}" role="progressbar" style="{{'width:' . (int)($learned_1[$s['level']] / $s['total'] * 100) . '%; height: 30px;'}}" aria-valuemin="0" aria-valuemax="100">{{$learned_1[$s['level']]}}</div>                                        
                    <div class="{{'progress-bar text-dark '.$individual[0]}}" role="progressbar" style="{{'width:' . (int)($learned_0[$s['level']] / $s['total'] * 100) . '%; height: 30px;'}}" aria-valuemin="0" aria-valuemax="100">{{$learned_0[$s['level']]}}</div>                     
                    <div class="{{'progress-bar text-dark '.$individual[-1]}}"  role="progressbar" style="{{'width:' . (int)($unlearned[$s['level']] / $s['total'] * 100) . '%; height: 30px;'}}" aria-valuemin="0" aria-valuemax="100">{{$unlearned[$s['level']]}}</div>
                  </div>

                  <div><span class="{{'btn btn-info rounded p-1 m-1 text-dark '.$individual[3]}}" style="width:65px; height:25px" >余裕♪</span>：　{{$learned_3[$s['level']]}}語</div>
                  <div><span class="{{'btn btn-info rounded p-1 m-1 text-dark '.$individual[2]}}" style="width:65px; height:25px" >覚えた!</span>：　{{$learned_2[$s['level']]}}語</div>                  
                  <div><span class="{{'btn btn-info rounded p-1 m-1 text-dark '.$individual[1]}}" style="width:65px; height:25px">びみょう</span>：　{{$learned_1[$s['level']]}}語</div>
                  <div><span class="{{'btn btn-info rounded p-1 m-1 text-dark '.$individual[0]}}" style="width:65px; height:25px">まだ。</span>：　{{$learned_0[$s['level']]}}語</div>                  
                  <div><span class="{{'btn btn-info rounded p-1 m-1 text-dark '.$individual[-1]}}" style="width:65px; height:25px">未習</span>：　{{$unlearned[$s['level']]}}語</div>  
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
      <div class=" m-2 text-right" style="">
          <button onclick="location.href='{{route("articles.han-nom")}}'" class="home-button shadow">
            単語レベル一覧
          </button><br>
      </div>                
    </div>

    @include('ads.horizontal')

    <div class="card my-2">
      <div class="h5 card-title  mt-1 ml-1">復習予定</div>
      <div class="card-body">      
        <div class="overflow-auto" style="display:flex">
          <div class="label-vertical">
            <div class="label" style="font-size: 12px;  line-height: 26px;  text-align: right;  padding-right: 10px;">[語]</div>
            <div class="label" style="font-size: 12px;  line-height: 26px;  text-align: right;  padding-right: 10px;">500</div>
            <div class="label" style="font-size: 12px;  line-height: 26px;  text-align: right;  padding-right: 10px;">400</div>
            <div class="label" style="font-size: 12px;  line-height: 26px;  text-align: right;  padding-right: 10px;">300</div>
            <div class="label" style="font-size: 12px;  line-height: 26px;  text-align: right;  padding-right: 10px;">200</div>
            <div class="label" style="font-size: 12px;  line-height: 26px;  text-align: right;  padding-right: 10px;">100</div>
            <div class="label" style="font-size: 12px;  line-height: 26px;  text-align: right;  padding-right: 10px;">0</div>  
          </div>
          <div class="inner" style="display:flex; flex-flow: column;">
            <div class="graph" style=" height:150x; width:1240px; border:1px solid #F0F0F0; position:relative; margin-top:13px;">
              <hr style="top: 25px; border: none;  position: absolute;  width: 100%;  height: 1px;  margin: 0 auto;  background: #F0F0F0;">
              <hr style="top: 50px; border: none;  position: absolute;  width: 100%;  height: 1px;  margin: 0 auto;  background: #F0F0F0;">
              <hr style="top: 75px; border: none;  position: absolute;  width: 100%;  height: 1px;  margin: 0 auto;  background: #F0F0F0;">
              <hr style="top: 100px;border: none;  position: absolute;  width: 100%;  height: 1px;  margin: 0 auto;  background: #F0F0F0;">
              <hr style="top: 125px;border: none;  position: absolute;  width: 100%;  height: 1px;  margin: 0 auto;  background: #F0F0F0;">
              <hr style="top: 150px;border: none;  position: absolute;  width: 100%;  height: 1px;  margin: 0 auto;  background: #F0F0F0;">

              
              <div class="bar pink lighten-3" style="height: {{$ready_total/4}}px; margin-top: {{150-$ready_total/4}}px; float: left;  text-align: center;  position: relative;  margin-left: 5px;  width: 15px;  background-color: #006400;"></div>
              @for($i=1;$i<=60;$i++)
                <div class="bar pink lighten-3" style="height: {{$schedule[$i]/4}}px; margin-top: {{150-$schedule[$i]/4}}px; float: left;  text-align: center;  position: relative;  margin-left: 5px;  width: 15px;  background-color: #006400;" ></div>
              @endfor
            </div>
            <div class="label-horizontal"style="display: flex;">
              <div class="label" style="font-size: 12px;  margin-left: 5px; line-height:14px; width: 15px;  text-align: center;  padding-top: 6px;">現在</div>
              @for($i=1;$i<=60;$i++)
                <div class="label" style="font-size: 12px;  margin-left: 5px; line-height:14px; width: 15px;  text-align: center;  padding-top: 6px;">{{$i}} @if($i===1) 日後 @endif</div>
              @endfor
            </div>
          </div>
        </div>
      </div>
    </div>

    <a href="/learn/REVIEW_ALL" >
      <div class="card my-2 px-2 py-2 primary-color text-white" style="color: white; max-width:230px; font-size:1.2rem; text-align:center; margin-left:auto; font-family:ＭＳ Ｐゴシック;">
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
