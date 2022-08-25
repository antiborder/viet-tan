<footer id="footer" class="card">

    <div class="footer-container d-sm-flex flex-row">
        <div class="footer-block1">
            <a href="{{route('index')}}">

                <strong >
                    <h5 class="footer-logo1">べとらん</h5>
                    <div class="footer-logo2">Viet Learn</div>
                </strong>

            </a>
        </div>
        <div class="footer-block2">
            <a href="{{route('learn')}}" class="text-white">単語学習</a><br>
            <a href="{{route('measure')}}" class="text-white">単語力測定</a><br>
            <a href="{{route('words.search')}}" class="text-white">あいまい検索</a><br>
            <a href="{{route('tags.categories')}}" class="text-white">タグから探す</a>
        </div>
        <div class="footer-block3">
            @auth
                <span><a class="text-white" href="{{ route('users.show', ['name'=>Auth::user()->name]) }}">学習状況</a></span><br>
            @endauth
            @guest
                <span data-toggle="modal" data-target="#recommend-trial"><a class="text-white">学習状況</a></span><br>
            @endguest
            <a href="{{route('articles.level-table')}}" class="text-white">単語レベル一覧</a><br>
            <span data-toggle="modal" data-target="#contact"><a class="text-white">ご意見・お問い合せ</a></span><br>
        </div>
    </div>
    <div class="footer-bottom">
        <a href="{{route('index')}}" class="text-muted small" >
            vietnamese-learn.net
        </a>&nbsp;&nbsp;
        <a href="{{route('privacy-policy')}}" class="text-muted small">privacy policy</a>
    </div>

</footer>
