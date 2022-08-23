<!DOCTYPE html>
<html lang="ja">
<head>
<!--AdScense-->
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9067426465896411" crossorigin="anonymous"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-229768517-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-229768517-1');
</script>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>
    @yield('title')
  </title>

  @yield('twitter_card')

  <!-- fabicon -->
  <link rel="apple-touch-icon" sizes="180x180" href="./image/apple-touch-icon-180x180.png">
  <link rel="icon" type="image/x-icon" href="./image/favicon.ico">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <!-- Google Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kiwi+Maru:wght@400;500&family=Kosugi+Maru&family=Roboto+Condensed&display=swap" rel="stylesheet">
  <!-- Bootstrap core CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.11/css/mdb.min.css" rel="stylesheet">

  <!-- Style Sheets -->
  <link href="{{ asset('css/style.css?20220823') }}" rel="stylesheet">
  <link href="{{ asset('css/stripe.css') }}" rel="stylesheet">
</head>

<body class="blue-grey lighten-5 normal-text">
  @if (session('flash_message'))
      <div class="flash_message">
          {{ session('flash_message') }}
      </div>
  @endif
  <div id="app" style="position:relative; min-height: 100vh; padding-bottom: 400px; box-sizing: border-box;">
    @yield('content')
  </div>

  <script src="{{ mix('js/app.js') }}"></script>

  <!-- JQuery -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.11/js/mdb.min.js"></script>
  <!-- Vue adsense -->
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9067426465896411"
    crossorigin="anonymous"></script>
</body>

</html>