@extends('backend.layouts.app')

@section('page-title', 'Shop Bonus Settings')
@section('page-heading', 'Shop Bonus Settings')

@section('content')
<section class="content-header">
    @include('backend.partials.messages')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Saved!</strong> {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif
</section>

<section class="content">

    {{-- Shop Selector --}}
    @if(auth()->user()->hasRole('admin') && $shops->count())
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-bank"></i> Select Shop</h3>
        </div>
        <div class="box-body">
            <form method="GET" action="{{ route('backend.shop-settings.bonus') }}" class="form-inline">
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
                &nbsp;
                <a href="{{ route('backend.shop-settings.overview', ['shop_id' => $shopId]) }}" class="btn btn-default">
                    <i class="fa fa-arrow-left"></i> Back to Overview
                </a>
            </form>
        </div>
    </div>
    @endif

    <form action="{{ route('backend.shop-settings.bonus.update') }}" method="POST">
        @csrf
        <input type="hidden" name="shop_id" value="{{ $shopId }}">

        <div class="row">

            {{-- Welcome Bonus --}}
            <div class="col-md-6">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-gift"></i> Welcome Bonus</h3>
                        <div class="box-tools pull-right">
                            <label class="checkbox-inline" style="font-weight:normal;margin:0">
                                <input type="checkbox" name="welcome_bonus_enabled" value="1"
                                       {{ $settings->welcome_bonus_enabled ? 'checked' : '' }}>
                                Enabled
                            </label>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Match Percentage (%)</label>
                            <input type="number" name="welcome_bonus_percent" class="form-control"
                                   step="1" min="0" max="500"
                                   value="{{ old('welcome_bonus_percent', $settings->welcome_bonus_percent) }}">
                            <span class="help-block">e.g. 100 = 100% match on first deposit</span>
                        </div>
                        <div class="form-group">
                            <label>Maximum Bonus Amount</label>
                            <div class="input-group">
                                <span class="input-group-addon">{{ $shop?->currency ?? '$' }}</span>
                                <input type="number" name="welcome_bonus_max_amount" class="form-control"
                                       step="0.01" min="0"
                                       value="{{ old('welcome_bonus_max_amount', $settings->welcome_bonus_max_amount) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Wagering Requirement (x)</label>
                            <input type="number" name="welcome_bonus_wagering_requirement" class="form-control"
                                   step="1" min="1" max="100"
                                   value="{{ old('welcome_bonus_wagering_requirement', $settings->welcome_bonus_wagering_requirement) }}">
                            <span class="help-block">Player must wager bonus × this many times before withdrawing.</span>
                        </div>
                        <div class="form-group">
                            <label>Expires After (days)</label>
                            <input type="number" name="welcome_bonus_expires_days" class="form-control"
                                   step="1" min="1"
                                   value="{{ old('welcome_bonus_expires_days', $settings->welcome_bonus_expires_days) }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Daily Login Bonus --}}
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-calendar-check-o"></i> Daily Login Bonus</h3>
                        <div class="box-tools pull-right">
                            <label class="checkbox-inline" style="font-weight:normal;margin:0">
                                <input type="checkbox" name="daily_bonus_enabled" value="1"
                                       {{ $settings->daily_bonus_enabled ? 'checked' : '' }}>
                                Enabled
                            </label>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Base Daily Amount</label>
                            <div class="input-group">
                                <span class="input-group-addon">{{ $shop?->currency ?? '$' }}</span>
                                <input type="number" name="daily_bonus_base_amount" class="form-control"
                                       step="0.01" min="0"
                                       value="{{ old('daily_bonus_base_amount', $settings->daily_bonus_base_amount) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Streak Multiplier (per consecutive day)</label>
                            <input type="number" name="daily_bonus_streak_multiplier" class="form-control"
                                   step="0.01" min="1" max="5"
                                   value="{{ old('daily_bonus_streak_multiplier', $settings->daily_bonus_streak_multiplier) }}">
                            <span class="help-block">e.g. 1.10 = 10% more per day streak</span>
                        </div>
                        <div class="form-group">
                            <label>Maximum Streak Days</label>
                            <input type="number" name="daily_bonus_max_streak" class="form-control"
                                   step="1" min="1"
                                   value="{{ old('daily_bonus_max_streak', $settings->daily_bonus_max_streak) }}">
                        </div>
                        <div class="form-group">
                            <label>Maximum Daily Bonus Amount</label>
                            <div class="input-group">
                                <span class="input-group-addon">{{ $shop?->currency ?? '$' }}</span>
                                <input type="number" name="daily_bonus_max_amount" class="form-control"
                                       step="0.01" min="0"
                                       value="{{ old('daily_bonus_max_amount', $settings->daily_bonus_max_amount) }}">
                            </div>
                            <span class="help-block">Cap on total daily bonus even with streak.</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Referral Bonus --}}
            <div class="col-md-6">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-users"></i> Referral Bonus</h3>
                        <div class="box-tools pull-right">
                            <label class="checkbox-inline" style="font-weight:normal;margin:0">
                                <input type="checkbox" name="referral_bonus_enabled" value="1"
                                       {{ $settings->referral_bonus_enabled ? 'checked' : '' }}>
                                Enabled
                            </label>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Referrer Reward (per successful referral)</label>
                            <div class="input-group">
                                <span class="input-group-addon">{{ $shop?->currency ?? '$' }}</span>
                                <input type="number" name="referral_bonus_per_referral" class="form-control"
                                       step="0.01" min="0"
                                       value="{{ old('referral_bonus_per_referral', $settings->referral_bonus_per_referral) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>New Player (Referee) Reward</label>
                            <div class="input-group">
                                <span class="input-group-addon">{{ $shop?->currency ?? '$' }}</span>
                                <input type="number" name="referral_bonus_referee_amount" class="form-control"
                                       step="0.01" min="0"
                                       value="{{ old('referral_bonus_referee_amount', $settings->referral_bonus_referee_amount) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Maximum Referrals Per Player</label>
                            <input type="number" name="referral_max_uses" class="form-control"
                                   step="1" min="0"
                                   value="{{ old('referral_max_uses', $settings->referral_max_uses) }}">
                        </div>
                        <div class="form-group">
                            <label>Referee Minimum Deposit to Unlock Reward</label>
                            <div class="input-group">
                                <span class="input-group-addon">{{ $shop?->currency ?? '$' }}</span>
                                <input type="number" name="referral_min_deposit" class="form-control"
                                       step="0.01" min="0"
                                       value="{{ old('referral_min_deposit', $settings->referral_min_deposit) }}">
                            </div>
                            <span class="help-block">The new player must deposit at least this much before the referrer is rewarded.</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Wheel of Fortune --}}
            <div class="col-md-6">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-circle-o-notch"></i> Wheel of Fortune</h3>
                        <div class="box-tools pull-right">
                            <label class="checkbox-inline" style="font-weight:normal;margin:0">
                                <input type="checkbox" name="wheel_enabled" value="1"
                                       {{ $settings->wheel_enabled ? 'checked' : '' }}>
                                Enabled
                            </label>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Minimum Deposit to Unlock Wheel Spin</label>
                            <div class="input-group">
                                <span class="input-group-addon">{{ $shop?->currency ?? '$' }}</span>
                                <input type="number" name="wheel_min_deposit" class="form-control"
                                       step="0.01" min="0"
                                       value="{{ old('wheel_min_deposit', $settings->wheel_min_deposit) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Cooldown Between Spins (hours)</label>
                            <input type="number" name="wheel_cooldown_hours" class="form-control"
                                   step="1" min="0"
                                   value="{{ old('wheel_cooldown_hours', $settings->wheel_cooldown_hours) }}">
                        </div>
                        <div class="form-group">
                            <label>Spins Granted Per Deposit</label>
                            <input type="number" name="wheel_spins_per_deposit" class="form-control"
                                   step="1" min="1"
                                   value="{{ old('wheel_spins_per_deposit', $settings->wheel_spins_per_deposit) }}">
                        </div>
                        <div class="form-group">
                            <label>Wheel Prizes (JSON)</label>
                            <textarea name="wheel_prizes" class="form-control" rows="4"
                                      placeholder='[{"label":"Free Spin","value":0,"weight":30},{"label":"$5","value":5,"weight":25},{"label":"$10","value":10,"weight":15},{"label":"$25","value":25,"weight":10}]'>{{ old('wheel_prizes', is_array($settings->wheel_prizes) ? json_encode($settings->wheel_prizes, JSON_PRETTY_PRINT) : $settings->wheel_prizes) }}</textarea>
                            <span class="help-block">JSON array: <code>[{"label":"$5","value":5,"weight":30}]</code> — higher weight = more likely.</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Happy Hour --}}
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-clock-o"></i> Happy Hour</h3>
                        <div class="box-tools pull-right">
                            <label class="checkbox-inline" style="font-weight:normal;margin:0">
                                <input type="checkbox" name="happyhour_enabled" value="1"
                                       {{ $settings->happyhour_enabled ? 'checked' : '' }}>
                                Enabled
                            </label>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Win Multiplier During Happy Hour</label>
                            <input type="number" name="happyhour_multiplier" class="form-control"
                                   step="0.1" min="1" max="10"
                                   value="{{ old('happyhour_multiplier', $settings->happyhour_multiplier) }}">
                            <span class="help-block">e.g. 2.0 = double winnings</span>
                        </div>
                        <div class="form-group">
                            <label>Happy Hour Start Time</label>
                            <input type="time" name="happyhour_start" class="form-control"
                                   value="{{ old('happyhour_start', substr($settings->happyhour_start, 0, 5)) }}">
                        </div>
                        <div class="form-group">
                            <label>Happy Hour End Time</label>
                            <input type="time" name="happyhour_end" class="form-control"
                                   value="{{ old('happyhour_end', substr($settings->happyhour_end, 0, 5)) }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- SMS / Loyalty Bonus --}}
            <div class="col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-mobile"></i> SMS / Loyalty Bonus</h3>
                        <div class="box-tools pull-right">
                            <label class="checkbox-inline" style="font-weight:normal;margin:0">
                                <input type="checkbox" name="sms_bonus_enabled" value="1"
                                       {{ $settings->sms_bonus_enabled ? 'checked' : '' }}>
                                Enabled
                            </label>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>SMS Bonus Amount</label>
                            <div class="input-group">
                                <span class="input-group-addon">{{ $shop?->currency ?? '$' }}</span>
                                <input type="number" name="sms_bonus_amount" class="form-control"
                                       step="0.01" min="0"
                                       value="{{ old('sms_bonus_amount', $settings->sms_bonus_amount) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Frequency (every N days)</label>
                            <input type="number" name="sms_bonus_interval_days" class="form-control"
                                   step="1" min="1"
                                   value="{{ old('sms_bonus_interval_days', $settings->sms_bonus_interval_days) }}">
                            <span class="help-block">Send bonus to inactive players every this many days.</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Deposit Bonus --}}
            <div class="col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-money"></i> Recurring Deposit Bonus</h3>
                        <div class="box-tools pull-right">
                            <label class="checkbox-inline" style="font-weight:normal;margin:0">
                                <input type="checkbox" name="deposit_bonus_enabled" value="1"
                                       {{ $settings->deposit_bonus_enabled ? 'checked' : '' }}>
                                Enabled
                            </label>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Bonus Percentage on Each Deposit (%)</label>
                            <input type="number" name="deposit_bonus_percent" class="form-control"
                                   step="0.01" min="0" max="100"
                                   value="{{ old('deposit_bonus_percent', $settings->deposit_bonus_percent) }}">
                        </div>
                        <div class="form-group">
                            <label>Maximum Bonus Per Deposit</label>
                            <div class="input-group">
                                <span class="input-group-addon">{{ $shop?->currency ?? '$' }}</span>
                                <input type="number" name="deposit_bonus_max" class="form-control"
                                       step="0.01" min="0"
                                       value="{{ old('deposit_bonus_max', $settings->deposit_bonus_max) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Wagering Requirement (x)</label>
                            <input type="number" name="deposit_bonus_wagering" class="form-control"
                                   step="1" min="1"
                                   value="{{ old('deposit_bonus_wagering', $settings->deposit_bonus_wagering) }}">
                        </div>
                    </div>
                </div>
            </div>

        </div>{{-- end .row --}}

        <div class="box box-default">
            <div class="box-body">
                <div class="form-group">
                    <label>Admin Notes</label>
                    <textarea name="notes" class="form-control" rows="2" placeholder="Internal notes...">{{ old('notes', $settings->notes) }}</textarea>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fa fa-save"></i> Save All Bonus Settings
                </button>
                <a href="{{ route('backend.shop-settings.overview', ['shop_id' => $shopId]) }}" class="btn btn-default btn-lg">
                    Cancel
                </a>
            </div>
        </div>

    </form>

</section>
@stop
