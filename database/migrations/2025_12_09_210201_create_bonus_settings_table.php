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
        Schema::create('bonus_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('level1', 5, 2)->default(0);
            $table->decimal('level2', 5, 2)->default(0);
            $table->decimal('level3', 5, 2)->default(0);
            $table->decimal('level4', 5, 2)->default(0);
            $table->decimal('level5', 5, 2)->default(0);

            $table->decimal('rank_pool', 5, 2)->default(0);
            $table->decimal('club_pool', 5, 2)->default(0);
            $table->decimal('shareholder_pool', 5, 2)->default(0);
            $table->decimal('director_pool', 5, 2)->default(0);

            $table->decimal('reactivation_charge', 20, 8)->default(0);
            $table->integer('max_pending_installments')->default(3);

            $table->timestamps();
        });

        DB::table('bonus_settings')->insert([
            'level1' => 15,
            'level2' => 3,
            'level3' => 1,
            'level4' => 1,
            'level5' => 1,
            'rank_pool' => 3,
            'club_pool' => 3,
            'shareholder_pool' => 3,
            'director_pool' => 3,
            'reactivation_charge' => 500,
            'max_pending_installments' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bonus_settings');
    }
};
