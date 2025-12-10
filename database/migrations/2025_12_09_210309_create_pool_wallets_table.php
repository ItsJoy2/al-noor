<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pool_wallets', function (Blueprint $table) {
            $table->id();
            $table->decimal('rank', 20, 8)->default(0);
            $table->decimal('club', 20, 8)->default(0);
            $table->decimal('shareholder', 20, 8)->default(0);
            $table->decimal('director', 20, 8)->default(0);
            $table->timestamps();
        });
        DB::table('pool_wallets')->insert([
            'rank' => 0,
            'club' => 0,
            'shareholder' => 0,
            'director' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pool_wallets');
    }
};
