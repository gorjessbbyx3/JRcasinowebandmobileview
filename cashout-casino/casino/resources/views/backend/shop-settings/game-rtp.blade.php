@extends('backend.layouts.app')

@section('page-title', 'Per-Game RTP Settings')
@section('page-heading', 'Per-Game RTP Settings')

@section('content')
<section class="content-header">
    @include('backend.partials.messages')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Saved!</strong> {{ session('success') }}
        </div>
    @endif
</section>

<section class="content">

    {{-- Shop + Filter --}}
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-filter"></i> Filter Games</h3>
        </div>
        <div class="box-body">
            <form method="GET" action="{{ route('backend.shop-settings.game-rtp') }}" class="form-inline">
                @if(auth()->user()->hasRole('admin') && $shops->count())
                <div class="form-group" style="margin-right:15px">
                    <label style="margin-right:6px">Shop:</label>
                    <select name="shop_id" class="form-control">
                        @foreach($shops as $s)
                            <option value="{{ $s->id }}" {{ $s->id == $shopId ? 'selected' : '' }}>
                                {{ $s->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="form-group" style="margin-right:15px">
                    <label style="margin-right:6px">Game Type:</label>
                    <select name="gamebank" class="form-control">
                        <option value="" {{ $gamebankFilter == '' ? 'selected' : '' }}>All Types</option>
                        <option value="fish" {{ $gamebankFilter == 'fish' ? 'selected' : '' }}>Fish / Shooting</option>
                        <option value="slots" {{ $gamebankFilter == 'slots' ? 'selected' : '' }}>Slots</option>
                        <option value="little" {{ $gamebankFilter == 'little' ? 'selected' : '' }}>Little (Mini Slots)</option>
                        <option value="table_bank" {{ $gamebankFilter == 'table_bank' ? 'selected' : '' }}>Table Games</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-search"></i> Filter
                </button>
                &nbsp;
                <a href="{{ route('backend.shop-settings.overview', ['shop_id' => $shopId]) }}" class="btn btn-default">
                    <i class="fa fa-arrow-left"></i> Back to Overview
                </a>
            </form>
        </div>
    </div>

    {{-- Global RTP Note --}}
    <div class="callout callout-info">
        <h4><i class="fa fa-info-circle"></i> How Per-Game RTP Works</h4>
        <p>The <strong>global shop RTP</strong> is currently <strong>{{ $globalPercent }}%</strong>. 
        Overrides set here apply only to individual games in this shop. 
        Leave <em>Target RTP</em> blank or at 0 to use the global shop default.
        The <strong>Enabled</strong> toggle controls whether that specific game is playable.</p>
    </div>

    {{-- Bulk action bar --}}
    <div class="box box-default">
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <label>Bulk Set RTP for ALL shown games:</label>
                    <div class="input-group">
                        <input type="number" id="bulk-rtp" class="form-control" placeholder="e.g. 92" step="0.01" min="50" max="99">
                        <span class="input-group-btn">
                            <button class="btn btn-warning" onclick="applyBulkRtp()">Apply to All</button>
                        </span>
                    </div>
                </div>
                <div class="col-md-4">
                    <label>Bulk Toggle:</label>
                    <div>
                        <button class="btn btn-success btn-sm" onclick="toggleAll(true)"><i class="fa fa-check"></i> Enable All</button>
                        &nbsp;
                        <button class="btn btn-danger btn-sm" onclick="toggleAll(false)"><i class="fa fa-times"></i> Disable All</button>
                    </div>
                </div>
                <div class="col-md-4 text-right" style="padding-top:24px">
                    <span class="text-muted">{{ $games->count() }} games shown</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Game RTP Table --}}
    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-sliders"></i> Game RTP Overrides</h3>
        </div>
        <form action="{{ route('backend.shop-settings.game-rtp.update') }}" method="POST" id="rtp-form">
            @csrf
            <input type="hidden" name="shop_id" value="{{ $shopId }}">
            <div class="box-body" style="padding:0">
                <table class="table table-hover table-bordered" id="rtp-table">
                    <thead>
                        <tr style="background:#f4f4f4">
                            <th width="35%">Game</th>
                            <th width="12%">Type</th>
                            <th width="10%">Actual RTP</th>
                            <th width="14%">Target RTP (%)</th>
                            <th width="10%">Min Bet</th>
                            <th width="10%">Max Bet</th>
                            <th width="10%">Max Win</th>
                            <th width="6%" class="text-center">Enabled</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($games as $game)
                        @php
                            $override = isset($rtpMap[$game->id]) ? (object)$rtpMap[$game->id] : null;
                            $actualRtp = $game->stat_in > 0 ? round($game->stat_out / $game->stat_in * 100, 1) : null;
                            $isEnabled = $override ? $override->enabled : true;
                            $targetRtp = $override ? $override->target_rtp : '';
                            $colors = ['fish'=>'info','slots'=>'success','little'=>'warning','table_bank'=>'danger'];
                            $bankColor = $colors[$game->gamebank] ?? 'default';
                        @endphp
                        <tr class="{{ !$isEnabled ? 'text-muted' : '' }}">
                            <td>
                                <strong>{{ $game->title ?: $game->name }}</strong>
                                <br><small class="text-muted">{{ $game->name }}</small>
                            </td>
                            <td>
                                <span class="label label-{{ $bankColor }}">{{ strtoupper($game->gamebank) }}</span>
                            </td>
                            <td class="text-center">
                                @if($actualRtp !== null)
                                    <span class="label label-{{ $actualRtp > $globalPercent + 5 ? 'danger' : ($actualRtp > $globalPercent ? 'warning' : 'success') }}">
                                        {{ $actualRtp }}%
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <input type="number" name="games[{{ $game->id }}][target_rtp]"
                                       class="form-control input-sm rtp-input"
                                       step="0.01" min="50" max="99"
                                       placeholder="{{ $globalPercent }}"
                                       value="{{ $targetRtp > 0 ? $targetRtp : '' }}">
                            </td>
                            <td>
                                <input type="number" name="games[{{ $game->id }}][min_bet]"
                                       class="form-control input-sm"
                                       step="0.01" min="0"
                                       placeholder="default"
                                       value="{{ $override && $override->min_bet_override ? $override->min_bet_override : '' }}">
                            </td>
                            <td>
                                <input type="number" name="games[{{ $game->id }}][max_bet]"
                                       class="form-control input-sm"
                                       step="0.01" min="0"
                                       placeholder="default"
                                       value="{{ $override && $override->max_bet_override ? $override->max_bet_override : '' }}">
                            </td>
                            <td>
                                <input type="number" name="games[{{ $game->id }}][max_win]"
                                       class="form-control input-sm"
                                       step="0.01" min="0"
                                       placeholder="default"
                                       value="{{ $override && $override->max_win_override ? $override->max_win_override : '' }}">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" name="games[{{ $game->id }}][enabled]"
                                       class="enabled-check" value="1"
                                       {{ $isEnabled ? 'checked' : '' }}>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted" style="padding:30px">
                                <i class="fa fa-gamepad fa-2x"></i>
                                <p>No games found for this filter.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fa fa-save"></i> Save RTP Settings
                </button>
                <a href="{{ route('backend.shop-settings.overview', ['shop_id' => $shopId]) }}" class="btn btn-default btn-lg">
                    Cancel
                </a>
                <span class="pull-right text-muted" style="line-height:36px">
                    Leave fields blank to use shop global defaults.
                </span>
            </div>
        </form>
    </div>

</section>

<script>
function applyBulkRtp() {
    var val = document.getElementById('bulk-rtp').value;
    if (!val) return;
    document.querySelectorAll('.rtp-input').forEach(function(el) {
        el.value = val;
    });
}
function toggleAll(state) {
    document.querySelectorAll('.enabled-check').forEach(function(el) {
        el.checked = state;
    });
}
</script>
@stop
