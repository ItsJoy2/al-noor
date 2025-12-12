<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('value');
            $table->timestamps();
        });

        DB::table('settings')->insert([
            ['key' => 'shareholder_min_shares', 'value' => 5],

            ['key' => 'club1_min_shares', 'value' => 10],
            ['key' => 'club2_min_shares', 'value' => 25],
            ['key' => 'club3_min_shares', 'value' => 50],

            ['key' => 'rank1_min_shares', 'value' => 10],
            ['key' => 'rank1_min_active_referrals', 'value' => 5],

            ['key' => 'rank2_min_shares', 'value' => 25],
            ['key' => 'rank2_min_active_referrals', 'value' => 10],

            ['key' => 'rank3_min_shares', 'value' => 50],
            ['key' => 'rank3_min_active_referrals', 'value' => 15],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
