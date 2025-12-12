<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->unsignedBigInteger('user_id');
            $table->decimal('amount', 15, 8);
            $table->decimal('charge', 15, 8)->default(0);
            $table->enum('remark',['deposit','withdrawal','transfer', 'convert', 'level_bonus','package_purchased', 'director_bonus', 'shareholder_bonus', 'club_bonus', 'rank_bonus','director_pool', 'shareholder_pool', 'club_pool', 'rank_pool' ]);
            $table->enum('type',['-','+']);
            $table->enum('status',['Pending','Paid','Completed','Rejected']);
            $table->string('details')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
