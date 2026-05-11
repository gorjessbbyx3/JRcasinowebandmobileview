<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Cashout Casino — Full Schema Migration
 * ─────────────────────────────────────────────────────────────────
 * This single migration creates every table the platform needs.
 * All operations are idempotent (safe to run on an existing DB).
 *
 * Table prefix "w_" is applied automatically by the DB connection
 * config, so all names here are written WITHOUT the prefix.
 *
 * Issues fixed vs the live DB:
 *   • w_statistics      — re-created with all real columns
 *   • w_statistics_add  — re-created with all real columns
 *   • w_securities      — MISSING, created fresh
 *   • w_api_tokens      — MISSING, created fresh
 *   • w_sms_bonus_items — missing columns added: days, bonus, status, shop_id
 *
 * Tables covered (70+):
 *   Core auth, shops, users, roles, permissions, sessions
 *   Games, categories, game log, game bank, fish bank
 *   All bonus types (wheel, daily, welcome, happyhour, sms, invite, jpg)
 *   Transactions, payments, credits, withdrawals, pincodes, ATM
 *   Statistics (full schema), securities monitoring
 *   Tournaments, messages, tickets, notifications
 *   CoinPayments, API tokens, SMS mailings
 *   Per-shop extended settings (fish / bonus / game RTP)
 */
return new class extends Migration
{
    // ─────────────────────────────────────────────────────────────
    // UP
    // ─────────────────────────────────────────────────────────────
    public function up(): void
    {
        // ══════════════════════════════════════════════════════════
        // 1. SHOPS
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('shops')) {
            Schema::create('shops', function (Blueprint $t) {
                $t->increments('id');
                $t->string('name');
                $t->string('currency', 10)->default('USD')->nullable();
                $t->decimal('balance', 20, 2)->default(0)->nullable();
                $t->decimal('max_bet', 15, 2)->default(100)->nullable();
                $t->string('status', 30)->default('Active')->nullable();
                $t->integer('parent_id')->nullable();
                $t->integer('percent')->default(90)->nullable();
                $t->boolean('is_demo')->default(false)->nullable();
                $t->integer('user_id')->nullable();
                $t->string('frontend', 50)->default('Default')->nullable();
                $t->timestamp('created_at')->useCurrent()->nullable();
                $t->timestamp('updated_at')->useCurrent()->nullable();
            });
            // Seed default shop
            DB::table('shops')->insertOrIgnore([[
                'id' => 1, 'name' => 'Jade Royale', 'currency' => 'USD',
                'balance' => 100000, 'max_bet' => 500, 'status' => 'Active',
                'percent' => 92, 'is_demo' => false, 'frontend' => 'Default',
                'created_at' => now(), 'updated_at' => now(),
            ]]);
        }

        // ══════════════════════════════════════════════════════════
        // 2. ROLES
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $t) {
                $t->increments('id');
                $t->string('name');
                $t->string('slug')->unique();
                $t->text('description')->nullable();
                $t->integer('level')->nullable()->default(0);
                $t->timestamps();
            });
            DB::table('roles')->insertOrIgnore([
                ['id' => 1, 'name' => 'Admin',        'slug' => 'admin',     'level' => 100, 'created_at' => now(), 'updated_at' => now()],
                ['id' => 2, 'name' => 'Player',       'slug' => 'player',    'level' => 1,   'created_at' => now(), 'updated_at' => now()],
                ['id' => 3, 'name' => 'Cashier',      'slug' => 'cashier',   'level' => 10,  'created_at' => now(), 'updated_at' => now()],
                ['id' => 4, 'name' => 'Agent',        'slug' => 'agent',     'level' => 20,  'created_at' => now(), 'updated_at' => now()],
                ['id' => 5, 'name' => 'Distributor',  'slug' => 'distributor','level' => 30, 'created_at' => now(), 'updated_at' => now()],
                ['id' => 6, 'name' => 'Operator',     'slug' => 'operator',  'level' => 50,  'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        // ══════════════════════════════════════════════════════════
        // 3. PERMISSIONS
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('permissions')) {
            Schema::create('permissions', function (Blueprint $t) {
                $t->increments('id');
                $t->string('name');
                $t->string('slug')->unique();
                $t->text('description')->nullable();
                $t->string('model', 100)->nullable();
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 4. USERS
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $t) {
                $t->bigIncrements('id');
                $t->string('name');
                $t->string('email')->unique();
                $t->timestamp('email_verified_at')->nullable();
                $t->string('password');
                $t->string('remember_token', 100)->nullable();
                $t->integer('shop_id')->default(1)->nullable();
                $t->integer('role_id')->default(2)->nullable();
                $t->decimal('balance', 20, 2)->default(0)->nullable();
                $t->string('status', 30)->default('Active')->nullable();
                $t->string('username', 100)->nullable();
                $t->string('phone', 30)->nullable();
                $t->boolean('phone_verified')->default(false)->nullable();
                // Bonus accumulators
                $t->decimal('count_balance', 20, 2)->default(0)->nullable();
                $t->boolean('is_demo')->default(false)->nullable();
                $t->decimal('tournaments', 15, 2)->default(0)->nullable();
                $t->decimal('happyhours', 15, 2)->default(0)->nullable();
                $t->decimal('refunds', 15, 2)->default(0)->nullable();
                $t->decimal('progress', 15, 2)->default(0)->nullable();
                $t->decimal('daily_entries', 15, 2)->default(0)->nullable();
                $t->decimal('invite', 15, 2)->default(0)->nullable();
                $t->decimal('welcomebonus', 15, 2)->default(0)->nullable();
                $t->decimal('smsbonus', 15, 2)->default(0)->nullable();
                $t->decimal('wheelfortune', 15, 2)->default(0)->nullable();
                $t->decimal('count_tournaments', 15, 2)->default(0)->nullable();
                $t->decimal('count_happyhours', 15, 2)->default(0)->nullable();
                $t->decimal('count_refunds', 15, 2)->default(0)->nullable();
                $t->decimal('count_progress', 15, 2)->default(0)->nullable();
                $t->decimal('count_daily_entries', 15, 2)->default(0)->nullable();
                $t->decimal('count_invite', 15, 2)->default(0)->nullable();
                $t->decimal('count_welcomebonus', 15, 2)->default(0)->nullable();
                $t->decimal('count_smsbonus', 15, 2)->default(0)->nullable();
                $t->decimal('count_wheelfortune', 15, 2)->default(0)->nullable();
                // Bonus tracking
                $t->date('last_daily_bonus')->nullable();
                $t->integer('daily_bonus_streak')->default(0)->nullable();
                $t->timestamp('last_wheel_spin')->nullable();
                $t->decimal('total_bets', 20, 2)->default(0)->nullable();
                $t->integer('total_wins')->default(0)->nullable();
                $t->integer('vip_level')->default(0)->nullable();
                // Referral
                $t->integer('referral_count')->default(0)->nullable();
                $t->decimal('referral_earnings', 15, 2)->default(0)->nullable();
                $t->timestamps();
            });
        } else {
            // Add any columns that may be missing on old installs
            $addCols = [
                'username'          => fn($t) => $t->string('username', 100)->nullable()->after('email'),
                'phone'             => fn($t) => $t->string('phone', 30)->nullable(),
                'phone_verified'    => fn($t) => $t->boolean('phone_verified')->default(false)->nullable(),
                'last_daily_bonus'  => fn($t) => $t->date('last_daily_bonus')->nullable(),
                'daily_bonus_streak'=> fn($t) => $t->integer('daily_bonus_streak')->default(0)->nullable(),
                'last_wheel_spin'   => fn($t) => $t->timestamp('last_wheel_spin')->nullable(),
                'total_bets'        => fn($t) => $t->decimal('total_bets', 20, 2)->default(0)->nullable(),
                'total_wins'        => fn($t) => $t->integer('total_wins')->default(0)->nullable(),
                'vip_level'         => fn($t) => $t->integer('vip_level')->default(0)->nullable(),
                'referral_count'    => fn($t) => $t->integer('referral_count')->default(0)->nullable(),
                'referral_earnings' => fn($t) => $t->decimal('referral_earnings', 15, 2)->default(0)->nullable(),
            ];
            foreach ($addCols as $col => $def) {
                if (!Schema::hasColumn('users', $col)) {
                    Schema::table('users', function (Blueprint $t) use ($col, $def) { $def($t); });
                }
            }
        }

        // ══════════════════════════════════════════════════════════
        // 5. ROLE_USER  /  PERMISSION_ROLE
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('role_user')) {
            Schema::create('role_user', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('role_id');
                $t->integer('user_id');
                $t->index(['role_id', 'user_id']);
            });
        }
        if (!Schema::hasTable('permission_role')) {
            Schema::create('permission_role', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('permission_id');
                $t->integer('role_id');
                $t->index(['permission_id', 'role_id']);
            });
        }

        // ══════════════════════════════════════════════════════════
        // 6. SETTINGS
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $t) {
                $t->increments('id');
                $t->string('name')->unique();
                $t->text('value')->nullable();
            });
            DB::table('settings')->insertOrIgnore([
                ['name' => 'app.name',     'value' => 'Jade Royale Casino'],
                ['name' => 'app.currency', 'value' => 'USD'],
                ['name' => 'app.locale',   'value' => 'en'],
                ['name' => 'app.timezone', 'value' => 'UTC'],
                ['name' => 'app.registration', 'value' => '0'],
                ['name' => 'app.maintenance', 'value' => '0'],
                ['name' => 'frontend.theme', 'value' => 'Default'],
            ]);
        }

        // ══════════════════════════════════════════════════════════
        // 7. SESSIONS
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('sessions')) {
            Schema::create('sessions', function (Blueprint $t) {
                $t->string('id')->primary();
                $t->integer('user_id')->nullable()->index();
                $t->string('ip_address', 45)->nullable();
                $t->text('user_agent')->nullable();
                $t->text('payload');
                $t->integer('last_activity')->index();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 8. PASSWORD_RESETS
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('password_resets')) {
            Schema::create('password_resets', function (Blueprint $t) {
                $t->string('email')->index();
                $t->string('token');
                $t->timestamp('created_at')->nullable();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 9. FAILED_JOBS
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('failed_jobs')) {
            Schema::create('failed_jobs', function (Blueprint $t) {
                $t->id();
                $t->string('uuid')->unique();
                $t->text('connection');
                $t->text('queue');
                $t->longText('payload');
                $t->longText('exception');
                $t->timestamp('failed_at')->useCurrent();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 10. PERSONAL_ACCESS_TOKENS (Laravel Sanctum)
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('personal_access_tokens')) {
            Schema::create('personal_access_tokens', function (Blueprint $t) {
                $t->id();
                $t->morphs('tokenable');
                $t->string('name');
                $t->string('token', 64)->unique();
                $t->text('abilities')->nullable();
                $t->timestamp('last_used_at')->nullable();
                $t->timestamp('expires_at')->nullable();
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 11. API_TOKENS (JWT custom tokens) ← WAS MISSING
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('api_tokens')) {
            Schema::create('api_tokens', function (Blueprint $t) {
                $t->string('id')->primary();        // JWT jti claim (UUID)
                $t->unsignedBigInteger('user_id');
                $t->timestamp('expires_at')->nullable();
                $t->timestamps();
                $t->index('user_id');
            });
        }

        // ══════════════════════════════════════════════════════════
        // 12. CATEGORIES
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $t) {
                $t->increments('id');
                $t->string('name');
                $t->string('title')->nullable();
                $t->integer('position')->nullable()->default(0);
                $t->string('href')->nullable();
                $t->integer('shop_id')->nullable()->default(1);
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 13. SHOP_CATEGORIES
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('shop_categories')) {
            Schema::create('shop_categories', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable();
                $t->integer('category_id')->nullable();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 14. GAMES
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('games')) {
            Schema::create('games', function (Blueprint $t) {
                $t->increments('id');
                $t->string('name');
                $t->string('title')->nullable();
                $t->integer('category_id')->nullable();
                $t->integer('shop_id')->nullable()->default(1);
                $t->string('gamebank', 50)->nullable()->default('slot');
                $t->string('device', 100)->nullable()->default('desktop,mobile');
                $t->integer('view')->nullable()->default(0);
                $t->decimal('bet', 15, 2)->nullable()->default(1);
                $t->decimal('denomination', 10, 4)->nullable()->default(0.01);
                $t->string('slotviewstate', 30)->nullable()->default('Active');
                $t->string('label', 50)->nullable();
                $t->integer('original_id')->nullable();
                $t->timestamps();
                $t->index(['shop_id', 'slotviewstate']);
            });
        } else {
            if (!Schema::hasColumn('games', 'label')) {
                Schema::table('games', fn($t) => $t->string('label', 50)->nullable());
            }
        }

        // ══════════════════════════════════════════════════════════
        // 15. GAME_CATEGORIES  (pivot: game ↔ category)
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('game_categories')) {
            Schema::create('game_categories', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('game_id')->nullable();
                $t->integer('category_id')->nullable();
                $t->integer('shop_id')->nullable()->default(1);
                $t->index(['game_id', 'category_id']);
            });
        }
        // Legacy alias table (same structure)
        if (!Schema::hasTable('game_category')) {
            Schema::create('game_category', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('game_id')->nullable();
                $t->integer('category_id')->nullable();
                $t->integer('shop_id')->nullable()->default(1);
            });
        }

        // ══════════════════════════════════════════════════════════
        // 16. TRANSACTIONS
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('transactions')) {
            Schema::create('transactions', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('user_id')->nullable();
                $t->integer('shop_id')->nullable()->default(1);
                $t->string('type', 50)->nullable();
                $t->decimal('amount', 20, 2)->nullable()->default(0);
                $t->decimal('balance', 20, 2)->nullable()->default(0);
                $t->string('reference')->nullable();
                $t->string('status', 30)->nullable()->default('completed');
                $t->timestamps();
                $t->index(['user_id', 'shop_id']);
            });
        }

        // ══════════════════════════════════════════════════════════
        // 17. PAYMENTS
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('payments')) {
            Schema::create('payments', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('user_id')->nullable();
                $t->integer('shop_id')->nullable()->default(1);
                $t->decimal('amount', 20, 2)->nullable()->default(0);
                $t->string('type', 50)->nullable();
                $t->string('status', 30)->nullable()->default('pending');
                $t->string('reference')->nullable();
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 18. CREDITS
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('credits')) {
            Schema::create('credits', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('user_id')->nullable();
                $t->integer('shop_id')->nullable()->default(1);
                $t->string('type', 50)->nullable();
                $t->decimal('sum', 20, 2)->nullable()->default(0);
                $t->decimal('balance', 20, 2)->nullable()->default(0);
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 19. WITHDRAW_FUNDS
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('withdraw_funds')) {
            Schema::create('withdraw_funds', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('user_id')->nullable();
                $t->integer('shop_id')->nullable()->default(1);
                $t->decimal('amount', 20, 2)->nullable()->default(0);
                $t->string('method', 50)->nullable();
                $t->text('details')->nullable();
                $t->string('status', 30)->nullable()->default('pending');
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 20. PAYMENT_SETTINGS
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('payment_settings')) {
            Schema::create('payment_settings', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable();
                $t->string('name', 100)->nullable();
                $t->string('key', 100)->nullable();
                $t->text('value')->nullable();
                $t->string('status', 30)->nullable()->default('active');
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 21. PINCODES
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('pincodes')) {
            Schema::create('pincodes', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable();
                $t->string('code', 50)->nullable();
                $t->decimal('amount', 15, 2)->nullable()->default(0);
                $t->string('status', 30)->nullable()->default('active');
                $t->integer('user_id')->nullable();
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 22. QUICK_SHOPS
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('quick_shops')) {
            Schema::create('quick_shops', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable();
                $t->string('name')->nullable();
                $t->decimal('balance', 20, 2)->nullable()->default(0);
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 23. GAME_LOG
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('game_log')) {
            Schema::create('game_log', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('user_id')->nullable()->index();
                $t->string('game', 100)->nullable();
                $t->integer('game_id')->nullable();
                $t->integer('shop_id')->nullable()->default(1);
                $t->decimal('bet', 20, 4)->nullable()->default(0);
                $t->decimal('win', 20, 4)->nullable()->default(0);
                $t->decimal('balance', 20, 2)->nullable()->default(0);
                $t->timestamps();
                $t->index(['shop_id', 'created_at']);
            });
        }

        // ══════════════════════════════════════════════════════════
        // 24. GAME_BANK
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('game_bank')) {
            Schema::create('game_bank', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable();
                $t->decimal('slots', 20, 4)->nullable()->default(0);
                $t->decimal('fish', 20, 4)->nullable()->default(0);
                $t->decimal('little', 20, 4)->nullable()->default(0);
                $t->decimal('little_lose', 20, 4)->nullable()->default(0);
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 25. FISH_BANK
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('fish_bank')) {
            Schema::create('fish_bank', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable();
                $t->decimal('bank', 20, 4)->nullable()->default(0);
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 26. STAT_GAME  (per-game aggregated stats)
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('stat_game')) {
            Schema::create('stat_game', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable();
                $t->integer('game_id')->nullable();
                $t->string('game_name')->nullable();
                $t->integer('plays')->nullable()->default(0);
                $t->decimal('bets', 20, 4)->nullable()->default(0);
                $t->decimal('wins', 20, 4)->nullable()->default(0);
                $t->timestamps();
                $t->unique(['shop_id', 'game_id']);
            });
        }

        // ══════════════════════════════════════════════════════════
        // 27. STATISTICS  ← RE-BUILT (many missing columns)
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('statistics')) {
            Schema::create('statistics', function (Blueprint $t) {
                $t->increments('id');
                $t->string('title')->nullable();
                $t->integer('user_id')->nullable()->index();
                $t->integer('payeer_id')->nullable()->index();
                $t->string('system', 50)->nullable()->index(); // 'user','game','shop','pincode','happyhour','invite','progress','tournament','daily_entry','refund','welcome_bonus','sms_bonus','wheelfortune','jpg','bank','handpay','interkassa','coinbase','btcpayserver'
                $t->string('type', 20)->nullable();            // 'add' | 'out'
                $t->decimal('sum', 20, 4)->nullable()->default(0);
                $t->decimal('sum2', 20, 4)->nullable()->default(0);
                $t->decimal('old', 20, 4)->nullable()->default(0);
                $t->integer('item_id')->nullable();
                $t->integer('shop_id')->nullable()->default(1);
                $t->decimal('credit_in', 20, 4)->nullable()->default(0);
                $t->decimal('credit_out', 20, 4)->nullable()->default(0);
                $t->decimal('money_in', 20, 4)->nullable()->default(0);
                $t->decimal('money_out', 20, 4)->nullable()->default(0);
                $t->decimal('hh_multiplier', 8, 2)->nullable()->default(1);
                // Geo / device data (filled via GeoData after create)
                $t->text('user_agent')->nullable();
                $t->string('ip_address', 45)->nullable();
                $t->string('country', 5)->nullable();
                $t->string('city', 100)->nullable();
                $t->string('os', 50)->nullable();
                $t->string('device', 50)->nullable();
                $t->string('browser', 80)->nullable();
                $t->timestamp('created_at')->nullable()->useCurrent();
                $t->timestamp('updated_at')->nullable();
                $t->index(['shop_id', 'created_at']);
            });
        } else {
            // Patch any missing columns on existing installs
            $statCols = [
                'title'          => fn($t) => $t->string('title')->nullable(),
                'payeer_id'      => fn($t) => $t->integer('payeer_id')->nullable(),
                'system'         => fn($t) => $t->string('system', 50)->nullable(),
                'type'           => fn($t) => $t->string('type', 20)->nullable(),
                'sum'            => fn($t) => $t->decimal('sum', 20, 4)->nullable()->default(0),
                'sum2'           => fn($t) => $t->decimal('sum2', 20, 4)->nullable()->default(0),
                'old'            => fn($t) => $t->decimal('old', 20, 4)->nullable()->default(0),
                'item_id'        => fn($t) => $t->integer('item_id')->nullable(),
                'credit_in'      => fn($t) => $t->decimal('credit_in', 20, 4)->nullable()->default(0),
                'credit_out'     => fn($t) => $t->decimal('credit_out', 20, 4)->nullable()->default(0),
                'money_in'       => fn($t) => $t->decimal('money_in', 20, 4)->nullable()->default(0),
                'money_out'      => fn($t) => $t->decimal('money_out', 20, 4)->nullable()->default(0),
                'hh_multiplier'  => fn($t) => $t->decimal('hh_multiplier', 8, 2)->nullable()->default(1),
                'user_agent'     => fn($t) => $t->text('user_agent')->nullable(),
                'ip_address'     => fn($t) => $t->string('ip_address', 45)->nullable(),
                'country'        => fn($t) => $t->string('country', 5)->nullable(),
                'city'           => fn($t) => $t->string('city', 100)->nullable(),
                'os'             => fn($t) => $t->string('os', 50)->nullable(),
                'device'         => fn($t) => $t->string('device', 50)->nullable(),
                'browser'        => fn($t) => $t->string('browser', 80)->nullable(),
            ];
            foreach ($statCols as $col => $def) {
                if (!Schema::hasColumn('statistics', $col)) {
                    Schema::table('statistics', function (Blueprint $t) use ($col, $def) { $def($t); });
                }
            }
        }

        // ══════════════════════════════════════════════════════════
        // 28. STATISTICS_ADD  ← RE-BUILT (many missing columns)
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('statistics_add')) {
            Schema::create('statistics_add', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('statistic_id')->nullable()->index(); // FK → statistics.id
                $t->integer('shop_id')->nullable()->default(1);
                $t->integer('user_id')->nullable();
                // Cash flow breakdown
                $t->decimal('agent_in', 20, 4)->nullable()->default(0);
                $t->decimal('agent_out', 20, 4)->nullable()->default(0);
                $t->decimal('distributor_in', 20, 4)->nullable()->default(0);
                $t->decimal('distributor_out', 20, 4)->nullable()->default(0);
                $t->decimal('credit_in', 20, 4)->nullable()->default(0);
                $t->decimal('credit_out', 20, 4)->nullable()->default(0);
                $t->decimal('money_in', 20, 4)->nullable()->default(0);
                $t->decimal('money_out', 20, 4)->nullable()->default(0);
                $t->decimal('type_in', 20, 4)->nullable()->default(0);
                $t->decimal('type_out', 20, 4)->nullable()->default(0);
                // Daily aggregate columns (used by StatisticAdd date summaries)
                $t->date('date')->nullable();
                $t->decimal('deposits', 20, 4)->nullable()->default(0);
                $t->decimal('withdrawals', 20, 4)->nullable()->default(0);
                $t->decimal('bets', 20, 4)->nullable()->default(0);
                $t->decimal('wins', 20, 4)->nullable()->default(0);
            });
        } else {
            $addCols = [
                'statistic_id'    => fn($t) => $t->integer('statistic_id')->nullable(),
                'user_id'         => fn($t) => $t->integer('user_id')->nullable(),
                'agent_in'        => fn($t) => $t->decimal('agent_in', 20, 4)->nullable()->default(0),
                'agent_out'       => fn($t) => $t->decimal('agent_out', 20, 4)->nullable()->default(0),
                'distributor_in'  => fn($t) => $t->decimal('distributor_in', 20, 4)->nullable()->default(0),
                'distributor_out' => fn($t) => $t->decimal('distributor_out', 20, 4)->nullable()->default(0),
                'credit_in'       => fn($t) => $t->decimal('credit_in', 20, 4)->nullable()->default(0),
                'credit_out'      => fn($t) => $t->decimal('credit_out', 20, 4)->nullable()->default(0),
                'money_in'        => fn($t) => $t->decimal('money_in', 20, 4)->nullable()->default(0),
                'money_out'       => fn($t) => $t->decimal('money_out', 20, 4)->nullable()->default(0),
                'type_in'         => fn($t) => $t->decimal('type_in', 20, 4)->nullable()->default(0),
                'type_out'        => fn($t) => $t->decimal('type_out', 20, 4)->nullable()->default(0),
            ];
            foreach ($addCols as $col => $def) {
                if (!Schema::hasColumn('statistics_add', $col)) {
                    Schema::table('statistics_add', function (Blueprint $t) use ($col, $def) { $def($t); });
                }
            }
        }

        // ══════════════════════════════════════════════════════════
        // 29. SUBSESSIONS
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('subsessions')) {
            Schema::create('subsessions', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('user_id')->nullable();
                $t->integer('shop_id')->nullable()->default(1);
                $t->string('session_id', 191)->nullable();
                $t->decimal('balance', 20, 2)->nullable()->default(0);
                $t->boolean('active')->nullable()->default(true);
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 30. BOTS_GAMES
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('bots_games')) {
            Schema::create('bots_games', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable();
                $t->integer('user_id')->nullable();
                $t->integer('game_id')->nullable();
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 31. USER_ACTIVITY
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('user_activity')) {
            Schema::create('user_activity', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('user_id')->nullable()->index();
                $t->text('description')->nullable();
                $t->string('ip_address', 45)->nullable();
                $t->text('user_agent')->nullable();
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 32. WELCOMEBONUSES
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('welcomebonuses')) {
            Schema::create('welcomebonuses', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable()->default(1);
                $t->string('pay', 50)->nullable();
                $t->decimal('sum', 15, 2)->nullable()->default(0);
                $t->string('type', 50)->nullable();
                $t->integer('bonus')->nullable()->default(0);
                $t->integer('wager')->nullable()->default(1);
            });
            DB::table('welcomebonuses')->insertOrIgnore([
                ['shop_id' => 1, 'pay' => 'first', 'sum' => 100.00, 'type' => 'percent', 'bonus' => 100, 'wager' => 30],
            ]);
        }

        // ══════════════════════════════════════════════════════════
        // 33. WHEELFORTUNE
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('wheelfortune')) {
            Schema::create('wheelfortune', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable()->default(1);
                $t->string('name')->nullable();
                $t->string('type', 50)->nullable();
                $t->decimal('min_bet', 15, 2)->nullable()->default(0);
                $t->integer('spins_count')->nullable()->default(1);
                $t->boolean('active')->nullable()->default(true);
                $t->text('prizes')->nullable();
                $t->text('sectors')->nullable();
            });
            $defaultSectors = json_encode([
                ['label' => '$0.05',  'color' => '#FF6B35'],
                ['label' => '$0.15',  'color' => '#4ECDC4'],
                ['label' => '$0.50',  'color' => '#45B7D1'],
                ['label' => '$5.00',  'color' => '#2ECC71'],
                ['label' => 'GOOD LUCK', 'color' => '#3498DB'],
                ['label' => '$0.02',  'color' => '#9B59B6'],
                ['label' => '$0.20',  'color' => '#E74C3C'],
                ['label' => '$1.00',  'color' => '#F39C12'],
                ['label' => '$10.00', 'color' => '#1ABC9C'],
                ['label' => 'GOOD LUCK', 'color' => '#E91E63'],
                ['label' => '$0.03',  'color' => '#00BCD4'],
                ['label' => '$0.77',  'color' => '#8BC34A'],
                ['label' => '$2.00',  'color' => '#FF5722'],
                ['label' => 'GOOD LUCK', 'color' => '#673AB7'],
                ['label' => '$0.01',  'color' => '#009688'],
                ['label' => '$50.00', 'color' => '#E040FB'],
            ]);
            DB::table('wheelfortune')->insertOrIgnore([
                ['shop_id' => 1, 'name' => 'Fortune Wheel', 'type' => 'daily', 'min_bet' => 0, 'spins_count' => 1, 'active' => true, 'sectors' => $defaultSectors],
            ]);
        }

        // ══════════════════════════════════════════════════════════
        // 34. DAILY_BONUS
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('daily_bonus')) {
            Schema::create('daily_bonus', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable()->default(1);
                $t->integer('day')->nullable()->default(1);
                $t->decimal('reward', 15, 2)->nullable()->default(5.00);
                $t->string('reward_type', 30)->nullable()->default('cash');
                $t->boolean('active')->nullable()->default(true);
            });
            // Seed 7 daily login rewards with increasing amounts
            for ($d = 1; $d <= 7; $d++) {
                DB::table('daily_bonus')->insertOrIgnore([
                    ['shop_id' => 1, 'day' => $d, 'reward' => round($d * 2.5, 2), 'reward_type' => 'cash', 'active' => true],
                ]);
            }
        }

        // ══════════════════════════════════════════════════════════
        // 35. JPG  (Progressive Jackpots)
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('jpg')) {
            Schema::create('jpg', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable()->default(1);
                $t->string('name');
                $t->decimal('balance', 20, 4)->nullable()->default(0);
                $t->decimal('start_balance', 20, 4)->nullable()->default(0);
                $t->decimal('pay_sum', 20, 4)->nullable()->default(0);
                $t->decimal('percent', 8, 4)->nullable()->default(0.1);
                $t->boolean('active')->nullable()->default(true);
            });
            DB::table('jpg')->insertOrIgnore([
                ['shop_id' => 1, 'name' => 'Mini Jackpot',   'balance' => 250,    'start_balance' => 100,  'pay_sum' => 0, 'percent' => 0.05, 'active' => true],
                ['shop_id' => 1, 'name' => 'Major Jackpot',  'balance' => 5000,   'start_balance' => 1000, 'pay_sum' => 0, 'percent' => 0.10, 'active' => true],
                ['shop_id' => 1, 'name' => 'Grand Jackpot',  'balance' => 50000,  'start_balance' => 5000, 'pay_sum' => 0, 'percent' => 0.20, 'active' => true],
            ]);
        }

        // ══════════════════════════════════════════════════════════
        // 36. HAPPYHOURS
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('happyhours')) {
            Schema::create('happyhours', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable()->default(1);
                $t->string('multiplier', 20)->nullable()->default('2');
                $t->integer('wager')->nullable()->default(1);
                $t->string('time', 50)->nullable()->default('18:00-22:00');
            });
        }

        // ══════════════════════════════════════════════════════════
        // 37. INVITES  (Referral codes)
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('invites')) {
            Schema::create('invites', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('user_id')->nullable();
                $t->integer('shop_id')->nullable()->default(1);
                $t->string('code', 50)->nullable()->unique();
                $t->string('status', 30)->nullable()->default('active');
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 38. SMS
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('sms')) {
            Schema::create('sms', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable();
                $t->string('phone', 30)->nullable();
                $t->string('code', 20)->nullable();
                $t->string('status', 30)->nullable()->default('pending');
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 39. SMS_BONUSES  (schedule-based SMS loyalty bonuses)
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('sms_bonuses')) {
            Schema::create('sms_bonuses', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable()->default(1);
                $t->integer('days')->nullable()->default(7);
                $t->decimal('bonus', 15, 2)->nullable()->default(10);
                $t->integer('wager')->nullable()->default(1);
            });
        }

        // ══════════════════════════════════════════════════════════
        // 40. SMS_BONUS_ITEMS  ← patched (missing days/bonus/status/shop_id)
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('sms_bonus_items')) {
            Schema::create('sms_bonus_items', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('sms_bonus_id')->nullable();
                $t->integer('user_id')->nullable();
                $t->integer('days')->nullable()->default(0);
                $t->decimal('bonus', 15, 2)->nullable()->default(0);
                $t->string('status', 30)->nullable()->default('pending');
                $t->integer('shop_id')->nullable()->default(1);
                $t->boolean('used')->nullable()->default(false);
                $t->timestamps();
            });
        } else {
            $patch = [
                'days'    => fn($t) => $t->integer('days')->nullable()->default(0),
                'bonus'   => fn($t) => $t->decimal('bonus', 15, 2)->nullable()->default(0),
                'status'  => fn($t) => $t->string('status', 30)->nullable()->default('pending'),
                'shop_id' => fn($t) => $t->integer('shop_id')->nullable()->default(1),
            ];
            foreach ($patch as $col => $def) {
                if (!Schema::hasColumn('sms_bonus_items', $col)) {
                    Schema::table('sms_bonus_items', function (Blueprint $t) use ($col, $def) { $def($t); });
                }
            }
        }

        // ══════════════════════════════════════════════════════════
        // 41. SMS_BONUS  (legacy flat bonus table)
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('sms_bonus')) {
            Schema::create('sms_bonus', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable()->default(1);
                $t->string('name')->nullable();
                $t->decimal('amount', 15, 2)->nullable()->default(0);
                $t->string('status', 30)->nullable()->default('active');
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 42. SMS_MAILINGS
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('sms_mailings')) {
            Schema::create('sms_mailings', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable();
                $t->string('name')->nullable();
                $t->string('status', 30)->nullable()->default('draft');
                $t->timestamps();
            });
        }
        if (!Schema::hasTable('sms_mailing_messages')) {
            Schema::create('sms_mailing_messages', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('mailing_id')->nullable()->index();
                $t->string('phone', 30)->nullable();
                $t->text('message')->nullable();
                $t->string('status', 30)->nullable()->default('pending');
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 43. USER_BONUSES  (per-user active bonus tracking)
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('user_bonuses')) {
            Schema::create('user_bonuses', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('user_id')->index();
                $t->string('bonus_type', 50);
                $t->integer('bonus_id')->nullable();
                $t->decimal('amount', 15, 2)->nullable()->default(0);
                $t->decimal('wager_requirement', 15, 2)->nullable()->default(0);
                $t->decimal('wager_progress', 15, 2)->nullable()->default(0);
                $t->string('status', 30)->nullable()->default('active');
                $t->timestamp('expires_at')->nullable();
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 44. REWARDS
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('rewards')) {
            Schema::create('rewards', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable()->default(1);
                $t->string('name')->nullable();
                $t->string('type', 50)->nullable();
                $t->decimal('value', 15, 2)->nullable()->default(0);
                $t->string('status', 30)->nullable()->default('active');
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 45. PROGRESS  (achievement / progress bar definitions)
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('progress')) {
            Schema::create('progress', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable()->default(1);
                $t->string('name')->nullable();
                $t->string('type', 50)->nullable();
                $t->decimal('target', 15, 2)->nullable()->default(0);
                $t->decimal('reward', 15, 2)->nullable()->default(0);
                $t->boolean('active')->nullable()->default(true);
            });
        }
        if (!Schema::hasTable('progress_users')) {
            Schema::create('progress_users', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('progress_id')->nullable()->index();
                $t->integer('user_id')->nullable()->index();
                $t->decimal('current_value', 15, 4)->nullable()->default(0);
                $t->boolean('completed')->nullable()->default(false);
                $t->boolean('claimed')->nullable()->default(false);
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 46. BONUS_PRESET
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('bonus_preset')) {
            Schema::create('bonus_preset', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable()->default(1);
                $t->string('name')->nullable();
                $t->string('type', 50)->nullable();
                $t->decimal('value', 15, 2)->nullable()->default(0);
                $t->decimal('min_deposit', 15, 2)->nullable()->default(0);
                $t->decimal('max_bonus', 15, 2)->nullable()->default(0);
                $t->integer('wager')->nullable()->default(1);
                $t->boolean('active')->nullable()->default(true);
            });
        }

        // ══════════════════════════════════════════════════════════
        // 47. TASKS
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('tasks')) {
            Schema::create('tasks', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable()->default(1);
                $t->string('name')->nullable();
                $t->string('type', 50)->nullable();
                $t->decimal('target', 15, 2)->nullable()->default(0);
                $t->decimal('reward', 15, 2)->nullable()->default(0);
                $t->string('status', 30)->nullable()->default('active');
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 48. SECURITIES  ← WAS COMPLETELY MISSING
        //     Security model monitors game/user/shop transactions
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('securities')) {
            Schema::create('securities', function (Blueprint $t) {
                $t->increments('id');
                $t->string('type', 50)->nullable()->index();      // 'user' | 'game' | 'shop'
                $t->integer('item_id')->nullable()->index();      // user_id or game_id
                $t->decimal('pay_in', 20, 4)->nullable()->default(0);
                $t->decimal('pay_out', 20, 4)->nullable()->default(0);
                $t->decimal('pay_total', 20, 4)->nullable()->default(0);
                $t->decimal('balance', 20, 4)->nullable()->default(0);
                $t->decimal('bank', 20, 4)->nullable()->default(0);
                $t->decimal('rtp', 8, 4)->nullable()->default(0);
                $t->integer('count')->nullable()->default(0);
                $t->boolean('view')->nullable()->default(true);
                $t->integer('shop_id')->nullable()->default(1)->index();
                $t->string('sms', 30)->nullable();
                $t->boolean('block')->nullable()->default(false);
                $t->string('category', 50)->nullable();
                $t->decimal('win', 20, 4)->nullable()->default(0);
                $t->timestamp('created_at')->nullable()->useCurrent();
                $t->index(['shop_id', 'created_at']);
            });
        }

        // ══════════════════════════════════════════════════════════
        // 49. SECURITY  (2FA per user — different from securities)
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('security')) {
            Schema::create('security', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('user_id')->nullable()->unique();
                $t->boolean('two_factor_enabled')->nullable()->default(false);
                $t->string('two_factor_secret')->nullable();
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 50. OPEN_SHIFT  (cashier shift management)
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('open_shift')) {
            Schema::create('open_shift', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable();
                $t->integer('user_id')->nullable();
                $t->decimal('start_balance', 20, 2)->nullable()->default(0);
                $t->decimal('end_balance', 20, 2)->nullable()->default(0);
                $t->string('status', 30)->nullable()->default('open');
                $t->timestamp('opened_at')->nullable();
                $t->timestamp('closed_at')->nullable();
                $t->timestamps();
            });
        }
        if (!Schema::hasTable('open_shift_temp')) {
            Schema::create('open_shift_temp', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable();
                $t->integer('user_id')->nullable();
                $t->decimal('balance', 20, 2)->nullable()->default(0);
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 51. APIS  (external API credential store)
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('apis')) {
            Schema::create('apis', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable();
                $t->string('name', 100)->nullable();
                $t->string('key')->nullable();
                $t->text('secret')->nullable();
                $t->string('status', 30)->nullable()->default('active');
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 52. NOTIFICATIONS
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('notifications')) {
            Schema::create('notifications', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('user_id')->nullable()->index();
                $t->integer('shop_id')->nullable()->default(1);
                $t->string('title')->nullable();
                $t->text('message')->nullable();
                $t->boolean('read')->nullable()->default(false);
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 53. MESSAGES  (player → shop support messages)
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('messages')) {
            Schema::create('messages', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('user_id')->nullable()->index();
                $t->integer('shop_id')->nullable()->default(1);
                $t->string('subject')->nullable();
                $t->text('content')->nullable();
                $t->boolean('read')->nullable()->default(false);
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 54. TICKETS  +  TICKET_ANSWERS
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('tickets')) {
            Schema::create('tickets', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('user_id')->nullable()->index();
                $t->integer('shop_id')->nullable()->default(1);
                $t->string('subject')->nullable();
                $t->string('status', 30)->nullable()->default('open');
                $t->timestamps();
            });
        }
        if (!Schema::hasTable('tickets_answers')) {
            Schema::create('tickets_answers', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('ticket_id')->nullable()->index();
                $t->integer('user_id')->nullable();
                $t->text('message')->nullable();
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 55. TOURNAMENTS  +  SUB-TABLES
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('tournaments')) {
            Schema::create('tournaments', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable()->default(1);
                $t->string('name')->nullable();
                $t->timestamp('start')->nullable();
                $t->timestamp('end')->nullable();
                $t->timestamp('start_date')->nullable();
                $t->timestamp('end_date')->nullable();
                $t->string('status', 30)->nullable()->default('pending');
                $t->timestamps();
            });
        }
        if (!Schema::hasTable('tournament_games')) {
            Schema::create('tournament_games', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('tournament_id')->nullable()->index();
                $t->integer('game_id')->nullable();
                $t->timestamps();
            });
        }
        if (!Schema::hasTable('tournament_prizes')) {
            Schema::create('tournament_prizes', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('tournament_id')->nullable()->index();
                $t->integer('position')->nullable()->default(1);
                $t->decimal('prize', 15, 2)->nullable()->default(0);
                $t->timestamps();
            });
        }
        if (!Schema::hasTable('tournament_stats')) {
            Schema::create('tournament_stats', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('tournament_id')->nullable()->index();
                $t->integer('user_id')->nullable()->index();
                $t->decimal('points', 20, 4)->nullable()->default(0);
                $t->integer('position')->nullable()->default(0);
                $t->timestamps();
            });
        }
        if (!Schema::hasTable('tournament_bots')) {
            Schema::create('tournament_bots', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('tournament_id')->nullable()->index();
                $t->integer('user_id')->nullable();
                $t->timestamps();
            });
        }
        if (!Schema::hasTable('tournament_categories')) {
            Schema::create('tournament_categories', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('tournament_id')->nullable()->index();
                $t->integer('category_id')->nullable();
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 56. SHOPS_USER / COUNTRIES / DEVICES / OS
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('shops_user')) {
            Schema::create('shops_user', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable();
                $t->integer('user_id')->nullable();
                $t->timestamps();
                $t->unique(['shop_id', 'user_id']);
            });
        }
        if (!Schema::hasTable('shops_countries')) {
            Schema::create('shops_countries', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable();
                $t->string('country', 10)->nullable();
                $t->timestamps();
            });
        }
        if (!Schema::hasTable('shops_devices')) {
            Schema::create('shops_devices', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable();
                $t->string('device', 50)->nullable();
                $t->timestamps();
            });
        }
        if (!Schema::hasTable('shops_os')) {
            Schema::create('shops_os', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable();
                $t->string('os', 50)->nullable();
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 57. ARTICLES / FAQS / INFO / RULES
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('articles')) {
            Schema::create('articles', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable()->default(1);
                $t->string('title')->nullable();
                $t->text('content')->nullable();
                $t->string('status', 30)->nullable()->default('published');
                $t->timestamps();
            });
        }
        if (!Schema::hasTable('faqs')) {
            Schema::create('faqs', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable()->default(1);
                $t->text('question')->nullable();
                $t->text('answer')->nullable();
                $t->integer('position')->nullable()->default(0);
                $t->timestamps();
            });
        }
        if (!Schema::hasTable('info')) {
            Schema::create('info', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable()->default(1);
                $t->string('title')->nullable();
                $t->text('content')->nullable();
                $t->timestamps();
            });
        }
        if (!Schema::hasTable('rules')) {
            Schema::create('rules', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('shop_id')->nullable()->default(1);
                $t->string('title')->nullable();
                $t->text('content')->nullable();
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 58. COINPAYMENT TABLES
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('coinpayment_transactions')) {
            Schema::create('coinpayment_transactions', function (Blueprint $t) {
                $t->increments('id');
                $t->uuid('uuid');
                $t->string('txn_id')->nullable();
                $t->string('order_id')->nullable();
                $t->string('buyer_name')->nullable();
                $t->string('buyer_email')->nullable();
                $t->string('currency_code', 20)->nullable();
                $t->string('time_expires')->nullable();
                $t->string('address')->nullable();
                $t->decimal('amount_total_fiat', 20, 8)->nullable();
                $t->string('amount')->nullable();
                $t->string('amountf')->nullable();
                $t->string('coin', 20)->nullable();
                $t->integer('confirms_needed')->nullable();
                $t->string('payment_address')->nullable();
                $t->text('qrcode_url')->nullable();
                $t->string('received')->nullable();
                $t->string('receivedf')->nullable();
                $t->string('recv_confirms')->nullable();
                $t->string('status', 30)->nullable();
                $t->string('status_text')->nullable();
                $t->text('status_url')->nullable();
                $t->string('timeout')->nullable();
                $t->text('checkout_url')->nullable();
                $t->text('redirect_url')->nullable();
                $t->text('cancel_url')->nullable();
                $t->string('type', 50)->nullable();
                $t->text('payload')->nullable();
                $t->timestamps();
            });
        }
        if (!Schema::hasTable('coinpayment_transaction_items')) {
            Schema::create('coinpayment_transaction_items', function (Blueprint $t) {
                $t->increments('id');
                $t->integer('coinpayment_transaction_id');
                $t->string('description');
                $t->decimal('price', 20, 8);
                $t->decimal('qty', 15, 4);
                $t->decimal('subtotal', 20, 8);
                $t->string('currency_code', 20)->nullable();
                $t->string('type', 50)->nullable();
                $t->string('state', 30)->nullable();
                $t->timestamps();
            });
        }

        // ══════════════════════════════════════════════════════════
        // 59. PER-SHOP EXTENDED SETTINGS
        // ══════════════════════════════════════════════════════════
        if (!Schema::hasTable('shop_fish_settings')) {
            Schema::create('shop_fish_settings', function (Blueprint $t) {
                $t->id();
                $t->unsignedBigInteger('shop_id')->unique();
                $t->decimal('target_rtp', 5, 2)->default(92.00);
                $t->decimal('fish_bank_size', 15, 2)->default(10000.00);
                $t->decimal('min_bet', 10, 2)->default(0.10);
                $t->decimal('max_bet', 10, 2)->default(100.00);
                $t->decimal('max_win_per_spin', 10, 2)->default(500.00);
                $t->boolean('enabled')->default(true);
                $t->decimal('jackpot_contribution_pct', 5, 2)->default(1.00);
                $t->decimal('bonus_trigger_pct', 5, 2)->default(5.00);
                $t->string('allowed_bets')->default('0.10,0.20,0.50,1.00,2.00,5.00,10.00,20.00,50.00,100.00');
                $t->text('notes')->nullable();
                $t->timestamps();
            });
        }
        if (!Schema::hasTable('shop_bonus_settings')) {
            Schema::create('shop_bonus_settings', function (Blueprint $t) {
                $t->id();
                $t->unsignedBigInteger('shop_id')->unique();
                $t->boolean('welcome_bonus_enabled')->default(true);
                $t->decimal('welcome_bonus_percent', 5, 2)->default(100.00);
                $t->decimal('welcome_bonus_max_amount', 10, 2)->default(500.00);
                $t->integer('welcome_bonus_wagering_requirement')->default(30);
                $t->integer('welcome_bonus_expires_days')->default(30);
                $t->boolean('daily_bonus_enabled')->default(true);
                $t->decimal('daily_bonus_base_amount', 10, 2)->default(5.00);
                $t->decimal('daily_bonus_streak_multiplier', 5, 2)->default(1.10);
                $t->integer('daily_bonus_max_streak')->default(30);
                $t->decimal('daily_bonus_max_amount', 10, 2)->default(50.00);
                $t->boolean('referral_bonus_enabled')->default(true);
                $t->decimal('referral_bonus_per_referral', 10, 2)->default(20.00);
                $t->decimal('referral_bonus_referee_amount', 10, 2)->default(10.00);
                $t->integer('referral_max_uses')->default(50);
                $t->decimal('referral_min_deposit', 10, 2)->default(20.00);
                $t->boolean('wheel_enabled')->default(true);
                $t->decimal('wheel_min_deposit', 10, 2)->default(10.00);
                $t->integer('wheel_cooldown_hours')->default(24);
                $t->integer('wheel_spins_per_deposit')->default(1);
                $t->json('wheel_prizes')->nullable();
                $t->boolean('happyhour_enabled')->default(true);
                $t->decimal('happyhour_multiplier', 4, 2)->default(2.00);
                $t->time('happyhour_start')->default('18:00:00');
                $t->time('happyhour_end')->default('22:00:00');
                $t->boolean('sms_bonus_enabled')->default(true);
                $t->decimal('sms_bonus_amount', 10, 2)->default(10.00);
                $t->integer('sms_bonus_interval_days')->default(7);
                $t->boolean('deposit_bonus_enabled')->default(false);
                $t->decimal('deposit_bonus_percent', 5, 2)->default(10.00);
                $t->decimal('deposit_bonus_max', 10, 2)->default(100.00);
                $t->integer('deposit_bonus_wagering')->default(10);
                $t->text('notes')->nullable();
                $t->timestamps();
            });
        }
        if (!Schema::hasTable('shop_game_rtp')) {
            Schema::create('shop_game_rtp', function (Blueprint $t) {
                $t->id();
                $t->unsignedBigInteger('shop_id');
                $t->unsignedBigInteger('game_id');
                $t->decimal('target_rtp', 5, 2)->default(92.00);
                $t->boolean('enabled')->default(true);
                $t->decimal('min_bet_override', 10, 2)->nullable();
                $t->decimal('max_bet_override', 10, 2)->nullable();
                $t->decimal('max_win_override', 10, 2)->nullable();
                $t->timestamps();
                $t->unique(['shop_id', 'game_id']);
            });
        }
    }

    // ─────────────────────────────────────────────────────────────
    // DOWN  (drops in reverse FK order — safe even on fresh DBs)
    // ─────────────────────────────────────────────────────────────
    public function down(): void
    {
        $tables = [
            'shop_game_rtp', 'shop_bonus_settings', 'shop_fish_settings',
            'coinpayment_transaction_items', 'coinpayment_transactions',
            'tournament_categories', 'tournament_bots', 'tournament_stats',
            'tournament_prizes', 'tournament_games', 'tournaments',
            'tickets_answers', 'tickets', 'messages', 'notifications',
            'rules', 'info', 'faqs', 'articles',
            'shops_os', 'shops_devices', 'shops_countries', 'shops_user',
            'open_shift_temp', 'open_shift', 'security', 'securities',
            'apis', 'tasks', 'bonus_preset',
            'user_bonuses', 'progress_users', 'progress', 'rewards',
            'sms_mailing_messages', 'sms_mailings',
            'sms_bonus_items', 'sms_bonuses', 'sms_bonus', 'sms',
            'invites', 'happyhours', 'jpg', 'daily_bonus',
            'wheelfortune', 'welcomebonuses',
            'user_activity', 'bots_games', 'subsessions',
            'statistics_add', 'statistics',
            'stat_game', 'fish_bank', 'game_bank', 'game_log',
            'game_category', 'game_categories', 'games',
            'shop_categories', 'categories',
            'api_tokens', 'personal_access_tokens',
            'failed_jobs', 'password_resets', 'sessions', 'settings',
            'permission_role', 'role_user',
            'users', 'permissions', 'roles', 'shops',
        ];
        foreach ($tables as $table) {
            Schema::dropIfExists($table);
        }
    }
};
