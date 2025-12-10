<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activation_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('activation_amount', 20, 2)->default(0);
            $table->decimal('activation_bonus', 20, 5)->default(0);
            $table->decimal('referral_bonus', 20, 2)->default(0);
            $table->integer('activation_duration_months')->default(12);
            $table->timestamps();
        });

        DB::table('activation_settings')->insert([
            'activation_amount' => 10.00,
            'activation_bonus' => 5000.00000,
            'referral_bonus' => 20.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('activation_settings');
    }
};

