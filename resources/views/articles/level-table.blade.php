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

        <p class="px-1 mx-2">            
            当サイトでは、学習者の指針となるよう、ベトナム語の単語を優先順に層別しています。<br>
        </p>
        <p class="px-1 mx-2">                                
            学習を始めたばかりの方でも、とりあえず<a href="{{route('learn')}}">単語学習</a>でレベル1から順番に覚えていけば、基礎を固めながら力を伸ばすことができるでしょう。様々な資料から分野の偏りなく、実際に使われている言葉が選ばれているためです。<br>
        </p>
        <p class="px-1 mx-2">                    
            とはいえ、必要な語彙というのは人によって異なるものですから、好きな言葉などが他にあれば、そちらを優先するのがよいでしょう。また、仕事や趣味でよく使う単語から覚えるのも効率的です。<br>
            それと並行して当サイトの<a href="{{route('learn')}}">単語学習</a>も進めていけば、基礎を固めつつ実用的な語彙を構築することができるでしょう。
        </p>

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
            簡単な文（広告、通知、注意書き等を含む）はだいぶ読めるようになってきます。<br>
            ここまでの単語を初級文法で組み合わせるだけでもかなり多様なアウトプットが可能ですので、このレベルが咄嗟に出てくるかどうかで対応力に差が出ます。<br>
            このレベルの外国人は意外と少ないので、初対面のベトナム人からは驚かれるはずです。まずはここを目標としてみるのも良いでしょう。<br>
            仕事等でよく使う単語があれば、初級語彙に加えて別途学んでおくのがおすすめです。初級までの既習語1600語と実用的な語彙を組み合わせることで、自由度が大きく上がるためです。
        </p>


        <h5 class="p-1 m-2">中級レベル　<span class="text-nowrap" style="font-size:0.8rem">―きっと役立つ2400語―</span></h5>
        <p class="px-1 mx-2">
            日常会話だけでなく、学校、職場等様々な場面で幅広い話題に対応できることでしょう。ニュースによく使われる単語が増え、専門的な言葉も少し混ざってきます。<br>
            ここまで来ると、見慣れない単語に対しても勘が働いて意味を推測できるようになっています。この分を含めれば、わかる単語数はさらに多いといえます。<br>
            単語の知識だけでなく運用能力を身に着けることで、できることが広がります。学んだ単語をベトナム人とのコミュニケーション等を通して積極的に運用することで、使える単語を増やしていきましょう。
        </p>

        <h5 class="p-1 m-2">上級レベル　<span class="text-nowrap" style="font-size:0.8rem">―さらに上を目指す方へ―</span></h5>
        <p class="px-1 mx-2">
            中級まで終えてもまだ足りないと感じる方が多いことでしょう。<br>
            上級レベルには、必ず使うとは言い難いもののできれば覚えておきたい単語を揃えています。<br>
            中級までをしっかり身に着けた後ならば、上級に進むことでさらに力を伸ばすことができます。<br>
            さらにお役にたてるよう、べとらんの単語データベースは随時更新・拡充しています。
        </p>
    </div>
  </div>


  @include('footer')
@endsection

<style>

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