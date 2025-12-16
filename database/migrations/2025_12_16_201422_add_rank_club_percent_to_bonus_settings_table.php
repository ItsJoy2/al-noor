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
        Schema::table('bonus_settings', function (Blueprint $table) {

            $table->decimal('rank1_percent', 5, 2)->default(0.5)->after('level5');
            $table->decimal('rank2_percent', 5, 2)->default(1.0)->after('rank1_percent');
            $table->decimal('rank3_percent', 5, 2)->default(1.5)->after('rank2_percent');

            $table->decimal('club1_percent', 5, 2)->default(0.5)->after('rank3_percent');
            $table->decimal('club2_percent', 5, 2)->default(1.0)->after('club1_percent');
            $table->decimal('club3_percent', 5, 2)->default(1.5)->after('club2_percent');
        });

        DB::table('bonus_settings')->update([
            'rank1_percent' => 0.5,
            'rank2_percent' => 1.0,
            'rank3_percent' => 1.5,
            'club1_percent' => 0.5,
            'club2_percent' => 1.0,
            'club3_percent' => 1.5,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bonus_settings', function (Blueprint $table) {
            $table->dropColumn([
                'rank1_percent',
                'rank2_percent',
                'rank3_percent',
                'club1_percent',
                'club2_percent',
                'club3_percent',
            ]);
        });
    }
};
