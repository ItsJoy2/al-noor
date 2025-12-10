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
        Schema::create('investors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('package_id')->constrained('packages')->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->enum('purchase_type', ['full', 'installment']);
            $table->decimal('total_amount', 20, 8);
            $table->decimal('paid_amount', 20, 8)->default(0);
            $table->integer('paid_installments')->default(0);
            $table->integer('pending_invoices')->default(0);
            $table->enum('status', ['active','inactive','paid'])->default('active');
            $table->timestamp('activated_at')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investors');
    }
};
