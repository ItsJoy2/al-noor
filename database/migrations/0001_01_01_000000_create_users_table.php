<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile',15);
            $table->decimal('funding_wallet', 20, 8)->default(0.00000000);
            $table->decimal('bonus_wallet', 20, 8)->default(0.00000000);
            $table->string('refer_code', 6)->unique();
            $table->foreignId('refer_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_active')->default(false);
            $table->timestamp('last_activated_at')->nullable();
            $table->boolean('is_block')->default(false);
            $table->enum('rank', ['none','rank1','rank2','rank3'])->default('none');
            $table->boolean('is_club')->default(false);
            $table->boolean('is_director')->default(false);
            $table->boolean('kyc_status')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role',['user','admin'])->default('user');
            $table->date('birthday')->nullable();
            $table->string('nid_or_passport')->nullable();
            $table->string('address')->nullable();
            $table->string('image')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

       DB::table('users')->insert([
           'name' => 'admin',
           'email' => 'admin@edulife.com',
           'mobile' => '0123456789',
           'password' => Hash::make('Admin123$'),
           'role' => 'admin',
           'is_active' => true,
           'is_block' => false,
           'refer_code' => 'admin',
           'email_verified_at' => now(),
       ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
