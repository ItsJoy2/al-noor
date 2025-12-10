<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('share_name');
            $table->decimal('amount', 20, 8);
            $table->integer('total_share_quantity');
            $table->integer('per_purchase_limit');
            $table->decimal('first_installment', 20, 8)->default(0);
            $table->decimal('monthly_installment', 20, 8)->default(0);
            $table->integer('installment_months')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package');
    }
};
