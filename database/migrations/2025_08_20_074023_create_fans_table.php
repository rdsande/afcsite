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
        Schema::create('fans', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->string('phone')->unique();
            $table->string('email')->nullable();
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('country')->default('Tanzania');
            $table->string('region');
            $table->string('district');
            $table->string('ward')->nullable();
            $table->string('street')->nullable();
            $table->integer('points')->default(0);
            $table->string('favorite_jersey_number')->nullable();
            $table->string('favorite_jersey_name')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fans');
    }
};
