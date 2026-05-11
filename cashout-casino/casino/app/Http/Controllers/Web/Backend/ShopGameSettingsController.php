<?php
namespace VanguardLTE\Http\Controllers\Web\Backend;

class ShopGameSettingsController extends \VanguardLTE\Http\Controllers\Controller
{
    public function __construct()
    {
        $this->middleware(['auth', '2fa']);
        $this->middleware('permission:access.admin.panel');
    }

    private function resolveShopId($shopId = null)
    {
        if (auth()->user()->hasRole('admin') && $shopId) {
            return (int) $shopId;
        }
        return auth()->user()->shop_id;
    }

    // ─── FISH SETTINGS ───────────────────────────────────────────────────────

    public function fishSettings(\Illuminate\Http\Request $request)
    {
        $shopId   = $this->resolveShopId($request->shop_id);
        $shops    = auth()->user()->hasRole('admin') ? \VanguardLTE\Shop::orderBy('name')->get() : collect();
        $settings = \VanguardLTE\ShopFishSetting::forShop($shopId);
        $shop     = \VanguardLTE\Shop::find($shopId);
        $fishBank = \VanguardLTE\FishBank::where('shop_id', $shopId)->first();
        $fishGames = \VanguardLTE\Game::where('shop_id', $shopId)->where('gamebank', 'fish')->orderBy('title')->get();

        $fishStats = [
            'total_in'   => $fishGames->sum('stat_in'),
            'total_out'  => $fishGames->sum('stat_out'),
            'game_count' => $fishGames->count(),
            'bank'       => $fishBank ? $fishBank->fish : 0,
        ];
        $fishStats['actual_rtp'] = $fishStats['total_in'] > 0
            ? round($fishStats['total_out'] / $fishStats['total_in'] * 100, 2)
            : 0;

        return view('backend.shop-settings.fish', compact(
            'settings', 'shops', 'shopId', 'shop', 'fishGames', 'fishStats'
        ));
    }

    public function updateFishSettings(\Illuminate\Http\Request $request)
    {
        $shopId = $this->resolveShopId($request->shop_id);

        $validated = $request->validate([
            'target_rtp'               => 'required|numeric|min:50|max:99',
            'fish_bank_size'           => 'required|numeric|min:0',
            'min_bet'                  => 'required|numeric|min:0.01',
            'max_bet'                  => 'required|numeric|min:0.01',
            'max_win_per_spin'         => 'required|numeric|min:0',
            'jackpot_contribution_pct' => 'required|numeric|min:0|max:10',
            'bonus_trigger_pct'        => 'required|numeric|min:0|max:50',
            'allowed_bets'             => 'required|string',
            'enabled'                  => 'nullable|boolean',
            'notes'                    => 'nullable|string|max:1000',
        ]);

        $validated['enabled']  = $request->has('enabled') ? 1 : 0;
        $validated['shop_id']  = $shopId;

        \VanguardLTE\ShopFishSetting::updateOrCreate(
            ['shop_id' => $shopId],
            $validated
        );

        return redirect()->route('backend.shop-settings.fish', ['shop_id' => $shopId])
            ->with('success', 'Fish game settings saved successfully.');
    }

    // ─── BONUS SETTINGS ──────────────────────────────────────────────────────

    public function bonusSettings(\Illuminate\Http\Request $request)
    {
        $shopId   = $this->resolveShopId($request->shop_id);
        $shops    = auth()->user()->hasRole('admin') ? \VanguardLTE\Shop::orderBy('name')->get() : collect();
        $settings = \VanguardLTE\ShopBonusSetting::forShop($shopId);
        $shop     = \VanguardLTE\Shop::find($shopId);

        return view('backend.shop-settings.bonus', compact('settings', 'shops', 'shopId', 'shop'));
    }

    public function updateBonusSettings(\Illuminate\Http\Request $request)
    {
        $shopId = $this->resolveShopId($request->shop_id);

        $data = $request->except(['_token', 'shop_id']);

        $booleans = [
            'welcome_bonus_enabled', 'daily_bonus_enabled', 'referral_bonus_enabled',
            'wheel_enabled', 'happyhour_enabled', 'sms_bonus_enabled', 'deposit_bonus_enabled',
        ];
        foreach ($booleans as $b) {
            $data[$b] = $request->has($b) ? 1 : 0;
        }

        \VanguardLTE\ShopBonusSetting::updateOrCreate(
            ['shop_id' => $shopId],
            array_merge($data, ['shop_id' => $shopId])
        );

        return redirect()->route('backend.shop-settings.bonus', ['shop_id' => $shopId])
            ->with('success', 'Bonus settings saved successfully.');
    }

    // ─── GAME RTP ─────────────────────────────────────────────────────────────

    public function gameRtp(\Illuminate\Http\Request $request)
    {
        $shopId  = $this->resolveShopId($request->shop_id);
        $shops   = auth()->user()->hasRole('admin') ? \VanguardLTE\Shop::orderBy('name')->get() : collect();
        $shop    = \VanguardLTE\Shop::find($shopId);

        $gamebankFilter = $request->get('gamebank', '');
        $query = \VanguardLTE\Game::where('shop_id', $shopId)->orderBy('title');
        if ($gamebankFilter) {
            $query->where('gamebank', $gamebankFilter);
        }
        $games = $query->get();

        $rtpMap = \VanguardLTE\ShopGameRtp::where('shop_id', $shopId)
            ->pluck(null, 'game_id')
            ->toArray();

        $globalPercent = $shop ? $shop->percent : 92;

        return view('backend.shop-settings.game-rtp', compact(
            'games', 'shops', 'shopId', 'shop', 'rtpMap', 'globalPercent', 'gamebankFilter'
        ));
    }

    public function updateGameRtp(\Illuminate\Http\Request $request)
    {
        $shopId = $this->resolveShopId($request->shop_id);

        $gameRtpData = $request->input('games', []);

        foreach ($gameRtpData as $gameId => $data) {
            \VanguardLTE\ShopGameRtp::updateOrCreate(
                ['shop_id' => $shopId, 'game_id' => $gameId],
                [
                    'target_rtp'       => isset($data['target_rtp']) ? (float)$data['target_rtp'] : 92.0,
                    'enabled'          => isset($data['enabled']) ? 1 : 0,
                    'min_bet_override' => isset($data['min_bet']) && $data['min_bet'] !== '' ? (float)$data['min_bet'] : null,
                    'max_bet_override' => isset($data['max_bet']) && $data['max_bet'] !== '' ? (float)$data['max_bet'] : null,
                    'max_win_override' => isset($data['max_win']) && $data['max_win'] !== '' ? (float)$data['max_win'] : null,
                ]
            );
        }

        return redirect()->route('backend.shop-settings.game-rtp', ['shop_id' => $shopId])
            ->with('success', 'Game RTP settings saved successfully.');
    }

    // ─── OVERVIEW ─────────────────────────────────────────────────────────────

    public function overview(\Illuminate\Http\Request $request)
    {
        $shopId  = $this->resolveShopId($request->shop_id);
        $shops   = auth()->user()->hasRole('admin') ? \VanguardLTE\Shop::orderBy('name')->get() : collect();
        $shop    = \VanguardLTE\Shop::find($shopId);

        $fishSettings  = \VanguardLTE\ShopFishSetting::where('shop_id', $shopId)->first();
        $bonusSettings = \VanguardLTE\ShopBonusSetting::where('shop_id', $shopId)->first();

        $allGames    = \VanguardLTE\Game::where('shop_id', $shopId)->get();
        $fishGames   = $allGames->where('gamebank', 'fish');
        $slotsGames  = $allGames->whereIn('gamebank', ['slots', 'little']);
        $tableGames  = $allGames->where('gamebank', 'table_bank');

        $rtpOverrides = \VanguardLTE\ShopGameRtp::where('shop_id', $shopId)->count();

        $fishBank = \VanguardLTE\FishBank::where('shop_id', $shopId)->first();
        $gameBank = \VanguardLTE\GameBank::where('shop_id', $shopId)->first();

        return view('backend.shop-settings.overview', compact(
            'shop', 'shops', 'shopId',
            'fishSettings', 'bonusSettings',
            'allGames', 'fishGames', 'slotsGames', 'tableGames',
            'rtpOverrides', 'fishBank', 'gameBank'
        ));
    }
}
