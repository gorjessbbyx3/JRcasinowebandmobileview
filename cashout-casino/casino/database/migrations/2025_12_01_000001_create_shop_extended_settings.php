<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Per-shop fish game bank & RTP settings
        Schema::create('shop_fish_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id')->unique();
            $table->decimal('target_rtp', 5, 2)->default(92.00)->comment('Target RTP % for fish games (e.g. 92.00)');
            $table->decimal('fish_bank_size', 15, 2)->default(10000.00)->comment('Max fish bank pool size');
            $table->decimal('min_bet', 10, 2)->default(0.10);
            $table->decimal('max_bet', 10, 2)->default(100.00);
            $table->decimal('max_win_per_spin', 10, 2)->default(500.00);
            $table->boolean('enabled')->default(true);
            $table->decimal('jackpot_contribution_pct', 5, 2)->default(1.00)->comment('% of each bet fed to jackpot pool');
            $table->decimal('bonus_trigger_pct', 5, 2)->default(5.00)->comment('% chance to trigger bonus round');
            $table->string('allowed_bets')->default('0.10,0.20,0.50,1.00,2.00,5.00,10.00,20.00,50.00,100.00');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
        });

        // Per-shop bonus configuration
        Schema::create('shop_bonus_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id')->unique();

            // Welcome Bonus
            $table->boolean('welcome_bonus_enabled')->default(true);
            $table->decimal('welcome_bonus_percent', 5, 2)->default(100.00)->comment('e.g. 100 = 100% match');
            $table->decimal('welcome_bonus_max_amount', 10, 2)->default(500.00);
            $table->integer('welcome_bonus_wagering_requirement')->default(30)->comment('Wagering multiplier (x times)');
            $table->integer('welcome_bonus_expires_days')->default(30);

            // Daily Login Bonus
            $table->boolean('daily_bonus_enabled')->default(true);
            $table->decimal('daily_bonus_base_amount', 10, 2)->default(5.00);
            $table->decimal('daily_bonus_streak_multiplier', 5, 2)->default(1.10)->comment('Multiplier per consecutive day');
            $table->integer('daily_bonus_max_streak')->default(30);
            $table->decimal('daily_bonus_max_amount', 10, 2)->default(50.00);

            // Referral Bonus
            $table->boolean('referral_bonus_enabled')->default(true);
            $table->decimal('referral_bonus_per_referral', 10, 2)->default(20.00);
            $table->decimal('referral_bonus_referee_amount', 10, 2)->default(10.00)->comment('Amount the new player gets');
            $table->integer('referral_max_uses')->default(50);
            $table->decimal('referral_min_deposit', 10, 2)->default(20.00)->comment('Referee must deposit this much to unlock referral reward');

            // Wheel of Fortune
            $table->boolean('wheel_enabled')->default(true);
            $table->decimal('wheel_min_deposit', 10, 2)->default(10.00);
            $table->integer('wheel_cooldown_hours')->default(24);
            $table->integer('wheel_spins_per_deposit')->default(1);
            $table->json('wheel_prizes')->nullable()->comment('JSON array of prizes and weights');

            // Happy Hour
            $table->boolean('happyhour_enabled')->default(true);
            $table->decimal('happyhour_multiplier', 4, 2)->default(2.00);
            $table->time('happyhour_start')->default('18:00:00');
            $table->time('happyhour_end')->default('22:00:00');

            // SMS / Loyalty Bonus
            $table->boolean('sms_bonus_enabled')->default(true);
            $table->decimal('sms_bonus_amount', 10, 2)->default(10.00);
            $table->integer('sms_bonus_interval_days')->default(7);

            // Deposit Bonus
            $table->boolean('deposit_bonus_enabled')->default(false);
            $table->decimal('deposit_bonus_percent', 5, 2)->default(10.00);
            $table->decimal('deposit_bonus_max', 10, 2)->default(100.00);
            $table->integer('deposit_bonus_wagering')->default(10);

            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
        });

        // Per-shop per-game RTP overrides
        Schema::create('shop_game_rtp', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id');
            $table->unsignedBigInteger('game_id');
            $table->decimal('target_rtp', 5, 2)->default(92.00);
            $table->boolean('enabled')->default(true);
            $table->decimal('min_bet_override', 10, 2)->nullable();
            $table->decimal('max_bet_override', 10, 2)->nullable();
            $table->decimal('max_win_override', 10, 2)->nullable();
            $table->timestamps();

            $table->unique(['shop_id', 'game_id']);
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shop_game_rtp');
        Schema::dropIfExists('shop_bonus_settings');
        Schema::dropIfExists('shop_fish_settings');
    }
};
