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
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // NBC Premier League, CAF Champions League, etc.
            $table->string('short_name')->nullable(); // NBC, CAF, etc.
            $table->text('description')->nullable();
            $table->string('type')->default('league'); // league, cup, friendly
            $table->string('format')->default('round_robin'); // round_robin, knockout, group_stage
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('season')->nullable(); // 2024/25
            $table->boolean('is_active')->default(true);
            $table->string('logo')->nullable();
            $table->json('settings')->nullable(); // Additional settings like number of rounds, etc.
            $table->timestamps();
            
            $table->index(['is_active', 'type']);
            $table->index('season');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};
