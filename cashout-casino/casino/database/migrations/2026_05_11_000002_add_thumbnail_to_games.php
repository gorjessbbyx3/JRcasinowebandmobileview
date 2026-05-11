<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('games', 'thumbnail')) {
            Schema::table('games', function (Blueprint $table) {
                $table->string('thumbnail', 500)->nullable()->after('label')
                    ->comment('Relative path to game thumbnail image e.g. /frontend/Default/ico/GameName.jpg');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('games', 'thumbnail')) {
            Schema::table('games', function (Blueprint $table) {
                $table->dropColumn('thumbnail');
            });
        }
    }
};
