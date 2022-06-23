@extends('app')

@section('title', '単語レベル一覧')

@section('content')
  @include('nav')
  <div class="container article" style="max-width:800px">
    <div class="card my-3 p-0">
        <h4 class="p-1 m-2"><span class="">べとらん</span><small>の</small>単語レベル一覧</h5>


            <table cellpadding="3" class="m-3" border="1" style="border-collapse:collapse; border: 1px solid #ffa726; font-family: 'Kosugi Maru', sans-serif; max-width:500px; font-size:150%">
                <thead>
                    <tr>
                    <th></th><th>レベル</th><th>単語数</th><th>小計</th>
                    
                    </tr>
                </thead>
                <tr>
                    <td rowspan='2'>入門</td><td>1</td><td >～100語</td><td rowspan='2'>300語</td>
                </tr>
                <tr>
                    <td>2</td><td>～300語</td>
                </tr>            
                <tr>
                <td rowspan='5'>初級</td><td>3</td><td>～500語</td><td rowspan='5'>1300語</td>
                </tr>                        
                <tr>
                    <td>4</td><td>～700語</td>
                </tr>            
                <tr>
                    <td>5</td><td>～1000語</td>
                </tr>                        
                <tr>
                    <td>6</td><td>～1300語</td>
                </tr>                        
                <tr>
                    <td>7</td><td>～1600語</td>
                </tr>                                                
                    <td rowspan='5'>中級</td><td>8</td><td>～2000語</td><td rowspan='5'>2400語</td>
                </tr>                        
                <tr>
                    <td>9</td><td>～2500語</td>
                </tr>            
                <tr>
                    <td>10</td><td>～3000語</td>
                </tr>                        
                <tr>
                    <td>11</td><td>～3500語</td>
                </tr>                        
                <tr>
                    <td>12</td><td>～4000語</td>
                </tr>            
                </tr>                                                
                    <td rowspan='2'>上級</td><td>13</td><td>～4500語</td><td rowspan='2'>1000語</td>
                </tr>                        
                <tr>
                    <td>14</td><td>～5000語</td>
                </tr>            
            </table>

    </div>

    @include('ads.horizontal')

    <div class="card my-3 p-0">
        <h5 class="p-1 m-2">入門レベル　<span class="text-nowrap" style="font-size:0.8rem">―基礎となる300語―</span></h5>
        <p class="px-1 mx-2">            
            頻繁に出会う単語なのでここからはじめると良いでしょう。<br>
            少し話せるだけでもベトナム人の方からの印象は変わってきます。<br>
            ベトナムに行く方だけでなく、ベトナム人とちょっと話してみたいという方にもおすすめです。
        </p>

        <h5 class="p-1 m-2">初級レベル　<span class="text-nowrap" style="font-size:0.8rem">―最低限知っておきたい1300語―</span></h5>
        <p class="px-1 mx-2">
            広告、通知、注意書き等の簡単な文はだいぶ読めるようになってきます。<br>
            ここまでの単語を初級文法で組み合わせるだけでもかなり多様なアウトプットが可能ですので、このレベルが咄嗟に出てくるかどうかで対応力に差が出ます。まずはここを目標にしてみるのも良いでしょう。<br>
            仕事等でよく使う単語があれば、初級語彙に加えて別途優先的に学んでおくのがおすすめです。既習の1600語と組み合わせることで、自由度が大きく上がるためです。
        </p>


        <h5 class="p-1 m-2">中級レベル　<span class="text-nowrap" style="font-size:0.8rem">―きっと役立つ2400語―</span></h5>
        <p class="px-1 mx-2">
            日常会話だけでなく、学校、職場等様々な場面で幅広い話題に対応できることでしょう。ニュースによく使われる単語が増え、専門的な言葉も混ざってきます。<br>
            学んだ単語をベトナム人とのコミュニケーション等で積極的に運用することで、使える単語を増やしていきましょう。
        </p>

        <h5 class="p-1 m-2">上級レベル　<span class="text-nowrap" style="font-size:0.8rem">―さらに上を目指す方へ―</span></h5>
        <p class="px-1 mx-2">
            中級まで終えてもまだ足りないと感じる方が多いことでしょう。<br>
            必ず使うとは言い難いものの、できれば覚えておきたい単語を上級レベルに揃えています。<br>
            また、さらにお役にたてるよう、単語データベースを随時更新・拡充しています。
        </p>
    </div>
  </div>


  @include('footer')
@endsection

<style>

    .article h5{
        border-bottom: 1px solid #ffa726;
        border-left: 4px solid #ffa726;

    }
        
    table{
        font-size:1.5rem;
    }
    td, th{
        border: 2px solid #ffa726;
        padding-top: 5px;
        padding-bottom: 5px;
    }
    th{
        color: #ffa726;
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