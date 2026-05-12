<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds the columns required by the Wheel of Fortune and Dragon Egg bonus
 * features wired up in ProfileController@wheel_spin / @dragon_egg.
 *
 * - users.last_wheelfortune  → 1-spin-per-day lock for the wheel
 * - users.last_daily_entry   → 1-claim-per-day lock for the dragon egg
 * - shops.wheelfortune_active → per-shop on/off switch surfaced in the backend
 *
 * Idempotent: every column is guarded with hasColumn() so it is safe to run
 * on installs where the columns were already added manually.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $t) {
                if (!Schema::hasColumn('users', 'last_wheelfortune')) {
                    $t->timestamp('last_wheelfortune')->nullable();
                }
                if (!Schema::hasColumn('users', 'last_daily_entry')) {
                    $t->timestamp('last_daily_entry')->nullable();
                }
            });
        }

        if (Schema::hasTable('shops')) {
            Schema::table('shops', function (Blueprint $t) {
                if (!Schema::hasColumn('shops', 'wheelfortune_active')) {
                    $t->boolean('wheelfortune_active')->default(true)->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $t) {
                if (Schema::hasColumn('users', 'last_wheelfortune')) {
                    $t->dropColumn('last_wheelfortune');
                }
                if (Schema::hasColumn('users', 'last_daily_entry')) {
                    $t->dropColumn('last_daily_entry');
                }
            });
        }

        if (Schema::hasTable('shops')) {
            Schema::table('shops', function (Blueprint $t) {
                if (Schema::hasColumn('shops', 'wheelfortune_active')) {
                    $t->dropColumn('wheelfortune_active');
                }
            });
        }
    }
};
