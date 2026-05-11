@extends('backend.layouts.app')

@section('page-title', 'Fish Game Settings')
@section('page-heading', 'Fish Game Settings')

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
            <form method="GET" action="{{ route('backend.shop-settings.fish') }}" class="form-inline">
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

    {{-- Live Stats --}}
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="fa fa-database"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Fish Bank</span>
                    <span class="info-box-number">{{ number_format($fishStats['bank'], 2) }}</span>
                    <div class="progress"><div class="progress-bar" style="width:{{ $settings->fish_bank_size > 0 ? min(100, $fishStats['bank']/$settings->fish_bank_size*100) : 0 }}%"></div></div>
                    <span class="progress-description">of {{ number_format($settings->fish_bank_size, 2) }} max</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="info-box bg-green">
                <span class="info-box-icon"><i class="fa fa-percent"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Actual RTP</span>
                    <span class="info-box-number">{{ $fishStats['actual_rtp'] }}%</span>
                    <div class="progress"><div class="progress-bar" style="width:{{ $fishStats['actual_rtp'] }}%"></div></div>
                    <span class="progress-description">Target: {{ $settings->target_rtp }}%</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="info-box bg-yellow">
                <span class="info-box-icon"><i class="fa fa-gamepad"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Fish Games</span>
                    <span class="info-box-number">{{ $fishStats['game_count'] }}</span>
                    <div class="progress"><div class="progress-bar" style="width:100%"></div></div>
                    <span class="progress-description">Active fish/shooting games</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="info-box {{ $settings->enabled ? 'bg-green' : 'bg-red' }}">
                <span class="info-box-icon"><i class="fa fa-power-off"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Fish Status</span>
                    <span class="info-box-number">{{ $settings->enabled ? 'ENABLED' : 'DISABLED' }}</span>
                    <div class="progress"><div class="progress-bar" style="width:100%"></div></div>
                    <span class="progress-description">Global fish game toggle</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Settings Form --}}
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-sliders"></i> Fish Game Configuration</h3>
                    <div class="box-tools pull-right">
                        <span class="label label-{{ $settings->enabled ? 'success' : 'danger' }} label-lg">
                            {{ $settings->enabled ? 'Fish Games ON' : 'Fish Games OFF' }}
                        </span>
                    </div>
                </div>
                <form action="{{ route('backend.shop-settings.fish.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="shop_id" value="{{ $shopId }}">
                    <div class="box-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('target_rtp') ? 'has-error' : '' }}">
                                    <label>Target RTP (%) <span class="text-danger">*</span></label>
                                    <input type="number" name="target_rtp" class="form-control" 
                                           step="0.01" min="50" max="99"
                                           value="{{ old('target_rtp', $settings->target_rtp) }}">
                                    <span class="help-block">The desired return-to-player percentage for fish games (50–99%). <strong>Recommended: 88–94%</strong></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('fish_bank_size') ? 'has-error' : '' }}">
                                    <label>Fish Bank Pool Size <span class="text-danger">*</span></label>
                                    <input type="number" name="fish_bank_size" class="form-control"
                                           step="0.01" min="0"
                                           value="{{ old('fish_bank_size', $settings->fish_bank_size) }}">
                                    <span class="help-block">Maximum size of the fish bank. Winnings are paid from this pool.</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('min_bet') ? 'has-error' : '' }}">
                                    <label>Minimum Bet <span class="text-danger">*</span></label>
                                    <input type="number" name="min_bet" class="form-control"
                                           step="0.01" min="0.01"
                                           value="{{ old('min_bet', $settings->min_bet) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('max_bet') ? 'has-error' : '' }}">
                                    <label>Maximum Bet <span class="text-danger">*</span></label>
                                    <input type="number" name="max_bet" class="form-control"
                                           step="0.01" min="0.01"
                                           value="{{ old('max_bet', $settings->max_bet) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('max_win_per_spin') ? 'has-error' : '' }}">
                                    <label>Max Win Per Round <span class="text-danger">*</span></label>
                                    <input type="number" name="max_win_per_spin" class="form-control"
                                           step="0.01" min="0"
                                           value="{{ old('max_win_per_spin', $settings->max_win_per_spin) }}">
                                    <span class="help-block">Max payout in a single game round.</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('jackpot_contribution_pct') ? 'has-error' : '' }}">
                                    <label>Jackpot Contribution (%) <span class="text-danger">*</span></label>
                                    <input type="number" name="jackpot_contribution_pct" class="form-control"
                                           step="0.01" min="0" max="10"
                                           value="{{ old('jackpot_contribution_pct', $settings->jackpot_contribution_pct) }}">
                                    <span class="help-block">Percentage of each bet that feeds the jackpot pool (0–10%).</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('bonus_trigger_pct') ? 'has-error' : '' }}">
                                    <label>Bonus Round Trigger Chance (%) <span class="text-danger">*</span></label>
                                    <input type="number" name="bonus_trigger_pct" class="form-control"
                                           step="0.01" min="0" max="50"
                                           value="{{ old('bonus_trigger_pct', $settings->bonus_trigger_pct) }}">
                                    <span class="help-block">Probability % of triggering the bonus round per game.</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('allowed_bets') ? 'has-error' : '' }}">
                            <label>Allowed Bet Denominations <span class="text-danger">*</span></label>
                            <input type="text" name="allowed_bets" class="form-control"
                                   value="{{ old('allowed_bets', $settings->allowed_bets) }}">
                            <span class="help-block">Comma-separated list of allowed bet amounts (e.g. <code>0.10,0.50,1.00,5.00,10.00</code>).</span>
                        </div>

                        <div class="form-group">
                            <label>Fish Games Enabled</label>
                            <div>
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="enabled" value="1" 
                                           {{ $settings->enabled ? 'checked' : '' }}>
                                    Enable fish/shooting games for this shop
                                </label>
                            </div>
                            <span class="help-block">When disabled, fish games will not be playable for players in this shop.</span>
                        </div>

                        <div class="form-group">
                            <label>Admin Notes</label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="Internal notes about this shop's fish game configuration...">{{ old('notes', $settings->notes) }}</textarea>
                        </div>

                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Save Fish Settings
                        </button>
                        <a href="{{ route('backend.shop-settings.overview', ['shop_id' => $shopId]) }}" class="btn btn-default">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Fish Games List --}}
        <div class="col-md-4">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-list"></i> Fish Games in this Shop</h3>
                </div>
                <div class="box-body" style="max-height:520px;overflow-y:auto">
                    @if($fishGames->count())
                    <table class="table table-condensed table-hover">
                        <thead><tr><th>Game</th><th>RTP</th><th>Status</th></tr></thead>
                        <tbody>
                            @foreach($fishGames as $game)
                            @php
                                $rtp = $game->stat_in > 0 ? round($game->stat_out / $game->stat_in * 100, 1) : 0;
                            @endphp
                            <tr>
                                <td style="font-size:11px">{{ $game->title ?: $game->name }}</td>
                                <td>
                                    <span class="label label-{{ $rtp > $settings->target_rtp ? 'danger' : 'success' }}">
                                        {{ $rtp }}%
                                    </span>
                                </td>
                                <td>
                                    <span class="label label-{{ $game->view ? 'success' : 'default' }}">
                                        {{ $game->view ? 'On' : 'Off' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                        <div class="text-center text-muted" style="padding:20px">
                            <i class="fa fa-fish fa-2x"></i>
                            <p>No fish games found for this shop.</p>
                        </div>
                    @endif
                </div>
                <div class="box-footer">
                    <a href="{{ route('backend.shop-settings.game-rtp', ['shop_id' => $shopId, 'gamebank' => 'fish']) }}" class="btn btn-default btn-block btn-sm">
                        <i class="fa fa-sliders"></i> Set Per-Game RTP Overrides
                    </a>
                </div>
            </div>
        </div>
    </div>

</section>
@stop
