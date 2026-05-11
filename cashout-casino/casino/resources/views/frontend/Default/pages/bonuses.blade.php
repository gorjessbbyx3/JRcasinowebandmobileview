@extends('frontend.Default.layouts.app')
@section('page-title', 'Bonus')

@section('add-main-class', 'main-pt')

@section('content')

    @php
    if(Auth::check()){
        $currency = auth()->user()->present()->shop ? auth()->user()->present()->shop->currency : '$';
    } else{
        $currency = '$';
    }
    
    $welcomeBonuses = \DB::table('welcomebonuses')->where('shop_id', 1)->get();
    $happyHours = \DB::table('happyhours')->where('shop_id', 1)->get();
    $smsBonuses = \DB::table('sms_bonuses')->where('shop_id', 1)->get();
    $wheelFortune = \DB::table('wheelfortune')->where('shop_id', 1)->where('active', true)->first();
    $jackpots = \DB::table('jpg')->where('shop_id', 1)->where('active', true)->get();
    $dailyBonuses = \DB::table('daily_bonus')->where('shop_id', 1)->where('active', true)->orderBy('day')->get();
    $achievements = \DB::table('progress')->where('shop_id', 1)->where('active', true)->get();
    @endphp

    <div class="bonus-page-premium">
        <div class="container">
            
            <div class="bonus-header">
                <h1 class="bonus-header__title">Exclusive Bonuses</h1>
                <p class="bonus-header__subtitle">Unlock amazing rewards, spin the wheel, and climb your way to jackpot glory!</p>
            </div>

            @if($welcomeBonuses->isNotEmpty())
            <div class="featured-bonus">
                <div class="featured-bonus__content">
                    <div class="featured-bonus__text">
                        <span class="featured-bonus__badge">First Deposit Bonus</span>
                        <h2 class="featured-bonus__title">
                            Welcome to the Casino!
                            <span>Up to {{ $welcomeBonuses->max('bonus') }}% Bonus</span>
                        </h2>
                        <p class="featured-bonus__desc">Make your first deposit and receive an incredible bonus to start your winning journey!</p>
                        @if(Auth::check())
                            <a href="{{ route('frontend.profile') }}" class="featured-bonus__cta">Claim Now</a>
                        @else
                            <a href="#" class="featured-bonus__cta" onclick="document.querySelector('.js-login').click(); return false;">Get Started</a>
                        @endif
                    </div>
                    <div class="featured-bonus__visual">
                        <div class="featured-bonus__circle">
                            <span class="featured-bonus__amount">{{ $welcomeBonuses->max('bonus') }}%</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="bonus-grid">
                
                @foreach($welcomeBonuses as $bonus)
                <div class="bonus-card bonus-card--welcome">
                    <div class="bonus-card__header">
                        <div class="bonus-card__icon">🎁</div>
                        <span class="bonus-card__type">Welcome Bonus</span>
                        <h3 class="bonus-card__title">{{ ucfirst($bonus->pay) }} Deposit</h3>
                        <div class="bonus-card__value">{{ $bonus->bonus }}%</div>
                    </div>
                    <div class="bonus-card__body">
                        <ul class="bonus-card__details">
                            <li><span>Min. Deposit</span><span>{{ $currency }}{{ number_format($bonus->sum, 0) }}</span></li>
                            <li><span>Bonus Type</span><span>{{ ucfirst($bonus->type) }}</span></li>
                            <li><span>Wager Requirement</span><span>{{ $bonus->wager }}x</span></li>
                        </ul>
                        @if(Auth::check())
                            <a href="{{ route('frontend.profile') }}" class="bonus-card__btn">Deposit Now</a>
                        @else
                            <button class="bonus-card__btn" onclick="document.querySelector('.js-login').click();">Sign Up</button>
                        @endif
                    </div>
                </div>
                @endforeach

                @foreach($happyHours as $hh)
                <div class="bonus-card bonus-card--happyhour">
                    <div class="bonus-card__header">
                        <div class="bonus-card__icon">⏰</div>
                        <span class="bonus-card__type">Happy Hour</span>
                        <h3 class="bonus-card__title">{{ $hh->time }}</h3>
                        <div class="bonus-card__value">{{ $hh->multiplier }}</div>
                    </div>
                    <div class="bonus-card__body">
                        <ul class="bonus-card__details">
                            <li><span>Multiplier</span><span>{{ $hh->multiplier }}</span></li>
                            <li><span>Time Window</span><span>{{ $hh->time }}</span></li>
                            <li><span>Wager Requirement</span><span>{{ $hh->wager }}x</span></li>
                        </ul>
                        <button class="bonus-card__btn">Set Reminder</button>
                    </div>
                </div>
                @endforeach

                @foreach($smsBonuses as $sms)
                <div class="bonus-card bonus-card--sms">
                    <div class="bonus-card__header">
                        <div class="bonus-card__icon">📱</div>
                        <span class="bonus-card__type">Loyalty Bonus</span>
                        <h3 class="bonus-card__title">{{ $sms->days }} Days Member</h3>
                        <div class="bonus-card__value">{{ $currency }}{{ number_format($sms->bonus, 0) }}</div>
                    </div>
                    <div class="bonus-card__body">
                        <ul class="bonus-card__details">
                            <li><span>Account Age</span><span>{{ $sms->days }} days</span></li>
                            <li><span>Bonus Amount</span><span>{{ $currency }}{{ number_format($sms->bonus, 0) }}</span></li>
                            <li><span>Wager Requirement</span><span>{{ $sms->wager }}x</span></li>
                        </ul>
                        <button class="bonus-card__btn">Learn More</button>
                    </div>
                </div>
                @endforeach
            </div>

            @if($wheelFortune)
            <div class="wheel-section">
                <h2 class="bonus-header__title" style="margin-bottom: 20px;">Wheel of Fortune</h2>
                <p class="bonus-header__subtitle" style="margin-bottom: 40px;">Spin the wheel daily for a chance to win amazing prizes!</p>
                
                <div class="wheel-container">
                    <div class="wheel-pointer"></div>
                    <div class="wheel" id="fortuneWheel">
                        @php
                            $sectors = json_decode($wheelFortune->sectors, true) ?? [];
                            $sectorCount = count($sectors);
                            $sectorAngle = $sectorCount > 0 ? 360 / $sectorCount : 45;
                        @endphp
                        <svg viewBox="0 0 300 300" style="width: 100%; height: 100%;">
                            @foreach($sectors as $index => $sector)
                                @php
                                    $startAngle = $index * $sectorAngle;
                                    $endAngle = ($index + 1) * $sectorAngle;
                                    $startRad = deg2rad($startAngle - 90);
                                    $endRad = deg2rad($endAngle - 90);
                                    $x1 = 150 + 140 * cos($startRad);
                                    $y1 = 150 + 140 * sin($startRad);
                                    $x2 = 150 + 140 * cos($endRad);
                                    $y2 = 150 + 140 * sin($endRad);
                                    $largeArc = $sectorAngle > 180 ? 1 : 0;
                                    $midAngle = ($startAngle + $endAngle) / 2;
                                    $midRad = deg2rad($midAngle - 90);
                                    $textX = 150 + 90 * cos($midRad);
                                    $textY = 150 + 90 * sin($midRad);
                                @endphp
                                <path d="M150,150 L{{ $x1 }},{{ $y1 }} A140,140 0 {{ $largeArc }},1 {{ $x2 }},{{ $y2 }} Z" fill="{{ $sector['color'] ?? '#FFD700' }}" stroke="#1a1a2e" stroke-width="2"/>
                                <text x="{{ $textX }}" y="{{ $textY }}" text-anchor="middle" dominant-baseline="middle" fill="#fff" font-size="14" font-weight="bold" transform="rotate({{ $midAngle }}, {{ $textX }}, {{ $textY }})">{{ $sector['label'] ?? '' }}</text>
                            @endforeach
                            <circle cx="150" cy="150" r="30" fill="url(#goldGradient)" stroke="#1a1a2e" stroke-width="3"/>
                            <defs>
                                <linearGradient id="goldGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#FFD700"/>
                                    <stop offset="100%" style="stop-color:#FFA500"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                </div>
                
                @if(Auth::check())
                    <button class="spin-btn" id="spinBtn" onclick="spinWheel()">Spin Now!</button>
                @else
                    <button class="spin-btn" onclick="document.querySelector('.js-login').click();">Login to Spin</button>
                @endif
            </div>
            @endif

            @if($jackpots->isNotEmpty())
            <div class="jackpot-section">
                <h2 class="bonus-header__title" style="margin-bottom: 30px;">Progressive Jackpots</h2>
                <div class="jackpot-grid">
                    @foreach($jackpots as $jp)
                    @php
                        $tier = strtolower(explode(' ', $jp->name)[0]);
                    @endphp
                    <div class="jackpot-card jackpot-card--{{ $tier }}">
                        <div class="jackpot-card__label">{{ $jp->name }}</div>
                        <div class="jackpot-card__amount" data-balance="{{ $jp->balance }}">
                            {{ $currency }}{{ number_format($jp->balance, 2) }}
                        </div>
                        <div class="jackpot-card__trigger">Triggers at {{ $currency }}{{ number_format($jp->pay_sum, 0) }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if($dailyBonuses->isNotEmpty())
            <div class="daily-bonus-section">
                <div class="daily-bonus__header">
                    <h2 class="daily-bonus__title">Daily Login Rewards</h2>
                    <p class="daily-bonus__subtitle">Login every day to claim increasing rewards!</p>
                </div>
                <div class="daily-streak">
                    @foreach($dailyBonuses as $index => $day)
                    @php
                        $isClaimed = false;
                        $isToday = false;
                        $isLocked = true;
                        
                        if(Auth::check()) {
                            $user = auth()->user();
                            $streak = $user->daily_bonus_streak ?? 0;
                            $lastClaim = $user->last_daily_bonus;
                            
                            if($day->day <= $streak) {
                                $isClaimed = true;
                                $isLocked = false;
                            } elseif($day->day == $streak + 1) {
                                $isToday = true;
                                $isLocked = false;
                            }
                        }
                    @endphp
                    <div class="daily-day {{ $isClaimed ? 'daily-day--claimed' : '' }} {{ $isToday ? 'daily-day--today' : '' }} {{ $isLocked ? 'daily-day--locked' : '' }}">
                        @if($isClaimed)
                            <div class="daily-day__check">✓</div>
                        @endif
                        <div class="daily-day__number">Day {{ $day->day }}</div>
                        <div class="daily-day__reward">{{ $currency }}{{ number_format($day->reward, 0) }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if($achievements->isNotEmpty())
            <div class="achievements-section">
                <h2 class="bonus-header__title" style="margin-bottom: 30px;">Achievements</h2>
                <div class="achievements-grid">
                    @foreach($achievements as $achievement)
                    @php
                        $progress = 0;
                        $isCompleted = false;
                        
                        if(Auth::check()) {
                            $user = auth()->user();
                            if($achievement->type == 'bets') {
                                $current = $user->total_bets ?? 0;
                            } else {
                                $current = $user->total_wins ?? 0;
                            }
                            $progress = min(100, ($current / $achievement->target) * 100);
                            $isCompleted = $progress >= 100;
                        }
                        
                        $icons = [
                            'First Steps' => '🎯',
                            'Getting Warmed Up' => '🔥',
                            'High Roller' => '💎',
                            'Legend' => '👑',
                            'Lucky 10' => '🍀',
                            'Winner Winner' => '🏆',
                            'Champion' => '🥇'
                        ];
                        $icon = $icons[$achievement->name] ?? '⭐';
                    @endphp
                    <div class="achievement-card {{ $isCompleted ? 'achievement-card--completed' : '' }}">
                        <div class="achievement__icon">{{ $icon }}</div>
                        <div class="achievement__content">
                            <div class="achievement__name">{{ $achievement->name }}</div>
                            <div class="achievement__desc">{{ ucfirst($achievement->type) }} {{ $currency }}{{ number_format($achievement->target, 0) }} to unlock</div>
                            <div class="achievement__progress">
                                <div class="achievement__progress-bar" style="width: {{ $progress }}%"></div>
                            </div>
                            <div class="achievement__stats">
                                <span>{{ number_format($progress, 1) }}% Complete</span>
                                <span class="achievement__reward">Reward: {{ $currency }}{{ number_format($achievement->reward, 0) }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>

    <script>
    @if($wheelFortune)
    let isSpinning = false;
    
    function spinWheel() {
        if (isSpinning) return;
        isSpinning = true;
        
        const wheel = document.getElementById('fortuneWheel');
        const btn = document.getElementById('spinBtn');
        btn.disabled = true;
        btn.textContent = 'Spinning...';
        
        const rotations = 5 + Math.random() * 5;
        const finalAngle = rotations * 360 + Math.random() * 360;
        
        wheel.style.transition = 'transform 4s cubic-bezier(0.17, 0.67, 0.12, 0.99)';
        wheel.style.transform = `rotate(${finalAngle}deg)`;
        
        setTimeout(() => {
            isSpinning = false;
            btn.disabled = false;
            btn.textContent = 'Spin Again Tomorrow!';
            
            const sectors = @json(json_decode($wheelFortune->sectors ?? '[]', true));
            const sectorAngle = 360 / sectors.length;
            const normalizedAngle = finalAngle % 360;
            const winningIndex = Math.floor((360 - normalizedAngle + sectorAngle / 2) % 360 / sectorAngle);
            const prize = sectors[winningIndex];
            
            if (prize) {
                setTimeout(() => {
                    alert('Congratulations! You won ' + prize.label + '!');
                }, 500);
            }
        }, 4000);
    }
    @endif
    
    setInterval(function() {
        document.querySelectorAll('.jackpot-card__amount').forEach(function(el) {
            let balance = parseFloat(el.dataset.balance);
            balance += Math.random() * 0.1;
            el.dataset.balance = balance;
            el.textContent = '{{ $currency }}' + balance.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        });
    }, 2000);
    </script>

@endsection

@section('scripts')
    @include('frontend.Default.partials.scripts')
@endsection
