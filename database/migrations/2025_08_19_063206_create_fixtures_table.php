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
        Schema::create('fixtures', function (Blueprint $table) {
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
            $table->text('match_preview')->nullable();
            $table->string('ticket_link')->nullable();
            $table->decimal('ticket_price', 8, 2)->nullable();
            $table->boolean('is_home')->default(true);
            $table->string('status')->default('scheduled'); // scheduled, live, completed, postponed, cancelled
            $table->timestamps();
            
            $table->index(['match_date', 'status']);
            $table->index(['team_category', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixtures');
    }
};
