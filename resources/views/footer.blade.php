<footer class="card mt-3 p-2 rounded-0 black " style="width:100%; position:absolute; bottom:0;">

    <div class="d-sm-flex flex-row" style="margin:0 auto">
        <div class="text-center" style="width:170px">
            <a href="{{route('index')}}" class="">
                
                <strong class="text-warning">
                    <h5 class="mb-0 pb-0">べとらん</h5>
                    <div class="text-muted mt-0 pt-0" style="font-size:0.8rem">Viet Learn</div>
                </strong>
                
            </a>
        </div>
        <div class="p-2 text-center" style="font-size:0.8rem; width:170px;">
            <a href="{{route('learn')}}" class="text-white">単語学習</a><br>
            <a href="{{route('measure')}}" class="text-white">単語力測定</a><br>
            <a href="{{route('words.search')}}" class="text-white">あいまい検索</a><br>
            <a href="{{route('tags.categories')}}" class="text-white">タグから探す</a>      
        </div>    
        <div class="p-2 text-center" style="font-size:0.8rem; width:170px;">
            
            <span data-toggle="modal" data-target="#recommend-trial"><a class="text-white">学習状況</a></span><br>
            <a href="{{route('articles.level-table')}}" class="text-white">単語レベル一覧</a><br>
            <span data-toggle="modal" data-target="#contact"><a class="text-white">ご意見・お問い合せ</a></span><br>
        </div>
    </div>
    <div class="text-center " style="font-size:1.0rem">
        <a href="{{route('index')}}" class="text-muted small" style="width:170px;">
            vietnamese-learn.net
        </a>&nbsp;&nbsp;
        <a href="{{route('privacy-policy')}}" class="text-muted small">privacy policy</a>
    </div>

</footer>
