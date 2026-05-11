<?php
namespace VanguardLTE;

class ShopBonusSetting extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'shop_bonus_settings';

    protected $fillable = [
        'shop_id',
        // Welcome
        'welcome_bonus_enabled',
        'welcome_bonus_percent',
        'welcome_bonus_max_amount',
        'welcome_bonus_wagering_requirement',
        'welcome_bonus_expires_days',
        // Daily
        'daily_bonus_enabled',
        'daily_bonus_base_amount',
        'daily_bonus_streak_multiplier',
        'daily_bonus_max_streak',
        'daily_bonus_max_amount',
        // Referral
        'referral_bonus_enabled',
        'referral_bonus_per_referral',
        'referral_bonus_referee_amount',
        'referral_max_uses',
        'referral_min_deposit',
        // Wheel
        'wheel_enabled',
        'wheel_min_deposit',
        'wheel_cooldown_hours',
        'wheel_spins_per_deposit',
        'wheel_prizes',
        // Happy Hour
        'happyhour_enabled',
        'happyhour_multiplier',
        'happyhour_start',
        'happyhour_end',
        // SMS
        'sms_bonus_enabled',
        'sms_bonus_amount',
        'sms_bonus_interval_days',
        // Deposit
        'deposit_bonus_enabled',
        'deposit_bonus_percent',
        'deposit_bonus_max',
        'deposit_bonus_wagering',
        'notes',
    ];

    protected $casts = [
        'welcome_bonus_enabled'   => 'boolean',
        'daily_bonus_enabled'     => 'boolean',
        'referral_bonus_enabled'  => 'boolean',
        'wheel_enabled'           => 'boolean',
        'happyhour_enabled'       => 'boolean',
        'sms_bonus_enabled'       => 'boolean',
        'deposit_bonus_enabled'   => 'boolean',
        'wheel_prizes'            => 'array',
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
                'welcome_bonus_enabled'             => true,
                'welcome_bonus_percent'             => 100.00,
                'welcome_bonus_max_amount'          => 500.00,
                'welcome_bonus_wagering_requirement'=> 30,
                'welcome_bonus_expires_days'        => 30,
                'daily_bonus_enabled'               => true,
                'daily_bonus_base_amount'           => 5.00,
                'daily_bonus_streak_multiplier'     => 1.10,
                'daily_bonus_max_streak'            => 30,
                'daily_bonus_max_amount'            => 50.00,
                'referral_bonus_enabled'            => true,
                'referral_bonus_per_referral'       => 20.00,
                'referral_bonus_referee_amount'     => 10.00,
                'referral_max_uses'                 => 50,
                'referral_min_deposit'              => 20.00,
                'wheel_enabled'                     => true,
                'wheel_min_deposit'                 => 10.00,
                'wheel_cooldown_hours'              => 24,
                'wheel_spins_per_deposit'           => 1,
                'wheel_prizes'                      => null,
                'happyhour_enabled'                 => true,
                'happyhour_multiplier'              => 2.00,
                'happyhour_start'                   => '18:00:00',
                'happyhour_end'                     => '22:00:00',
                'sms_bonus_enabled'                 => true,
                'sms_bonus_amount'                  => 10.00,
                'sms_bonus_interval_days'           => 7,
                'deposit_bonus_enabled'             => false,
                'deposit_bonus_percent'             => 10.00,
                'deposit_bonus_max'                 => 100.00,
                'deposit_bonus_wagering'            => 10,
            ]
        );
    }
}
