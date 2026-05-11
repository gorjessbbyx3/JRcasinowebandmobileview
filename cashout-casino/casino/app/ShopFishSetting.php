<?php
namespace VanguardLTE;

class ShopFishSetting extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'shop_fish_settings';

    protected $fillable = [
        'shop_id',
        'target_rtp',
        'fish_bank_size',
        'min_bet',
        'max_bet',
        'max_win_per_spin',
        'enabled',
        'jackpot_contribution_pct',
        'bonus_trigger_pct',
        'allowed_bets',
        'notes',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'target_rtp' => 'float',
        'fish_bank_size' => 'float',
        'min_bet' => 'float',
        'max_bet' => 'float',
        'max_win_per_spin' => 'float',
        'jackpot_contribution_pct' => 'float',
        'bonus_trigger_pct' => 'float',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public static function forShop($shopId)
    {
        return static::firstOrCreate(
            ['shop_id' => $shopId],
            [
                'target_rtp'              => 92.00,
                'fish_bank_size'          => 10000.00,
                'min_bet'                 => 0.10,
                'max_bet'                 => 100.00,
                'max_win_per_spin'        => 500.00,
                'enabled'                 => true,
                'jackpot_contribution_pct'=> 1.00,
                'bonus_trigger_pct'       => 5.00,
                'allowed_bets'            => '0.10,0.20,0.50,1.00,2.00,5.00,10.00,20.00,50.00,100.00',
            ]
        );
    }
}
