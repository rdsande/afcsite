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
        Schema::create('match_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fixture_id')->constrained()->onDelete('cascade');
            $table->foreignId('player_id')->nullable()->constrained()->onDelete('set null');
            $table->string('event_type'); // goal, yellow_card, red_card, substitution, match_start, match_end, half_time
            $table->integer('minute')->nullable(); // Match minute when event occurred
            $table->string('team'); // home or away
            $table->text('description')->nullable(); // Additional details about the event
            $table->json('metadata')->nullable(); // Extra data like assist player, card reason, etc.
            $table->timestamp('event_time')->nullable(); // Actual time when event was recorded
            $table->boolean('is_live_update')->default(false); // For live match commentary
            $table->integer('sort_order')->default(0); // For ordering events
            $table->timestamps();
            
            $table->index(['fixture_id', 'minute']);
            $table->index(['fixture_id', 'event_type']);
            $table->index(['fixture_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_events');
    }
};
