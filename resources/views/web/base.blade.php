<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <meta property="fb:app_id" content="{{ env('FACEBOOK_APP_ID') }}" />

    @section('pagemeta')
        <title>Dapur Keju Prochiz</title>
    @show

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Dancing+Script:400,700" rel="stylesheet">
    <link href="{{ mix('/assets/web/css/vegas.css') }}" rel="stylesheet">

    @section('styles')
    @show

    <link href="{{ mix('/assets/web/css/app.css') }}" rel="stylesheet">
    <style type="text/css">
        .lang-icon, .dropdown.menu a.lang-icon{
            padding: 0;
            display: inline;
        }
        .lang-icon img{
            width: 30px;
        }
    </style>

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    @if (config('app.env') === 'production')
        <!-- Global site tag (gtag.js) - Google Ads: 739538052 -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=AW-739538052"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'AW-739538052');
        </script>

        <!-- Event snippet for Smart Goal (All Web Site Data) conversion page -->
        <script>
          gtag('event', 'conversion', {'send_to': 'AW-739538052/AX3nCOPe86IBEITp0eAC'});
        </script>

        <!-- Google Analytics-->
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-99638870-2', 'auto');
          ga('send', 'pageview');
        </script>
        <!-- End Google Analytics-->

        <!-- Facebook Pixel Code -->
        <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window,document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
         fbq('init', '682567121933823'); 
        fbq('track', 'PageView');
        </script>
        <noscript>
         <img height="1" width="1" 
        src="https://www.facebook.com/tr?id=682567121933823&ev=PageView
        &noscript=1"/>
        </noscript>
        <!-- End Facebook Pixel Code -->

        <!-- Hotjar Tracking Code for https://www.dapurkejuprochiz.com -->
        <script>
            (function(h,o,t,j,a,r){
                h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
                h._hjSettings={hjid:598724,hjsv:5};
                a=o.getElementsByTagName('head')[0];
                r=o.createElement('script');r.async=1;
                r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
                a.appendChild(r);
            })(window,document,'//static.hotjar.com/c/hotjar-','.js?sv=');
        </script>
        <!-- End Hotjar Tracking Code -->
    @endif
</head>
<body>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.11&appId={{ env("FACEBOOK_APP_ID") }}';
    fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

    <script>window.twttr = (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0],
        t = window.twttr || {};
    if (d.getElementById(id)) return t;
    js = d.createElement(s);
    js.id = id;
    js.src = "https://platform.twitter.com/widgets.js";
    fjs.parentNode.insertBefore(js, fjs);

    t._e = [];
    t.ready = function(f) {
        t._e.push(f);
    };

    return t;
    }(document, "script", "twitter-wjs"));</script>

    <header>
        <a href="{{ url('/') }}" class="logo"><img src="{{ asset('assets/web/img/logo.png') }}"></a>

        <div class="title-bar row" data-responsive-toggle="main-menu" data-hide-for="large">
            <div class="small-6 column">
                <button class="menu-icon" type="button" data-toggle="main-menu"></button>
            </div>
            {{-- 
            <div class="small-6 column text-right">
                <a href="{{ url("/upload-resep") }}" class="cta">UPLOAD RESEP</a>
            </div> --}}
        </div>

        <div class="top-bar" id="main-menu">
            <div class="top-bar-left">
                <?php $currents = (isset($currents)) ? $currents : []; ?>
                <ul class="dropdown menu navi" data-dropdown-menu>
                    <li class="{{ Frontend::menu_active('home', $currents) }}">
                        <a href="{{ url('/') }}">HOME</a>
                    </li>
                    <li class="{{ Frontend::menu_active('resep', $currents) }}">
                        <a href="#">RECIPES</a>

                        <ul>
                            <li class="{{ Frontend::menu_active('prochiz', $currents) }}"><a href="{{ url('/resep/prochiz') }}">PROCHIZ RECIPE</a></li>
                            <li class="{{ Frontend::menu_active('prochizlover', $currents) }}"><a href="{{ url('/resep/prochizlover') }}">PROCHIZLOVERS RECIPE</a></li>
                        </ul>
                    </li>
                    <li class="{{ Frontend::menu_active('kuliner-all', $currents) }}">
                        <a href="#">CULINARY</a>

                        <ul>
                            <li class="{{ Frontend::menu_active('kuliner', $currents) }}"><a href="{{ url('/kuliner') }}">PROCHIZ CULINARY</a></li>
                            {{-- <li class="{{ Frontend::menu_active('partner', $currents) }}"><a href="{{ url('/partner') }}">PARTNER REGISTRATION</a></li> --}}
                        </ul>
                    </li>
                    <li class="{{ Frontend::menu_active('produk', $currents) }}">
                        <a href="{{ url('/produk') }}">PRODUCTS</a>
                    </li>
                    <li class="{{ Frontend::menu_active('artikel', $currents) }}">
                        <a href="#">ARTICLE</a>

                        <ul>
                            <li class="{{ Frontend::menu_active('news', $currents) }}">
                                <a href="{{ url('/news') }}">NEWS</a>
                            </li>
                            <li class="{{ Frontend::menu_active('tips', $currents) }}">
                                <a href="{{ url('/tips') }}">TIPS</a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ Frontend::menu_active('video', $currents) }}">
                        <a href="{{ url('/video') }}">VIDEO</a>
                    </li>
                </ul>
            </div>
            <div class="top-bar-right">
                <ul class="dropdown menu" data-dropdown-menu>
                    <li class="">
                        <?php 
                            $base = 'https://dapurkejuprochiz.com/';
                        ?>
                        <span style="font-size: .75em; font-weight: bold;">CHOOSE LANGUAGE : </span>
                        <a class="lang-icon" href="{{ $base }}"><img src="{{ asset('indonesia.png') }}"></a>
                        <a class="lang-icon" href="{{ $base.'en/' }}"><img src="{{ asset('uk.png') }}"></a>
                    </li>
                    <li class="">
                        <form action="{{ url('/search') }}" method="get">
                            <input class="search-input" type="text" name="s" placeholder="Find Recipe">
                            <button><img class="search-icon" src="{{ asset('assets/web/img/search-icon.png') }}"></button>
                        </form>
                    </li>

                    {{-- <li><a href="{{ url("/upload-resep") }}" class="cta">UPLOAD RECIPE</a></li> --}}

                    @if (Auth::guest())
                        {{-- <li class=""><a href="{{ url('/login') }}" class="login">LOGIN</a></li> --}}
                    @else
                        <li class="profile-pic">
                            <a href="#" class="img-box">
                                @if (Auth::user()->image)
                                    <img src="{{ asset('storage/users/square/'.Auth::user()->image) }}">
                                @else
                                    <img src="{{ asset('assets/web/img/default.jpg') }}">
                                @endif

                                <span class="hide-for-large">&nbsp;&nbsp;{{ Auth::user()->name }}</span>
                            </a>
                            <ul>
                                <li><a href="{{ url('/my-account') }}">PROFILE</a></li>
                                <li><a href="{{ url('/my-account/password') }}">CHANGE PASSWORD</a></li>
                                <li><a href="{{ url('/my-account/resep') }}">MY RECIPE</a></li>
                                <li><a href="{{ url('/logout') }}">LOGOUT</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </header>

    @yield('content')

    <footer>
        @if (isset($footer_text))
            @if (in_array('resep', $currents) || in_array('produk', $currents))
                <hr>
                <div class="spacer"></div>
            @endif

            <div class="row footer-text">
                <div class="medium-12 column">
                    <h2 class="footer-text__title text-center">{{ $footer_text->title }}</h2>
                    <div class="footer-text__content">
                        {!! $footer_text->content !!}
                    </div>
                </div>
            </div>

            <div class="spacer"></div>
        @endif

        <hr>

        <div class="spacer"></div>

        <div class="row align-middle">
            <div class="small-12 medium-4 column small-text-center">
                <ul class="no-bullet">
                    <li>
                        <div class="img-box show-for-large">
                            <img class="ver-icon" src="{{ asset('assets/web/img/mappin-icon.png') }}">
                        </div>
                        <div class="text-box">
                            <p>
                            PT.Mulia Boga Raya Tbk<br>
                            <strong>Marketing Office</strong><br>
                            Jl.Tubagus Angke Raya<br>
                            Ruko Angke Square blok A/8<br>
                            Jakarta Barat 11460, Indonesia
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="img-box show-for-large">
                            <img class="hor-icon" src="{{ asset('assets/web/img/tele-icon.png') }}">
                        </div>
                        <div class="text-box">
                            <h4 class="no-tel">
                                <a href="tel:+622156943299">+6221 56943299</a>
                            </h4>
                        </div>
                    </li>
                    <li>
                        <div class="img-box show-for-large">
                            <img class="hor-icon" src="{{ asset('assets/web/img/envelope-icon.png') }}">
                        </div>
                        <div class="text-box">
                            customer.care@prochiz.co.id
                        </div>
                    </li>
                    <li class="hide-for-medium"><a href="{{ url('/page/daftar-alamat-distributor') }}">Distributor List</a></li>
                </ul>
            </div>
            <div class="small-12 medium-4 column text-center">
                <a class="foot-logo" href="{{ url('/') }}"><img src="{{ asset('assets/web/img/logo.png') }}"></a>
                <span class="footer-copyright">
                    &copy; 2017 PROCHIZ Taste Better. All Rights Reserved. <br> 
                    <span class="show-for-medium">
                        <a href="{{ url('/page/daftar-alamat-distributor') }}">Distributor List</a>
                        &nbsp;|&nbsp;
                    </span>
                    <a href="{{ url('/page/syarat-ketentuan') }}">Terms &amp; Conditons</a><br>
                    <a href="{{ url('/page/privacy-policy') }}">Privacy Policy</a>
                </span>
            </div>
            <div class="small-12 medium-4 column">
                <ul class="menu small-text-center medium-text-right">
                    <li><a href="https://www.facebook.com/kreasikejuprochiz"><img src="{{ asset('assets/web/img/fb-icon.png') }}"></a></li>
                    <li><a href="https://twitter.com/kejuPROCHIZ"><img src="{{ asset('assets/web/img/tw-icon.png') }}"></a></li>
                    <li><a href="https://www.instagram.com/keju_prochiz/"><img src="{{ asset('assets/web/img/ig-icon.png') }}"></a></li>
                </ul>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ mix('/assets/web/js/jquery.min.js') }}"></script>
    <script src="{{ mix('/assets/web/js/what-input.min.js') }}"></script>
    <script src="{{ mix('/assets/web/js/foundation.min.js') }}"></script>
    <script src="{{ mix('/assets/web/js/infinite-scroll.js') }}"></script>
    <script src="{{ mix('/assets/web/js/app.js') }}"></script>

    @section('scripts')
    @show

    @if (config('app.env') === 'production')
        <!-- Google Code for Remarketing Tag -->
        <!-- 
        Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. See more information and instructions on how to setup the tag on: http://google.com/ads/remarketingsetup 
        -->
        <script type="text/javascript">
        /* <![CDATA[ */
        var google_conversion_id = 859625669;
        var google_custom_params = window.google_tag_params;
        var google_remarketing_only = true;
        /* ]]> */
        </script>
        <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
        </script>
        <noscript>
        <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/859625669/?guid=ON&amp;script=0"/>
        </div>
        </noscript>
    @endif
</body>
</html>
