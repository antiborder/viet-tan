@extends('app')

@section('title', 'タグ一覧')

@section('content')
  @include('nav')

  <div class="container text-center" style="line-height:200%; ">

    <a href="{{route('export_tags')}}" download="export_tags.csv">タグcsvのダウンロード</a>

    <h4 class="p-1" >タグ一覧</h4>

    <div class="mt-2">
        <table>
            @foreach($tags as $i => $tag)
                <tr>
                    <td>
                        {{$tag->id}}
                    </td>
                    <td>
                        {{$tag->name}}
                    </td>
                    <td>
                        {{$tag->words->count()}}

                    </td>
                </tr>
            @endforeach
        </table>
    </div>

  </div>

  @include('footer')
@endsection

<style>

    table{
        font-size:1.5rem;
    }
    td, th{
        border: 2px solid #ffffff;
        padding-top: 5px;
        padding-bottom: 5px;
    }
    th{
        color: #999999;
    }
    table tr td,th:nth-of-type(1){
        text-align:center;
        font-size:1.1rem;        
    }
    table tr td,th:nth-of-type(2){
        text-align:center;
        font-size:1.1rem;
    }
    table tr td,th:nth-of-type(3){
        text-align:center;
        font-size:1.1rem;        
    }        
    table tr td,th:nth-of-type(4){
        text-align:center;
        font-size:1.1rem;        
    }            

</style>