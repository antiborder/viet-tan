@extends('app')

@section('title', 'user一覧')

@section('content')
  @include('nav')
  <div class="container" style="max-width:800px">
      <div class="card my-3 p-0">    


        <table cellpadding="3" bgcolor="#e3f2fd" align="center" class="my-1" border="1" style="border-collapse:collapse; ; font-family: 'Kosugi Maru', sans-serif; font-size:150%; margin:auto">
            <thead>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>email</th>
                    <th>created_at</th>
                    <th>updated_at</th>
                    <th>latest_learn</th>
                </tr>
            </thead>

            @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->created_at}}</td>                
                <td>{{$user->updated_at}}</td>                
                <td>{{$user->latest_learn}}</td>                
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