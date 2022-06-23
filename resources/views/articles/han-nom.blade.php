@extends('app')

@section('title', '漢字表記について')

@section('content')
  @include('nav')
  <div class="container article" style="max-width:800px">

    <div class="card my-3 p-0">    
        <h4 class="p-1 mx-2">漢字表記について　<span class="text-nowrap" style="font-size:0.8rem"></span></h4>        
        <h5 class="p-1 mx-2">ベトナムでは漢字が使われていた　<span class="text-nowrap" style="font-size:0.8rem"></span></h5>
        <p class="px-1 mx-2">
            ベトナムでは昔、漢字が使われていました。例えば、今ではベトナムのことを「Việt Nam」と書きますが、昔は「越南」と書いていました。<br>
            アルファベットを用いた表記は1600年代にフランス人が考案したもので、それ以前は漢字の表記でした。
        </p>

        <h5 class="p-1 mx-2">漢字を利用して学習効率を上げよう　<span class="text-nowrap" style="font-size:0.8rem"></span></h5>
        <p class="px-1 mx-2">
            ベトナムで使われていた漢字はざっくり二つに分けることができます。
        </p>            
        <p class="px-1 mx-2">        
            片方は中国から伝わったもの（Chữ Hán：𡨸漢）で、辞書に載っている単語の70% 以上とも言われています。具体例としては、chú ý（注意）や thiên nhiên（天然）などが挙げられます。<br>
            日本人に馴染みがあるのはこちらです。ですからベトナム語の学習に漢字を利用しない手はありません。漢越語と呼ばれているのもこちらです。<br>
            下に具体例を載せておきます。御覧の通り、日本語に近い単語が多いのです。<br>
            （表内の単語をクリックすると詳細が開きます。）
            
            <table cellpadding="3" bgcolor="#e3f2fd" align="center" class="my-1" border="1" style="border-collapse:collapse; ; font-family: 'Kosugi Maru', sans-serif; max-width:500px; font-size:150%; margin:auto">
                <thead>
                    <tr>
                    <th>アルファベット表記</th><th>漢字表記</th><th>意味</th>
                    </tr>
                </thead>
                <tr>
                    <td><a href="/words/10376" class="yellow lighten-3 text-dark rounded p-1">chú ý</a></td><td>注意</td><td>注意する</td>
                </tr>
                <tr>
                    <td><a href="/words/11818" class="yellow lighten-3 text-dark rounded p-1">thiên nhiên</a></td><td>天然</td><td>天然の</td>
                </tr>
                <tr>
                    <td><a href="/words/10643" class="yellow lighten-3 text-dark rounded p-1">động vật</a></td><td>動物</td><td>動物</td>
                </tr>
                <tr>
                    <td><a href="/words/9969" class="yellow lighten-3 text-dark rounded p-1">yêu cầu</a></td><td>要求</td><td>要求する</td>
                </tr>
                <tr>
                    <td><a href="/words/10698" class="yellow lighten-3 text-dark rounded p-1">bảo quản</a></td><td>保管</td><td>保管する</td>
                </tr>                                                
            </table>                    
        </p>
        


        <p class="px-1 mx-2">              
            もう一方は、ベトナム独自のもの（Chữ Nôm：𡨸喃）です。当サイトではこちらについても一部を表示しています。ベトナム語の学習に役立つ可能性があるためです。<small>（こちらは狭義の漢字には含まれませんが、上ではまとめて漢字としています。ちなみにChữ HánとChữ NômをまとめてHán Nômと呼びます。）</small>
        </p>

        <h5 class="p-1 mx-2">わかりやすい字体　<span class="text-nowrap" style="font-size:0.8rem"></span></h5>
        <p class="px-1 mx-2">
            当サイトではベトナム語の学習効率を上げるために漢字表記を使用しているため、昔使われていた字体と一致しない表記もあります。<br>
            例えば「台湾」の「台」は、昔は「臺」と書かれていました。現代の台湾で使われている繁体字でも「臺」です。これに対し、現代の日本語や中国の簡体字での表記は「台」です。「臺」という字を見てすぐにピンとくる日本人は少ないと思います。<br>
            このような場合に当サイトでは、「台」の方で表記しています。また、表記については主に<a class="text-muted" href="https://en.wiktionary.org/wiki/Wiktionary:Main_Page">Wikitionary(英語版)</a>などを参考にしています。
        </p>
    </div>          
    
    @include('ads.horizontal')

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