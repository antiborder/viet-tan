@extends('app')

@section('title', 'ベトナム語の漢字')
@section('twitter_card')
  <meta name="twitter:card" content="summary" />
  <meta name="twitter:site" content="@viet_learn" />
  <meta name="twitter:title" content="ベトナム語の『漢字』" />
  <meta name="twitter:description" content="ベトナム語を学ぶ上で最低限知っておきたい背景知識をまとめました。漢字の知識を効率的に活用しましょう。" />
  <meta name="twitter:image" content="https://vietnamese-learn.net/image/twitter-card.png" />
@endsection

@section('content')
  @include('nav')
  <div class="container article" style="max-width:800px">
    <div class="card my-3 p-0">    
        <h4 class="p-1 mx-2 mt-3 mb-3">ベトナム語の『漢字』</h4>        
        <p class="px-1 mx-2">
            日本人がベトナム語を学ぶ場合、漢字の知識を活かしたほうがお得です。このページではベトナム語を学ぶ上で知っておきたいことをを短くまとめました。
        </p>

        <h5 class="p-1 mx-2 mt-3">ベトナムでは漢字が使われていた　<span class="text-nowrap" style="font-size:0.8rem"></span></h5>
        <p class="px-1 mx-2 mt-3">
            ベトナムでは昔、漢字が使われていました。例えば、今ではベトナムのことを「Việt Nam」と書きますが、昔は「<span class="kanji-text">越南</span>」と書いていました。<br>
            アルファベットを用いた表記は1600年代にフランス人が考案したもので、それ以前は漢字の表記でした。
        </p>
        <div class="text-center">
          <img class="pl-1 mb-2 wide-image" src="/image/han-nom1.webp">
        </div>          

        <h5 class="p-1 mx-2 mt-3 nb-3">漢字を利用して学習効率を上げよう　<span class="text-nowrap" style="font-size:0.8rem"></span></h5>
        <p class="px-1 mx-2">
            ベトナムで使われていた漢字はざっくり二つに分けることができます。
        </p>            
        <p class="px-1 mx-2" >        
            一方は中国から伝わったもの（Chữ Hán：<span class="kanji-text">𡨸漢</span>）で、辞書に載っている単語の70% 以上とも言われています。具体例としては、chú ý（注意）や thiên nhiên（天然）などが挙げられます。<br>
            日本人に馴染みがあるのはこちらです。ですからベトナム語の学習に漢字を利用しない手はありません。漢越語と呼ばれているのもこちらです。<br>
            下に具体例を載せておきます。御覧の通り、日本語に近い単語が多いのです。<br>
            漢字の活用によるメリットは学習を進めると実感できるようになり、その恩恵は強力です。慣れてくれば、初めて見る単語の意味を推測できることも増えるでしょう。
        <p class="px-1 mx-2 mt-1 mb-0 pb-0 text-muted text-center">
            表内の単語をクリックすると詳細が開きます。
        </p>                        
            
            <table cellpadding="3" bgcolor="#e3f2fd" align="center" class="my-1" border="1" style="border-collapse:collapse; ; font-family: 'Kosugi Maru', sans-serif; max-width:500px; font-size:150%; margin:auto">
                <thead>
                    <tr>
                    <th>アルファベット表記</th><th>漢字表記</th><th>意味</th>
                    </tr>
                </thead>
                <tr>
                    <td><a href="/word-name/chú ý" class="yellow lighten-3 text-dark rounded p-1">chú ý</a></td><td>注意</td><td>注意する</td>
                </tr>
                <tr>
                    <td><a href="/word-name/thiên nhiên" class="yellow lighten-3 text-dark rounded p-1">thiên nhiên</a></td><td>天然</td><td>天然の</td>
                </tr>
                <tr>
                    <td><a href="/word-name/động vật" class="yellow lighten-3 text-dark rounded p-1">động vật</a></td><td>動物</td><td>動物</td>
                </tr>
                <tr>
                    <td><a href="/word-name/yêu cầu" class="yellow lighten-3 text-dark rounded p-1">yêu cầu</a></td><td>要求</td><td>要求する</td>
                </tr>
                <tr>
                    <td><a href="/word-name/bảo quản" class="yellow lighten-3 text-dark rounded p-1">bảo quản</a></td><td>保管</td><td>保管する</td>
                </tr>                                                
            </table>                    
        </p>
        


        <p class="px-1 mx-2">              
            もう一方は、ベトナム独自のもの（Chữ Nôm：<span class="kanji-text">𡨸喃</spam>）です。当サイトではこちらについても一部を表示しています。ベトナム語の学習に役立つ可能性があるためです。<small>（こちらは狭義の漢字には含まれませんが、上ではまとめて漢字としています。）</small>
        </p>

        <h5 class="p-1 mx-2 mt-3 mb-3">わかりやすい字体　<span class="text-nowrap" style="font-size:0.8rem"></span></h5>
        <p class="px-1 mx-2">
            ベトナムで昔使われていた漢字には、現在日本で使われている漢字と字体が一致しないものも多く存在します。異体字にはよく似ているものもありますし、大きく違うものもあります。<br>
        </p>            
        <p class="px-1 mx-2">
            当サイトではベトナム語の学習効率を上げるために漢字表記を使用しているため、昔使われていた字体と一致しない表記もあります。<br>
            例えば「<span class="kanji-text">台湾</span>（たいわん）」の「<span class="kanji-text">台</span>」は、昔は「<span class="kanji-text">臺</span>」と書かれていたそうです。現代の台湾で使われている繁体字でも「臺」です。これに対し、現代の日本語や中国の簡体字での表記は「<span class="kanji-text">台</span>」です。「<span class="kanji-text">臺</span>」という字を見てすぐにピンとくる日本人は少ないと考えられます。<br>
            このような場合に当サイトでは、なるべく「台」の方で表記しています。また、表記については主に<a class="text-muted" href="https://en.wiktionary.org/wiki/Wiktionary:Main_Page">Wikitionary(英語版)</a>などを参考にしています。
        </p>
        <div class="text-center">
          <img class="pl-1 mb-2 wide-image" src="/image/han-nom2.webp">
        </div>                  
    </div>          
    
    @include('ads.horizontal')

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