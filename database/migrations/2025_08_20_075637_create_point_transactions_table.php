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
        Schema::create('point_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fan_id')->constrained()->onDelete('cascade');
            $table->integer('points');
            $table->string('type'); // 'login', 'win', 'bonus', etc.
            $table->text('description')->nullable();
            $table->json('metadata')->nullable(); // Store additional data like fixture_id for wins
            $table->timestamps();
            
            $table->index(['fan_id', 'created_at']);
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_transactions');
    }
};
