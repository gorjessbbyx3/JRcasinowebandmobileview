<!DOCTYPE html>
<!--[if lte IE 8]>
<html class="ie ie8" lang="ru"><![endif]-->
<!--[if lte IE 9]>
<html class="ie ie9" lang="ru"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html class="ie9up" lang="en"><!--<![endif]-->
        <head>

                <meta name="description" content="@yield('description')">
                <meta name="keywords" content="@yield('keywords')" />
                <meta name="csrf-token" content="{{ csrf_token() }}">

                <title>@yield('page-title') - {{ settings('app_name') }}</title>

                <!-- META TAGS -->
    <link rel="shortcut icon" type="image/png" href="/woocasino/images/favicon/spc.png">
    <link rel="icon" type="image/png" href="/woocasino/images/favicon/spc.png">
    <link rel="apple-touch-icon" href="/woocasino/images/favicon/spc-iphone.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/woocasino/images/favicon/spc-ipad.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/woocasino/images/favicon/spc-ipad2.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/woocasino/images/favicon/spc-ipad3.png">

    <meta name="msapplication-TileImage" content="/woocasino/mstile-144x144.png" />

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="HandheldFriendly" content="true"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover"/>

    <!-- PWA / Fullscreen support -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Jade Royale">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#050208">
    <link rel="manifest" href="/manifest.json">


    <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700&amp;subset=cyrillic,cyrillic-ext,latin-ext"
          rel="stylesheet">
    
    <script src="/frontend/Default/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="/woocasino/js/angular.min.js"></script>
    <!--[if lt IE 9]>
    <script src="/woocasino/js/html5shiv.min.js"></script>
    <script src="/woocasino/js/respond.min.js"></script><![endif]-->

    <!-- DEFAULT CSS -->
    <link href="/woocasino/css/reset.css" rel="stylesheet" type="text/css" class="styles"/>
    <!-- Flags -->
    <link rel="stylesheet" href="/woocasino//flag-icon-css/css/flag-icon.min.css">
    <!-- Perfect scrollbar css -->
    <link rel="stylesheet" type="text/css" href="/woocasino/css/perfect-scrollbar.css">
    <!-- zebra datepicker -->
    <link rel="stylesheet" type="text/css" href="/woocasino/css/zebra_datepicker.css">
    <!-- START OF ALL CUSTOM CSS + FONTS -->
    <link href="/woocasino/css/style.css?v={{ time() }}" rel="stylesheet" type="text/css"/>

    <link href="/woocasino/css/regional.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="/woocasino/css/oct7vfe.css">
    <link href="/frontend/Default/css/bonuses.css" rel="stylesheet" type="text/css"/>
    <link href="/woocasino/css/custom-overrides.css" rel="stylesheet" type="text/css"/>
    <link href="/woocasino/css/jade-royale-ui.css" rel="stylesheet" type="text/css"/>
    <link href="/woocasino/css/minimal-layout.css" rel="stylesheet" type="text/css"/>
    <link href="/woocasino/css/netflix-carousel.css" rel="stylesheet" type="text/css"/>
    <link href="/woocasino/css/desktop-redesign.css" rel="stylesheet" type="text/css"/>
    <link href="/woocasino/css/premium-chinese-ui.css?v=20260512m" rel="stylesheet" type="text/css"/>

    <!-- DEFAULT JS SCRIPTS -->
    <!--[if lt IE 9]>
    <script src="/woocasino/js/html5-shiv.js" type="text/javascript"></script>
    <![endif]-->
        </head>
<body class="en" ng-app="app" ng-controller="gameCtrl">

{{-- ═══════════════════════════════════════════════════════════════════
     INTRO VIDEO OVERLAY — plays once per browser session on first land.
     When the video ends (or user skips), the overlay fades away and,
     if the visitor is a guest, the login modal opens automatically.
   ═══════════════════════════════════════════════════════════════════ --}}
<div id="jrIntroOverlay" class="jr-intro-overlay" aria-hidden="true">
    <video id="jrIntroVideo" class="jr-intro-overlay__video"
           src="/woocasino/video/intro.mp4"
           playsinline webkit-playsinline muted autoplay preload="auto"></video>
    <button type="button" id="jrIntroSkip" class="jr-intro-overlay__skip" aria-label="Skip intro">
        Skip <span aria-hidden="true">›</span>
    </button>
</div>
<style>
    .jr-intro-overlay {
        position: fixed;
        inset: 0;
        z-index: 2147483600;          /* above everything, including modals */
        background: #000;
        display: none;
        align-items: center;
        justify-content: center;
        opacity: 1;
        transition: opacity 0.6s ease;
        cursor: pointer;
    }
    .jr-intro-overlay.is-active { display: flex; }
    .jr-intro-overlay.is-fading { opacity: 0; pointer-events: none; }
    .jr-intro-overlay__video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        background: #000;
    }
    .jr-intro-overlay__skip {
        position: absolute;
        top: calc(14px + env(safe-area-inset-top, 0px));
        right: calc(14px + env(safe-area-inset-right, 0px));
        padding: 8px 16px;
        background: rgba(0,0,0,0.45);
        border: 1px solid rgba(255,255,255,0.25);
        border-radius: 100px;
        color: rgba(255,255,255,0.85);
        font-family: 'Poppins', sans-serif;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        cursor: pointer;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        transition: all 0.2s ease;
        -webkit-tap-highlight-color: transparent;
    }
    .jr-intro-overlay__skip:hover {
        background: rgba(212,175,55,0.2);
        border-color: rgba(212,175,55,0.6);
        color: #ffd770;
    }
    .jr-intro-overlay__skip span { margin-left: 4px; font-size: 14px; }
</style>
<script>
(function() {
    /* Show only once per browser session. */
    try {
        if (sessionStorage.getItem('jr_intro_played') === '1') return;
    } catch (e) { /* sessionStorage may be unavailable */ }

    var overlay = document.getElementById('jrIntroOverlay');
    var video   = document.getElementById('jrIntroVideo');
    var skipBtn = document.getElementById('jrIntroSkip');
    if (!overlay || !video) return;

    /* Prevent the page from scrolling while the intro plays. */
    var prevOverflow = document.documentElement.style.overflow;
    document.documentElement.style.overflow = 'hidden';

    overlay.classList.add('is-active');
    overlay.setAttribute('aria-hidden', 'false');

    var finished = false;
    function finish() {
        if (finished) return;
        finished = true;
        try { sessionStorage.setItem('jr_intro_played', '1'); } catch (e) {}
        try { video.pause(); } catch (e) {}
        overlay.classList.add('is-fading');
        document.documentElement.style.overflow = prevOverflow;
        setTimeout(function() {
            overlay.parentNode && overlay.parentNode.removeChild(overlay);
        }, 700);

        /* Open the login modal for guests once the intro has finished. */
        @if(!\Illuminate\Support\Facades\Auth::check())
            setTimeout(openLoginAfterIntro, 350);
        @endif
    }

    function openLoginAfterIntro() {
        var modal = document.getElementById('login-modal');
        if (!modal) return;
        /* Try the AngularJS gateway first (preserves backdrop + state). */
        try {
            var scope = window.angular && angular.element(document.body).scope();
            if (scope && typeof scope.openModal === 'function') {
                scope.$apply(function() { scope.openModal(null, '#login-modal'); });
                return;
            }
        } catch (e) {}
        /* Manual fallback — show the modal directly. */
        modal.style.display    = 'block';
        modal.style.background = 'transparent';
        document.body.classList.add('modal-open');
        if (!document.querySelector('.modal-backdrop')) {
            var bd = document.createElement('div');
            bd.className = 'modal-backdrop fade in';
            document.body.appendChild(bd);
        }
    }

    /* Autoplay needs to be muted on most browsers. Try unmuted first
       (some browsers allow it after a prior interaction); fall back
       to muted on rejection. */
    video.muted = false;
    var p = video.play();
    if (p && p.catch) {
        p.catch(function() {
            video.muted = true;
            video.play().catch(function() { finish(); });
        });
    }

    video.addEventListener('ended',  finish);
    video.addEventListener('error',  finish);
    skipBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        finish();
    });
    /* Tapping anywhere on the overlay also dismisses (after a short
       safety window so accidental taps during load don't cut it). */
    setTimeout(function() {
        overlay.addEventListener('click', function(e) {
            if (e.target === skipBtn) return;
            finish();
        });
    }, 600);

    /* Hard cap — never let the intro block the UI longer than 30s. */
    setTimeout(finish, 30000);
})();
</script>
<style>
    @-webkit-keyframes lights {
        0% {
            background-image: url("/woocasino/images/cobranded_board.png");
        }

        100% {
            background-image: url("/woocasino/images/cobranded_board_1.png");
        }
    }

    @-webkit-keyframes lightsMobile {
        0% {
            background-image: url("/woocasino/images/cobranded_board_mobile.png");
        }

        100% {
            background-image: url("/woocasino/images/cobranded_board_mobile_1.png");
        }
    }

    @-moz-keyframes lights {
        0% {
            background-image: url("/woocasino/images/cobranded_board.png");
        }

        100% {
            background-image: url("/woocasino/images/cobranded_board_1.png");
        }
    }

    @-moz-keyframes lightsMobile {
        0% {
            background-image: url("/woocasino/images/cobranded_board_mobile.png");
        }

        100% {
            background-image: url("/woocasino/images/cobranded_board_mobile_1.png");
        }
    }

    @keyframes  lights {
        0% {
            background-image: url("/woocasino/images/cobranded_board.png");
        }

        100% {
            background-image: url("/woocasino/images/cobranded_board_1.png");
        }
    }

    @keyframes  lightsMobile {
        0% {
            background-image: url("/woocasino/images/cobranded_board_mobile.png");
        }

        100% {
            background-image: url("/woocasino/images/cobranded_board_mobile_1.png");
        }
    }

    .games__hero__wrapper {
        background-image: url("/woocasino/images/spin-mobile.jpg");
        padding-bottom: 123vw;
        position: relative;
    }

    .games__hero__offer__wrapper .bonus-breakdown {
        font-size: .75em;
        max-width: 90%;
        margin: 5px auto;
    }

    .cobranded_board_mobile {
        animation-name: lightsMobile;
        animation-duration: 0.75s;
        animation-iteration-count: infinite;
        position: absolute;
        background-image: url("/woocasino/images/cobranded_board_mobile.png");
        background-size: 100%;
        background-repeat: no-repeat;
        right: 2vw;
        display: block;
        width: 70vw;
        height: 39vw;
        top: -13vw;
        text-align: center;
        padding-top: 2.5vw;
        left: 50%;
        transform: translate(-50%);
    }

    .cobranded_board {
        animation-name: lights;
        animation-duration: 0.75s;
        animation-iteration-count: infinite;
        position: absolute;
        background-image: url("/woocasino/images/cobranded_board.png");
        background-size: 100%;
        background-repeat: no-repeat;
        right: 2vw;
        display: none;
        width: 32vw;
        height: 25vw;
        top: 1vw;
        text-align: center;
        padding-top: 4vw;
    }

    .cobranded_board {
        display: none;
    }

    .games__hero__offer__wrapper h1 {
        font-size: 6vw;
    }

    .games__hero__offer__wrapper h2 {
        font-size: 11vw;
    }

    .cobranded_board img, .cobranded_board_mobile img {
        width: 65%;
    }

    .games__offer__text {
        top: 14vw;
        position: relative;
    }

    .es .games__hero__offer__wrapper h1, .es-ar .games__hero__offer__wrapper h1, .es-mx .games__hero__offer__wrapper h1 {
        font-size: 7vw;
        line-height: 9vw;
    }

    .pt-br .games__hero__offer__wrapper h1 {
        font-size: 5vw;
        line-height: 6vw;
    }

    .pt-br .games__hero__offer__wrapper h2 {
        font-size: 11vw;
        line-height: 14vw;
    }

    .es .games__hero__offer__wrapper h2, .es-ar .games__hero__offer__wrapper h2, .es-mx .games__hero__offer__wrapper h2 {
        font-size: 12vw;
        line-height: 14vw;
    }

    .es .button-hero, .pt-br .button-hero, .de .button-hero, .es-ar .button-hero, .es-mx .button-hero, .fr-ca .button-hero {
        margin-top: 3vw;
    }

    .fr-ca .button-hero {
        font-size: 5vw;
    }

    .de .games__hero__offer__wrapper h1 {
        font-size: 5.5vw;
    }

    .de .games__hero__offer__wrapper h2, .fr-ca .games__hero__offer__wrapper h2 {
        font-size: 10vw;
    }

    @media  screen and (min-width: 760px) {
        .games__offer__text {
            top: 10vw;
            position: relative;
        }

        .games__hero__wrapper {
            padding-bottom: 75vw;
        }

        .en-ca .button-hero, .en-nz .button-hero, .fr-ca .button-hero, .button-hero {
            font-size: 3.2vw;
            padding: 25px 45px 30px 66px;
            margin-top: 1vw;
        }

        .fr-ca .button-hero {
            font-size: 2.5vw;
        }

        .es .games__hero__offer__wrapper h1, .pt-br .games__hero__offer__wrapper h1, .es-ar .games__hero__offer__wrapper h1, .es-mx .games__hero__offer__wrapper h1 {
            font-size: 5vw;
            line-height: 9vw;
        }

        .es .games__hero__offer__wrapper h2, .es-ar .games__hero__offer__wrapper h2, .es-mx .games__hero__offer__wrapper h2 {
            font-size: 10vw;
            line-height: 10vw;
        }

        .fr-ca .games__hero__offer__wrapper h1 {
            font-size: 2.5vw;
        }

        .fr-ca .games__hero__offer__wrapper h2 {
            font-size: 8vw;
        }

        .es .games__hero__offer__wrapper h1, .pt-br .games__hero__offer__wrapper h1, .es-ar .games__hero__offer__wrapper h1, .es-mx .games__hero__offer__wrapper h1 {
            font-size: 5vw;
            line-height: 7vw;
        }

        .pt-br .games__hero__offer__wrapper h2 {
            font-size: 9vw;
            line-height: 11vw;
        }

        .cobranded_board_mobile {
            width: 55vw;
            top: -9vw;
        }
    }

    @media  screen and (min-width: 1020px) {
        .games__hero__offer__wrapper .bonus-breakdown {
            font-size: 1em;
            max-width: 45%;
            margin: 10px 0 0 0;
        }

        .games__hero__offer__wrapper h1 {
            font-size: 2.5vw;
        }

        .games__hero__offer__wrapper h2 {
            font-size: 5vw;
        }

        .games__hero__wrapper {
            background-image: url("/woocasino/images/spin-desktop.jpg");
            padding-bottom: 31vw;
        }

        .games__hero__offer__wrapper {
            text-align: left;
        }

        .games__offer__text {
            top: 0;
        }

        .cobranded_board {
            display: block;
        }

        .cobranded_board_mobile {
            display: none;
        }

        .games__hero__offer__wrapper h1 {
            line-height: 0.8;
        }

        .button-hero {
            margin-top: 2vw;
        }

        .es .games__hero__offer__wrapper h1, .es-ar .games__hero__offer__wrapper h1, .es-mx .games__hero__offer__wrapper h1 {
            font-size: 2.5vw;
            line-height: 3vw;
        }

        .pt-br .games__hero__offer__wrapper h1 {
            font-size: 3vw;
            line-height: 5vw;
        }

        .es .games__hero__offer__wrapper h2 {
            font-size: 5vw;
            line-height: 6vw;
        }

        .es-ar .games__hero__offer__wrapper h2, .es-mx .games__hero__offer__wrapper h2 {
            font-size: 4.8vw;
            line-height: 6vw;
        }

        .pt-br .games__hero__offer__wrapper h2, .fr-ca .games__hero__offer__wrapper h2 {
            font-size: 3.5vw;
            line-height: 6vw;
        }

        .es .button-hero, .pt-br .button-hero, .de .button-hero, .es-ar .button-hero, .es-mx .button-hero {
            font-size: 2.3vw;
            margin-top: 0;
        }

        .de .games__hero__offer__wrapper h2 {
            font-size: 5vw;
            line-height: 6vw;
        }

        .de .games__hero__offer__wrapper h1 {
            font-size: 2.5vw;
            line-height: 3vw;
        }
    }
</style>
<div class="overlay"></div>
<div class="pop-container" style="display:none">

    <div class="pop-wrapper">
        <a class="close-pop">x</a>
        <div class="pop-content clear"><p style="font-size: 22px; font-weight: bold">@lang('app.cond_title1') </p>
            <br>
            <p style="font-weight: bold;"></p>@lang('app.cond_title2')<br>
            <p style="font-weight: bold;">@lang('app.cond_title3')</p><br>
            <ol style="list-style-type: decimal;margin-left: 15px;">
                <li>@lang('app.cond_title4')
                </li>
                <li>@lang('app.cond_par1')
                </li>
                <li>@lang('app.cond_par2')
                </li>
                <li>@lang('app.cond_par3')
                </li>
                <li>@lang('app.cond_par4')
                </li>
                <li>@lang('app.cond_par5')
                </li>
                <li>@lang('app.cond_par6')
                </li>
                <li>@lang('app.cond_par7')
                </li>
                <li>@lang('app.cond_par8')
                </li>
                <li>@lang('app.cond_par9')
                </li>
                <li>@lang('app.cond_par10')
                </li>
                <li>@lang('app.cond_par11')
                </li>
                <li>@lang('app.cond_par12')
                </li>
            </ol>
            <ul style="list-style-type: disc; margin-left: 25px;">
                <li> @lang('app.cond_par13')
                </li>
               @lang('app.cond_par14')
                </li>
                <li>@lang('app.cond_par15')
                </li>
            </ul>
            <ol style="list-style-type: decimal;margin-left: 15px;" start="14">
                <li>@lang('app.cond_par16')
                </li>
                <li>@lang('app.cond_par17')
                </li>
                <li>@lang('app.cond_par18')
                </li>
                <li>@lang('app.cond_par19')
                </li>
                <li>@lang('app.cond_par20')
                </li>
                <li>@lang('app.cond_par21')
                </li>
                <li>@lang('app.cond_par22')
                </li>
                <li>@lang('app.cond_par23')
                </li>
                <li>@lang('app.cond_par24')
                </li>
                <li>@lang('app.cond_par25')
                </li>
                <li>@lang('app.cond_par26')
                </li>
            </ol>
            <br>
            <p style="font-weight: bold;">@lang('app.cond_par27')</p></div>
    </div>
</div>
<!-- END OF TERMS POP -->

<!-- Live Support fixed button 
<div class="ls__fixed__btn">
    <a class="button-ls lc"><img src="/woocasino/images/livesupport.png"/></a>
</div>
-->
      
                @include('frontend.Default.partials.navbar')

                <section class="section section_main">
                        @yield('content')
                        
                </section>
    <!-- Footer -->
    <!--    <div class="footer">-->
       <!--  <div class="col-1">
            <div class="games__footer__icons">
                <img src="/woocasino/images/footer_icons_0.png"/>
                <br/>
                <a target="_blank" href="#" style="display:inline-block;">
                    <img src="/woocasino/images/footer_icons_1.png"/>
                </a>
                <a target="_blank"
                   href="#"
                   style="display:inline-block;">
                    <img src="/woocasino/images/footer_icons_2.png"/>
                </a>


                <a target="_blank" href="#"
                   style="display:inline-block;">
                    <img src="/woocasino/images/footer_icons_4.png"/>
                </a>


                <a target="_blank" href="#" style="display:inline-block;">
                    <img src="/woocasino/images/en18logo.png"/>
                </a>


                <a target="_blank" href="#" style="display:inline-block;">
                    <img src="/woocasino/images/gambleaware.png"/>
                </a>
                <a target="_blank" href="#" style="display:inline-block;">
                    <img src="/woocasino/images/microgaming.png"/>
                </a>
                <img src="/woocasino/images/footer_icons_5.png"/>
                <img src="/woocasino/images/footer_icons_6.png"/>
                <img src="/woocasino/images/footer_icons_7.png"/>
                <img src="/woocasino/images/footer_icons_8.png"/>


            </div>

            <div class="games__footer__btns">
                <a class="games__button tc ">@lang('app.cond_par28')</a>
                <a class="games__button lc">@lang('app.cond_par29')</a>
            </div>
            <p class="games__footer__terms">
                @lang('app.cond_par30') <br/>
            </p>
        </div> -->
                <div class="ls__fixed__btn">
                        <div class="footer__item-search">
                                <span class="search-wrap"><input type="text" placeholder="Search Game" class="search" style="    border-radius: 15px;width: 100%;background: #131521;padding: 1px 15px;border-style: double;"></span>
                        </div>
                </div>
                <script>
                    $(document).on('keyup', '.search', function() {
                                var query = $(this).val().toLowerCase();
                                if(query.length > 2)doSearch(query);
                        });

                        function OnSearch(input) {
                                var query = input.value.toLowerCase();
                                doSearch(query);
                        }

                        function doSearch(query){
                                $.getJSON('{{ route('frontend.game.search')  }}?category1={{ $category1 }}&q=' + query, function(data) {
                                        $('#woocasino > section > main > div.ng-scope > div > section > .games-list__title-wrp > h1').html(query + ' Search Results');
                                        $('#woocasino > section > main > div.ng-scope > div > section > div.games-list__wrap.ng-scope').html(data.data);
                                });
                        }
                </script>
     <!--   </div>-- -->

    <!-- Site Footer -->
    <footer class="site-footer">
        <div class="site-footer__content">
            <a href="/" class="site-footer__logo">
                <img src="/woocasino/resources/images/footer-logo.png" alt="Jade Royale Casino">
            </a>
            <div class="site-footer__social">
                <a href="https://www.facebook.com/profile.php?id=61581838898713" target="_blank" rel="noopener noreferrer" class="site-footer__social-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>
            </div>
            @php
            $footerLangOpts = ['en' => 'English', 'de' => 'Deutsch'];
            $footerCurrentLang = isset($_COOKIE['language']) ? htmlspecialchars($_COOKIE['language']) : 'en';
            @endphp
            <div class="site-footer__language">
                <div class="footer-lang-selector">
                    <button class="footer-lang-btn">
                        <img src="/woocasino/flag-icon-css/flags/4x3/{{$footerCurrentLang}}.svg" alt="">
                        <span>{{ $footerLangOpts[$footerCurrentLang] ?? 'English' }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg>
                    </button>
                    <ul class="footer-lang-dropdown">
                        @foreach ($footerLangOpts as $k=>$v)
                        <li data-lang-code="{{$k}}">
                            <img src="/woocasino/flag-icon-css/flags/4x3/{{$k}}.svg" alt="{{$v}}">
                            <span>{{ $v }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <p class="site-footer__copyright">&copy; {{ date('Y') }} Jade Royale Casino. All rights reserved.</p>
        </div>
    </footer>
    <!-- END Footer -->
</section>
      
                {{-- @include('frontend.Default.partials.popups') --}}
                @include('frontend.Default.partials.popups')
          
<!-- Lock screen -->
<div id="lock__screen"></div>
<!-- Preconnect CSS -->
<style>
    body.no-scroll {
        overflow: hidden;
    }

    .enable-form {
        opacity: 1 !important;
        z-index: 999 !important;
        transition: opacity .4s ease;
    }


    .frame__cont_log, .frame__cont_reg {
        transition: opacity .4s ease;
        z-index: -999;
        display: block;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        padding-top: 50px;
        text-align: center;
        background: rgba(0, 0, 0, .75);
        background-repeat: repeat;
        opacity: 0;
    }

    .frame__inner_log, .frame__inner_reg {
        position: absolute;
        text-align: center;
        width: 100%;
        max-width: 680px;
        height: 100%;
        margin: 0 auto;
        left: 0;
        right: 0;
    }

    .reg-close {
        color: #773d4f;
        font-size: 47px;
        font-weight: 300;
        font-family: Arial, Helvetica, sans-serif;
        position: absolute;
        top: 2px;
        z-index: 9999;
        cursor: pointer;
        right: 50px;
    }

    .log-close {
        color: #773d4f;
        font-size: 47px;
        font-weight: 300;
        font-family: Arial, Helvetica, sans-serif;
        position: absolute;
        top: 3px;
        z-index: 9999;
        cursor: pointer;
        right: 176px;
    }

    .reg {
        width: 641px !important;
        height: 100% !important;
        margin: 0 auto;
    }

    .log {
        width: 408px !important;
        height: 100% !important;
        margin: 0 auto;
    }

    .close {
        color: #ffffff;
    }

    .sps-close {
        color: #156644;
    }

    .spc-close {
        color: #3f4a74;
    }

    .rfc-close {
        color: #773d4f;
    }

    .ccc-close {
        color: #7a334f;
    }
</style>
<!-- <script type="text/javascript" src="/woocasino/js/jquery-1.7.1.min.js"></script> -->
<script type="text/javascript" src="/woocasino/js/jquery.corsproxy.1.0.0.js"></script>
<script type="text/javascript" src="/woocasino/js/perfect-scrollbar.jquery.js"></script>
<script type="text/javascript" src="/woocasino/js/zebra_datepicker.min.js"></script>
<!-- Set CSRF token to each interaction -->
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '<?php csrf_token() ?>',
        }
    });
</script>
<script type="text/javascript" src="/woocasino/js/app.js"></script>
<script type="text/javascript" src="/woocasino/js/angular-lazy-img.min.js"></script>
<script type="text/javascript" src="/woocasino/js/gameController.js"></script>
<script type="text/javascript" src="/woocasino/js/sweetalert.min.js"></script>
<script>
    //Initialise lp config object
    var config = new LPConfig();
    //First parameter is the hero offer position, you can type "left", "right" or "center". the two colours are the H1 and H2 offer elements.
    config.heroOptions('left', ["#fff", "#fff"]);
    //Category to show in the Featured tab by default
    config.gameOptions('top', true);
</script>
        </body>
</html>
@yield('scripts')