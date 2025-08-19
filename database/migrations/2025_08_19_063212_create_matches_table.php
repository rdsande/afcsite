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
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->string('home_team')->default('AZAM FC');
            $table->string('away_team');
            $table->string('home_team_logo')->nullable();
            $table->string('away_team_logo')->nullable();
            $table->datetime('match_date');
            $table->string('venue');
            $table->string('competition'); // NBC Premier League, CAF, etc.
            $table->string('match_type')->default('league'); // league, cup, friendly
            $table->string('team_category')->default('senior'); // senior, u20, u17, u15, u13
            $table->integer('home_score')->default(0);
            $table->integer('away_score')->default(0);
            $table->integer('home_penalties')->nullable(); // for penalty shootouts
            $table->integer('away_penalties')->nullable();
            $table->text('match_summary')->nullable();
            $table->json('goal_scorers')->nullable(); // JSON array of goal scorers
            $table->json('cards')->nullable(); // JSON array of yellow/red cards
            $table->integer('attendance')->nullable();
            $table->string('referee')->nullable();
            $table->boolean('is_home')->default(true);
            $table->string('result')->nullable(); // win, loss, draw
            $table->timestamps();
            
            $table->index(['match_date']);
            $table->index(['team_category', 'match_date']);
            $table->index(['competition']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
