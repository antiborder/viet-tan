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
          email　：　{{ $user->email}}
        </div>
      </div>
    </div>
    <div class="card mt-3">
      学習状況
      <table>
        <tr>
          <th style="font-size:1.0rem; text-align:center">Level</th>
          <th style="font-size:1.0rem; text-align:center">進捗率</th>
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
          <td style="font-size:0.8  rem;">           
            <!-- Button trigger modal -->
            @php
              $modal = "modal".$s['level'];
              $label = "label".$s['level'];
            @endphp
            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="{{'#'.$modal}}" style="font-size:0.8rem; height:30px">
              詳細
            </button>
            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="{{'#'.$modal}}" style="font-size:0.8rem; height:30px">
             ▶
            </button>            
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

                  <div class="progress" style="height:40px;"> <!-- ["pink", "red", "deep-orange", "orange"] -->
                    @php
                      $width_3 = "width:" . (int)($learned_3[$s['level']] / $s['total'] * 100) . "%; height: 30px;";
                      $width_2 = "width:" . (int)($learned_2[$s['level']] / $s['total'] * 100) . "%; height: 30px;";
                      $width_1 = "width:" . (int)($learned_1[$s['level']] / $s['total'] * 100) . "%; height: 30px;";
                      $width_0 = "width:" . (int)($learned_0[$s['level']] / $s['total'] * 100) . "%; height: 30px;";
                      $width_unlearned = "width:" . (int)($unlearned[$s['level']] / $s['total'] * 100) . "%; height: 30px;";
                    @endphp

                    <div class="progress-bar grey lighten-1"  role="progressbar" style="{{$width_unlearned}}" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">{{$unlearned[$s['level']]}}</div>
                    <div class="progress-bar pink lighten-2"  role="progressbar" style="{{$width_0}}" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">{{$learned_0[$s['level']]}}</div> 
                    <div class="progress-bar red lighten-2"   role="progressbar" style="{{$width_1}}" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">{{$learned_1[$s['level']]}}</div>                    
                    <div class="progress-bar deep-orange lighten-2" role="progressbar" style="{{$width_2}}" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">{{$learned_2[$s['level']]}}</div>
                    <div class="progress-bar orange lighten-2" role="progressbar" style="{{$width_3}}" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">{{$learned_3[$s['level']]}}</div>                    

                  </div>
                  <div>未習：　{{$unlearned[$s['level']]}}語</div>  
                  <div>いいえ：　{{$learned_0[$s['level']]}}語</div>
                  <div>びみょ～：　{{$learned_1[$s['level']]}}語</div>
                  <div>覚えた!：　{{$learned_2[$s['level']]}}語</div>                                  
                  <div>余裕♪：　{{$learned_3[$s['level']]}}語</div>                  
                  <hr>                  
                  <div>合計：　{{$s['total']}}語</div>
                  <div>進捗率：　{{$progress[$s['level']]}}&#037;</div>                  

                </div>
                <!-- <div class="modal-footer" style="height:50px">

                  <button type="button" class="btn btn-info btn-sm" data-dismiss="modal">Close</button>
                </div> -->
              </div>
            </div>
          </div>

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


    <div class="card mt-3">
      <div class="card-body">
        学習予定  <br>    
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
            <div class="graph" style=" height:150x; width:350px; border:1px solid #F0F0F0; position:relative; margin-top:13px;">
              <hr style="top: 25px; border: none;  position: absolute;  width: 100%;  height: 1px;  margin: 0 auto;  background: #F0F0F0;">
              <hr style="top: 50px; border: none;  position: absolute;  width: 100%;  height: 1px;  margin: 0 auto;  background: #F0F0F0;">
              <hr style="top: 75px; border: none;  position: absolute;  width: 100%;  height: 1px;  margin: 0 auto;  background: #F0F0F0;">
              <hr style="top: 100px;border: none;  position: absolute;  width: 100%;  height: 1px;  margin: 0 auto;  background: #F0F0F0;">
              <hr style="top: 125px;border: none;  position: absolute;  width: 100%;  height: 1px;  margin: 0 auto;  background: #F0F0F0;">
              <hr style="top: 150px;border: none;  position: absolute;  width: 100%;  height: 1px;  margin: 0 auto;  background: #F0F0F0;">

              
              <div class="bar pink lighten-3" style="height: {{$ready_total/4}}px; margin-top: {{150-$ready_total/4}}px; float: left;  text-align: center;  position: relative;  margin-left: 5px;  width: 15px;  background-color: #006400;"></div>
              @for($i=1;$i<=15;$i++)
                <div class="bar pink lighten-3" style="height: {{$schedule[$i]/4}}px; margin-top: {{150-$schedule[$i]/4}}px; float: left;  text-align: center;  position: relative;  margin-left: 5px;  width: 15px;  background-color: #006400;" ></div>
              @endfor
            </div>
            <div class="label-horizontal"style="display: flex;">
              <div class="label" style="font-size: 12px;  margin-left: 5px;  width: 15px;  text-align: center;  padding-top: 6px;">現在</div>
              @for($i=1;$i<=15;$i++)
                <div class="label" style="font-size: 12px;  margin-left: 5px;  width: 15px;  text-align: center;  padding-top: 6px;">{{$i}}</div>
              @endfor
              <div class="label" style="font-size: 12px;  margin-left: 5px;  width: 40px;  text-align: center;  padding-top: 6px;">[日後]</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card mt-3">
      <div class="card-body">
        学習実績  <br>    
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
            <div class="graph" style=" height:150x; width:350px; border:1px solid #F0F0F0; position:relative; margin-top:13px;">
              <hr style="top: 25px; border: none;  position: absolute;  width: 100%;  height: 1px;  margin: 0 auto;  background: #F0F0F0;">
              <hr style="top: 50px; border: none;  position: absolute;  width: 100%;  height: 1px;  margin: 0 auto;  background: #F0F0F0;">
              <hr style="top: 75px; border: none;  position: absolute;  width: 100%;  height: 1px;  margin: 0 auto;  background: #F0F0F0;">
              <hr style="top: 100px;border: none;  position: absolute;  width: 100%;  height: 1px;  margin: 0 auto;  background: #F0F0F0;">
              <hr style="top: 125px;border: none;  position: absolute;  width: 100%;  height: 1px;  margin: 0 auto;  background: #F0F0F0;">
              <hr style="top: 150px;border: none;  position: absolute;  width: 100%;  height: 1px;  margin: 0 auto;  background: #F0F0F0;">

              
              <div class="bar pink lighten-3" style="height: {{$ready_total/4}}px; margin-top: {{150-$ready_total/4}}px; float: left;  text-align: center;  position: relative;  margin-left: 5px;  width: 15px;  background-color: #006400;"></div>
              @for($i=1;$i<=15;$i++)
                <div class="bar pink lighten-3" style="height: {{$schedule[$i]/4}}px; margin-top: {{150-$schedule[$i]/4}}px; float: left;  text-align: center;  position: relative;  margin-left: 5px;  width: 15px;  background-color: #006400;" ></div>
              @endfor
            </div>
            <div class="label-horizontal"style="display: flex;">
              <div class="label" style="font-size: 12px;  margin-left: 5px;  width: 15px;  text-align: center;  padding-top: 6px;">現在</div>
              @for($i=1;$i<=15;$i++)
                <div class="label" style="font-size: 12px;  margin-left: 5px;  width: 15px;  text-align: center;  padding-top: 6px;">{{$i}}</div>
              @endfor
              <div class="label" style="font-size: 12px;  margin-left: 5px;  width: 40px;  text-align: center;  padding-top: 6px;">[日後]</div>
            </div>
          </div>
        </div>
      </div>
    </div>    
  </div>

@endsection
