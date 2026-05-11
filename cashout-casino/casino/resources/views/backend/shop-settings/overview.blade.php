@extends('backend.layouts.app')

@section('page-title', 'Shop Game Settings')
@section('page-heading', 'Shop Game Settings')

@section('content')
<section class="content-header">
    @include('backend.partials.messages')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
    @endif
</section>

<section class="content">

    {{-- Shop Selector (admin only) --}}
    @if(auth()->user()->hasRole('admin') && $shops->count())
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-bank"></i> Select Shop</h3>
        </div>
        <div class="box-body">
            <form method="GET" action="{{ route('backend.shop-settings.overview') }}" class="form-inline">
                <div class="form-group">
                    <label class="control-label" style="margin-right:10px">Shop:</label>
                    <select name="shop_id" class="form-control" onchange="this.form.submit()">
                        @foreach($shops as $s)
                            <option value="{{ $s->id }}" {{ $s->id == $shopId ? 'selected' : '' }}>
                                {{ $s->name }} ({{ $s->currency }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Overview Cards --}}
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="fa fa-gamepad"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Games</span>
                    <span class="info-box-number">{{ $allGames->count() }}</span>
                    <div class="progress"><div class="progress-bar" style="width:100%"></div></div>
                    <span class="progress-description">
                        {{ $slotsGames->count() }} Slots &bull; {{ $fishGames->count() }} Fish &bull; {{ $tableGames->count() }} Tables
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="info-box bg-green">
                <span class="info-box-icon"><i class="fa fa-percent"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Fish Target RTP</span>
                    <span class="info-box-number">{{ $fishSettings ? $fishSettings->target_rtp : 'N/A' }}%</span>
                    <div class="progress"><div class="progress-bar" style="width:{{ $fishSettings ? $fishSettings->target_rtp : 0 }}%"></div></div>
                    <span class="progress-description">
                        Fish bank: {{ number_format($fishBank ? $fishBank->fish : 0, 2) }}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="info-box bg-yellow">
                <span class="info-box-icon"><i class="fa fa-diamond"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Active Bonuses</span>
                    @php
                        $activeBonuses = 0;
                        if($bonusSettings) {
                            $activeBonuses += $bonusSettings->welcome_bonus_enabled ? 1 : 0;
                            $activeBonuses += $bonusSettings->daily_bonus_enabled ? 1 : 0;
                            $activeBonuses += $bonusSettings->referral_bonus_enabled ? 1 : 0;
                            $activeBonuses += $bonusSettings->wheel_enabled ? 1 : 0;
                            $activeBonuses += $bonusSettings->happyhour_enabled ? 1 : 0;
                            $activeBonuses += $bonusSettings->sms_bonus_enabled ? 1 : 0;
                        }
                    @endphp
                    <span class="info-box-number">{{ $activeBonuses }}/6</span>
                    <div class="progress"><div class="progress-bar" style="width:{{ $activeBonuses / 6 * 100 }}%"></div></div>
                    <span class="progress-description">Bonus types enabled</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="info-box bg-red">
                <span class="info-box-icon"><i class="fa fa-sliders"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">RTP Overrides</span>
                    <span class="info-box-number">{{ $rtpOverrides }}</span>
                    <div class="progress"><div class="progress-bar" style="width:{{ $allGames->count() ? min(100, $rtpOverrides/$allGames->count()*100) : 0 }}%"></div></div>
                    <span class="progress-description">Games with custom RTP</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick links --}}
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-fish"></i> Fish Game Settings</h3>
                </div>
                <div class="box-body">
                    <p>Configure RTP targets, bank size, bet limits, jackpot contribution, and bonus trigger rates specifically for fish/shooting games.</p>
                    @if($fishSettings)
                        <table class="table table-condensed">
                            <tr><td>Target RTP</td><td><strong>{{ $fishSettings->target_rtp }}%</strong></td></tr>
                            <tr><td>Bank Size</td><td><strong>{{ number_format($fishSettings->fish_bank_size, 2) }}</strong></td></tr>
                            <tr><td>Bet Range</td><td><strong>{{ $fishSettings->min_bet }} – {{ $fishSettings->max_bet }}</strong></td></tr>
                            <tr><td>Status</td><td><span class="label label-{{ $fishSettings->enabled ? 'success' : 'danger' }}">{{ $fishSettings->enabled ? 'Enabled' : 'Disabled' }}</span></td></tr>
                        </table>
                    @else
                        <p class="text-muted">No fish settings configured yet.</p>
                    @endif
                </div>
                <div class="box-footer">
                    <a href="{{ route('backend.shop-settings.fish', ['shop_id' => $shopId]) }}" class="btn btn-primary btn-block">
                        <i class="fa fa-edit"></i> Configure Fish Settings
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-diamond"></i> Bonus Settings</h3>
                </div>
                <div class="box-body">
                    <p>Set per-shop bonus amounts, wagering requirements, wheel prizes, happy hour schedule, referral rewards, and daily login streaks.</p>
                    @if($bonusSettings)
                        <table class="table table-condensed">
                            <tr><td>Welcome Bonus</td><td><span class="label label-{{ $bonusSettings->welcome_bonus_enabled ? 'success' : 'default' }}">{{ $bonusSettings->welcome_bonus_enabled ? $bonusSettings->welcome_bonus_percent.'%' : 'Off' }}</span></td></tr>
                            <tr><td>Daily Bonus</td><td><span class="label label-{{ $bonusSettings->daily_bonus_enabled ? 'success' : 'default' }}">{{ $bonusSettings->daily_bonus_enabled ? $bonusSettings->daily_bonus_base_amount : 'Off' }}</span></td></tr>
                            <tr><td>Referral</td><td><span class="label label-{{ $bonusSettings->referral_bonus_enabled ? 'success' : 'default' }}">{{ $bonusSettings->referral_bonus_enabled ? $bonusSettings->referral_bonus_per_referral : 'Off' }}</span></td></tr>
                            <tr><td>Happy Hour</td><td><span class="label label-{{ $bonusSettings->happyhour_enabled ? 'success' : 'default' }}">{{ $bonusSettings->happyhour_enabled ? $bonusSettings->happyhour_start.' – '.$bonusSettings->happyhour_end : 'Off' }}</span></td></tr>
                        </table>
                    @else
                        <p class="text-muted">No bonus settings configured yet.</p>
                    @endif
                </div>
                <div class="box-footer">
                    <a href="{{ route('backend.shop-settings.bonus', ['shop_id' => $shopId]) }}" class="btn btn-success btn-block">
                        <i class="fa fa-edit"></i> Configure Bonuses
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-sliders"></i> Per-Game RTP</h3>
                </div>
                <div class="box-body">
                    <p>Override RTP targets, bet limits, and enable/disable individual games on a per-shop basis. Works for all game types.</p>
                    <table class="table table-condensed">
                        <tr><td>Slots</td><td><strong>{{ $slotsGames->count() }} games</strong></td></tr>
                        <tr><td>Fish</td><td><strong>{{ $fishGames->count() }} games</strong></td></tr>
                        <tr><td>Tables</td><td><strong>{{ $tableGames->count() }} games</strong></td></tr>
                        <tr><td>Overrides set</td><td><strong>{{ $rtpOverrides }}</strong></td></tr>
                    </table>
                </div>
                <div class="box-footer">
                    <a href="{{ route('backend.shop-settings.game-rtp', ['shop_id' => $shopId]) }}" class="btn btn-warning btn-block">
                        <i class="fa fa-edit"></i> Configure Game RTP
                    </a>
                </div>
            </div>
        </div>
    </div>

</section>
@stop
