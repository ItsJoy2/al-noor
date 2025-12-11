<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deposit_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['mobile_banking', 'bank', 'crypto']);
            $table->json('details')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('method_id')->constrained('deposit_methods')->cascadeOnDelete();
            $table->decimal('amount', 20, 8);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('transaction_id')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deposits');
        Schema::dropIfExists('deposit_methods');
    }
};
