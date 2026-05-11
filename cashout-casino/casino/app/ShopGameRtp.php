<?php
namespace VanguardLTE;

class ShopGameRtp extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'shop_game_rtp';

    protected $fillable = [
        'shop_id',
        'game_id',
        'target_rtp',
        'enabled',
        'min_bet_override',
        'max_bet_override',
        'max_win_override',
    ];

    protected $casts = [
        'enabled'    => 'boolean',
        'target_rtp' => 'float',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public static function forShopGame($shopId, $gameId)
    {
        return static::firstOrCreate(
            ['shop_id' => $shopId, 'game_id' => $gameId],
            ['target_rtp' => 92.00, 'enabled' => true]
        );
    }
}
