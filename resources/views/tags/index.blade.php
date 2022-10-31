@extends('app')

@section('title', 'タグ一覧')

@section('content')
  @include('nav')

  <div class="container text-center" style="line-height:200%; ">

    <form action="{{ route('tags.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mt-4 form-group">
            <input type="file" name="file" style="min-width:300px">
            <br>
            <button class="btn btn-success">import</button>
        </div>
    </form>

    <a href="{{route('export_tags')}}" download="export_tags.csv">タグcsvのダウンロード</a>

    <h4 class="p-1" >タグ一覧</h4>

    <div class="mt-2">
        <table>
            <thead>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>number</th>
                    <th>keywords</th>
                    <th>words</th>
                </tr>
            </thead>
            @foreach($tags as $i => $tag)
                <tr>
                    <td>
                        {{$tag->id}}
                    </td>
                    <td>
                        <a href="{{route('tags.edit',$tag->name)}}">
                            {{$tag->name}}
                        </a>
                    </td>
                    <td>
                        {{$tag->words->count()}}
                    </td>
                    <td>
                        {{$tag->keywords}}
                    </td>
                    <td>
                        {{$tag->words->first()['name']}}
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