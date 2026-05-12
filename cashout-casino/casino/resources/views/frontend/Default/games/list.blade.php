@extends('frontend.Default.layouts.app')

@section('page-title', $title)
@section('body', $body)
@section('keywords', $keywords)
@section('description', $description)

@section('content')
<style type="text/css">
        @charset "UTF-8";
        [ng\:cloak],
        [ng-cloak],
        [data-ng-cloak],
        [x-ng-cloak],
        .ng-cloak,
        .x-ng-cloak,
        .ng-hide:not(.ng-hide-animate) {
                display: none !important;
        }

        ng\:form {
                display: block;
        }

        .ng-animate-shim {
                visibility: hidden;
        }

        @import url('https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&display=swap');

        .ng-anchor {
                position: absolute;
        }

        /* ══════════════════════════════════════════════════════════
           JADE ROYALE LOGO — mobile glow + Cinzel font
        ══════════════════════════════════════════════════════════ */
        @media (max-width: 768px) {
            .mob-header__logo {
                font-family: 'Cinzel Decorative', Georgia, serif !important;
                font-weight: 700 !important;
                font-size: 17px !important;
                letter-spacing: 2px !important;
                background: linear-gradient(120deg, #00ff88 0%, #ffd700 50%, #00cfff 100%) !important;
                -webkit-background-clip: text !important;
                -webkit-text-fill-color: transparent !important;
                background-clip: text !important;
                text-shadow: none !important;
                filter: drop-shadow(0 0 8px rgba(0,255,136,0.8)) drop-shadow(0 0 18px rgba(0,207,255,0.5)) !important;
                animation: jadeLogoGlow 3s ease-in-out infinite !important;
            }
            @keyframes jadeLogoGlow {
                0%,100% { filter: drop-shadow(0 0 7px rgba(0,255,136,0.9)) drop-shadow(0 0 16px rgba(0,207,255,0.5)); }
                33%     { filter: drop-shadow(0 0 14px rgba(255,215,0,0.9)) drop-shadow(0 0 28px rgba(0,255,136,0.7)); }
                66%     { filter: drop-shadow(0 0 10px rgba(0,207,255,0.9)) drop-shadow(0 0 22px rgba(168,85,247,0.6)); }
            }
        }

        /* ══════════════════════════════════════════════════════════
           PREMIUM MOBILE NAV ICONS
        ══════════════════════════════════════════════════════════ */
        .mob-nav-icon-wrap {
            width: 38px; height: 38px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 2px;
            position: relative;
            transition: transform 0.18s ease, box-shadow 0.18s ease;
            flex-shrink: 0;
        }
        .mob-nav-item:active .mob-nav-icon-wrap { transform: scale(0.85); }
        .mob-nav-item svg { width: 22px !important; height: 22px !important; display: block; }
        .mob-spin-ring { display: contents; }
        @keyframes spinIconGlow {
            0%,100% { box-shadow: 0 3px 14px rgba(245,158,11,0.7); }
            50%      { box-shadow: 0 3px 22px rgba(245,158,11,1), 0 0 30px rgba(255,215,0,0.5); }
        }

        /* ══════════════════════════════════════════════════════════
           BONUS MODAL → FULLSCREEN SLIDE-IN PAGE
        ══════════════════════════════════════════════════════════ */
        .bonus-modal-overlay {
            display: flex !important;
            visibility: hidden !important;
            pointer-events: none !important;
            align-items: stretch !important;
            justify-content: flex-end !important;
            background: rgba(0,0,0,0) !important;
            transition: background 0.4s ease, visibility 0s linear 0.4s !important;
        }
        .bonus-modal-overlay.active {
            visibility: visible !important;
            pointer-events: all !important;
            background: rgba(0,0,0,0.65) !important;
            transition: background 0.4s ease, visibility 0s linear 0s !important;
        }
        .bonus-modal {
            width: 100% !important;
            max-width: 100% !important;
            height: 100vh !important;
            max-height: 100vh !important;
            border-radius: 0 !important;
            margin: 0 !important;
            overflow-y: auto !important;
            transform: translateX(110%) !important;
            transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94) !important;
            background: linear-gradient(160deg, #100828 0%, #1c0d40 40%, #0d1a38 100%) !important;
            box-shadow: none !important;
        }
        .bonus-modal-overlay.active .bonus-modal {
            transform: translateX(0) !important;
        }
        .bonus-modal__close {
            position: sticky !important;
            top: 12px !important;
            left: 12px !important;
            float: left !important;
            z-index: 20 !important;
            margin: 12px 0 0 12px !important;
            width: 44px !important; height: 44px !important;
            border-radius: 50% !important;
            background: rgba(139,92,246,0.2) !important;
            border: 1px solid rgba(139,92,246,0.4) !important;
        }
        .bonus-modal__header { padding-top: 8px !important; }

        /* ══════════════════════════════════════════════════════════
           MORE MODAL → FULLSCREEN SLIDE-IN PAGE (from left)
        ══════════════════════════════════════════════════════════ */
        .more-modal-overlay {
            display: flex !important;
            visibility: hidden !important;
            pointer-events: none !important;
            align-items: stretch !important;
            justify-content: flex-start !important;
            background: rgba(0,0,0,0) !important;
            transition: background 0.4s ease, visibility 0s linear 0.4s !important;
        }
        .more-modal-overlay.active {
            visibility: visible !important;
            pointer-events: all !important;
            background: rgba(0,0,0,0.65) !important;
            transition: background 0.4s ease, visibility 0s linear 0s !important;
        }
        .more-modal {
            width: 100% !important;
            max-width: 100% !important;
            height: 100vh !important;
            max-height: 100vh !important;
            border-radius: 0 !important;
            margin: 0 !important;
            overflow-y: auto !important;
            transform: translateX(-110%) !important;
            transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94) !important;
            background: linear-gradient(160deg, #0d1a2e 0%, #0d1535 40%, #100828 100%) !important;
            box-shadow: none !important;
        }
        .more-modal-overlay.active .more-modal {
            transform: translateX(0) !important;
        }
        .more-modal__close {
            position: sticky !important;
            top: 12px !important;
            right: 12px !important;
            float: right !important;
            z-index: 20 !important;
            margin: 12px 12px 0 0 !important;
            width: 44px !important; height: 44px !important;
            border-radius: 50% !important;
            background: rgba(56,189,248,0.15) !important;
            border: 1px solid rgba(56,189,248,0.35) !important;
        }

        /* ══════════════════════════════════════════════════════════
           LOGIN MODAL — always visible on mobile (high z-index)
        ══════════════════════════════════════════════════════════ */
        #login-modal {
            z-index: 999999 !important;
        }
        .modal-backdrop {
            z-index: 999998 !important;
        }

        /* ══════════════════════════════════════════════════════════
           DESKTOP BACKGROUND — aggressive override to ensure dark bg
        ══════════════════════════════════════════════════════════ */
        @media (min-width: 769px) {
            html { background: #000 !important; }
            body {
                background: transparent !important;
                background-color: transparent !important;
                animation: none !important;
                filter: none !important;
            }
            body::before, body::after {
                display: none !important;
                background: none !important;
                animation: none !important;
            }
            .background-layer-rainbow, .background-layer-particles { display: none !important; }
            .carcass, .carcass__body, .carcass__inner, .carcass__content,
            .main-content, .contain, .main, section.main,
            .ng-scope > div:not(.main-slider__img):not(.mobile-slider__img) { background: transparent !important; }
            .main-slider__img, .mobile-slider__img { background-color: #0a0a0a !important; }
            .footer { background: rgba(8, 4, 20, 0.95) !important; }
        }

        /* ══════════════════════════════════════════════════════════
           DESKTOP PLAYER ACTION BAR — premium redesign
        ══════════════════════════════════════════════════════════ */
        .player-action-bar--centered {
            background: rgba(255,255,255,0.03) !important;
            backdrop-filter: blur(20px) !important;
            -webkit-backdrop-filter: blur(20px) !important;
            border: 1px solid rgba(255,255,255,0.07) !important;
            border-radius: 100px !important;
            padding: 10px 20px !important;
            gap: 14px !important;
            max-width: 560px !important;
            margin: 18px auto !important;
            box-shadow: 0 8px 40px rgba(0,0,0,0.5), inset 0 1px 0 rgba(255,255,255,0.05) !important;
        }
        .player-btn--withdraw {
            background: linear-gradient(135deg, #1e0040 0%, #3d005a 100%) !important;
            border: 1px solid rgba(239,68,68,0.55) !important;
            color: #fca5a5 !important;
            box-shadow: 0 0 18px rgba(239,68,68,0.25), inset 0 1px 0 rgba(255,255,255,0.08) !important;
            font-weight: 700 !important;
            letter-spacing: 1.5px !important;
            text-transform: uppercase !important;
            font-size: 11px !important;
            padding: 12px 22px !important;
            border-radius: 50px !important;
            transition: all 0.3s ease !important;
            gap: 7px !important;
        }
        .player-btn--withdraw:hover {
            border-color: rgba(239,68,68,1) !important;
            box-shadow: 0 0 28px rgba(239,68,68,0.7), 0 4px 20px rgba(239,68,68,0.3) !important;
            transform: translateY(-2px) !important;
            color: #fff !important;
        }
        .player-btn--deposit {
            background: linear-gradient(135deg, #003022 0%, #004d33 100%) !important;
            border: 1px solid rgba(16,185,129,0.55) !important;
            color: #6ee7b7 !important;
            box-shadow: 0 0 18px rgba(16,185,129,0.25), inset 0 1px 0 rgba(255,255,255,0.08) !important;
            font-weight: 700 !important;
            letter-spacing: 1.5px !important;
            text-transform: uppercase !important;
            font-size: 11px !important;
            padding: 12px 22px !important;
            border-radius: 50px !important;
            transition: all 0.3s ease !important;
            gap: 7px !important;
        }
        .player-btn--deposit:hover {
            border-color: rgba(16,185,129,1) !important;
            box-shadow: 0 0 28px rgba(16,185,129,0.7), 0 4px 20px rgba(16,185,129,0.3) !important;
            transform: translateY(-2px) !important;
            color: #fff !important;
        }
        .player-btn--login {
            background: linear-gradient(135deg, #1e0055 0%, #4a0096 50%, #1e0055 100%) !important;
            border: 2px solid rgba(168,85,247,0.7) !important;
            color: #fff !important;
            box-shadow: 0 0 24px rgba(168,85,247,0.55), 0 4px 24px rgba(168,85,247,0.35), inset 0 1px 0 rgba(255,255,255,0.15) !important;
            font-weight: 800 !important;
            letter-spacing: 2px !important;
            text-transform: uppercase !important;
            font-size: 13px !important;
            padding: 14px 34px !important;
            border-radius: 50px !important;
            animation: desktopLoginPulse 2.5s ease-in-out infinite !important;
            transition: all 0.3s ease !important;
        }
        @keyframes desktopLoginPulse {
            0%,100% { box-shadow: 0 0 20px rgba(168,85,247,0.5), 0 4px 20px rgba(168,85,247,0.3); }
            50%      { box-shadow: 0 0 40px rgba(168,85,247,0.8), 0 6px 36px rgba(168,85,247,0.5), 0 0 60px rgba(168,85,247,0.2); }
        }
        .player-btn--login:hover {
            transform: translateY(-2px) scale(1.04) !important;
            box-shadow: 0 0 50px rgba(168,85,247,0.9), 0 8px 40px rgba(168,85,247,0.6) !important;
            background: linear-gradient(135deg, #2a007a 0%, #6200cc 50%, #2a007a 100%) !important;
        }
        .balance-value-large {
            font-size: 20px !important;
            font-weight: 700 !important;
            color: #ffd700 !important;
            text-shadow: 0 0 12px rgba(255,215,0,0.55) !important;
            letter-spacing: 0.5px !important;
            font-family: 'Poppins', sans-serif !important;
        }
        .balance-label-small {
            font-size: 10px !important;
            color: rgba(255,255,255,0.38) !important;
            text-transform: uppercase !important;
            letter-spacing: 1.5px !important;
        }

        /* ══════════════════════════════════════════════════════════
           DESKTOP 3D BACKGROUND CANVAS
        ══════════════════════════════════════════════════════════ */
        /* ── DESKTOP: kill all rainbow/aurora effects, set dark casino bg ── */
        @media (min-width: 769px) {
            body {
                animation: none !important;
                background: #0d0821 !important;
                background-color: #0d0821 !important;
                filter: none !important;
            }
            body::before, body::after {
                display: none !important;
                content: none !important;
                animation: none !important;
            }
            .background-layer-rainbow,
            .background-layer-particles {
                display: none !important;
                animation: none !important;
            }
            html, .carcass, .carcass__body, .main-content, .contain, .main {
                background: transparent !important;
                background-color: transparent !important;
            }
            .footer {
                background: rgba(10, 5, 25, 0.92) !important;
            }
        }

        /* ── DESKTOP 3D BG canvas ── */
        #casino-bg-canvas {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: 0;
            pointer-events: none;
            display: none;
        }
        @media (min-width: 769px) {
            #casino-bg-canvas { display: block; }
        }

        /* Make desktop content sit above canvas */
        @media (min-width: 769px) {
            .carcass, .top-winners-bar, .contain, section.main,
            .player-action-bar, .slides, .carcass__header,
            .minimal-float-logo, #woocasino, .footer {
                position: relative;
                z-index: 2;
            }
        }
        
</style>
        @php
        if(Auth::check() && auth()->user()->email == 'demo01@gmail.com'){
            \Auth::logout();
            echo "<script>location.reload()</script>";
        }
        if(Auth::check()){
            $currency = auth()->user()->present()->shop ? auth()->user()->present()->shop->currency : '';
        } else{
            $currency = '';
        }
        @endphp
    <!-- ===================== MOBILE CASINO LAYOUT ===================== -->
    @php
        /* SHOP-SCOPED GAMES: only show games assigned to the player's shop.
           Guests see the default shop (id=1) catalog as a teaser, blurred via CSS. */
        $jrShopId   = \Illuminate\Support\Facades\Auth::check() ? (auth()->user()->shop_id ?: 1) : 1;
        $jrIsGuest  = !\Illuminate\Support\Facades\Auth::check();
        $allMobGames = \VanguardLTE\Game::where(['view' => 1, 'shop_id' => $jrShopId])
            ->whereIn('device', [1, 2])->take(120)->get();
        /* Fallback: if the shop has no games yet, fall back to shop_id=0 catalog template. */
        if ($allMobGames->isEmpty()) {
            $allMobGames = \VanguardLTE\Game::where(['view' => 1, 'shop_id' => 0])
                ->whereIn('device', [1, 2])->take(120)->get();
        }
    @endphp
    <div class="mobile-casino-layout jr-app {{ $jrIsGuest ? 'jr-app--guest' : '' }}" id="mobileCasinoLayout">

        <!-- Animated background orbs -->
        <div class="jr-bg" aria-hidden="true">
            <div class="jr-orb jr-orb--1"></div>
            <div class="jr-orb jr-orb--2"></div>
            <div class="jr-orb jr-orb--3"></div>
            <div class="jr-orb jr-orb--4"></div>
        </div>

        <!-- App layout: sidebar + content -->
        <div class="jr-layout">

            <!-- LEFT SIDEBAR -->
            <nav class="jr-sidebar" id="jrSidebar">
                <button class="jr-sidebar__btn active" data-cat="hot" onclick="jrSelectCat('hot',this)">
                    <svg class="jr-sidebar__icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M8.5 14.5A2.5 2.5 0 0011 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 11-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 002.5 2.5z"/>
                    </svg>
                    <span class="jr-sidebar__label">Hot</span>
                    <span class="jr-count-badge" data-badge="hot">0</span>
                </button>
                <button class="jr-sidebar__btn" data-cat="favorites" onclick="jrSelectCat('favorites',this)">
                    <svg class="jr-sidebar__icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                    <span class="jr-sidebar__label">Favs</span>
                    <span class="jr-count-badge" data-badge="favorites">0</span>
                </button>
                <button class="jr-sidebar__btn" data-cat="slots" onclick="jrSelectCat('slots',this)">
                    <svg class="jr-sidebar__icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    <span class="jr-sidebar__label">Slots</span>
                    <span class="jr-count-badge" data-badge="slots">0</span>
                </button>
                <button class="jr-sidebar__btn" data-cat="fish" onclick="jrSelectCat('fish',this)">
                    <svg class="jr-sidebar__icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M21.17 3.25Q21.5 3.25 21.76 3.5C23.24 5 23.29 7.26 22.5 9.21C21.76 11 20.25 12.5 18.5 13.5L13 16.5L7.59 21.91C7.19 22.3 6.56 22.3 6.16 21.91L2.09 17.84C1.7 17.44 1.7 16.81 2.09 16.41L7.5 11L10.5 5.5C11.5 3.75 13 2.24 14.79 1.5C16.74 0.71 19 0.76 20.5 2.24Q20.76 2.5 20.76 2.83V3.25H21.17M17 10A1 1 0 0 0 18 9A1 1 0 0 0 17 8A1 1 0 0 0 16 9A1 1 0 0 0 17 10Z"/>
                    </svg>
                    <span class="jr-sidebar__label">Fish</span>
                    <span class="jr-count-badge" data-badge="fish">0</span>
                </button>
                <button class="jr-sidebar__btn" data-cat="table" onclick="jrSelectCat('table',this)">
                    <svg class="jr-sidebar__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                    </svg>
                    <span class="jr-sidebar__label">Tables</span>
                    <span class="jr-count-badge" data-badge="table">0</span>
                </button>
            </nav>

            <!-- MAIN CONTENT -->
            <div class="jr-content">

                <!-- HEADER -->
                <header class="jr-header">
                    <a href="/" class="jr-header__logo-link">
                        <img src="/woocasino/images/jade-royale-logo-v2.png?v=2" alt="Jade Royale" class="jr-logo-img">
                    </a>
                    <div class="jr-header__right">
                        @if(Auth::check())
                        <button class="jr-balance-pill" id="jrBalancePill" onclick="jrRefreshBalance(this)">
                            <svg viewBox="0 0 20 20" width="13" height="13" style="flex-shrink:0"><circle cx="10" cy="10" r="9" fill="#D4AF37"/><text x="10" y="14.5" text-anchor="middle" font-size="10" font-weight="900" fill="#5a2d00">$</text></svg>
                            <span id="jrBalanceAmt">${{ number_format(auth()->user()->balance, 2) }}</span>
                            <svg class="jr-refresh-ico" viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="rgba(212,175,55,0.6)" stroke-width="2.5"><path d="M1 4v6h6"/><path d="M23 20v-6h-6"/><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"/></svg>
                        </button>
                        <button class="jr-action-btn" style="color:#D4AF37" onclick="openBonusModal()" title="Daily Bonus">
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="currentColor"><path d="M20 12v10H4V12M22 7H2v5h20V7zM12 22V7M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7zM12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/></svg>
                        </button>
                        <button class="jr-action-btn" style="color:#A020F0" onclick="openBonusModal()" title="Spin Wheel">
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        </button>
                        <button class="jr-action-btn" style="color:#0099FF" onclick="openMoreModal()" title="Alerts">
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        </button>
                        <button class="jr-action-btn" style="color:#00FF87" ng-click="openModal($event,'#my-account')" title="Deposit">
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </button>
                        <button class="jr-action-btn" style="color:#FF1493" ng-click="openModal($event,'#my-account')" title="Withdraw">
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M19 12l-7 7-7-7"/></svg>
                        </button>
                        <button class="jr-action-btn" style="color:#A020F0" ng-click="openModal($event,'#my-account')" title="Profile">
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </button>
                        @else
                        <button class="jr-login-btn" ng-click="openModal($event,'#login-modal')">Log In</button>
                        <div class="jr-guest-pill" ng-click="openModal($event,'#login-modal')">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                            <span>Play Now</span>
                        </div>
                        @endif
                    </div>
                </header>

                <!-- BONUS ICONS STRIP — always visible, sits above cat-bar -->
                <div class="jr-bonus-strip">
                    <a class="jr-bonus-icon" onclick="if(window.openBonusModal){openBonusModal();if(window.switchBonusTab)switchBonusTab('wheel');}">
                        <div class="jr-bonus-icon__circle" style="background:linear-gradient(135deg,#A020F0,#FF1493)">
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="#fff"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm-1-13h2v6h-2zm0 7h2v2h-2z"/></svg>
                        </div>
                        <span class="jr-bonus-icon__lbl">WHEEL</span>
                    </a>
                    <a class="jr-bonus-icon" onclick="if(window.openBonusModal){openBonusModal();if(window.switchBonusTab)switchBonusTab('referral');}">
                        <div class="jr-bonus-icon__circle" style="background:linear-gradient(135deg,#FF6B35,#FFD700)">
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="#fff"><path d="M16 4a4 4 0 1 1-4 4 4 4 0 0 1 4-4m0 14c-3.3 0-6 1.4-6 3v1h12v-1c0-1.6-2.7-3-6-3M8 4a4 4 0 1 0 4 4 4 4 0 0 0-4-4m0 14c-3.3 0-8 1.4-8 3v1h8v-1c0-1.1.4-2 1-2.7-.3 0-.7-.3-1-.3z"/></svg>
                        </div>
                        <span class="jr-bonus-icon__lbl">REFERRAL</span>
                    </a>
                    <a class="jr-bonus-icon" onclick="if(window.openBonusModal){openBonusModal();if(window.switchBonusTab)switchBonusTab('daily');}">
                        <div class="jr-bonus-icon__circle" style="background:linear-gradient(135deg,#00FF87,#0099FF)">
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="#fff"><path d="M19 3h-1V1h-2v2H8V1H6v2H5a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zm0 18H5V8h14zM7 10h5v5H7z"/></svg>
                        </div>
                        <span class="jr-bonus-icon__lbl">DAILY</span>
                    </a>
                    <a class="jr-bonus-icon" onclick="if(window.openBonusModal){openBonusModal();if(window.switchBonusTab)switchBonusTab('welcome');}">
                        <div class="jr-bonus-icon__circle" style="background:linear-gradient(135deg,#D4AF37,#FFD700)">
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="#fff"><path d="M12 2L9 9l-7 .8 5.2 4.9L5.8 22 12 18l6.2 4-1.4-7.3L22 9.8 15 9z"/></svg>
                        </div>
                        <span class="jr-bonus-icon__lbl">BONUS</span>
                    </a>
                    <a class="jr-bonus-icon" onclick="if(window.openMoreModal)openMoreModal();">
                        <div class="jr-bonus-icon__circle" style="background:linear-gradient(135deg,#5B00A8,#A020F0)">
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="#fff"><circle cx="6" cy="12" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="18" cy="12" r="2"/></svg>
                        </div>
                        <span class="jr-bonus-icon__lbl">MORE</span>
                    </a>
                </div>

                <!-- CATEGORY BAR -->
                <div class="jr-cat-bar" id="jrCatBar" data-cat="hot">
                    <span class="jr-cat-bar__title" id="jrCatTitle">Hot Games</span>
                    <span class="jr-cat-bar__count" id="jrCatCount">0</span>
                    <div class="jr-cat-bar__arrows">
                        <button onclick="document.getElementById('jrCarousel').scrollBy({left:-300,behavior:'smooth'})" title="Scroll left">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>
                        </button>
                        <button onclick="document.getElementById('jrCarousel').scrollBy({left:300,behavior:'smooth'})" title="Scroll right">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>
                        </button>
                    </div>
                </div>

                <!-- CAROUSEL TRAY — jackpot banner + live ticker + game grid + progress -->
                <div class="jr-carousel-wrap">
                    <!-- LIVE JACKPOT BANNER — 3 tiers with rolling counters -->
                    <div class="jr-jackpots" id="jrJackpots">
                        <div class="jr-jackpot jr-jackpot--mini" data-base="48750" data-rate="1">
                            <div class="jr-jackpot__label">MINI JACKPOT</div>
                            <div class="jr-jackpot__amt">₱<span data-jp-amt>0</span></div>
                            <div class="jr-jackpot__pulse"></div>
                        </div>
                        <div class="jr-jackpot jr-jackpot--major" data-base="284900" data-rate="3">
                            <div class="jr-jackpot__label">MAJOR JACKPOT</div>
                            <div class="jr-jackpot__amt">₱<span data-jp-amt>0</span></div>
                            <div class="jr-jackpot__pulse"></div>
                        </div>
                        <div class="jr-jackpot jr-jackpot--mega" data-base="1847250" data-rate="7">
                            <div class="jr-jackpot__label">MEGA JACKPOT</div>
                            <div class="jr-jackpot__amt">₱<span data-jp-amt>0</span></div>
                            <div class="jr-jackpot__pulse"></div>
                        </div>
                    </div>

                    <!-- LIVE WIN TICKER — rotating winners -->
                    <div class="jr-ticker">
                        <span class="jr-ticker__prefix">🏆</span>
                        <div class="jr-ticker__track">
                            <span class="jr-ticker__inner" id="jrTickerInner">Loading recent wins…</span>
                        </div>
                        <span class="jr-ticker__live"><span class="jr-ticker__livedot"></span>LIVE</span>
                    </div>

                    <!-- HORIZONTAL GAME CAROUSEL — rebuilt by JS -->
                    <div class="jr-carousel" id="jrCarousel"></div>

                    <!-- SCROLL PROGRESS — thin gradient bar -->
                    <div class="jr-scroll-progress"><div class="jr-scroll-progress__bar" id="jrScrollBar"></div></div>
                </div>

            </div><!-- end .jr-content -->
        </div><!-- end .jr-layout -->

        <!-- PULL-DOWN FULLSCREEN INDICATOR -->
        <div class="jr-pull-indicator" id="jrPullIndicator"></div>
        <div class="jr-pull-ripple"    id="jrPullRipple"></div>

        <!-- BOTTOM NAV — shown in phone landscape (Game Vault style) -->
        <nav class="jr-bottom-nav" id="jrBottomNav">
            <button class="jr-bnav__btn active" data-cat="hot" onclick="jrSelectCat('hot',this)">
                <svg class="jr-bnav__icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M8.5 14.5A2.5 2.5 0 0011 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 11-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 002.5 2.5z"/>
                </svg>
                <span class="jr-bnav__label">Hot</span>
                <span class="jr-count-badge" data-badge="hot">0</span>
            </button>
            <button class="jr-bnav__btn" data-cat="slots" onclick="jrSelectCat('slots',this)">
                <svg class="jr-bnav__icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
                <span class="jr-bnav__label">Slots</span>
                <span class="jr-count-badge" data-badge="slots">0</span>
            </button>
            <button class="jr-bnav__btn" data-cat="fish" onclick="jrSelectCat('fish',this)">
                <svg class="jr-bnav__icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M21.17 3.25Q21.5 3.25 21.76 3.5C23.24 5 23.29 7.26 22.5 9.21C21.76 11 20.25 12.5 18.5 13.5L13 16.5L7.59 21.91C7.19 22.3 6.56 22.3 6.16 21.91L2.09 17.84C1.7 17.44 1.7 16.81 2.09 16.41L7.5 11L10.5 5.5C11.5 3.75 13 2.24 14.79 1.5C16.74 0.71 19 0.76 20.5 2.24Q20.76 2.5 20.76 2.83V3.25H21.17M17 10A1 1 0 0 0 18 9A1 1 0 0 0 17 8A1 1 0 0 0 16 9A1 1 0 0 0 17 10Z"/>
                </svg>
                <span class="jr-bnav__label">Fishing</span>
                <span class="jr-count-badge" data-badge="fish">0</span>
            </button>
            <button class="jr-bnav__btn" data-cat="table" onclick="jrSelectCat('table',this)">
                <svg class="jr-bnav__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                </svg>
                <span class="jr-bnav__label">Tables</span>
                <span class="jr-count-badge" data-badge="table">0</span>
            </button>
            <button class="jr-bnav__btn" data-cat="favorites" onclick="jrSelectCat('favorites',this)">
                <svg class="jr-bnav__icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                </svg>
                <span class="jr-bnav__label">Favs</span>
                <span class="jr-count-badge" data-badge="favorites">0</span>
            </button>
        </nav>

        <!-- HIDDEN CARD POOL — all games pre-rendered, JS pulls from here -->
        <div id="jrCardPool" hidden aria-hidden="true">
            @foreach($allMobGames as $game)
            @php
                $jrCat = 'slots';
                $jrN   = strtolower($game->name ?? '');
                if (preg_match('/(VP|SW|CQ9|PGD|KA)$/i', $game->name ?? '')
                    || str_contains($jrN, 'fishing')
                    || str_contains($jrN, 'hunter')
                    || str_contains($jrN, 'shooter')) {
                    $jrCat = 'fish';
                } elseif (str_contains($jrN, 'keno') || str_contains($jrN, 'poker')
                    || str_contains($jrN, 'blackjack') || str_contains($jrN, 'roulette')
                    || str_contains($jrN, 'baccarat')) {
                    $jrCat = 'table';
                }
                $jrHref = (isset(auth()->user()->username) && auth()->user()->balance > 0)
                    ? route('frontend.game.go', $game->name).'?api_exit=/'
                    : route('frontend.game.go', $game->name).'/prego?api_exit=/';
                $jrLbl = strtolower($game->label ?? '');
                $jrImg = $game->thumbnail ?? '/frontend/Default/ico/'.$game->name.'.jpg';
            @endphp
            <div class="jr-card"
                data-cat="{{ $jrCat }}"
                data-label="{{ $jrLbl }}"
                data-name="{{ $game->name }}"
                data-href="{{ $jrHref }}">
                <div class="jr-card__inner" onclick="window.location.href=this.closest('.jr-card').dataset.href">
                    <img class="jr-card__img"
                        src="{{ $jrImg }}"
                        alt="{{ $game->title }}"
                        loading="lazy"
                        onerror="this.src='/woocasino/mslider1.gif'">
                    <div class="jr-card__overlay"></div>
                    <div class="jr-card__play">
                        <div class="jr-card__play-btn">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="#fff"><path d="M8 5v14l11-7z"/></svg>
                            <span>PLAY</span>
                        </div>
                    </div>
                    <div class="jr-card__title">{{ $game->title }}</div>
                    @if($game->label)
                    <div class="jr-card__badge jr-card__badge--{{ $jrLbl }}">{{ $game->label }}</div>
                    @endif
                    <button class="jr-card__fav" data-name="{{ $game->name }}"
                        onclick="event.stopPropagation();jrToggleFav('{{ $game->name }}')">
                        <svg class="jr-fav-icon" data-name="{{ $game->name }}"
                            viewBox="0 0 24 24" width="12" height="12"
                            fill="none" stroke="rgba(255,255,255,0.7)" stroke-width="2">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                        </svg>
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <!-- JS: carousel rendering, category filtering, favorites -->
        <script>
        (function() {
            var CAT_TITLES = {
                hot: 'Hot Games', favorites: 'Favorites',
                slots: 'Slots', fish: 'Fishing', table: 'Table Games'
            };

            var jrIsLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
            var jrCsrfToken  = '{{ csrf_token() }}';
            window.jrLoggedIn = jrIsLoggedIn;

            /* Toast-style login gate for guest interactions */
            window.jrShowLoginGate = function(msg) {
                var t = document.getElementById('jrLoginGate');
                if (!t) {
                    t = document.createElement('div');
                    t.id = 'jrLoginGate';
                    t.className = 'jr-login-gate';
                    t.innerHTML = '<div class="jr-login-gate__inner">'
                        + '<div class="jr-login-gate__icon">🔒</div>'
                        + '<div class="jr-login-gate__msg"></div>'
                        + '<button class="jr-login-gate__btn" onclick="document.getElementById(\'jrLoginGate\').classList.remove(\'show\');if(window.openLoginModal)openLoginModal();">LOG IN</button>'
                        + '<button class="jr-login-gate__close" onclick="document.getElementById(\'jrLoginGate\').classList.remove(\'show\')">×</button>'
                        + '</div>';
                    document.body.appendChild(t);
                }
                t.querySelector('.jr-login-gate__msg').textContent = msg || 'Please log in to continue.';
                t.classList.add('show');
                clearTimeout(window._jrGateTimer);
                window._jrGateTimer = setTimeout(function(){ t.classList.remove('show'); }, 6000);
            };

            /* Game cards: guests see blurred preview with login prompt on click */
            document.addEventListener('click', function(e) {
                var card = e.target.closest('.jr-card, .jr-card__inner');
                if (!card || jrIsLoggedIn) return;
                var realCard = e.target.closest('.jr-card');
                if (realCard && realCard.closest('.jr-app--guest')) {
                    e.preventDefault();
                    e.stopPropagation();
                    jrShowLoginGate('Log in to play ' + (realCard.dataset.name || 'this game') + '.');
                }
            }, true);

            /* Per-category game counts — computed once from the card pool */
            var jrCatCounts = { hot: 0, slots: 0, fish: 0, table: 0, favorites: 0 };

            function jrComputeCounts() {
                var all  = Array.from(document.querySelectorAll('#jrCardPool .jr-card'));
                var favs = jrGetFavs();
                ['slots','fish','table'].forEach(function(c) {
                    jrCatCounts[c] = all.filter(function(card) { return card.dataset.cat === c; }).length;
                });
                var hot = all.filter(function(c) {
                    return c.dataset.label === 'hot' || c.dataset.label === 'new';
                }).length;
                jrCatCounts.hot       = hot || all.length;
                jrCatCounts.favorites = favs.length;
            }

            function jrUpdateBadges() {
                jrCatCounts.favorites = jrGetFavs().length;
                ['hot','slots','fish','table','favorites'].forEach(function(cat) {
                    var n   = jrCatCounts[cat] || 0;
                    var txt = n > 99 ? '99+' : String(n);
                    document.querySelectorAll('[data-badge="' + cat + '"]').forEach(function(el) {
                        el.textContent = txt;
                    });
                });
            }

            function jrGetFavs() {
                try { return JSON.parse(localStorage.getItem('jr_favs') || '[]'); }
                catch(e) { return []; }
            }
            function jrSetFavs(f) {
                try { localStorage.setItem('jr_favs', JSON.stringify(f)); } catch(e) {}
            }

            /* Merge server favorites into localStorage on load */
            if (jrIsLoggedIn) {
                fetch('/user/favorites', { credentials: 'same-origin' })
                    .then(function(r) { return r.ok ? r.json() : null; })
                    .then(function(data) {
                        if (data && Array.isArray(data.favorites) && data.favorites.length) {
                            var local = jrGetFavs();
                            var merged = data.favorites.concat(local.filter(function(n) {
                                return data.favorites.indexOf(n) < 0;
                            }));
                            jrSetFavs(merged);
                            jrUpdateFavIcons();
                        }
                    })
                    .catch(function() {});
            }

            window.jrToggleFav = function(name) {
                var favs = jrGetFavs();
                var idx = favs.indexOf(name);
                var adding = idx < 0;
                if (adding) favs.push(name); else favs.splice(idx, 1);
                jrSetFavs(favs);
                jrUpdateFavIcons();

                /* Sync to server for logged-in users */
                if (jrIsLoggedIn) {
                    var method = adding ? 'POST' : 'DELETE';
                    var url    = (adding ? '/favorites/add/' : '/favorites/remove/') + encodeURIComponent(name);
                    fetch(url, {
                        method: method,
                        credentials: 'same-origin',
                        headers: { 'X-CSRF-TOKEN': jrCsrfToken, 'Accept': 'application/json' }
                    }).catch(function() {});
                }
            };

            function jrUpdateFavIcons() {
                var favs = jrGetFavs();
                document.querySelectorAll('.jr-fav-icon').forEach(function(svg) {
                    var name = svg.dataset.name;
                    var on = favs.indexOf(name) >= 0;
                    svg.setAttribute('fill', on ? '#FF1493' : 'none');
                    svg.setAttribute('stroke', on ? '#FF1493' : 'rgba(255,255,255,0.7)');
                    svg.style.filter = on ? 'drop-shadow(0 0 4px #FF1493)' : 'none';
                });
            }

            /* Always render the stacked multi-section feed (was portrait-only).
               Sidebar / bottom-nav tabs scroll to the corresponding section. */
            function jrIsPortrait() { return true; }

            window.jrSelectCat = function(cat, btn) {
                /* Sync ALL nav buttons (sidebar + bottom nav) */
                document.querySelectorAll('.jr-sidebar__btn, .jr-bnav__btn').forEach(function(b) {
                    b.classList.remove('active');
                });
                document.querySelectorAll('[data-cat="' + cat + '"]').forEach(function(b) {
                    b.classList.add('active');
                });
                /* Color-theme the cat bar */
                var catBar = document.getElementById('jrCatBar');
                if (catBar) catBar.dataset.cat = cat;

                /* In portrait: scroll to that section (multi-section feed). In landscape/desktop: filter. */
                if (jrIsPortrait()) {
                    var sec = document.getElementById('jrSec-' + cat);
                    var carousel = document.getElementById('jrCarousel');
                    if (sec && carousel) {
                        carousel.scrollTo({ top: sec.offsetTop - 8, behavior: 'smooth' });
                    }
                    return;
                }
                jrRender(cat);
            };

            function jrRowCount() {
                if (window.innerWidth >= 800) return 2;                          /* desktop: 2 rows */
                if (window.matchMedia('(orientation: portrait)').matches) return 2; /* phone portrait: 2-row grid */
                return 1;                                                         /* phone landscape: single tall row */
            }

            var jrCurrentCat = 'hot';

            function jrBuildCarousel(carousel, visible) {
                carousel.innerHTML = '';
                if (visible.length === 0) {
                    carousel.innerHTML = '<div class="jr-empty"><p>No games found</p></div>';
                    return;
                }
                var rows = jrRowCount();
                for (var i = 0; i < visible.length; i += rows) {
                    var col = document.createElement('div');
                    col.className = 'jr-col';
                    for (var r = 0; r < rows; r++) {
                        if (visible[i + r]) col.innerHTML += visible[i + r].outerHTML;
                    }
                    carousel.appendChild(col);
                }
                jrUpdateFavIcons();
            }

            function jrFilterFor(catKey, cards, favs) {
                if (catKey === 'hot') {
                    var hot = cards.filter(function(c) { return c.dataset.label === 'hot' || c.dataset.label === 'new'; });
                    return hot.length ? hot : cards.slice();
                }
                if (catKey === 'favorites') {
                    return cards.filter(function(c) { return favs.indexOf(c.dataset.name) >= 0; });
                }
                return cards.filter(function(c) { return c.dataset.cat === catKey; });
            }

            /* PORTRAIT: render every category as its own stacked section, scrollable vertically */
            function jrBuildSections(carousel, cards, favs) {
                carousel.innerHTML = '';
                var order = ['hot', 'favorites', 'slots', 'fish', 'table'];
                order.forEach(function(catKey) {
                    var games = jrFilterFor(catKey, cards, favs);
                    if (games.length === 0 && catKey !== 'favorites') return;  /* skip empty non-fav sections */
                    var sec = document.createElement('section');
                    sec.className = 'jr-section jr-section--' + catKey;
                    sec.id = 'jrSec-' + catKey;
                    var head = document.createElement('div');
                    head.className = 'jr-section__head';
                    head.innerHTML = '<span class="jr-section__title">' + (CAT_TITLES[catKey] || catKey) + '</span>'
                                   + '<span class="jr-section__count">' + games.length + '</span>';
                    sec.appendChild(head);
                    var grid = document.createElement('div');
                    grid.className = 'jr-section__grid';
                    if (games.length === 0) {
                        grid.innerHTML = '<div class="jr-section__empty">No favorites yet — tap the heart on any game.</div>';
                    } else {
                        games.forEach(function(c) { grid.innerHTML += c.outerHTML; });
                    }
                    sec.appendChild(grid);
                    carousel.appendChild(sec);
                });
                jrUpdateFavIcons();
            }

            window.jrRender = function(cat) {
                if (cat) jrCurrentCat = cat;
                var cards   = Array.from(document.querySelectorAll('#jrCardPool .jr-card'));
                var favs    = jrGetFavs();
                var carousel = document.getElementById('jrCarousel');
                if (!carousel) return;

                /* PORTRAIT: stack all categories as sections (no filtering by tab) */
                if (jrIsPortrait()) {
                    carousel.classList.add('jr-portrait-mode');
                    jrBuildSections(carousel, cards, favs);
                    var titleEl = document.getElementById('jrCatTitle');
                    var countEl = document.getElementById('jrCatCount');
                    if (titleEl) titleEl.textContent = 'All Games';
                    if (countEl) countEl.textContent = cards.length;
                    jrUpdateBadges();
                    return;
                }
                carousel.classList.remove('jr-portrait-mode');

                /* LANDSCAPE / DESKTOP: original single-category filtered view */
                var visible = jrFilterFor(jrCurrentCat, cards, favs);

                var titleEl = document.getElementById('jrCatTitle');
                var countEl = document.getElementById('jrCatCount');
                if (titleEl) titleEl.textContent = CAT_TITLES[jrCurrentCat] || jrCurrentCat;
                if (countEl) countEl.textContent = visible.length;

                /* Crossfade: fade out → swap content → fade in */
                carousel.classList.add('jr-fading');
                carousel.classList.remove('jr-showing');
                var snap = visible.slice();
                setTimeout(function() {
                    jrBuildCarousel(carousel, snap);
                    carousel.scrollLeft = 0;
                    carousel.classList.remove('jr-fading');
                    carousel.classList.add('jr-showing');
                    setTimeout(function() { carousel.classList.remove('jr-showing'); }, 250);
                    jrUpdateBadges();
                }, 95);
            };

            window.jrRefreshBalance = function(btn) {
                if (btn) btn.classList.add('refreshing');
                fetch('/user/balance', { credentials: 'same-origin', headers: { 'Accept': 'application/json' } })
                    .then(function(r) { return r.ok ? r.json() : null; })
                    .then(function(data) {
                        if (data && data.balance !== undefined) {
                            var el = document.getElementById('jrBalanceAmt');
                            if (el) el.textContent = '$' + data.balance;
                        }
                        if (btn) btn.classList.remove('refreshing');
                    })
                    .catch(function() {
                        if (btn) btn.classList.remove('refreshing');
                        location.reload();
                    });
            };

            /* Re-render on orientation change or resize */
            var jrResizeTimer = null;
            function jrOnResize() {
                clearTimeout(jrResizeTimer);
                jrResizeTimer = setTimeout(function() {
                    jrRender();
                }, 120);
            }
            window.addEventListener('orientationchange', function() {
                setTimeout(jrOnResize, 50);
            });
            window.addEventListener('resize', jrOnResize);

            /* ═══ LIVE JACKPOT COUNTERS — rolling digits ═════════════ */
            function jrFmt(n) { return Math.floor(n).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','); }
            function jrInitJackpots() {
                document.querySelectorAll('.jr-jackpot').forEach(function(jp) {
                    var base = parseFloat(jp.dataset.base) || 0;
                    var rate = parseFloat(jp.dataset.rate) || 1;
                    /* slight random offset so they don't all start in lockstep */
                    jp._cur = base + Math.floor(Math.random() * 500);
                    jp._rate = rate;
                    var amtEl = jp.querySelector('[data-jp-amt]');
                    if (amtEl) amtEl.textContent = jrFmt(jp._cur);
                });
                setInterval(function() {
                    document.querySelectorAll('.jr-jackpot').forEach(function(jp) {
                        /* increment by rate * (1..3) every tick — feels organic */
                        jp._cur += jp._rate * (1 + Math.random() * 2);
                        var amtEl = jp.querySelector('[data-jp-amt]');
                        if (amtEl) {
                            amtEl.textContent = jrFmt(jp._cur);
                            var box = jp.querySelector('.jr-jackpot__amt');
                            if (box) {
                                box.classList.remove('jr-jp-tick');
                                /* eslint-disable-next-line no-unused-expressions */
                                box.offsetWidth;
                                box.classList.add('jr-jp-tick');
                            }
                        }
                    });
                }, 850);
            }

            /* ═══ LIVE WIN TICKER — rotating fake winners ════════════ */
            var JR_NAMES = ['Marco G.','Ana L.','Jordan T.','Maya P.','Rico V.','Liza M.','Carl D.',
                            'Elena S.','Diego R.','Faye N.','Kai B.','Noor A.','Ravi K.','Sofia C.',
                            'Theo J.','Wren H.','Zoe F.','Hana O.','Ivan W.','Lia Q.'];
            var JR_GAMES = ['Sweet Bonanza','Gates of Olympus','Wolf Gold','Book of Dead','Starburst',
                            'Fortune Ox','Money Train 3','Caishen Gold','Joker Bomber','Gold Party','Book of Ra'];
            var JR_EVENTS = [
                { ico:'🎉', verb:'won',           min:1500,  max:18000 },
                { ico:'🔥', verb:'big win on',    min:8000,  max:65000 },
                { ico:'💎', verb:'jackpot on',    min:48000, max:240000 },
                { ico:'⚡', verb:'bonus on',      min:900,   max:6500 },
                { ico:'🍀', verb:'lucky win on',  min:3200,  max:24000 }
            ];
            function jrPick(arr) { return arr[Math.floor(Math.random()*arr.length)]; }
            function jrMakeWin() {
                var ev = jrPick(JR_EVENTS);
                var amt = Math.floor(ev.min + Math.random()*(ev.max - ev.min));
                /* round to nearest 50 for realism */
                amt = Math.round(amt/50)*50;
                return ev.ico + ' ' + jrPick(JR_NAMES) + ' ' + ev.verb + ' ' + jrPick(JR_GAMES)
                     + ' — ₱' + jrFmt(amt);
            }
            function jrBuildTicker() {
                /* generate 12 wins, join with bullet — long enough to scroll smoothly */
                var arr = [];
                for (var i = 0; i < 12; i++) arr.push(jrMakeWin());
                var el = document.getElementById('jrTickerInner');
                if (el) el.innerHTML = arr.join('  •  ');
            }
            function jrInitTicker() {
                jrBuildTicker();
                /* refresh every 22s with a new batch of winners */
                setInterval(jrBuildTicker, 22000);
            }

            /* ═══ SCROLL PROGRESS BAR ════════════════════════════════ */
            function jrInitScrollProgress() {
                var c = document.getElementById('jrCarousel');
                var bar = document.getElementById('jrScrollBar');
                if (!c || !bar) return;
                function upd() {
                    var max = c.scrollWidth - c.clientWidth;
                    var pct = max > 0 ? (c.scrollLeft / max) * 100 : 0;
                    bar.style.width = pct + '%';
                }
                c.addEventListener('scroll', upd, { passive: true });
                /* MutationObserver re-checks after content swaps */
                var mo = new MutationObserver(upd);
                mo.observe(c, { childList: true });
                window.addEventListener('resize', upd);
                upd();
            }

            /* ═══ CARD STAGGER ENTRANCE ═════════════════════════════ */
            function jrStaggerCols() {
                var cols = document.querySelectorAll('#jrCarousel .jr-col');
                cols.forEach(function(col, i) {
                    col.style.animationDelay = (i * 28) + 'ms';
                });
            }
            /* hook into render cycle */
            var _origBuild = window.jrBuildCarousel;
            /* (jrBuildCarousel is a local fn, so wrap render instead) */
            var _origRender = window.jrRender;
            window.jrRender = function(cat) {
                _origRender(cat);
                setTimeout(jrStaggerCols, 105); /* after the 95ms crossfade swap */
            };

            document.addEventListener('DOMContentLoaded', function() {
                jrComputeCounts();
                jrUpdateBadges();
                jrRender('hot');
                jrInitJackpots();
                jrInitTicker();
                jrInitScrollProgress();
            });

            /* ── PULL-DOWN FULLSCREEN GESTURE (rewritten) ─────────── */
            (function() {
                var isIOS     = /iPhone|iPad|iPod/i.test(navigator.userAgent);
                var isAndroid = /Android/i.test(navigator.userAgent);
                if (!isIOS && !isAndroid) return;

                var indicator = document.getElementById('jrPullIndicator');
                var ripple    = document.getElementById('jrPullRipple');
                var startY = null, pulling = false, threshCrossed = false;
                var THRESHOLD = 75;
                var TRIGGER_ZONE = 110;          /* generous top zone — finger lands here */
                var hapticFired = false;

                function tryEnterFullscreen() {
                    /* iOS Safari can't fullscreen non-video — show Add-to-Home prompt */
                    if (isIOS) {
                        var bar = document.getElementById('jrFsBar');
                        if (bar) {
                            bar.style.display = 'flex';
                            /* highlight it briefly */
                            bar.style.animation = 'none';
                            /* eslint-disable-next-line no-unused-expressions */
                            bar.offsetWidth;
                            bar.style.animation = 'jrFadeIn 0.4s ease';
                        }
                        return;
                    }
                    /* Android / desktop Chrome — real Fullscreen API */
                    var el = document.documentElement;
                    var req = el.requestFullscreen || el.webkitRequestFullscreen
                           || el.mozRequestFullScreen || el.msRequestFullscreen;
                    if (!req) return;
                    var p = req.call(el);
                    if (p && p.then) {
                        p.then(function() {
                            localStorage.setItem('jr_fs_dismissed', '1');
                            var bar = document.getElementById('jrFsBar');
                            if (bar) bar.style.display = 'none';
                            /* lock orientation to landscape if available */
                            if (screen.orientation && screen.orientation.lock) {
                                screen.orientation.lock('landscape').catch(function(){});
                            }
                        }).catch(function(){});
                    }
                }

                function reset() {
                    if (indicator) {
                        indicator.classList.remove('jr-pull-active', 'pulling');
                        indicator.style.width = '';
                        indicator.style.opacity = '';
                        indicator.style.height = '';
                    }
                    if (ripple) ripple.style.height = '0';
                    pulling = false;
                    startY = null;
                    threshCrossed = false;
                    hapticFired = false;
                }

                document.addEventListener('touchstart', function(e) {
                    /* Only arm if at top of page AND finger landed in top zone */
                    if (window.scrollY > 4) return;
                    var y = e.touches[0].clientY;
                    if (y < TRIGGER_ZONE) {
                        startY = y;
                        pulling = true;
                        threshCrossed = false;
                        hapticFired = false;
                        if (indicator) indicator.classList.add('jr-pull-active');
                    }
                }, { passive: true });

                /* NON-passive — must preventDefault to block native pull-to-refresh */
                document.addEventListener('touchmove', function(e) {
                    if (!pulling || startY === null) return;
                    var dy = e.touches[0].clientY - startY;
                    if (dy < 0) { reset(); return; }

                    /* We own this gesture now — block browser pull-to-refresh */
                    if (e.cancelable) e.preventDefault();

                    var pct = Math.min(dy / THRESHOLD, 1.4);

                    if (indicator) {
                        indicator.style.width  = (80 + pct * 180) + 'px';
                        indicator.style.height = (3 + pct * 4) + 'px';
                        indicator.style.opacity = String(0.35 + Math.min(pct, 1) * 0.65);
                        indicator.classList.toggle('pulling', pct >= 1);
                    }
                    if (ripple) {
                        ripple.style.height = Math.min(dy * 0.55, 140) + 'px';
                    }

                    /* Haptic feedback when threshold crossed */
                    if (pct >= 1 && !hapticFired) {
                        hapticFired = true;
                        threshCrossed = true;
                        if (navigator.vibrate) navigator.vibrate(12);
                    }
                }, { passive: false });

                document.addEventListener('touchend', function(e) {
                    if (!pulling || startY === null) return;
                    var dy = e.changedTouches[0].clientY - startY;
                    if (dy >= THRESHOLD) tryEnterFullscreen();
                    reset();
                }, { passive: true });

                document.addEventListener('touchcancel', reset, { passive: true });
            })();
        })();
        </script>

        <!-- FULLSCREEN HANDLER -->
        <div id="jrFsBar" style="display:none">
            <span id="jrFsMsg"></span>
            <button id="jrFsBtn" onclick="jrEnterFullscreen()"></button>
            <button id="jrFsDismiss" onclick="jrDismissFs()">✕</button>
        </div>

        <style>
        #jrFsBar {
            position: fixed;
            bottom: 0; left: 0; right: 0;
            z-index: 99999;
            background: rgba(10,5,20,0.97);
            border-top: 1px solid rgba(212,175,55,0.4);
            backdrop-filter: blur(12px);
            display: flex !important;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            animation: jrFadeIn 0.4s ease;
        }
        #jrFsMsg {
            flex: 1;
            font-size: 13px;
            color: rgba(255,255,255,0.85);
            line-height: 1.35;
        }
        #jrFsBtn {
            background: linear-gradient(135deg, #D4AF37, #B8860B);
            border: none;
            border-radius: 8px;
            padding: 8px 14px;
            color: #000;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            white-space: nowrap;
            flex-shrink: 0;
        }
        #jrFsDismiss {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 6px;
            color: rgba(255,255,255,0.5);
            font-size: 13px;
            width: 28px; height: 28px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
            padding: 0;
        }
        /* Safe-area padding for iPhone notch/home bar */
        .jr-app {
            padding-bottom: env(safe-area-inset-bottom);
        }
        /* Hide the install/fullscreen prompt in landscape — only show in portrait */
        @media (orientation: landscape) {
            #jrFsBar { display: none !important; }
        }
        </style>

        <script>
        (function() {
            var isIOS     = /iPhone|iPad|iPod/i.test(navigator.userAgent);
            var isAndroid = /Android/i.test(navigator.userAgent);
            var isMobile  = isIOS || isAndroid;
            var standalone = window.navigator.standalone === true
                          || window.matchMedia('(display-mode: fullscreen)').matches
                          || window.matchMedia('(display-mode: standalone)').matches;

            if (!isMobile || standalone) return;
            if (localStorage.getItem('jr_fs_dismissed') === '1') return;

            var bar = document.getElementById('jrFsBar');
            var msg = document.getElementById('jrFsMsg');
            var btn = document.getElementById('jrFsBtn');

            window.jrDismissFs = function() {
                localStorage.setItem('jr_fs_dismissed', '1');
                if (bar) bar.style.display = 'none';
            };

            if (isIOS) {
                msg.innerHTML = 'For the best experience, tap <strong style="color:#D4AF37">Share</strong> then <strong style="color:#D4AF37">Add to Home Screen</strong> — launches in fullscreen.';
                btn.textContent = '📲 How to';
                btn.onclick = function() {
                    alert('To play fullscreen on iPhone:\n\n1. Tap the Share button (□↑) in Safari\n2. Scroll down and tap "Add to Home Screen"\n3. Tap Add — then open the app from your home screen');
                };
                setTimeout(function() {
                    if (bar) bar.style.display = 'flex';
                }, 2500);
            } else if (isAndroid) {
                msg.textContent = 'Tap Fullscreen for the best gaming experience.';
                btn.textContent = '⛶ Fullscreen';
                window.jrEnterFullscreen = function() {
                    var el = document.documentElement;
                    var req = el.requestFullscreen || el.webkitRequestFullscreen || el.mozRequestFullScreen || el.msRequestFullscreen;
                    if (req) {
                        req.call(el).then(function() {
                            if (bar) bar.style.display = 'none';
                            localStorage.setItem('jr_fs_dismissed', '1');
                        }).catch(function() {});
                    }
                };
                setTimeout(function() {
                    if (bar) bar.style.display = 'flex';
                }, 1500);

                document.addEventListener('fullscreenchange', function() {
                    if (!document.fullscreenElement && bar) {
                        bar.style.display = 'flex';
                    }
                });
            }
        })();
        </script>

    </div>
    <!-- ===================== END MOBILE CASINO LAYOUT ===================== -->

    <!-- ===================== DESKTOP 3D ANIMATED BACKGROUND ===================== -->
    <canvas id="casino-bg-canvas" style="display:none!important"></canvas>
    <!-- ===================== END DESKTOP 3D BACKGROUND ===================== -->

    <!-- ===================== DESKTOP NAVBAR ===================== -->
    <nav class="desktop-navbar" id="desktopNavbar">
        <a href="/" class="desktop-navbar__logo">
            <img class="desktop-navbar__logo-img" src="/woocasino/images/jade-royale-logo-v2.png?v=2" alt="Jade Royale">
        </a>
        <div class="desktop-navbar__nav">
            <a href="/" class="desktop-navbar__nav-link active">All Games</a>
            <a href="{{ route('frontend.game.list.category', 'slots') }}" class="desktop-navbar__nav-link">Slots</a>
            <a href="{{ route('frontend.game.list.category', 'all') }}" class="desktop-navbar__nav-link">Fish &amp; Arcade</a>
            <a href="{{ route('frontend.game.list.category', 'roulette') }}" class="desktop-navbar__nav-link">Table Games</a>
        </div>
        <div class="desktop-navbar__auth">
            @if(Auth::check())
            <span class="desktop-navbar__balance">
                {{ number_format(auth()->user()->balance, 2, '.', ',') }} {{ $currency ?? 'PHP' }}
            </span>
            <a href="#" class="desktop-navbar__deposit-btn" ng-click="openModal($event, '#my-account')">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
                Deposit
            </a>
            @else
            <a href="#" class="desktop-navbar__login-btn" ng-click="openModal($event, '#login-modal')">Log In</a>
            @endif
        </div>
    </nav>
    <style>
    @media (max-width: 768px) { .desktop-navbar { display: none !important; } }
    </style>
    <!-- ===================== END DESKTOP NAVBAR ===================== -->

    <!-- BLOCK WITH GAMES -->
    <main class="carcass__body">
        <div class="main-content">
            <div class="contain">

            <div class="ng-scope">
                    <!-- LAST WINNERS - Top Bar -->
                    <div class="top-winners-bar">
                        <ul class="top-winners-list">
                            @if(isset($games) && count($games) > 0)
                                @for ($i = 0;$i < 5;$i++)
                                @php
                                $g = $games[(int)(rand(0, count($games)-1))];
                                $p = ['Sa****','Ro****','Ma****','Ji****','Th****','Le****','Ki****','Ma****','St****','Pi****','Je****','Go****', 'Ma****', 'Da****'];
                                @endphp
                                <li class="top-winner-item">
                                    <img class="top-winner-img" src="/frontend/Default/ico/{{ $g->name }}.jpg" alt="{{ $g->title }}">
                                    <span class="top-winner-name">{{$p[rand(0, 13)]}}</span>
                                    <span class="top-winner-amount">${{number_format(rand(5, 3000)/rand(1,10), 2)}}</span>
                                </li>
                                @endfor
                            @endif
                        </ul>
                    </div>
                    
                    <div class="ng-scope">
                        <div class="mobile-slider ng-scope ng-isolate-scope" template="mobile-slider" category="mobile-slider">
                            <div class="carousel-fade carousel ng-scope ng-isolate-scope" >
                                <ol class="carousel-indicators">
                                    <!-- ngRepeat: slide in slides track by $index -->
                                    <li class="ng-scope active"></li>
                                    <!-- end ngRepeat: slide in slides track by $index -->
                                    <li class="ng-scope"></li>
                                    <!-- end ngRepeat: slide in slides track by $index -->
                                    <li class="ng-scope"></li>
                                    <!-- end ngRepeat: slide in slides track by $index -->
                                    <li class="ng-scope"></li>
                                    <!-- end ngRepeat: slide in slides track by $index -->
                                    <li class="ng-scope"></li>
                                    <!-- end ngRepeat: slide in slides track by $index -->
                                </ol>
                                <div class="carousel-inner">
                                    <!-- ngRepeat: slide in slides -->
                                    <div class="item text-center ng-scope ng-isolate-scope active">
                                        <div class="mobile-slider__img ng-scope" style="background-image: url(/woocasino/mslider1.gif)"></div>
                                    </div>
                                    <!-- end ngRepeat: slide in slides -->
                                    <div class="item text-center ng-scope ng-isolate-scope">
                                        <div class="mobile-slider__img ng-scope" style="background-image: url(/woocasino/mslider2.gif)"></div>
                                    </div>
                                    <!-- end ngRepeat: slide in slides -->
                                    <div class="item text-center ng-scope ng-isolate-scope">
                                        <div class="mobile-slider__img ng-scope" style="background-image: url(/woocasino/mslider3.gif)"></div>
                                    </div>
                                    <!-- end ngRepeat: slide in slides -->
                                    <div class="item text-center ng-scope ng-isolate-scope">
                                        <div class="mobile-slider__img ng-scope" style="background-image: url(/woocasino/mslider4.gif)"></div>
                                    </div>
                                    <!-- end ngRepeat: slide in slides -->
                                    <div class="item text-center ng-scope ng-isolate-scope">
                                        <div class="mobile-slider__img ng-scope" style="background-image: url(/woocasino/mslider5.gif)"></div>
                                    </div>
                                    <!-- end ngRepeat: slide in slides -->
                                </div>
                                <a class="left carousel-control">
                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                </a>
                                <a class="right carousel-control">
                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                </a>
                            </div>
                            <!-- end ngIf: slides.length -->
                            <div class="mobile-slider__content">
                                <div class="slideshow-login-wrap">
                                    @if( !isset(auth()->user()->username) )
                                    <button class="slideshow-login-btn" ng-click="openModal($event, '#login-modal')">@lang('app.log_in')</button>
                                    @else
                                    <button class="slideshow-deposit-btn" ng-click="openModal($event, '#my-account')">
                                        <span class="balance-display">{{ number_format(auth()->user()->balance, 2, '.', '') }} {{ isset($currency) ? $currency : 'EUR' }}</span>
                                        <span class="deposit-text">@lang('app.depositb')</span>
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- end ngIf: ['home'].includes(state.current.page_name) -->
                        <div class="main-content__first-screen">
                            <div class="main-content__slider main-slider ng-isolate-scope" category="main-slider">
                                <!-- ngIf: slides.length -->
                                <div class="carousel-fade carousel ng-scope ng-isolate-scope">
                                    <ol class="carousel-indicators">
                                        <!-- ngRepeat: slide in slides track by $index -->
                                        <li class="ng-scope active"></li>
                                        <!-- end ngRepeat: slide in slides track by $index -->
                                        <li class="ng-scope"></li>
                                        <!-- end ngRepeat: slide in slides track by $index -->
                                        <li class="ng-scope"></li>
                                        <!-- end ngRepeat: slide in slides track by $index -->
                                        <li class="ng-scope"></li>
                                        <!-- end ngRepeat: slide in slides track by $index -->
                                    </ol>
                                    <div class="carousel-inner">
                                        <!-- ngRepeat: slide in slides -->
                                        <div class="item text-center ng-scope ng-isolate-scope active">
                                            <div class="main-slider__img ng-scope" style="background-image: url(/woocasino/slider1.gif)"></div>
                                        </div>
                                        <!-- end ngRepeat: slide in slides -->
                                        <div class="item text-center ng-scope ng-isolate-scope">
                                            <div class="main-slider__img ng-scope" style="background-image: url(/woocasino/slider2.gif)"></div>
                                        </div>
                                        <!-- end ngRepeat: slide in slides -->
                                        <div class="item text-center ng-scope ng-isolate-scope">
                                            <div class="main-slider__img ng-scope" style="background-image: url(/woocasino/slider3.gif)"></div>
                                        </div>
                                        <!-- end ngRepeat: slide in slides -->
                                        <div class="item text-center ng-scope ng-isolate-scope">
                                            <div class="main-slider__img ng-scope" style="background-image: url(/woocasino/slider4.gif)"></div>
                                        </div>
                                        <!-- end ngRepeat: slide in slides -->
                                        <div type="main-slider" class="ng-binding ng-scope ng-isolate-scope">
                                        <div class="main-slider__promo active">
                                                <a class="main-slider__link" href=""></a>
                                                <div class="main-slider__promo-wrp">
                                                    <p class="main-slider__promo-txt">@lang('app.slider1text1')
                                                        <br> <span class="main-slider__promo-separator">
                                                        <span class="text-color-yellow">@lang('app.slider1text2')</span> </span>
                                                        <br> <span class="main-slider__promo-bg"><span class="text-color-blue">@lang('app.slider1text3')</span> @lang('app.slider1text4')</span>
                                                    </p>
                                                    <div class="main-slider__btn-wrp ng-isolate-scope">
                                                        <!-- ngIf: !$root.data.user.email -->
                                                                                                                
                                                        <button class="button button-secondary"> @lang('app.play_now') </button>
                                                        <!-- end ngIf: !$root.data.user.email -->
                                                        <!-- ngIf: $root.data.user.email -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="main-slider__promo">
                                                <a class="main-slider__link" href=""></a>
                                                <div class="main-slider__promo-wrp">
                                                <p class="main-slider__promo-txt">@lang('app.slider2text1')
                                                        <br> <span class="main-slider__promo-separator">
                                                        <span class="text-color-yellow">@lang('app.slider2text2')</span> </span>
                                                        <br> <span class="main-slider__promo-bg"><span class="text-color-blue">@lang('app.slider2text3')</span> @lang('app.slider2text4')</span>
                                                    </p>
                                                    <div class="main-slider__btn-wrp ng-isolate-scope">
                                                        <!-- ngIf: !$root.data.user.email -->
                                                                                                                
                                                        <button class="button button-secondary"> @lang('app.play_now') </button>
                                                        <!-- end ngIf: !$root.data.user.email -->
                                                        <!-- ngIf: $root.data.user.email -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="main-slider__promo" href=""></a>
                                                <div class="main-slider__promo-wrp">
                                                <p class="main-slider__promo-txt">@lang('app.slider3text1')
                                                        <br> <span class="main-slider__promo-separator">
                                                        <span class="text-color-yellow">@lang('app.slider3text2')</span> </span>
                                                        <br> <span class="main-slider__promo-bg"><span class="text-color-blue">@lang('app.slider3text3')</span> @lang('app.slider3text4')</span>
                                                    </p>
                                                    <div class="main-slider__btn-wrp ng-isolate-scope">
                                                        <!-- ngIf: !$root.data.user.email -->
                                                                                                                
                                                        <button class="button button-secondary"> @lang('app.play_now') </button>
                                                        <!-- end ngIf: !$root.data.user.email -->
                                                        <!-- ngIf: $root.data.user.email -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="main-slider__promo">
                                                <a class="main-slider__link" href=""></a>
                                                <div class="main-slider__promo-wrp">
                                                <p class="main-slider__promo-txt">@lang('app.slider4text1')
                                                        <br> <span class="main-slider__promo-separator">
                                                        <span class="text-color-yellow">@lang('app.slider4text2')</span> </span>
                                                        <br> <span class="main-slider__promo-bg"><span class="text-color-blue">@lang('app.slider4text3')</span> @lang('app.slider4text4')</span>
                                                    </p>
                                                    <div class="main-slider__btn-wrp ng-isolate-scope">
                                                        <!-- ngIf: !$root.data.user.email -->
                                                                                                                
                                                        <button class="button button-secondary"> @lang('app.play_now') </button>
                                                        <!-- end ngIf: !$root.data.user.email -->
                                                        <!-- ngIf: $root.data.user.email -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="main-slider__promo">
                                                <a class="main-slider__link" href=""></a>
                                                <div class="main-slider__promo-wrp">
                                                <p class="main-slider__promo-txt">@lang('app.slider5text1')
                                                        <br> <span class="main-slider__promo-separator">
                                                        <span class="text-color-yellow">@lang('app.slider5text2')</span> </span>
                                                        <br> <span class="main-slider__promo-bg"><span class="text-color-blue">@lang('app.slider5text3')</span> @lang('app.slider5text4')</span>
                                                    </p>
                                                    <div class="main-slider__btn-wrp ng-isolate-scope">
                                                        <!-- ngIf: !$root.data.user.email -->
                                                                                                                
                                                        <button class="button button-secondary"> @lang('app.play_now') </button>
                                                        <!-- end ngIf: !$root.data.user.email -->
                                                        <!-- ngIf: $root.data.user.email -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a class="left carousel-control">
                                        <span class="glyphicon glyphicon-chevron-left"></span>
                                    </a>
                                    <a class="right carousel-control">
                                        <span class="glyphicon glyphicon-chevron-right"></span>
                                    </a>
                                </div>
                                <!-- end ngIf: slides.length -->
                            </div>
                            <style>
                                .glass-winners {
                                    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
                                    backdrop-filter: blur(10px);
                                    -webkit-backdrop-filter: blur(10px);
                                    border-radius: 16px;
                                    border: 1px solid rgba(255, 255, 255, 0.18);
                                    padding: 20px;
                                    box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
                                }
                                .glass-winners__title {
                                    font-size: 18px;
                                    font-weight: 700;
                                    margin-bottom: 15px;
                                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                                    -webkit-background-clip: text;
                                    -webkit-text-fill-color: transparent;
                                    background-clip: text;
                                }
                                .glass-winners__list {
                                    list-style: none;
                                    padding: 0;
                                    margin: 0;
                                    display: flex;
                                    flex-direction: column;
                                    gap: 8px;
                                }
                                .glass-winner-card {
                                    display: flex;
                                    align-items: center;
                                    gap: 12px;
                                    padding: 10px 12px;
                                    background: linear-gradient(135deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.02));
                                    backdrop-filter: blur(8px);
                                    border-radius: 12px;
                                    border: 1px solid rgba(255, 255, 255, 0.1);
                                    transition: all 0.3s ease;
                                    cursor: pointer;
                                }
                                .glass-winner-card:hover {
                                    background: linear-gradient(135deg, rgba(255, 255, 255, 0.12), rgba(255, 255, 255, 0.04));
                                    transform: translateX(4px);
                                    border-color: rgba(255, 255, 255, 0.2);
                                }
                                .glass-winner-card__img {
                                    width: 50px;
                                    height: 50px;
                                    border-radius: 8px;
                                    object-fit: cover;
                                    border: 2px solid rgba(255, 255, 255, 0.15);
                                }
                                .glass-winner-card__info {
                                    flex: 1;
                                    min-width: 0;
                                }
                                .glass-winner-card__name {
                                    font-size: 13px;
                                    font-weight: 600;
                                    color: rgba(255, 255, 255, 0.95);
                                    margin: 0 0 2px 0;
                                    white-space: nowrap;
                                    overflow: hidden;
                                    text-overflow: ellipsis;
                                }
                                .glass-winner-card__game {
                                    font-size: 11px;
                                    color: rgba(255, 255, 255, 0.6);
                                    margin: 0;
                                    white-space: nowrap;
                                    overflow: hidden;
                                    text-overflow: ellipsis;
                                }
                                .glass-winner-card__amount {
                                    font-size: 16px;
                                    font-weight: 700;
                                    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
                                    -webkit-background-clip: text;
                                    -webkit-text-fill-color: transparent;
                                    background-clip: text;
                                    white-space: nowrap;
                                }
                            </style>
                            <div class="main-content__latest-winners glass-winners ng-isolate-scope">
                                <h3 class="glass-winners__title ng-binding">@lang('app.last_winner')</h3>
                                <ul class="glass-winners__list ng-scope">
                                    @if(count($games) > 0)
                                        @for ($i = 0;$i < 5;$i++)
                                        @php
                                        $g = $games[(int)(rand(0, count($games)-1))];
                                        $p = ['Sa****','Ro****','Ma****','Ji****','Th****','Le****','Ki****','Ma****','St****','Pi****','Je****','Go****', 'Ma****', 'Da****'];
                                        @endphp
                                        <li class="glass-winner-card ng-scope">
                                            <img class="glass-winner-card__img" src="/frontend/Default/ico/{{ $g->name }}.jpg" alt="{{ $g->title }}">
                                            <div class="glass-winner-card__info">
                                                <p class="glass-winner-card__name">{{$p[rand(0, 13)]}} @lang('app.just_won')</p>
                                                <p class="glass-winner-card__game">{{ $g->title }}</p>
                                            </div>
                                            <div class="glass-winner-card__amount">${{number_format(rand(5, 3000)/rand(1,10), 2)}}</div>
                                        </li>
                                        @endfor
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- PLAYER ACTION BAR - Withdraw, Balance, Deposit -->
                    <div class="player-action-bar player-action-bar--centered">
                        <button class="player-btn player-btn--withdraw" ng-click="openModal($event, '#my-account')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
                            Withdraw
                        </button>
                        <div class="player-action-bar__balance-center">
                            @if(Auth::check())
                            <span class="balance-value-large">{{ number_format(auth()->user()->balance, 2, '.', ',') }} {{ $currency }}</span>
                            <span class="balance-label-small">Available Credit</span>
                            @else
                            <button class="player-btn player-btn--login" ng-click="openModal($event, '#login-modal')">Login</button>
                            @endif
                        </div>
                        <button class="player-btn player-btn--deposit" ng-click="openModal($event, '#my-account')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
                            Deposit
                        </button>
                    </div>

                    <!-- ACTION BAR - 4 Bonus Icons -->
                    <div class="slideshow-action-bar">
                        <div class="bonus-icons-row bonus-icons-row--small">
                            <a class="bonus-icon-item" data-bonus="wheel" onclick="openBonusModal(); switchBonusTab('wheel');">
                                <div class="bonus-icon-img"><img src="/woocasino/images/bonus-icons/wheel.png" alt="Wheel"></div>
                                <span class="bonus-icon-label">Wheel</span>
                            </a>
                            <a class="bonus-icon-item" data-bonus="referral" onclick="openBonusModal(); switchBonusTab('referral');">
                                <div class="bonus-icon-img"><img src="/woocasino/images/bonus-icons/jackpot.png" alt="Referral"></div>
                                <span class="bonus-icon-label">Referral</span>
                            </a>
                            <a class="bonus-icon-item" data-bonus="daily" onclick="openBonusModal(); switchBonusTab('daily');">
                                <div class="bonus-icon-img"><img src="/woocasino/images/bonus-icons/daily.png" alt="Daily"></div>
                                <span class="bonus-icon-label">Daily</span>
                            </a>
                            <a class="bonus-icon-item" data-bonus="more" onclick="openMoreModal();">
                                <div class="bonus-icon-img"><img src="/woocasino/images/bonus-icons/more.png" alt="More"></div>
                                <span class="bonus-icon-label">More</span>
                            </a>
                        </div>
                    </div>

                    <!-- BONUS MODAL POPUP -->
                    @php
                    $welcomeBonuses = \DB::table('welcomebonuses')->where('shop_id', $jrShopId)->get();
                    $wheelFortune = \DB::table('wheelfortune')->where('shop_id', $jrShopId)->where('active', true)->first();
                    $jackpots = \DB::table('jpg')->where('shop_id', $jrShopId)->where('active', true)->get();
                    $dailyBonuses = \DB::table('daily_bonus')->where('shop_id', $jrShopId)->where('active', true)->orderBy('day')->get();
                    if (empty($wheelFortune)) { $wheelFortune = \DB::table('wheelfortune')->where('active', true)->first(); }
                    if ($jackpots->isEmpty())  { $jackpots = \DB::table('jpg')->where('active', true)->get(); }
                    if ($dailyBonuses->isEmpty()) { $dailyBonuses = \DB::table('daily_bonus')->where('active', true)->orderBy('day')->get(); }
                    $modalCurrency = Auth::check() && auth()->user()->present()->shop ? auth()->user()->present()->shop->currency : '$';
                    @endphp
                    <div class="bonus-modal-overlay" id="bonusModalOverlay" onclick="closeBonusModal()">
                        <div class="bonus-modal" onclick="event.stopPropagation()">
                            <button class="bonus-modal__close" onclick="closeBonusModal()">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
                            </button>
                            <div class="bonus-modal__header">
                                <h2 class="bonus-modal__title">Exclusive Bonuses</h2>
                                <p class="bonus-modal__subtitle">Unlock amazing rewards!</p>
                            </div>
                            <div class="bonus-modal__tabs">
                                <button class="bonus-modal__tab active" data-tab="wheel" onclick="switchBonusTab('wheel')">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="3"/></svg>
                                    Wheel
                                </button>
                                <button class="bonus-modal__tab" data-tab="referral" onclick="switchBonusTab('referral')">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                                    Referral
                                </button>
                                <button class="bonus-modal__tab" data-tab="daily" onclick="switchBonusTab('daily')">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8 2 5 5 5 9c0 5 7 13 7 13s7-8 7-13c0-4-3-7-7-7z"/></svg>
                                    Dragon Egg
                                </button>
                            </div>
                            <div class="bonus-modal__content">
                                <!-- WHEEL TAB - Premium Design -->
                                <div class="bonus-modal__panel active" data-panel="wheel">
                                    @php
                                        $defaultSectors = [
                                            ['label' => '$0.05', 'color' => '#FF6B35'],
                                            ['label' => '$0.15', 'color' => '#4ECDC4'],
                                            ['label' => '$0.50', 'color' => '#45B7D1'],
                                            ['label' => '$5.00', 'color' => '#2ECC71'],
                                            ['label' => 'GOOD LUCK', 'color' => '#3498DB'],
                                            ['label' => '$0.02', 'color' => '#9B59B6'],
                                            ['label' => '$0.20', 'color' => '#E74C3C'],
                                            ['label' => '$1.00', 'color' => '#F39C12'],
                                            ['label' => '$10.00', 'color' => '#1ABC9C'],
                                            ['label' => 'GOOD LUCK', 'color' => '#E91E63'],
                                            ['label' => '$0.03', 'color' => '#00BCD4'],
                                            ['label' => '$0.77', 'color' => '#8BC34A'],
                                            ['label' => '$2.00', 'color' => '#FF5722'],
                                            ['label' => 'GOOD LUCK', 'color' => '#673AB7'],
                                            ['label' => '$0.01', 'color' => '#009688'],
                                            ['label' => '$0.25', 'color' => '#CDDC39'],
                                            ['label' => '$1.50', 'color' => '#FF9800'],
                                            ['label' => '$50.00', 'color' => '#E040FB'],
                                        ];
                                        $sectors = $wheelFortune ? (json_decode($wheelFortune->sectors, true) ?? $defaultSectors) : $defaultSectors;
                                        $sectorCount = count($sectors);
                                        $sectorAngle = $sectorCount > 0 ? 360 / $sectorCount : 20;
                                    @endphp
                                    <div class="premium-wheel-container">
                                        <div class="premium-wheel-bg">
                                            <div class="premium-wheel-rays"></div>
                                            <div class="premium-wheel-sparkles"></div>
                                        </div>
                                        <div class="premium-wheel-title">
                                            <span class="wheel-title-text">FORTUNE WHEEL</span>
                                        </div>
                                        <div class="premium-wheel-pointer">
                                            <svg viewBox="0 0 50 60" fill="none">
                                                <path d="M25 60L5 20C5 8.954 13.954 0 25 0s20 8.954 20 20L25 60z" fill="url(#pointerGold)"/>
                                                <circle cx="25" cy="20" r="8" fill="#8B0000"/>
                                                <defs>
                                                    <linearGradient id="pointerGold" x1="25" y1="0" x2="25" y2="60" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#FFD700"/>
                                                        <stop offset="0.5" stop-color="#FFA500"/>
                                                        <stop offset="1" stop-color="#B8860B"/>
                                                    </linearGradient>
                                                </defs>
                                            </svg>
                                        </div>
                                        <div class="premium-wheel-frame">
                                            <div class="premium-wheel-lights">
                                                @for($i = 0; $i < 24; $i++)
                                                <div class="wheel-light" style="transform: rotate({{ $i * 15 }}deg);"></div>
                                                @endfor
                                            </div>
                                            <div class="premium-wheel-inner" id="premiumWheel">
                                                <svg viewBox="0 0 400 400" class="wheel-svg">
                                                    <defs>
                                                        <filter id="wheelShadow" x="-20%" y="-20%" width="140%" height="140%">
                                                            <feDropShadow dx="0" dy="0" stdDeviation="8" flood-color="#000" flood-opacity="0.5"/>
                                                        </filter>
                                                    </defs>
                                                    <circle cx="200" cy="200" r="195" fill="url(#frameGold)" filter="url(#wheelShadow)"/>
                                                    <circle cx="200" cy="200" r="180" fill="#1a1a2e"/>
                                                    @foreach($sectors as $index => $sector)
                                                        @php
                                                            $startAngle = $index * $sectorAngle;
                                                            $endAngle = ($index + 1) * $sectorAngle;
                                                            $startRad = deg2rad($startAngle - 90);
                                                            $endRad = deg2rad($endAngle - 90);
                                                            $x1 = 200 + 175 * cos($startRad);
                                                            $y1 = 200 + 175 * sin($startRad);
                                                            $x2 = 200 + 175 * cos($endRad);
                                                            $y2 = 200 + 175 * sin($endRad);
                                                            $largeArc = $sectorAngle > 180 ? 1 : 0;
                                                            $midAngle = ($startAngle + $endAngle) / 2;
                                                            $midRad = deg2rad($midAngle - 90);
                                                            $textX = 200 + 120 * cos($midRad);
                                                            $textY = 200 + 120 * sin($midRad);
                                                        @endphp
                                                        <path d="M200,200 L{{ $x1 }},{{ $y1 }} A175,175 0 {{ $largeArc }},1 {{ $x2 }},{{ $y2 }} Z" fill="{{ $sector['color'] ?? '#FFD700' }}" stroke="#1a1a2e" stroke-width="1"/>
                                                        <text x="{{ $textX }}" y="{{ $textY }}" text-anchor="middle" dominant-baseline="middle" fill="#fff" font-size="{{ strlen($sector['label']) > 4 ? '11' : '14' }}" font-weight="bold" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.8);" transform="rotate({{ $midAngle }}, {{ $textX }}, {{ $textY }})">{{ $sector['label'] ?? '' }}</text>
                                                    @endforeach
                                                    <defs>
                                                        <linearGradient id="frameGold" x1="0%" y1="0%" x2="100%" y2="100%">
                                                            <stop offset="0%" stop-color="#FFD700"/>
                                                            <stop offset="25%" stop-color="#FFA500"/>
                                                            <stop offset="50%" stop-color="#FFD700"/>
                                                            <stop offset="75%" stop-color="#B8860B"/>
                                                            <stop offset="100%" stop-color="#FFD700"/>
                                                        </linearGradient>
                                                        <radialGradient id="centerGold" cx="50%" cy="30%" r="70%">
                                                            <stop offset="0%" stop-color="#FFD700"/>
                                                            <stop offset="50%" stop-color="#FFA500"/>
                                                            <stop offset="100%" stop-color="#B8860B"/>
                                                        </radialGradient>
                                                    </defs>
                                                    <circle cx="200" cy="200" r="45" fill="url(#centerGold)" stroke="#B8860B" stroke-width="3"/>
                                                    <text x="200" y="200" text-anchor="middle" dominant-baseline="middle" fill="#8B0000" font-size="16" font-weight="bold" style="text-shadow: 0 1px 0 rgba(255,255,255,0.5);">SPIN</text>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="premium-wheel-actions">
                                            @if(Auth::check())
                                                <button class="premium-spin-btn" onclick="spinPremiumWheel()">
                                                    <span class="spin-btn-glow"></span>
                                                    <span class="spin-btn-text">SPIN NOW!</span>
                                                </button>
                                            @else
                                                <button class="premium-spin-btn premium-spin-btn--login" onclick="closeBonusModal(); setTimeout(function(){document.querySelector('.js-login').click();}, 300);">
                                                    <span class="spin-btn-glow"></span>
                                                    <span class="spin-btn-text">LOGIN TO SPIN</span>
                                                </button>
                                            @endif
                                        </div>
                                        <div class="premium-wheel-result" id="wheelResult" style="display:none;">
                                            <div class="result-celebration">
                                                <span class="result-label">YOU WON</span>
                                                <span class="result-amount" id="wheelPrize">$0.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- REFERRAL TAB -->
                                <div class="bonus-modal__panel" data-panel="referral">
                                    <div class="referral-tracker">
                                        <div class="referral-tracker__header">
                                            <h3 class="referral-tracker__title">Referral Bonus Tracker</h3>
                                            <p class="referral-tracker__subtitle">Invite friends and earn rewards!</p>
                                        </div>
                                        <div class="referral-tracker__stats">
                                            <div class="referral-stat">
                                                <span class="referral-stat__value">{{ Auth::check() ? (auth()->user()->referral_count ?? 0) : 0 }}</span>
                                                <span class="referral-stat__label">Total Referrals</span>
                                            </div>
                                            <div class="referral-stat referral-stat--highlight">
                                                <span class="referral-stat__value">{{ $modalCurrency }}{{ Auth::check() ? number_format(auth()->user()->referral_earnings ?? 0, 2) : '0.00' }}</span>
                                                <span class="referral-stat__label">Total Earned</span>
                                            </div>
                                            <div class="referral-stat">
                                                <span class="referral-stat__value">{{ $modalCurrency }}5.00</span>
                                                <span class="referral-stat__label">Per Referral</span>
                                            </div>
                                        </div>
                                        @if(Auth::check())
                                        <div class="referral-tracker__code">
                                            <span class="referral-code-label">Your Referral Code</span>
                                            <div class="referral-code-box">
                                                <span class="referral-code" id="referralCode">{{ strtoupper(substr(auth()->user()->username ?? 'USER', 0, 4)) }}{{ auth()->user()->id ?? '000' }}</span>
                                                <button class="referral-copy-btn" onclick="copyReferralCode()">
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                                                    Copy
                                                </button>
                                            </div>
                                        </div>
                                        <div class="referral-tracker__progress">
                                            <div class="referral-progress-bar">
                                                <div class="referral-progress-fill" style="width: {{ min(((auth()->user()->referral_count ?? 0) / 10) * 100, 100) }}%;"></div>
                                            </div>
                                            <span class="referral-progress-text">{{ auth()->user()->referral_count ?? 0 }}/10 referrals to next bonus tier!</span>
                                        </div>
                                        @else
                                        <div class="referral-tracker__login">
                                            <p>Login to get your referral code and start earning!</p>
                                            <button class="referral-login-btn" onclick="closeBonusModal(); setTimeout(function(){document.querySelector('.js-login').click();}, 300);">Login Now</button>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- DAILY TAB - Dragon Egg Game -->
                                @php
                                    $dailyBonusAmount = \DB::table('daily_bonus')->where('shop_id', $jrShopId)->where('active', true)->value('reward')
                                        ?? \DB::table('daily_bonus')->where('active', true)->value('reward')
                                        ?? 10;
                                @endphp
                                <div class="bonus-modal__panel" data-panel="daily">
                                    <div class="dragon-egg-game" id="dragonEggGame">
                                        <h3 class="dragon-egg-title">Pick a Dragon Egg!</h3>
                                        <p class="dragon-egg-subtitle">Choose your egg to reveal your daily bonus of <span class="prize-amount">${{ number_format($dailyBonusAmount, 0) }}</span></p>
                                        <div class="dragon-eggs-container" id="dragonEggsContainer">
                                            <div class="dragon-egg" data-egg="1" onclick="pickDragonEgg(1)">
                                                <img src="/woocasino/images/bonus-icons/dragon-egg.png" alt="Dragon Egg 1">
                                                <div class="egg-glow"></div>
                                            </div>
                                            <div class="dragon-egg" data-egg="2" onclick="pickDragonEgg(2)">
                                                <img src="/woocasino/images/bonus-icons/dragon-egg.png" alt="Dragon Egg 2">
                                                <div class="egg-glow"></div>
                                            </div>
                                            <div class="dragon-egg" data-egg="3" onclick="pickDragonEgg(3)">
                                                <img src="/woocasino/images/bonus-icons/dragon-egg.png" alt="Dragon Egg 3">
                                                <div class="egg-glow"></div>
                                            </div>
                                        </div>
                                        <div class="dragon-egg-result" id="dragonEggResult" style="display: none;">
                                            <div class="prize-reveal">
                                                <div class="prize-coins"></div>
                                                <span class="prize-text">Congratulations!</span>
                                                <span class="prize-value">${{ number_format($dailyBonusAmount, 0) }}</span>
                                                <span class="prize-subtext">Added to your balance!</span>
                                            </div>
                                        </div>
                                        @if(!Auth::check())
                                        <p class="dragon-egg-login-prompt">Please login to claim your daily bonus!</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- MORE MODAL POPUP -->
                    <div class="more-modal-overlay" id="moreModalOverlay" onclick="closeMoreModal()">
                        <div class="more-modal" onclick="event.stopPropagation()">
                            <button class="more-modal__close" onclick="closeMoreModal()">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
                            </button>
                            <div class="more-modal__header">
                                <h2 class="more-modal__title">My Account</h2>
                            </div>
                            <div class="more-modal__tabs">
                                <button class="more-modal__tab active" data-tab="history" onclick="switchMoreTab('history')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    History
                                </button>
                                <button class="more-modal__tab" data-tab="settings" onclick="switchMoreTab('settings')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
                                    Settings
                                </button>
                                <button class="more-modal__tab" data-tab="profile" onclick="switchMoreTab('profile')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    Profile
                                </button>
                                <button class="more-modal__tab" data-tab="message" onclick="switchMoreTab('message')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                                    Message
                                </button>
                            </div>
                            <div class="more-modal__content">
                                <!-- HISTORY TAB -->
                                <div class="more-modal__panel active" data-panel="history">
                                    <div class="history-tabs">
                                        <button class="history-subtab active" onclick="switchHistorySubtab('transactions')">Transactions</button>
                                        <button class="history-subtab" onclick="switchHistorySubtab('bonuses')">Bonuses</button>
                                        <button class="history-subtab" onclick="switchHistorySubtab('games')">Games Played</button>
                                    </div>
                                    <div class="history-content" id="historyTransactions">
                                        @if(Auth::check())
                                        <div class="history-list" id="transactionsList">
                                            <p class="history-empty">No transactions yet.</p>
                                        </div>
                                        @else
                                        <p class="history-login-prompt">Please login to view your history.</p>
                                        @endif
                                    </div>
                                    <div class="history-content" id="historyBonuses" style="display:none;">
                                        @if(Auth::check())
                                        <div class="history-list" id="bonusesList">
                                            <p class="history-empty">No bonuses claimed yet.</p>
                                        </div>
                                        @else
                                        <p class="history-login-prompt">Please login to view your bonuses.</p>
                                        @endif
                                    </div>
                                    <div class="history-content" id="historyGames" style="display:none;">
                                        @if(Auth::check())
                                        <div class="history-list" id="gamesList">
                                            <p class="history-empty">No games played yet.</p>
                                        </div>
                                        @else
                                        <p class="history-login-prompt">Please login to view your game history.</p>
                                        @endif
                                    </div>
                                </div>
                                <!-- SETTINGS TAB -->
                                <div class="more-modal__panel" data-panel="settings">
                                    <div class="settings-section">
                                        <h4 class="settings-title">Sound Settings</h4>
                                        <div class="settings-row">
                                            <label>Music Volume</label>
                                            <input type="range" min="0" max="100" value="50" class="volume-slider" id="musicVolume">
                                            <span class="volume-value">50%</span>
                                        </div>
                                        <div class="settings-row">
                                            <label>Sound Effects</label>
                                            <input type="range" min="0" max="100" value="50" class="volume-slider" id="sfxVolume">
                                            <span class="volume-value">50%</span>
                                        </div>
                                    </div>
                                    @if(Auth::check())
                                    <div class="settings-section">
                                        <h4 class="settings-title">Change Password</h4>
                                        <form id="changePasswordForm" onsubmit="return changePassword(event)">
                                            <div class="form-group">
                                                <label>Current Password</label>
                                                <input type="password" name="current_password" class="settings-input" required>
                                            </div>
                                            <div class="form-group">
                                                <label>New Password</label>
                                                <input type="password" name="new_password" class="settings-input" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Confirm New Password</label>
                                                <input type="password" name="confirm_password" class="settings-input" required>
                                            </div>
                                            <button type="submit" class="settings-btn">Update Password</button>
                                        </form>
                                    </div>
                                    @endif
                                </div>
                                <!-- PROFILE TAB -->
                                <div class="more-modal__panel" data-panel="profile">
                                    @if(Auth::check())
                                    <div class="profile-card">
                                        <div class="profile-avatar">
                                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                                        </div>
                                        <div class="profile-details">
                                            <div class="profile-row">
                                                <span class="profile-label">Username</span>
                                                <span class="profile-value">{{ auth()->user()->username }}</span>
                                            </div>
                                            <div class="profile-row">
                                                <span class="profile-label">User ID</span>
                                                <span class="profile-value">{{ auth()->user()->id }}</span>
                                            </div>
                                            <div class="profile-row">
                                                <span class="profile-label">Shop ID</span>
                                                <span class="profile-value">{{ auth()->user()->shop_id ?? 'N/A' }}</span>
                                            </div>
                                            <div class="profile-row">
                                                <span class="profile-label">Balance</span>
                                                <span class="profile-value balance">{{ $modalCurrency }}{{ number_format(auth()->user()->balance, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <p class="profile-login-prompt">Please login to view your profile.</p>
                                    @endif
                                </div>
                                <!-- MESSAGE TAB -->
                                <div class="more-modal__panel" data-panel="message">
                                    @if(Auth::check())
                                    <div class="message-section">
                                        <h4 class="message-title">Send Message to Shop</h4>
                                        <form id="shopMessageForm" onsubmit="return sendShopMessage(event)">
                                            <div class="form-group">
                                                <label>Subject</label>
                                                <input type="text" name="subject" class="settings-input" placeholder="Enter subject..." required>
                                            </div>
                                            <div class="form-group">
                                                <label>Message</label>
                                                <textarea name="message" class="settings-textarea" rows="5" placeholder="Type your message here..." required></textarea>
                                            </div>
                                            <button type="submit" class="settings-btn">Send Message</button>
                                        </form>
                                        <div id="messageStatus" class="message-status" style="display:none;"></div>
                                    </div>
                                    @else
                                    <p class="message-login-prompt">Please login to send messages.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CONFETTI CONTAINER -->
                    <div id="confettiContainer" class="confetti-container"></div>

                    <div class="category-panel" style="display: none;">
                        <nav class="category-panel__menu games-menu ng-isolate-scope" name="games_menu">
                            <ul class="games-menu__list">
                                <li class="games-menu__item games-menu__item--bitcoin">
                                    <a class="games-menu__link games-menu__link--bitcoin" href="{{ route('frontend.game.list.category', 'all') }}"> <i class="games-menu-icon games-menu-icon--bitcoin"></i> <span class="games-menu__title ng-scope">@lang('app.all')</span> </a>
                                </li>

                                <li class="games-menu__item games-menu__item--woo_choice">
                                    <a class="games-menu__link games-menu__link--woo_choice" href="{{ route('frontend.game.list.category', 'hot') }}"> <i class="games-menu-icon games-menu-icon--woo_choice"></i> <span class="games-menu__title ng-scope" >@lang('app.hot_game')</span> </a>
                                </li>
                                <!-- end ngRepeat: filter_collection in gamesData.data.collections | limitTo: 9 -->
                                <li class="games-menu__item games-menu__item--new-games">
                                    <a class="games-menu__link games-menu__link--new-games" href="{{ route('frontend.game.list.category', 'new') }}"> <i class="games-menu-icon games-menu-icon--new-games"></i> <span class="games-menu__title ng-scope" >@lang('app.new')</span> </a>
                                </li>
                                <!-- end ngRepeat: filter_collection in gamesData.data.collections | limitTo: 9 -->
                                <li class="games-menu__item games-menu__item--slots">
                                    <a class="games-menu__link games-menu__link--slots" href="{{ route('frontend.game.list.category', 'slots') }}"> <i class="games-menu-icon games-menu-icon--slots"></i> <span class="games-menu__title ng-scope" >@lang('app.slots')</span> </a>
                                </li>
                                <!-- end ngRepeat: filter_collection in gamesData.data.collections | limitTo: 9 -->
                                <li class="games-menu__item games-menu__item--bonus_buy_slots">
                                    <a class="games-menu__link games-menu__link--bonus_buy_slots" href="{{ route('frontend.game.list.category', 'jackpot') }}"> <i class="games-menu-icon games-menu-icon--bonus_buy_slots"></i> <span class="games-menu__title ng-scope" >Jackpot</span> </a>
                                </li>
                                <li class="games-menu__item games-menu__item--roulette-games">
                                    <a class="games-menu__link games-menu__link--roulette-games" href="{{ route('frontend.game.list.category', 'roulette') }}"> <i class="games-menu-icon games-menu-icon--roulette-games"></i> <span class="games-menu__title ng-scope" >Roulette</span> </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="providers ng-isolate-scope">
                        <div class="providers__panel">
                            <a class="providers__btn-all ng-scope" href="{{ route('frontend.game.list.category', 'all') }}">@lang('app.all')</a>
                            <ul class="providers__panel-list">

                            @php
                            $top_categories = ['netent', 'playtech', 'pragmatic', 'wazdan', 'igtech', 'evolution', 'amatic', 'isoftbet'];
                            @endphp
                            @foreach ($top_categories as $k=>$v)
                                <li class="providers__item ng-scope">
                                    <a class="providers__link" scroll-up="" href="{{ route('frontend.game.list.category', $v) }}">
                                        <span class="providers__icon">
                                            <img class="providers__icon-img providers__icon-img--{{$v}}" alt="{{$v}}" src="/frontend/Default/svg/{{$v}}.svg">
                                        </span>
                                        <span class="providers__name ng-scope">{{ lcfirst($v) }}</span> </a>
                                </li>
                            @endforeach
                            </ul>
                            <button class="providers__toggler">
                                <span class="providers__toggler-text ng-scope">@lang('app.all_providers')</span>
                                <span class="ng-scope ng-hide">@lang('app.close')</span>
                            </button>
                        </div>
                        <ul class="providers__dropdown ng-hide">
                            @if ($categories && count($categories))
                                @foreach($categories AS $index=>$category)
                                @if (!in_array($category->href, $top_categories))
                                <li class="providers__dropdown-item ng-scope">
                                    <a class="providers__link" href="{{ route('frontend.game.list.category', $category->href) }}">
                                        <span class="providers__icon">
                                            <img class="providers__icon-img providers__icon-img--1x2gaming" alt="" src="/frontend/Default/svg/{{$category->href}}.svg">
                                        </span>
                                        <span class="providers__name ng-scope">{{ $category->title }}</span> </a>
                                </li>
                                @endif
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- uiView: -->
        <div class="ng-scope">
            <!-- uiView: -->
            <div class="contain ng-scope">
                <style>
                    .game-item.ng-scope {
                        margin-bottom: 0 !important;
                    }
                    .game-item--overflow {
                        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05)) !important;
                        backdrop-filter: blur(10px) !important;
                        -webkit-backdrop-filter: blur(10px) !important;
                        border-radius: 16px !important;
                        border: 1px solid rgba(255, 255, 255, 0.15) !important;
                        overflow: hidden !important;
                        transition: all 0.3s ease !important;
                        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2) !important;
                    }
                    .game-item--overflow:hover {
                        transform: translateY(-8px) !important;
                        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.4) !important;
                        border-color: rgba(255, 255, 255, 0.3) !important;
                        background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.08)) !important;
                    }
                    .game-item__img {
                        border-radius: 12px 12px 0 0 !important;
                        transition: transform 0.3s ease !important;
                    }
                    .game-item--overflow:hover .game-item__img {
                        transform: scale(1.05) !important;
                    }
                    .game-item__panel {
                        background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.2)) !important;
                        backdrop-filter: blur(8px) !important;
                        padding: 12px !important;
                        border-top: 1px solid rgba(255, 255, 255, 0.1) !important;
                    }
                    .game-item__panel-provider {
                        font-size: 11px !important;
                        text-transform: uppercase !important;
                        letter-spacing: 0.5px !important;
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
                        -webkit-background-clip: text !important;
                        -webkit-text-fill-color: transparent !important;
                        background-clip: text !important;
                        margin-bottom: 4px !important;
                    }
                    .game-item__panel-title {
                        font-size: 14px !important;
                        font-weight: 600 !important;
                        color: rgba(255, 255, 255, 0.95) !important;
                        margin: 0 !important;
                        white-space: nowrap !important;
                        overflow: hidden !important;
                        text-overflow: ellipsis !important;
                    }
                    .game-item__label {
                        backdrop-filter: blur(8px) !important;
                        background: linear-gradient(135deg, rgba(255, 107, 107, 0.9), rgba(255, 69, 96, 0.9)) !important;
                        border-radius: 8px !important;
                        padding: 4px 10px !important;
                        font-size: 11px !important;
                        font-weight: 700 !important;
                        text-transform: uppercase !important;
                        letter-spacing: 0.5px !important;
                        border: 1px solid rgba(255, 255, 255, 0.2) !important;
                    }
                    .game-item__overlay {
                        background: linear-gradient(135deg, rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.75)) !important;
                        backdrop-filter: blur(12px) !important;
                    }
                </style>
                
                <!-- SVG Gradient Definitions for Category Icons -->
                <svg style="position: absolute; width: 0; height: 0; overflow: hidden;">
                    <defs>
                        <linearGradient id="slotsGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#fbbf24"/>
                            <stop offset="100%" style="stop-color:#f59e0b"/>
                        </linearGradient>
                        <linearGradient id="fishGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#22d3ee"/>
                            <stop offset="100%" style="stop-color:#38bdf8"/>
                        </linearGradient>
                        <linearGradient id="tableGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#10b981"/>
                            <stop offset="100%" style="stop-color:#059669"/>
                        </linearGradient>
                    </defs>
                </svg>

                @php
                    $allGamesForCarousel = \VanguardLTE\Game::where(['view' => 1, 'shop_id' => $jrShopId])->whereIn('device', [1, 2])->get();
                    if ($allGamesForCarousel->isEmpty()) {
                        $allGamesForCarousel = \VanguardLTE\Game::where(['view' => 1, 'shop_id' => 0])->whereIn('device', [1, 2])->get();
                    }
                    $slotGames = [];
                    $fishGames = [];
                    $tableGames = [];
                    $usedGameIds = [];
                    
                    foreach($allGamesForCarousel as $g) {
                        $name = $g->name ?? '';
                        $nameLower = strtolower($name);
                        
                        $isArcade = (
                            preg_match('/(VP|SW|CQ9|PGD|KA)$/i', $name) ||
                            strpos($nameLower, 'fishing') !== false ||
                            strpos($nameLower, 'hunter') !== false ||
                            strpos($nameLower, 'shooter') !== false ||
                            strpos($nameLower, 'buffalo') !== false && strpos($name, 'VP') !== false
                        );
                        
                        $isTable = (
                            strpos($nameLower, 'keno') !== false ||
                            strpos($nameLower, 'poker') !== false ||
                            strpos($nameLower, 'blackjack') !== false ||
                            strpos($nameLower, 'roulette') !== false ||
                            strpos($nameLower, 'baccarat') !== false ||
                            strpos($nameLower, 'deuceswild') !== false
                        );
                        
                        if($isArcade) {
                            if(!in_array($g->id, $usedGameIds)) {
                                $fishGames[] = $g;
                                $usedGameIds[] = $g->id;
                            }
                        } elseif($isTable) {
                            if(!in_array($g->id, $usedGameIds)) {
                                $tableGames[] = $g;
                                $usedGameIds[] = $g->id;
                            }
                        } else {
                            if(!in_array($g->id, $usedGameIds)) {
                                $slotGames[] = $g;
                                $usedGameIds[] = $g->id;
                            }
                        }
                    }
                    
                    $slotRow1 = [];
                    $slotRow2 = [];
                    $slotIndex = 0;
                    foreach($slotGames as $sg) {
                        if($slotIndex % 2 === 0) {
                            $slotRow1[] = $sg;
                        } else {
                            $slotRow2[] = $sg;
                        }
                        $slotIndex++;
                    }
                    
                    $fishRow1 = [];
                    $fishRow2 = [];
                    foreach($fishGames as $idx => $fg) {
                        if($idx % 2 === 0) {
                            $fishRow1[] = $fg;
                        } else {
                            $fishRow2[] = $fg;
                        }
                    }
                    
                    $tableRow1 = [];
                    $tableRow2 = [];
                    foreach($tableGames as $idx => $tg) {
                        if($idx % 2 === 0) {
                            $tableRow1[] = $tg;
                        } else {
                            $tableRow2[] = $tg;
                        }
                    }
                @endphp

                <!-- DESKTOP FILTER CHIPS -->
                <div class="desktop-filter-chips" style="display:none" id="desktopFilterChips">
                    <a href="/" class="desktop-filter-chip active">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                        All Games
                    </a>
                    <a href="{{ route('frontend.game.list.category', 'slots') }}" class="desktop-filter-chip">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="2"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3M4.9 4.9l2.1 2.1M16.9 16.9l2.1 2.1M4.9 19.1l2.1-2.1M16.9 7.1l2.1-2.1"/></svg>
                        Slots
                    </a>
                    <a href="{{ route('frontend.game.list.category', 'all') }}" class="desktop-filter-chip">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 16.5a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0z"/><path d="M6 8h.01M8 4h.01M12 2h.01M16 4h.01M18 8h.01"/></svg>
                        Fish &amp; Arcade
                    </a>
                    <a href="{{ route('frontend.game.list.category', 'roulette') }}" class="desktop-filter-chip">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/><line x1="12" y1="2" x2="12" y2="9"/><line x1="12" y1="15" x2="12" y2="22"/><line x1="2" y1="12" x2="9" y2="12"/><line x1="15" y1="12" x2="22" y2="12"/></svg>
                        Table Games
                    </a>
                </div>
                <script>
                if (window.innerWidth >= 769) {
                    document.getElementById('desktopFilterChips').style.display = 'flex';
                }
                </script>

                <!-- SLOTS CAROUSEL - 2 Rows -->
                @if(count($slotGames) > 0)
                <section class="category-section category-section--slots">
                    <span class="category-title-badge">Slots</span>
                    <div class="netflix-carousel" data-carousel="slots">
                        <div class="netflix-carousel__track-wrapper" id="slots-carousel">
                            <div class="netflix-carousel__track--double">
                                <div class="netflix-carousel__row" id="slots-row-1">
                                    @foreach($slotRow1 as $game)
                                    <a href="@if(isset(auth()->user()->username) && auth()->user()->balance > 0){{ route('frontend.game.go', $game->name) }}?api_exit=/@else{{ route('frontend.game.go', $game->name) }}/prego?api_exit=/@endif" class="netflix-game-card">
                                        <img class="netflix-game-card__image" src="{{ $game->thumbnail ?? '/frontend/Default/ico/'.$game->name.'.jpg' }}" alt="{{ $game->title }}" loading="lazy" onerror="this.onerror=null;this.src='/woocasino/mslider1.gif'">
                                        @if($game->label)<span class="netflix-game-card__badge">{{ $game->label }}</span>@endif
                                    </a>
                                    @endforeach
                                    <a href="{{ route('frontend.game.list.category', 'slots') }}" class="carousel-see-all-card carousel-see-all-card--slots">
                                        <div class="see-all-inner">
                                            <span class="see-all-icon">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/></svg>
                                            </span>
                                            <span class="see-all-text">View All<br>Slots</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="netflix-carousel__row" id="slots-row-2">
                                    @foreach($slotRow2 as $game)
                                    <a href="@if(isset(auth()->user()->username) && auth()->user()->balance > 0){{ route('frontend.game.go', $game->name) }}?api_exit=/@else{{ route('frontend.game.go', $game->name) }}/prego?api_exit=/@endif" class="netflix-game-card">
                                        <img class="netflix-game-card__image" src="{{ $game->thumbnail ?? '/frontend/Default/ico/'.$game->name.'.jpg' }}" alt="{{ $game->title }}" loading="lazy" onerror="this.onerror=null;this.src='/woocasino/mslider1.gif'">
                                        @if($game->label)<span class="netflix-game-card__badge">{{ $game->label }}</span>@endif
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <button class="netflix-carousel__nav netflix-carousel__nav--left" onclick="scrollCarousel('slots-carousel', -400)"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg></button>
                        <button class="netflix-carousel__nav netflix-carousel__nav--right" onclick="scrollCarousel('slots-carousel', 400)"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg></button>
                    </div>
                </section>
                @endif

                <!-- FISH/ARCADE CAROUSEL - 2 Rows -->
                @if(count($fishGames) > 0)
                <section class="category-section category-section--fish">
                    <span class="category-title-badge">Fish & Arcade</span>
                    <div class="netflix-carousel" data-carousel="fish">
                        <div class="netflix-carousel__track-wrapper" id="fish-carousel">
                            <div class="netflix-carousel__track--double">
                                <div class="netflix-carousel__row" id="fish-row-1">
                                    @foreach($fishRow1 as $game)
                                    <a href="@if(isset(auth()->user()->username) && auth()->user()->balance > 0){{ route('frontend.game.go', $game->name) }}?api_exit=/@else{{ route('frontend.game.go', $game->name) }}/prego?api_exit=/@endif" class="netflix-game-card">
                                        <img class="netflix-game-card__image" src="{{ $game->thumbnail ?? '/frontend/Default/ico/'.$game->name.'.jpg' }}" alt="{{ $game->title }}" loading="lazy" onerror="this.onerror=null;this.src='/woocasino/mslider1.gif'">
                                        @if($game->label)<span class="netflix-game-card__badge">{{ $game->label }}</span>@endif
                                    </a>
                                    @endforeach
                                    <a href="{{ route('frontend.game.list.category', 'all') }}" class="carousel-see-all-card carousel-see-all-card--fish">
                                        <div class="see-all-inner">
                                            <span class="see-all-icon">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/></svg>
                                            </span>
                                            <span class="see-all-text">View All<br>Games</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="netflix-carousel__row" id="fish-row-2">
                                    @foreach($fishRow2 as $game)
                                    <a href="@if(isset(auth()->user()->username) && auth()->user()->balance > 0){{ route('frontend.game.go', $game->name) }}?api_exit=/@else{{ route('frontend.game.go', $game->name) }}/prego?api_exit=/@endif" class="netflix-game-card">
                                        <img class="netflix-game-card__image" src="{{ $game->thumbnail ?? '/frontend/Default/ico/'.$game->name.'.jpg' }}" alt="{{ $game->title }}" loading="lazy" onerror="this.onerror=null;this.src='/woocasino/mslider1.gif'">
                                        @if($game->label)<span class="netflix-game-card__badge">{{ $game->label }}</span>@endif
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <button class="netflix-carousel__nav netflix-carousel__nav--left" onclick="scrollCarousel('fish-carousel', -400)"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg></button>
                        <button class="netflix-carousel__nav netflix-carousel__nav--right" onclick="scrollCarousel('fish-carousel', 400)"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg></button>
                    </div>
                </section>
                @endif

                <!-- TABLE GAMES CAROUSEL - 2 Rows -->
                @if(count($tableGames) > 0)
                <section class="category-section category-section--table">
                    <span class="category-title-badge">Table Games</span>
                    <div class="netflix-carousel" data-carousel="table">
                        <div class="netflix-carousel__track-wrapper" id="table-carousel">
                            <div class="netflix-carousel__track--double">
                                <div class="netflix-carousel__row" id="table-row-1">
                                    @foreach($tableRow1 as $game)
                                    <a href="@if(isset(auth()->user()->username) && auth()->user()->balance > 0){{ route('frontend.game.go', $game->name) }}?api_exit=/@else{{ route('frontend.game.go', $game->name) }}/prego?api_exit=/@endif" class="netflix-game-card">
                                        <img class="netflix-game-card__image" src="{{ $game->thumbnail ?? '/frontend/Default/ico/'.$game->name.'.jpg' }}" alt="{{ $game->title }}" loading="lazy" onerror="this.onerror=null;this.src='/woocasino/mslider1.gif'">
                                        @if($game->label)<span class="netflix-game-card__badge">{{ $game->label }}</span>@endif
                                    </a>
                                    @endforeach
                                    <a href="{{ route('frontend.game.list.category', 'roulette') }}" class="carousel-see-all-card carousel-see-all-card--table">
                                        <div class="see-all-inner">
                                            <span class="see-all-icon">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/></svg>
                                            </span>
                                            <span class="see-all-text">View All<br>Tables</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="netflix-carousel__row" id="table-row-2">
                                    @foreach($tableRow2 as $game)
                                    <a href="@if(isset(auth()->user()->username) && auth()->user()->balance > 0){{ route('frontend.game.go', $game->name) }}?api_exit=/@else{{ route('frontend.game.go', $game->name) }}/prego?api_exit=/@endif" class="netflix-game-card">
                                        <img class="netflix-game-card__image" src="{{ $game->thumbnail ?? '/frontend/Default/ico/'.$game->name.'.jpg' }}" alt="{{ $game->title }}" loading="lazy" onerror="this.onerror=null;this.src='/woocasino/mslider1.gif'">
                                        @if($game->label)<span class="netflix-game-card__badge">{{ $game->label }}</span>@endif
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <button class="netflix-carousel__nav netflix-carousel__nav--left" onclick="scrollCarousel('table-carousel', -400)"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg></button>
                        <button class="netflix-carousel__nav netflix-carousel__nav--right" onclick="scrollCarousel('table-carousel', 400)"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg></button>
                    </div>
                </section>
                @endif

                <!-- Hidden pagination for SEO -->
                <section class="games-list ng-isolate-scope" style="display:none;">
                    <div class="games-list__wrap ng-scope">
                        @if ($games && count($games))
                            @foreach ($games as $key=>$game)
                            <div class="game-item ng-scope"></div>
                            @endforeach
                        @endif
                    </div>
                    <div class="game-pagination">{{ $games->links() }}</div>
                </section>
            </div>
        </div>
    </main>
    <script>
    var timerHdle = null;
    function call_timer() {
        return setInterval(() => {
            $('.carousel-inner').each(function(){
                var totalItems = $(this).find('.item').length;
                var currentIndex = $(this).find('.item.active').index();
                
                if(currentIndex < totalItems - 1) {
                    $(this).find('.item.active').removeClass('active').next().addClass('active');
                } else {
                    $(this).find('.item.active').removeClass('active');
                    $(this).find('.item').eq(0).addClass('active');
                }
                
                var totalPromos = $(this).find('.main-slider__promo').length;
                var currentPromoIndex = $(this).find('.main-slider__promo.active').index();
                
                if(totalPromos > 0) {
                    if(currentPromoIndex < totalPromos - 1) {
                        $(this).find('.main-slider__promo.active').removeClass('active').next().addClass('active');
                    } else {
                        $(this).find('.main-slider__promo.active').removeClass('active');
                        $(this).find('.main-slider__promo').eq(0).addClass('active');
                    }
                }
            })
            $('.carousel-indicators').each(function(){
                var totalIndicators = $(this).find('li').length;
                var currentIndicatorIndex = $(this).find('li.active').index();
                
                if(currentIndicatorIndex < totalIndicators - 1) {
                    $(this).find('li.active').removeClass('active').next().addClass('active');
                } else {
                    $(this).find('li.active').removeClass('active');
                    $(this).find('li').eq(0).addClass('active');
                }
            })
        }, 5000);
    }
    timerHdle = call_timer()
    $('.carousel-indicators').find('li').click(function(){
        clearInterval(timerHdle)
        var index = $(this).index()
        $(this).parent().find('.active').removeClass('active')
        $(this).parent().find('li').eq(index).addClass('active');

        $(this).parent().parent().find('.carousel-inner .item.active').removeClass('active')
        $(this).parent().parent().find('.carousel-inner .item').eq(index).addClass('active')

        $(this).parent().parent().find('.carousel-inner .main-slider__promo.active').removeClass('active')
        $(this).parent().parent().find('.carousel-inner .main-slider__promo').eq(index).addClass('active')
        timerHdle = call_timer()
    })
    $('.providers__toggler').click(function(){
        $('.providers__dropdown').toggleClass('ng-hide');
    })

    // Netflix Carousel Scroll Function
    function scrollCarousel(carouselId, scrollAmount) {
        var carousel = document.getElementById(carouselId);
        if (carousel) {
            carousel.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        }
    }

    // Touch swipe support for carousels
    document.querySelectorAll('.netflix-carousel__track-wrapper').forEach(function(wrapper) {
        var startX, scrollLeft;
        
        wrapper.addEventListener('touchstart', function(e) {
            startX = e.touches[0].pageX - wrapper.offsetLeft;
            scrollLeft = wrapper.scrollLeft;
        }, { passive: true });
        
        wrapper.addEventListener('touchmove', function(e) {
            if (!startX) return;
            var x = e.touches[0].pageX - wrapper.offsetLeft;
            var walk = (x - startX) * 1.5;
            wrapper.scrollLeft = scrollLeft - walk;
        }, { passive: true });
        
        wrapper.addEventListener('touchend', function() {
            startX = null;
        });
    });

    // Bonus Modal Functions
    function openBonusModal() {
        document.getElementById('bonusModalOverlay').classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    function closeBonusModal() {
        document.getElementById('bonusModalOverlay').classList.remove('active');
        document.body.style.overflow = '';
    }
    function copyReferralCode() {
        var code = document.getElementById('referralCode').textContent;
        navigator.clipboard.writeText(code).then(function() {
            var btn = document.querySelector('.referral-copy-btn');
            var originalText = btn.innerHTML;
            btn.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg> Copied!';
            setTimeout(function() { btn.innerHTML = originalText; }, 2000);
        });
    }
    function switchBonusTab(tabName) {
        document.querySelectorAll('.bonus-modal__tab').forEach(function(tab) {
            tab.classList.remove('active');
            if (tab.dataset.tab === tabName) tab.classList.add('active');
        });
        document.querySelectorAll('.bonus-modal__panel').forEach(function(panel) {
            panel.classList.remove('active');
            if (panel.dataset.panel === tabName) panel.classList.add('active');
        });
    }
    function spinModalWheel() {
        var wheel = document.querySelector('#modalFortuneWheel svg');
        var randomDeg = 1800 + Math.floor(Math.random() * 360);
        wheel.style.transform = 'rotate(' + randomDeg + 'deg)';
    }

    // Premium Wheel Spin
    var premiumWheelSpinning = false;
    var wheelSectors = @json($sectors ?? []);
    function spinPremiumWheel() {
        if (premiumWheelSpinning) return;
        if (!window.jrLoggedIn) {
            jrShowLoginGate('Log in to spin the Wheel of Fortune and win real prizes.');
            return;
        }
        premiumWheelSpinning = true;

        var wheel = document.getElementById('premiumWheel');
        var sectorCount = wheelSectors.length || 16;
        var sectorAngle = 360 / sectorCount;

        // Ask the server which sector wins. Server enforces 1/day + awards balance.
        fetch('/profile/wheel_spin', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': (document.querySelector('meta[name="csrf-token"]') || {}).content || (window.jrCsrfToken || ''),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin',
            body: JSON.stringify({})
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.fail) {
                premiumWheelSpinning = false;
                jrShowLoginGate(data.error || 'Spin not available.');
                return;
            }
            var idx = (typeof data.sector_index === 'number') ? data.sector_index : 0;
            var randomOffset = (Math.random() - 0.5) * sectorAngle * 0.6;
            var targetAngle = 1800 + (360 - (idx * sectorAngle + sectorAngle / 2 + randomOffset));

            wheel.classList.add('spinning');
            wheel.style.transform = 'rotate(' + targetAngle + 'deg)';

            setTimeout(function() {
                var prizeText = (data.value > 0)
                    ? (data.currency || '$') + Number(data.value).toFixed(2)
                    : 'Good Luck!';
                document.getElementById('wheelPrize').textContent = prizeText;
                document.getElementById('wheelResult').style.display = 'flex';
                if (data.value > 0) triggerConfetti();
                /* Refresh on-screen balance pill */
                var pill = document.getElementById('jrBalancePill');
                if (pill && data.balance) {
                    pill.textContent = (data.currency || '') + Number(data.balance).toLocaleString();
                }
                setTimeout(function() { premiumWheelSpinning = false; }, 2000);
            }, 5000);
        })
        .catch(function() {
            premiumWheelSpinning = false;
            jrShowLoginGate('Could not reach the wheel server. Please try again.');
        });
    }

    // MORE Modal Functions
    function openMoreModal() {
        document.getElementById('moreModalOverlay').classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    function closeMoreModal() {
        document.getElementById('moreModalOverlay').classList.remove('active');
        document.body.style.overflow = '';
    }
    function switchMoreTab(tabName) {
        document.querySelectorAll('.more-modal__tab').forEach(function(tab) {
            tab.classList.remove('active');
            if (tab.dataset.tab === tabName) tab.classList.add('active');
        });
        document.querySelectorAll('.more-modal__panel').forEach(function(panel) {
            panel.classList.remove('active');
            if (panel.dataset.panel === tabName) panel.classList.add('active');
        });
    }
    function switchHistorySubtab(type) {
        document.querySelectorAll('.history-subtab').forEach(function(btn) { btn.classList.remove('active'); });
        document.querySelectorAll('.history-content').forEach(function(c) { c.style.display = 'none'; });
        if (type === 'transactions') {
            document.querySelectorAll('.history-subtab')[0].classList.add('active');
            document.getElementById('historyTransactions').style.display = 'block';
        } else if (type === 'bonuses') {
            document.querySelectorAll('.history-subtab')[1].classList.add('active');
            document.getElementById('historyBonuses').style.display = 'block';
        } else if (type === 'games') {
            document.querySelectorAll('.history-subtab')[2].classList.add('active');
            document.getElementById('historyGames').style.display = 'block';
        }
    }
    function changePassword(e) {
        e.preventDefault();
        var form = e.target;
        var newPass = form.new_password.value;
        var confirmPass = form.confirm_password.value;
        if (newPass !== confirmPass) {
            alert('Passwords do not match!');
            return false;
        }
        alert('Password change request submitted.');
        form.reset();
        return false;
    }
    function sendShopMessage(e) {
        e.preventDefault();
        var form = e.target;
        var statusDiv = document.getElementById('messageStatus');
        statusDiv.className = 'message-status success';
        statusDiv.textContent = 'Message sent successfully!';
        statusDiv.style.display = 'block';
        form.reset();
        setTimeout(function() { statusDiv.style.display = 'none'; }, 3000);
        return false;
    }

    // Dragon Egg Pick Game
    var eggPicked = false;
    function pickDragonEgg(eggNum) {
        if (eggPicked) return;
        if (!window.jrLoggedIn) {
            jrShowLoginGate('Log in to claim your daily Dragon Egg reward.');
            return;
        }
        eggPicked = true;

        var eggs = document.querySelectorAll('.dragon-egg');
        eggs.forEach(function(egg) {
            if (parseInt(egg.dataset.egg) === eggNum) {
                egg.classList.add('selected');
            } else {
                egg.classList.add('not-selected');
            }
        });

        // Claim from server — it enforces 1/day and credits the wallet.
        fetch('/profile/dragon_egg', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': (document.querySelector('meta[name="csrf-token"]') || {}).content || (window.jrCsrfToken || ''),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin',
            body: JSON.stringify({ egg: eggNum })
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            setTimeout(function() {
                document.getElementById('dragonEggsContainer').style.display = 'none';
                var resultBox = document.getElementById('dragonEggResult');
                resultBox.style.display = 'block';

                if (data.fail) {
                    /* Already claimed today, etc. — show error in the result panel */
                    var rewardEl = resultBox.querySelector('.dragon-egg-reward');
                    if (rewardEl) rewardEl.textContent = data.error || 'Not available';
                    eggPicked = false;
                    return;
                }
                /* Update reward display + balance pill */
                var rewardEl = resultBox.querySelector('.dragon-egg-reward');
                if (rewardEl) {
                    rewardEl.textContent = (data.currency || '$') + Number(data.value).toFixed(2);
                }
                var pill = document.getElementById('jrBalancePill');
                if (pill && data.balance) {
                    pill.textContent = (data.currency || '') + Number(data.balance).toLocaleString();
                }
                if (data.value > 0) triggerConfetti();
            }, 800);
        })
        .catch(function() {
            setTimeout(function() {
                document.getElementById('dragonEggsContainer').style.display = 'none';
                document.getElementById('dragonEggResult').style.display = 'block';
                eggPicked = false;
                jrShowLoginGate('Could not reach the bonus server. Please try again.');
            }, 800);
        });
    }

    // Confetti Celebration
    function triggerConfetti() {
        var container = document.getElementById('confettiContainer');
        var colors = ['#fbbf24', '#10b981', '#ef4444', '#8b5cf6', '#3b82f6', '#ec4899'];
        for (var i = 0; i < 100; i++) {
            var confetti = document.createElement('div');
            confetti.className = 'confetti-piece';
            confetti.style.left = Math.random() * 100 + '%';
            confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
            confetti.style.animationDelay = Math.random() * 2 + 's';
            confetti.style.animationDuration = (2 + Math.random() * 2) + 's';
            confetti.style.width = (6 + Math.random() * 8) + 'px';
            confetti.style.height = (6 + Math.random() * 8) + 'px';
            confetti.style.borderRadius = Math.random() > 0.5 ? '50%' : '0';
            container.appendChild(confetti);
        }
        setTimeout(function() { container.innerHTML = ''; }, 4000);
    }

    // Volume sliders
    document.querySelectorAll('.volume-slider').forEach(function(slider) {
        slider.addEventListener('input', function() {
            this.nextElementSibling.textContent = this.value + '%';
        });
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeBonusModal();
            closeMoreModal();
        }
    });

    // ===== MOBILE CASINO LAYOUT JS =====
    function mobFilterGames(cat, btn) {
        // Update sidebar active state
        document.querySelectorAll('.mob-sidebar__item').forEach(function(el) { el.classList.remove('active'); });
        if (btn) btn.classList.add('active');

        var cards = document.querySelectorAll('#mobGameGrid .mob-game-card');
        if (cat === 'all' || cat === 'faves') {
            cards.forEach(function(c) { c.style.display = ''; });
        } else {
            cards.forEach(function(c) {
                c.style.display = (c.dataset.cat === cat) ? '' : 'none';
            });
        }
        // Scroll content back to top
        var content = document.getElementById('mobContent');
        if (content) content.scrollTop = 0;
    }

    // Mobile banner auto-slide
    (function() {
        var slides = document.querySelectorAll('#mobBannerSlider .mob-banner-slide');
        var dots = document.querySelectorAll('#mobBannerDots .mob-banner-dot');
        if (!slides.length) return;
        var idx = 0;
        setInterval(function() {
            slides[idx].classList.remove('active');
            dots[idx] && dots[idx].classList.remove('active');
            idx = (idx + 1) % slides.length;
            slides[idx].classList.add('active');
            dots[idx] && dots[idx].classList.add('active');
        }, 3500);
        // Dots click
        dots.forEach(function(dot, i) {
            dot.addEventListener('click', function() {
                slides[idx].classList.remove('active');
                dots[idx].classList.remove('active');
                idx = i;
                slides[idx].classList.add('active');
                dots[idx].classList.add('active');
            });
        });
    })();
    // ===== END MOBILE CASINO LAYOUT JS =====

    // ===== ROUNDRECT POLYFILL (for older browsers) =====
    if (!CanvasRenderingContext2D.prototype.roundRect) {
        CanvasRenderingContext2D.prototype.roundRect = function(x, y, w, h, r) {
            var radii = Array.isArray(r) ? r : [r||0, r||0, r||0, r||0];
            var tl = radii[0]||0, tr = radii[1]||0, br = radii[2]||0, bl = radii[3]||0;
            this.beginPath();
            this.moveTo(x + tl, y);
            this.lineTo(x + w - tr, y);
            this.arcTo(x + w, y, x + w, y + tr, tr);
            this.lineTo(x + w, y + h - br);
            this.arcTo(x + w, y + h, x + w - br, y + h, br);
            this.lineTo(x + bl, y + h);
            this.arcTo(x, y + h, x, y + h - bl, bl);
            this.lineTo(x, y + tl);
            this.arcTo(x, y, x + tl, y, tl);
            this.closePath();
            return this;
        };
    }

    // ===== AUTO-OPEN LOGIN FOR UNAUTHENTICATED USERS =====
    @if(!Auth::check())
    (function() {
        var loginTriggered = false;
        function triggerLogin() {
            if (loginTriggered) return;
            // Try AngularJS route first
            var guestPill = document.querySelector('.mob-header__user-pill--guest');
            var loginBtn  = document.querySelector('.player-btn--login');
            var jsLogin   = document.querySelector('.js-login, [ng-click*="login-modal"]');
            if (loginBtn)  { loginBtn.click();  return; }
            if (guestPill) { guestPill.click(); return; }
            if (jsLogin)   { jsLogin.click();   return; }
        }
        document.addEventListener('click', function(e) {
            var el = e.target;
            // Don't intercept clicks on login modal itself, close buttons, or login triggers
            if (el.closest && (
                el.closest('#login-modal') ||
                el.closest('.modal') ||
                el.closest('[ng-click*="login-modal"]') ||
                el.closest('.mob-header__user-pill--guest') ||
                el.closest('.player-btn--login') ||
                el.closest('.slideshow-login-btn') ||
                el.closest('.js-login') ||
                el.closest('#bonusModalOverlay') ||
                el.closest('#moreModalOverlay') ||
                el.closest('.bonus-modal-overlay') ||
                el.closest('.more-modal-overlay')
            )) return;
            // Don't intercept sidebar/nav items that only filter games
            if (el.closest && el.closest('.mob-sidebar')) return;
            // Intercept everything else
            triggerLogin();
        }, true);
    })();
    @endif

    // ===== DESKTOP 3D CASINO BACKGROUND =====
    (function() {
        if (window.innerWidth < 769) return;
        var canvas = document.getElementById('casino-bg-canvas');
        if (!canvas) return;
        var ctx = canvas.getContext('2d');

        function resize() {
            canvas.width  = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        resize();
        window.addEventListener('resize', function() {
            resize();
            if (window.innerWidth < 769) canvas.style.display = 'none';
            else canvas.style.display = 'block';
        });

        var W = function(){ return canvas.width;  };
        var H = function(){ return canvas.height; };

        // ─── SLOT MACHINES ────────────────────────────────────────────────
        var slotSymbols = ['7','★','♦','☘','🍒','BAR'];
        var slotColors  = ['#ffd700','#ff4fff','#00ffcc','#ff6b35','#ff1493','#00cfff'];

        function SlotMachine(x, y, scale, alpha, speed) {
            this.x      = x;
            this.y      = y;
            this.scale  = scale;
            this.alpha  = alpha;
            this.bobOff = Math.random() * Math.PI * 2;
            this.bobSpd = 0.4 + Math.random() * 0.3;
            this.spinT  = Math.random() * 100;
            this.spinSpd= speed || (0.02 + Math.random() * 0.04);
            this.reelSym= [
                Math.floor(Math.random() * slotSymbols.length),
                Math.floor(Math.random() * slotSymbols.length),
                Math.floor(Math.random() * slotSymbols.length)
            ];
            this.flash  = 0;
            this.flashDir = 1;
        }

        SlotMachine.prototype.draw = function(t) {
            var s  = this.scale;
            var cx = this.x;
            var cy = this.y + Math.sin(t * this.bobSpd + this.bobOff) * 6 * s;
            ctx.save();
            ctx.globalAlpha = this.alpha;

            // Machine body dimensions
            var bw = 90 * s, bh = 120 * s;
            var bx = cx - bw / 2, by = cy - bh / 2;

            // 3D depth offsets
            var dx = 18 * s, dy = -12 * s;

            // --- Top face ---
            ctx.beginPath();
            ctx.moveTo(bx, by);
            ctx.lineTo(bx + bw, by);
            ctx.lineTo(bx + bw + dx, by + dy);
            ctx.lineTo(bx + dx, by + dy);
            ctx.closePath();
            ctx.fillStyle = '#3a1a6e';
            ctx.fill();
            ctx.strokeStyle = '#9b59b6';
            ctx.lineWidth = 1.5 * s;
            ctx.stroke();

            // --- Right side face ---
            ctx.beginPath();
            ctx.moveTo(bx + bw, by);
            ctx.lineTo(bx + bw + dx, by + dy);
            ctx.lineTo(bx + bw + dx, by + dy + bh);
            ctx.lineTo(bx + bw, by + bh);
            ctx.closePath();
            ctx.fillStyle = '#1e0a40';
            ctx.fill();
            ctx.strokeStyle = '#7d3cb5';
            ctx.lineWidth = 1.5 * s;
            ctx.stroke();

            // --- Front face body ---
            var grad = ctx.createLinearGradient(bx, by, bx + bw, by + bh);
            grad.addColorStop(0, '#2d0b5e');
            grad.addColorStop(0.5, '#1a0840');
            grad.addColorStop(1, '#0d0520');
            ctx.beginPath();
            ctx.roundRect(bx, by, bw, bh, 6 * s);
            ctx.fillStyle = grad;
            ctx.fill();
            ctx.strokeStyle = '#8a2be2';
            ctx.lineWidth = 2 * s;
            ctx.stroke();

            // --- Gold trim top ---
            ctx.beginPath();
            ctx.roundRect(bx, by, bw, 14 * s, [6 * s, 6 * s, 0, 0]);
            var tgrad = ctx.createLinearGradient(bx, by, bx + bw, by);
            tgrad.addColorStop(0, '#b8860b');
            tgrad.addColorStop(0.5, '#ffd700');
            tgrad.addColorStop(1, '#b8860b');
            ctx.fillStyle = tgrad;
            ctx.fill();

            // --- Title: JADE ROYALE ---
            ctx.fillStyle = '#0d0520';
            ctx.font = 'bold ' + (7 * s) + 'px Arial';
            ctx.textAlign = 'center';
            ctx.fillText('JADE ROYALE', cx, by + 10 * s);

            // --- Reel window ---
            var rw = 70 * s, rh = 42 * s;
            var rx = cx - rw / 2, ry = by + 20 * s;
            ctx.beginPath();
            ctx.roundRect(rx, ry, rw, rh, 4 * s);
            ctx.fillStyle = '#000';
            ctx.fill();
            ctx.strokeStyle = '#ffd700';
            ctx.lineWidth = 2 * s;
            ctx.stroke();

            // --- Reels ---
            var reel_w = (rw - 8 * s) / 3;
            this.spinT += this.spinSpd;
            for (var r = 0; r < 3; r++) {
                var rx2 = rx + 4 * s + r * reel_w;
                var symIdx = (this.reelSym[r] + Math.floor(this.spinT * (r + 1) * 0.3)) % slotSymbols.length;
                symIdx = Math.abs(symIdx);
                ctx.save();
                ctx.beginPath();
                ctx.rect(rx2, ry + 2 * s, reel_w, rh - 4 * s);
                ctx.clip();
                ctx.fillStyle = slotColors[symIdx];
                ctx.font = 'bold ' + (18 * s) + 'px Arial';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText(slotSymbols[symIdx], rx2 + reel_w / 2, ry + rh / 2);
                ctx.restore();
            }
            // Reel center line
            ctx.beginPath();
            ctx.moveTo(rx, ry + rh / 2);
            ctx.lineTo(rx + rw, ry + rh / 2);
            ctx.strokeStyle = 'rgba(255,215,0,0.25)';
            ctx.lineWidth = s;
            ctx.stroke();

            // --- Lights row ---
            var lcount = 7, lSpacing = bw / (lcount + 1);
            this.flash += 0.08;
            for (var i = 0; i < lcount; i++) {
                var lx = bx + lSpacing * (i + 1);
                var ly = by + 68 * s;
                var lit = (Math.floor(this.flash + i * 0.7)) % 2 === 0;
                ctx.beginPath();
                ctx.arc(lx, ly, 3.5 * s, 0, Math.PI * 2);
                ctx.fillStyle = lit ? slotColors[i % slotColors.length] : '#333';
                if (lit) {
                    ctx.shadowColor = slotColors[i % slotColors.length];
                    ctx.shadowBlur  = 8 * s;
                }
                ctx.fill();
                ctx.shadowBlur = 0;
            }

            // --- Coin slot ---
            ctx.beginPath();
            ctx.ellipse(cx, by + 78 * s, 12 * s, 3 * s, 0, 0, Math.PI * 2);
            ctx.strokeStyle = '#ffd700';
            ctx.lineWidth = 1.5 * s;
            ctx.stroke();

            // --- Spin button ---
            var btnGrad = ctx.createRadialGradient(cx, by + 92 * s, 2 * s, cx, by + 92 * s, 12 * s);
            btnGrad.addColorStop(0, '#ff6b6b');
            btnGrad.addColorStop(1, '#cc0000');
            ctx.beginPath();
            ctx.arc(cx, by + 92 * s, 12 * s, 0, Math.PI * 2);
            ctx.fillStyle = btnGrad;
            ctx.fill();
            ctx.strokeStyle = '#ff9999';
            ctx.lineWidth = 1.5 * s;
            ctx.stroke();
            ctx.fillStyle = '#fff';
            ctx.font = 'bold ' + (7 * s) + 'px Arial';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText('SPIN', cx, by + 92 * s);

            // --- Lever ---
            var lbx = bx + bw + 8 * s;
            var lby = by + 20 * s;
            ctx.beginPath();
            ctx.moveTo(lbx, lby + 55 * s);
            ctx.lineTo(lbx, lby + 20 * s);
            ctx.quadraticCurveTo(lbx, lby, lbx + 14 * s, lby);
            ctx.strokeStyle = '#ffd700';
            ctx.lineWidth = 3 * s;
            ctx.lineCap = 'round';
            ctx.stroke();
            ctx.beginPath();
            ctx.arc(lbx + 14 * s, lby, 7 * s, 0, Math.PI * 2);
            ctx.fillStyle = '#ff1493';
            ctx.fill();
            ctx.strokeStyle = '#ff69b4';
            ctx.lineWidth = 1.5 * s;
            ctx.stroke();

            // --- Legs ---
            ctx.fillStyle = '#1a0840';
            ctx.fillRect(bx + 12 * s, by + bh, 10 * s, 14 * s);
            ctx.fillRect(bx + bw - 22 * s, by + bh, 10 * s, 14 * s);
            ctx.fillStyle = '#ffd700';
            ctx.fillRect(bx + 8 * s, by + bh + 11 * s, 18 * s, 3 * s);
            ctx.fillRect(bx + bw - 26 * s, by + bh + 11 * s, 18 * s, 3 * s);

            ctx.restore();
        };

        // ─── COINS ────────────────────────────────────────────────────────
        function Coin() { this.reset(true); }
        Coin.prototype.reset = function(init) {
            this.x    = Math.random() * canvas.width;
            this.y    = init ? Math.random() * canvas.height : -30;
            this.r    = 8 + Math.random() * 14;
            this.vy   = 0.8 + Math.random() * 1.8;
            this.vx   = (Math.random() - 0.5) * 0.6;
            this.spinT= Math.random() * Math.PI * 2;
            this.spinS= (Math.random() > 0.5 ? 1 : -1) * (0.03 + Math.random() * 0.05);
            this.alpha= 0.6 + Math.random() * 0.4;
            this.wobble= Math.random() * Math.PI * 2;
        };
        Coin.prototype.update = function() {
            this.y      += this.vy;
            this.x      += this.vx + Math.sin(this.wobble) * 0.3;
            this.wobble += 0.02;
            this.spinT  += this.spinS;
            if (this.y > canvas.height + 40) this.reset(false);
        };
        Coin.prototype.draw = function() {
            var rx = this.r * Math.abs(Math.cos(this.spinT));
            var ry = this.r;
            ctx.save();
            ctx.globalAlpha = this.alpha;
            var face = Math.cos(this.spinT) >= 0;
            var gx = this.x - rx, gy = this.y - ry;
            var grad = ctx.createRadialGradient(this.x - rx * 0.3, this.y - ry * 0.3, 1, this.x, this.y, rx);
            if (face) {
                grad.addColorStop(0, '#fff9c4');
                grad.addColorStop(0.3, '#ffd700');
                grad.addColorStop(0.7, '#b8860b');
                grad.addColorStop(1, '#8b6914');
            } else {
                grad.addColorStop(0, '#e0c060');
                grad.addColorStop(0.5, '#c8a000');
                grad.addColorStop(1, '#7a5c00');
            }
            if (rx > 1) {
                ctx.beginPath();
                ctx.ellipse(this.x, this.y, rx, ry, 0, 0, Math.PI * 2);
                ctx.fillStyle = grad;
                ctx.fill();
                // Coin edge ring
                ctx.strokeStyle = face ? '#ffd700' : '#a07800';
                ctx.lineWidth = 1.5;
                ctx.stroke();
                if (face && rx > 4) {
                    // $ symbol on coin
                    ctx.fillStyle = 'rgba(139, 105, 20, 0.8)';
                    ctx.font = 'bold ' + (this.r * 0.8) + 'px Arial';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.fillText('$', this.x, this.y);
                }
                // Shine
                ctx.beginPath();
                ctx.ellipse(this.x - rx * 0.25, this.y - ry * 0.3, rx * 0.3, ry * 0.25, -0.5, 0, Math.PI * 2);
                ctx.fillStyle = 'rgba(255,255,255,0.35)';
                ctx.fill();
            }
            ctx.restore();
        };

        // ─── CONFETTI ─────────────────────────────────────────────────────
        var confettiColors = [
            '#ff1493','#ffd700','#00ffcc','#ff6b35',
            '#7c3aed','#00cfff','#ff4500','#39ff14',
            '#ff69b4','#1e90ff','#ffdf00','#ff6347'
        ];
        function Confetti() { this.reset(true); }
        Confetti.prototype.reset = function(init) {
            this.x    = Math.random() * canvas.width;
            this.y    = init ? Math.random() * canvas.height : -20;
            this.w    = 6 + Math.random() * 10;
            this.h    = 4 + Math.random() * 6;
            this.rot  = Math.random() * Math.PI * 2;
            this.rotS = (Math.random() - 0.5) * 0.12;
            this.vy   = 1.2 + Math.random() * 2.0;
            this.vx   = (Math.random() - 0.5) * 1.2;
            this.alpha= 0.65 + Math.random() * 0.35;
            this.color= confettiColors[Math.floor(Math.random() * confettiColors.length)];
            this.shape= Math.random() < 0.3 ? 'circle' : (Math.random() < 0.5 ? 'diamond' : 'rect');
            this.wobble= Math.random() * Math.PI * 2;
            this.wobbleS= 0.03 + Math.random() * 0.03;
        };
        Confetti.prototype.update = function() {
            this.y      += this.vy;
            this.x      += this.vx + Math.sin(this.wobble) * 0.5;
            this.wobble += this.wobbleS;
            this.rot    += this.rotS;
            if (this.y > canvas.height + 30) this.reset(false);
        };
        Confetti.prototype.draw = function() {
            ctx.save();
            ctx.globalAlpha = this.alpha;
            ctx.translate(this.x, this.y);
            ctx.rotate(this.rot);
            ctx.fillStyle = this.color;
            ctx.shadowColor = this.color;
            ctx.shadowBlur = 4;
            if (this.shape === 'circle') {
                ctx.beginPath();
                ctx.arc(0, 0, this.w / 2, 0, Math.PI * 2);
                ctx.fill();
            } else if (this.shape === 'diamond') {
                ctx.beginPath();
                ctx.moveTo(0, -this.h);
                ctx.lineTo(this.w / 2, 0);
                ctx.lineTo(0, this.h);
                ctx.lineTo(-this.w / 2, 0);
                ctx.closePath();
                ctx.fill();
            } else {
                ctx.fillRect(-this.w / 2, -this.h / 2, this.w, this.h);
            }
            ctx.restore();
        };

        // ─── STAR PARTICLES ───────────────────────────────────────────────
        var starParticles = [];
        for (var i = 0; i < 60; i++) {
            starParticles.push({
                x: Math.random(), y: Math.random(),
                r: 0.5 + Math.random() * 2,
                alpha: 0.2 + Math.random() * 0.6,
                twinkle: Math.random() * Math.PI * 2,
                twinkleS: 0.02 + Math.random() * 0.04,
                color: Math.random() < 0.3 ? '#ffd700' : (Math.random() < 0.5 ? '#00ffcc' : '#ffffff')
            });
        }

        // ─── SCENE SETUP ──────────────────────────────────────────────────
        var slots = [
            new SlotMachine(W() * 0.08, H() * 0.45, 0.85, 0.28, 0.025),
            new SlotMachine(W() * 0.22, H() * 0.60, 0.65, 0.22, 0.035),
            new SlotMachine(W() * 0.78, H() * 0.45, 0.85, 0.28, 0.03),
            new SlotMachine(W() * 0.92, H() * 0.62, 0.60, 0.20, 0.020),
            new SlotMachine(W() * 0.50, H() * 0.72, 0.55, 0.18, 0.028),
            new SlotMachine(W() * 0.35, H() * 0.28, 0.50, 0.16, 0.032),
            new SlotMachine(W() * 0.65, H() * 0.25, 0.52, 0.16, 0.022),
        ];

        var coins = [];
        for (var i = 0; i < 28; i++) coins.push(new Coin());

        var confettiPieces = [];
        for (var i = 0; i < 55; i++) confettiPieces.push(new Confetti());

        // ─── RENDER LOOP ──────────────────────────────────────────────────
        var t = 0;
        function drawBg() {
            // Deep dark casino background gradient
            var bg = ctx.createLinearGradient(0, 0, W(), H());
            bg.addColorStop(0,   '#0d0821');
            bg.addColorStop(0.3, '#110a28');
            bg.addColorStop(0.6, '#0e0820');
            bg.addColorStop(1,   '#090515');
            ctx.fillStyle = bg;
            ctx.fillRect(0, 0, W(), H());

            // Subtle deep purple radial glow in center
            var cg = ctx.createRadialGradient(W()*0.5, H()*0.4, 50, W()*0.5, H()*0.4, W()*0.55);
            cg.addColorStop(0, 'rgba(100, 30, 180, 0.12)');
            cg.addColorStop(0.5, 'rgba(60, 10, 120, 0.06)');
            cg.addColorStop(1, 'transparent');
            ctx.fillStyle = cg;
            ctx.fillRect(0, 0, W(), H());
        }

        function drawStars(t) {
            for (var i = 0; i < starParticles.length; i++) {
                var s = starParticles[i];
                s.twinkle += s.twinkleS;
                var a = s.alpha * (0.4 + 0.6 * Math.abs(Math.sin(s.twinkle)));
                ctx.beginPath();
                ctx.arc(s.x * W(), s.y * H(), s.r, 0, Math.PI * 2);
                ctx.fillStyle = s.color;
                ctx.globalAlpha = a;
                ctx.shadowColor = s.color;
                ctx.shadowBlur = s.r * 3;
                ctx.fill();
                ctx.globalAlpha = 1;
                ctx.shadowBlur = 0;
            }
        }

        function loop() {
            if (window.innerWidth < 769) {
                requestAnimationFrame(loop);
                return;
            }
            t += 0.016;
            ctx.clearRect(0, 0, W(), H());
            drawBg();
            drawStars(t);

            // Draw slot machines
            ctx.shadowBlur = 0;
            for (var i = 0; i < slots.length; i++) {
                slots[i].draw(t);
            }

            // Update & draw coins
            for (var i = 0; i < coins.length; i++) {
                coins[i].update();
                coins[i].draw();
            }

            // Update & draw confetti
            for (var i = 0; i < confettiPieces.length; i++) {
                confettiPieces[i].update();
                confettiPieces[i].draw();
            }

            requestAnimationFrame(loop);
        }

        // Reposition slots on resize
        window.addEventListener('resize', function() {
            slots[0].x = W()*0.08;  slots[0].y = H()*0.45;
            slots[1].x = W()*0.22;  slots[1].y = H()*0.60;
            slots[2].x = W()*0.78;  slots[2].y = H()*0.45;
            slots[3].x = W()*0.92;  slots[3].y = H()*0.62;
            slots[4].x = W()*0.50;  slots[4].y = H()*0.72;
            slots[5].x = W()*0.35;  slots[5].y = H()*0.28;
            slots[6].x = W()*0.65;  slots[6].y = H()*0.25;
        });

        loop();
    })();
    // ===== END DESKTOP 3D CASINO BACKGROUND =====

    // Player Action Bar Search
    $('#playerSearchInput').on('keyup', function() {
        var query = $(this).val().toLowerCase();
        if (query.length > 2) {
            playerDoSearch(query);
        }
    });

    function playerDoSearch(query) {
        $.getJSON('{{ route('frontend.game.search') }}?category1={{ $category1 }}&q=' + query, function(data) {
            $('#woocasino > section > main > div.ng-scope > div > section > .games-list__title-wrp > h1').html(query + ' Search Results');
            $('#woocasino > section > main > div.ng-scope > div > section > div.games-list__wrap.ng-scope').html(data.data);
        });
    }
    </script>
@stop

@section('scripts')
@stop